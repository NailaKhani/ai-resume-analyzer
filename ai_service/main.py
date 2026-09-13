from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
import os
import re
from PyPDF2 import PdfReader
import docx
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity

app = FastAPI(title="Resume Analyzer AI Service - v2 (TF-IDF + SBERT)")

# ─── Try to load Sentence-BERT model (optional, falls back to TF-IDF only) ───
try:
    from sentence_transformers import SentenceTransformer, util as st_util
    SBERT_MODEL = SentenceTransformer('all-MiniLM-L6-v2')
    SBERT_AVAILABLE = True
    print("✅ Sentence-BERT loaded: all-MiniLM-L6-v2")
except ImportError:
    SBERT_AVAILABLE = False
    print("⚠️  sentence-transformers not installed. Using TF-IDF only. Run: pip install sentence-transformers")

# ─── Try to load spaCy NER model ───
try:
    import spacy
    NLP = spacy.load("en_core_web_sm")
    SPACY_AVAILABLE = True
    print("✅ spaCy NER model loaded: en_core_web_sm")
except (ImportError, OSError):
    SPACY_AVAILABLE = False
    print("⚠️  spaCy not available. Run: pip install spacy && python -m spacy download en_core_web_sm")


class AnalyzeRequest(BaseModel):
    resume_path: str
    job_description: str
    required_skills: str


# ─── Text Extraction ───────────────────────────────────────────────────────────

def extract_text_from_pdf(file_path: str) -> str:
    try:
        reader = PdfReader(file_path)
        text = ""
        for page in reader.pages:
            if page.extract_text():
                text += page.extract_text() + "\n"
        return text
    except Exception as e:
        print(f"Error reading PDF: {e}")
        return ""

def extract_text_from_docx(file_path: str) -> str:
    try:
        doc = docx.Document(file_path)
        text = "\n".join([para.text for para in doc.paragraphs])
        return text
    except Exception as e:
        print(f"Error reading DOCX: {e}")
        return ""

def extract_text(file_path: str) -> str:
    ext = os.path.splitext(file_path)[1].lower()
    if ext == '.pdf':
        return extract_text_from_pdf(file_path)
    elif ext == '.docx':
        return extract_text_from_docx(file_path)
    return ""


# ─── NER Extraction (spaCy) ───────────────────────────────────────────────────

def extract_entities(resume_text: str) -> dict:
    """Use spaCy to extract named entities: PERSON, ORG, email, phone."""
    entities = {"name": None, "email": None, "phone": None, "organizations": []}

    # Regex-based extraction (always works)
    email_match = re.search(r'[\w\.-]+@[\w\.-]+\.\w+', resume_text)
    if email_match:
        entities["email"] = email_match.group(0)

    phone_match = re.search(r'(\+?\d[\d\s\-().]{7,}\d)', resume_text)
    if phone_match:
        entities["phone"] = phone_match.group(0).strip()

    # spaCy NER (if available)
    if SPACY_AVAILABLE:
        doc = NLP(resume_text[:5000])  # limit to first 5000 chars for speed
        for ent in doc.ents:
            if ent.label_ == "PERSON" and not entities["name"]:
                entities["name"] = ent.text
            elif ent.label_ == "ORG":
                if ent.text not in entities["organizations"]:
                    entities["organizations"].append(ent.text)

    return entities


# ─── Scoring ──────────────────────────────────────────────────────────────────

def tfidf_score(resume_text: str, job_description: str, required_skills: str) -> float:
    target_text = job_description + " " + required_skills
    if not resume_text.strip():
        return 0.0
    vectorizer = TfidfVectorizer(stop_words='english')
    try:
        tfidf_matrix = vectorizer.fit_transform([target_text, resume_text])
        similarity = cosine_similarity(tfidf_matrix[0:1], tfidf_matrix[1:2])[0][0]
        return float(similarity * 100)
    except Exception as e:
        print(f"TF-IDF error: {e}")
        return 0.0

