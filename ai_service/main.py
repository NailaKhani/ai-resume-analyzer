from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
import os
import re
from PyPDF2 import PdfReader
import docx
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity

app = FastAPI(title="Resume Analyzer AI Service")

class AnalyzeRequest(BaseModel):
    resume_path: str
    job_description: str
    required_skills: str

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

def calculate_match_score(resume_text: str, job_description: str, required_skills: str) -> float:
    # Combine job description and skills as the target document
    target_text = job_description + " " + required_skills
    
    # If resume is empty, score is 0
    if not resume_text.strip():
        return 0.0

    # TF-IDF Cosine Similarity
    vectorizer = TfidfVectorizer(stop_words='english')
    try:
        tfidf_matrix = vectorizer.fit_transform([target_text, resume_text])
        similarity = cosine_similarity(tfidf_matrix[0:1], tfidf_matrix[1:2])[0][0]
        # Convert to percentage
        return float(similarity * 100)
    except Exception as e:
        print(f"Error calculating similarity: {e}")
        return 0.0

def extract_matched_skills(resume_text: str, required_skills: str) -> list:
    skills = [s.strip().lower() for s in required_skills.split(',') if s.strip()]
    resume_text_lower = resume_text.lower()
    
    matched = []
    for skill in skills:
        # Simple string matching; regex could be used for exact word boundaries
        if re.search(r'\b' + re.escape(skill) + r'\b', resume_text_lower):
            matched.append(skill.title())
            
    return matched

@app.post("/analyze")
def analyze_resume(request: AnalyzeRequest):
    if not os.path.exists(request.resume_path):
        raise HTTPException(status_code=404, detail="Resume file not found")
        
    resume_text = extract_text(request.resume_path)
    
    if not resume_text:
        return {
            "match_score": 0.0,
            "extracted_skills": [],
            "message": "Could not extract text from the provided file."
        }
        
    score = calculate_match_score(resume_text, request.job_description, request.required_skills)
    matched_skills = extract_matched_skills(resume_text, request.required_skills)
    
    # Boost score slightly based on exact skill matches (optional heuristic)
    if len(request.required_skills.split(',')) > 0:
        total_skills = len([s for s in request.required_skills.split(',') if s.strip()])
        if total_skills > 0:
            skill_ratio = len(matched_skills) / total_skills
            # Add up to 20% bonus for explicit skill keyword matches
            score = min(100.0, score + (skill_ratio * 20))
            
    return {
        "match_score": round(score, 2),
        "extracted_skills": matched_skills,
        "message": "Analysis complete"
    }

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="127.0.0.1", port=8001)
