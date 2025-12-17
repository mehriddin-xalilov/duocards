# 📋 Unified Testing Platform

Milliy sertifikat savollari va ishga kirish suhbat testlarini yagona backend va websocket orqali boshqaruvchi test platformasi.

---

## 🎯 Platforma Maqsadi

Platforma ikki asosiy test turini **bitta database strukturasi** orqali boshqaradi:

### 1️⃣ Milliy Sertifikat Testlari (test_type = 1)
- Fanlar `Category` orqali boshqariladi
- Savollar umumiy `questions` jadvalidan olinadi
- Statistikalar:
    - Yechgan foydalanuvchilar soni
    - To'g'ri javoblar foizi
    - Qiyin savollar reytingi

### 2️⃣ Ishga Kirish Suhbat Testlari (test_type = 2)
- Darajalar `Level` orqali (Junior, Middle, Senior)
- Yo'nalishlar `speciality_id` orqali (Backend, Frontend, DevOps va h.k.)
- Random intervyu savollari
- Natija darajasi: Low / Medium / Strong

---

## 🏛️ Asosiy Ma'lumotlar Modellari

Platforma mavjud jadvallarni buzmasdan, minimal kengaytirish orqali ishlaydi.

### 👤 User - Foydalanuvchi

Foydalanuvchi ma'lumotlari va autentifikatsiya.

| Ustun | Turi | Tavsif |
|-------|------|--------|
| id | bigint | Birlamchi kalit (PK) |
| name | string | Foydalanuvchi ismi |
| login | string | Login (unikal) |
| email | string | Email manzili |
| phone | string | Telefon raqami |
| password | string | Parol (hashed) |
| status | tinyint | 1=faol, 0=nofa'ol |
| photo | string/file | FileableTrait bilan saqlanadi |
| created_at | timestamp | Yaratilgan vaqti |
| updated_at | timestamp | O'zgartirilgan vaqti |

**Aloqalar:**
- `userRole` → 1:1 (UserRole bilan)
- `detail` → student ma'lumotlari bilan BelongsTo

---

### 👥 UserRole - Foydalanuvchi Roli

Foydalanuvchining roli va huquqlari.

| Ustun | Turi | Tavsif |
|-------|------|--------|
| id | bigint | Birlamchi kalit |
| user_id | bigint FK | Userga bog'langan |
| role | string | Roli: admin, user, student, instructor |
| name | string | To'liq rol nomi |
| created_at | timestamp | Yaratilgan vaqti |
| updated_at | timestamp | O'zgartirilgan vaqti |

---

### 🔑 UserLoginProviders - OAuth Integratsiya

Uchinchi tomon autentifikatsiya provayderlar.

| Ustun | Turi | Tavsif |
|-------|------|--------|
| id | bigint | Birlamchi kalit |
| user_id | bigint FK | Userga bog'langan |
| provider | string | Provider nomi (Google, GitHub, Facebook) |
| provider_id | string | Provider ichidagi ID |
| email | string | Email manzili |
| full_name | string | To'liq ism |
| photo | string | Profil rasmi URL |
| phone | string | Telefon raqami |
| created_at | timestamp | Yaratilgan vaqti |
| updated_at | timestamp | O'zgartirilgan vaqti |

---

### 📚 Category - Fanlar (Sertifikat Testlari)

Sertifikat testlarining fanlari (Matematika, Ingliz tili, Fizika va h.k.).