def sbert_score(resume_text: str, job_description: str, required_skills: str) -> float:
    if not SBERT_AVAILABLE:
        return 0.0
    try:
        target = job_description + " " + required_skills
        emb1 = SBERT_MODEL.encode(target[:512], convert_to_tensor=True)
        emb2 = SBERT_MODEL.encode(resume_text[:512], convert_to_tensor=True)
        similarity = st_util.cos_sim(emb1, emb2).item()
        return float(max(0, similarity) * 100)
    except Exception as e:
        print(f"SBERT error: {e}")
        return 0.0

def calculate_match_score(resume_text: str, job_description: str, required_skills: str) -> float:
    tfidf = tfidf_score(resume_text, job_description, required_skills)

    if SBERT_AVAILABLE:
        sbert = sbert_score(resume_text, job_description, required_skills)
        # Combined: TF-IDF 40% + SBERT 60% (as per proposal)
        combined = (0.4 * tfidf) + (0.6 * sbert)
        print(f"Scores → TF-IDF: {tfidf:.1f}% | SBERT: {sbert:.1f}% | Combined: {combined:.1f}%")
        return combined
    else:
        return tfidf


# ─── Skill Matching ───────────────────────────────────────────────────────────

def extract_matched_skills(resume_text: str, required_skills: str) -> list:
    skills = [s.strip().lower() for s in required_skills.split(',') if s.strip()]
    resume_text_lower = resume_text.lower()
    matched = []
    for skill in skills:
        if re.search(r'\b' + re.escape(skill) + r'\b', resume_text_lower):
            matched.append(skill.title())
    return matched

def extract_missing_skills(matched_skills: list, required_skills: str) -> list:
    all_skills = [s.strip().title() for s in required_skills.split(',') if s.strip()]
    return [skill for skill in all_skills if skill not in matched_skills]

def generate_ai_advice(missing_skills: list, score: float) -> str:
    if not missing_skills and score >= 70:
        return "Excellent match! Your resume is a strong fit for this position. Focus on crafting a tailored cover letter."
    if not missing_skills:
        return f"Your resume matched at {score:.1f}%. While all keywords are present, consider adding more quantified achievements to strengthen your application."
    advice = f"Your resume matched {score:.1f}% using advanced NLP analysis. "
    advice += f"To significantly boost your score, add hands-on experience with: {', '.join(missing_skills)}. "
    advice += "Consider updating your resume with specific projects or certifications related to these skills."
    return advice


# ─── Main Endpoint ────────────────────────────────────────────────────────────

@app.post("/analyze")
def analyze_resume(request: AnalyzeRequest):
    if not os.path.exists(request.resume_path):
        raise HTTPException(status_code=404, detail="Resume file not found")

    resume_text = extract_text(request.resume_path)

    if not resume_text:
        return {
            "match_score": 0.0,
            "extracted_skills": [],
            "missing_skills": [],
            "ai_advice": "Could not extract text from the provided file.",
            "entities": {},
            "message": "Text extraction failed."
        }

    score = calculate_match_score(resume_text, request.job_description, request.required_skills)
    matched_skills = extract_matched_skills(resume_text, request.required_skills)
    missing_skills = extract_missing_skills(matched_skills, request.required_skills)
    advice = generate_ai_advice(missing_skills, round(score, 2))
    entities = extract_entities(resume_text)

    return {
        "match_score":       round(score, 2),
        "extracted_skills":  matched_skills,
        "missing_skills":    missing_skills,
        "ai_advice":         advice,
        "entities":          entities,
        "sbert_used":        SBERT_AVAILABLE,
        "spacy_used":        SPACY_AVAILABLE,
        "message":           "Analysis complete"
    }


@app.get("/health")
def health():
    return {
        "status": "ok",
        "sbert_available": SBERT_AVAILABLE,
        "spacy_available": SPACY_AVAILABLE
    }


if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="127.0.0.1", port=8001)
