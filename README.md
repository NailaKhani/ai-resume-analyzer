<div align="center">
  <img src="public/images/hero.jpg" alt="Resume Analyzer AI" width="100%" style="border-radius:12px;margin-bottom:20px;">
  <h1>✨ Resume Analyzer & Job Matching AI</h1>
  <p><strong>A Next-Generation AI Recruitment Platform built with Laravel 12 & FastAPI</strong></p>
</div>

---

## 🚀 Overview

The **AI-Powered Resume Analyzer & Job Matching System** is a robust SaaS product designed to solve the real-world problem of manual resume screening. It bridges the gap between overwhelmed HR professionals and eager job candidates by using advanced Natural Language Processing (NLP) to instantly evaluate applications.

This system evaluates candidate resumes against job descriptions using a hybrid scoring model (TF-IDF + Sentence-BERT) and automatically extracts key applicant information.

---

## 🌟 Key Features

### 👑 Multi-Role Architecture
- **Admin**: System-wide dashboard, global user management, role assignments, and a real-time audit log of all activities.
- **HR Professional**: Post job openings, review AI-scored candidates, update applicant statuses (Screened, Shortlisted, Interviewed, Rejected), and view interactive Chart.js analytics.
- **Candidate**: Browse available jobs, upload resumes (PDF/DOCX), manage a rich personal profile, and track their applications and AI match scores.

### 🧠 Advanced AI Microservice (FastAPI)
- **Hybrid Scoring**: Combines **TF-IDF (40%)** with **Sentence-BERT (60%)** (`all-MiniLM-L6-v2`) for deep semantic understanding of resumes.
- **spaCy NER Extraction**: Automatically extracts the candidate's Name, Email, Phone Number, and mentioned Organizations using `en_core_web_sm`.
- **Skill Gap Analysis**: Compares the candidate's resume against job requirements to generate a list of "Matched" and "Missing" skills, providing actionable AI advice to the candidate.

### 📊 Beautiful, Responsive UI
- **Glassmorphism Aesthetic**: Deep purple gradients, rich drop shadows, and modern card-based layouts.
- **Interactive Dashboards**: Role-specific dashboards featuring Chart.js graphs, animated progress bars, and recent activity feeds.
- **Profile Completeness**: A gamified profile system that encourages candidates to add their LinkedIn, Bio, and Skills to reach 100% completeness.

### 🔒 Enterprise Grade Security
- **Activity Logging**: An immutable audit trail that logs all significant actions (Job Creation, Applications, Status Updates) along with timestamps and IPs.
- **Strict Role-Based Access Control**: Middleware protected routes ensuring Candidates cannot access HR tools, and HR cannot access Admin tools.

---

## 🛠️ Technology Stack

**Backend (Core System)**
- Laravel 12 (PHP 8.2+)
- MySQL
- Laravel Breeze / Sanctum (Authentication)

**Backend (AI Microservice)**
- Python 3.10+
- FastAPI & Uvicorn
- Sentence-Transformers (Sentence-BERT)
- spaCy
- Scikit-Learn (TF-IDF)
- PyPDF2 & python-docx

**Frontend**
- HTML5 / Vanilla CSS
- Chart.js (Analytics)
- TailwindCSS (Utility classes generated via Vite)

---

## ⚙️ Installation & Setup

### 1. Setup Laravel Core
```bash
# Clone the repository
git clone https://github.com/yourusername/resume-analyzer.git
cd resume-analyzer

# Install PHP dependencies
composer install

# Install NPM dependencies
npm install
npm run build

# Setup environment variables
cp .env.example .env
php artisan key:generate

# Configure your database in .env, then migrate and seed
php artisan migrate --seed

# Start the Laravel development server
php artisan serve
```

### 2. Setup AI Microservice
```bash
# Navigate to the AI service directory
cd ai_service

# Create and activate a virtual environment
python -m venv venv
.\venv\Scripts\activate  # (Windows)
# source venv/bin/activate # (Mac/Linux)

# Install Python dependencies
pip install fastapi uvicorn scikit-learn PyPDF2 python-docx spacy sentence-transformers

# Download spaCy English Model
python -m spacy download en_core_web_sm

# Run the FastAPI server (starts on port 8001)
uvicorn main:app --reload --port 8001
```

---
### Contact Information
- **Email:** nailakhani5457@gmail.com
- **LinkedIn:** [Naila Bibi](https://www.linkedin.com/in/naila-bibi-62a2863a7)

---