| Ustun | Turi | Tavsif |
|-------|------|--------|
| id | bigint | Birlamchi kalit |
| name | string | Fan nomi |
| parent_id | bigint nullable | Ota kategoriasi (agar bo'lsa) |
| icon | string/file | Icon fayl |
| description | text nullable | Tavsifi |
| is_active | boolean | Faolmi? |
| created_at | timestamp | Yaratilgan vaqti |
| updated_at | timestamp | O'zgartirilgan vaqti |

**Aloqalar:**
- `children` → 1:M (Boshqa kategoriyalar)
- `parent` → M:1 (Ota kategoriysiga)
- `questions` → 1:M (Savollar)
- `tests` → 1:M (Testlar)

---

### 🧱 Level - Darajalar (Suhbat Testlari)

Suhbat testlarining darajalari.

| Ustun | Turi | Tavsif |
|-------|------|--------|
| id | bigint | Birlamchi kalit |
| name | string | Daraja nomi: Junior, Middle, Senior |
| type | tinyint | Tur kodi |
| icon | string/file | Icon fayl |
| description | text nullable | Tavsifi |
| created_at | timestamp | Yaratilgan vaqti |
| updated_at | timestamp | O'zgartirilgan vaqti |

**Aloqalar:**
- `questions` → 1:M (Savollar)
- `tests` → 1:M (Testlar)

---

### 🎯 Speciality - Yo'nalishlar (Interview Testlari)

Suhbat testlarining yo'nalishlari.

| Ustun | Turi | Tavsif |
|-------|------|--------|
| id | bigint | Birlamchi kalit |
| name | string | Yo'nalish nomi: Backend, Frontend, DevOps, QA, Mobile |
| description | text nullable | Tavsifi |
| icon | string/file | Icon fayl |
| created_at | timestamp | Yaratilgan vaqti |
| updated_at | timestamp | O'zgartirilgan vaqti |

**Aloqalar:**
- `tests` → M:N (Pivot jadval `speciality_test` orqali)

---

### ❓ Question - Savollar (Markaziy Savol Bazasi)

Sertifikat va intervyu savollarining markaziy jadvali.

| Ustun | Turi | Tavsif |
|-------|------|--------|
| id | bigint | Birlamchi kalit |
| category_id | bigint FK nullable | Sertifikat testlari uchun |
| level_id | bigint FK nullable | Suhbat testlari uchun |
| test_type | tinyint | 1=sertifikat, 2=suhbat |
| question_text | text | Savol matni |
| photo | string/file nullable | Chizma, diagramma yoki rasm |
| type | tinyint | 0=test (variantli), 1=open (ochiq) |
| difficulty | tinyint nullable | Qiyinlik darajasi (1-5) |
| tags | string nullable | Teglar |
| is_active | boolean | Faolmi? |
| created_at | timestamp | Yaratilgan vaqti |
| updated_at | timestamp | O'zgartirilgan vaqti |

**Aloqalar:**
- `category` → BelongsTo (Category)
- `level` → BelongsTo (Level)
- `answers` → HasMany (Javoblar)
- `testAnswers` → HasMany (UserTestAnswer)

---

### ✅ Answer - Javoblar

Savol variantlari va to'g'ri javoblar.

| Ustun | Turi | Tavsif |
|-------|------|--------|
| id | bigint | Birlamchi kalit |
| question_id | bigint FK | Savolga bog'langan |
| answer_text | text | Javob matni |
| is_correct | boolean | To'g'ri javob belgisi |
| type | tinyint | 0=standart, 1=ochiq javob |
| order | int nullable | Javoblar tartibi |
| created_at | timestamp | Yaratilgan vaqti |
| updated_at | timestamp | O'zgartirilgan vaqti |

**Aloqalar:**
- `question` → BelongsTo (Question)

---

### 📝 Test - Test Meta Ma'lumotlari

⚠️ **Bu jadval ikkala test turini boshqaradi. Alohida sertifikat yoki suhbat jadvali yo'q.**

| Ustun | Turi | Tavsif |
|-------|------|--------|
| id | bigint | Birlamchi kalit |
| name | string | Test nomi |
| category_id | bigint FK nullable | Sertifikat testi uchun |
| level_id | bigint FK nullable | Suhbat testi uchun |
| test_type | tinyint | 1=sertifikat, 2=suhbat |
| speciality_id | bigint FK nullable | Yo'nalish (faqat interview uchun) |
| time_limit | int | Test davomiyligi (daqiqa) |
| questions_count | int | Testdagi savollar soni |
| randomize_questions | boolean | Savollarni tasodifiy aralashtirish |
| randomize_answers | boolean | Javoblarni tasodifiy aralashtirish |
| passing_score | int | O'tish balli (%) |
| description | text nullable | Test tavsifi |
| is_active | boolean | Faolmi? |
| created_at | timestamp | Yaratilgan vaqti |
| updated_at | timestamp | O'zgartirilgan vaqti |

**Aloqalar:**
- `category` → BelongsTo (Category)
- `level` → BelongsTo (Level)
- `specialities` → BelongsToMany (Pivot: speciality_test)
- `sessions` → HasMany (UserTestSession)

---

### 🔗 Speciality_Test - Pivot Jadval

Test va yo'nalish o'rtasidagi bog'lanish.

```sql
CREATE TABLE speciality_test (
    id bigint PRIMARY KEY AUTO_INCREMENT,
    speciality_id bigint NOT NULL,
    test_id bigint NOT NULL,
    created_at timestamp,
    updated_at timestamp,
    FOREIGN KEY (speciality_id) REFERENCES specialities(id) ON DELETE CASCADE,
    FOREIGN KEY (test_id) REFERENCES tests(id) ON DELETE CASCADE,
    UNIQUE KEY unique_speciality_test (speciality_id, test_id)
);
```

---

### 🔑 UserTestSession - Test Sessiyasi

Foydalanuvchining test yechish sessiyasi.

| Ustun | Turi | Tavsif |
|-------|------|--------|
| id | bigint | Birlamchi kalit |
| user_id | bigint FK | Foydalanuvchi |
| test_id | bigint FK | Test |
| started_at | timestamp | Test boshlangan vaqti |
| finished_at | timestamp nullable | Test tugatilgan vaqti |
| score | int nullable | Yaxlitlangan ball |
| correct_answers | int | To'g'ri javoblar soni |
| wrong_answers | int | Noto'g'ri javoblar soni |
| status | enum | pending, in_progress, completed, abandoned |
| created_at | timestamp | Yaratilgan vaqti |
| updated_at | timestamp | O'zgartirilgan vaqti |

**Aloqalar:**
- `user` → BelongsTo (User)
- `test` → BelongsTo (Test)
- `answers` → HasMany (UserTestAnswer)

---

### 💾 UserTestAnswer - Javoblar Yozuvi

Foydalanuvchi tomonidan berilgan javoblar.

| Ustun | Turi | Tavsif |
|-------|------|--------|
| id | bigint | Birlamchi kalit |
| session_id | bigint FK | Test sessiyasi |
| test_id | bigint FK | Test |
| question_id | bigint FK | Savol |
| answer_id | bigint FK nullable | Tanlangan javob (variantli savol uchun) |
| open_answer | text nullable | Ochiq javob (ochiq savol uchun) |
| is_correct | boolean | To'g'ri javobmi? |
| answered_at | timestamp | Javob berilgan vaqti |
| created_at | timestamp | Yaratilgan vaqti |
| updated_at | timestamp | O'zgartirilgan vaqti |

**Aloqalar:**
- `session` → BelongsTo (UserTestSession)
- `test` → BelongsTo (Test)
- `question` → BelongsTo (Question)
- `answer` → BelongsTo (Answer)

---

## 🔌 API Endpoints

### Test Boshlanishi

**POST** `/api/v1/test/start`

Request:
```json
{
  "test_id": 1
}
```

Response:
```json
{
  "success": true,
  "data": {
    "session_id": 123,
    "test_id": 1,
    "test_name": "Matematika",
    "time_limit": 60,
    "started_at": "2025-12-15T10:30:00Z"
  }
}
```

---

### Savollar Olish

**GET** `/api/v1/test/questions?session_id=123`

Response:
```json
{
  "success": true,
  "data": {
    "session_id": 123,
    "questions": [
      {
        "id": 1,
        "question_text": "2+2 nechasi?",
        "type": 0,
        "photo": null,
        "answers": [
          {
            "id": 1,
            "answer_text": "3"
          },
          {
            "id": 2,
            "answer_text": "4"
          }
        ]
      }
    ]
  }
}
```

---

### Javob Saqlash

**POST** `/api/v1/test/submit-answer`

Request:
```json
{
  "session_id": 123,
  "question_id": 1,
  "answer_id": 2,
  "open_answer": null
}
```

Response:
```json
{
  "success": true,
  "data": {
    "is_correct": true,
    "message": "Javob qabul qilindi"
  }
}
```

---

### Test Yakunlash

**POST** `/api/v1/test/finish`

Request:
```json
{
  "session_id": 123
}
```

Response:
```json
{
  "success": true,
  "data": {
    "score": 85,
    "correct_answers": 17,
    "wrong_answers": 3,
    "status": "completed"
  }
}
```

---

### Test Natijalari

**GET** `/api/v1/test/results/{sessionId}`

Response:
```json
{
  "success": true,
  "data": {
    "session_id": 123,
    "test_name": "Matematika",
    "score": 85,
    "correct_answers": 17,
    "wrong_answers": 3,
    "total_questions": 20,
    "time_spent": 45,
    "status": "completed",
    "answers": [
      {
        "question_id": 1,
        "question_text": "2+2 nechasi?",
        "user_answer": "4",
        "correct_answer": "4",
        "is_correct": true
      }
    ]
  }
}
```

---

### Foydalanuvchi Test Tarixi

**GET** `/api/v1/test/history?per_page=10`

Response:
```json
{
  "success": true,
  "data": {
    "total": 15,
    "per_page": 10,
    "current_page": 1,
    "data": [
      {
        "session_id": 123,
        "test_name": "Matematika",
        "test_type": 1,
        "score": 85,
        "finished_at": "2025-12-15T11:00:00Z"
      }
    ]
  }
}
```

---

## 🔄 WebSocket Events

Haqiqiy vaqt yangilashlar uchun WebSocket ishlatilysa:

### Client → Server

- `test:start` - Test boshlash
- `test:submit-answer` - Javob saqlash
- `test:finish` - Test tugatish

### Server → Client

- `test:question-received` - Savol qabul qilindi
- `test:answer-correct` - To'g'ri javob
- `test:answer-incorrect` - Noto'g'ri javob
- `test:time-remaining` - Qolgan vaqt
- `test:finished` - Test tugadi

---

## 📊 Statistika va Analitika

### Sertifikat Testlari Statistikasi

```
GET /api/v1/stats/certificate/{category_id}

Natija:
- Yechgan foydalanuvchilar soni
- O'rtacha ball
- Qiyin savollar (eng ko'p xato)
- O'tgan foydalanuvchilar foizi
```

### Suhbat Testlari Statistikasi

```
GET /api/v1/stats/interview/{level_id}/{speciality_id}

Natija:
- Suhbat qiluvchilar soni
- Darajalar bo'yicha taqsimot
- O'rtacha vaqt
- Natija turlari (Low/Medium/Strong)
```

---

## 🔒 Xavfsizlik va Validatsiya

- ✅ Test vaqti maxfiy saqlanadi
- ✅ Javoblar IP va sessiya bilan bog'lanadi
- ✅ Plagiarizmni aniqlash (test vaqtida hamma savollar bir xil)
- ✅ Noto'g'ri harakatlari aniqlash (masalan, test vaqtida sahifa yangilash)
- ✅ Role-based access control (RBAC)

---

## 🚀 Deployment va Configuration

### Database Migratsiyalar

```bash
php artisan migrate
```

### Key Configuration

```env
TEST_TIME_LIMIT=60
RANDOMIZE_QUESTIONS=true
RANDOMIZE_ANSWERS=true
PASSING_SCORE_CERTIFICATE=60
PASSING_SCORE_INTERVIEW=70
```

---

## 📞 Support va Kontakt

Har qanday savollar yoki masalalar uchun admin panelida xabar qoldiring yoki admin@platform.uz ga yozing.
