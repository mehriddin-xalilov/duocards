# Unified Testing Platform

Milliy sertifikat savollari va ishga kirish suhbat testlarini yagona backend va websocket orqali boshqaruvchi test platformasi.

Bu loyiha quyidagi mavjud modellarga tayangan holda qurilgan:

- User
- UserRole
- UserLoginProviders
- Category
- Level
- Question
- Answer
- Test
- UserTestSession
- UserTestAnswer

Platforma **sertifikat testlari** va **interview testlari**ni alohida jadvallar yaratmasdan, mavjud jadvallarga minimal kengaytirish orqali qo‘llab-quvvatlaydi.

---

# 🎯 Maqsad

Platforma ikki asosiy test turini boshqaradi:

### 1) Milliy Sertifikat Testlari (test_type = 1)
- Fanlar `Category` orqali boshqariladi
- Savollar umumiy `questions` jadvalidan olinadi
- Statistikalar:
    - yechgan foydalanuvchilar soni
    - to‘g‘ri javoblar foizi
    - qiyin savollar reytingi

### 2) Ishga Kirish Suhbat Testlari (test_type = 2)
- Darajalar `Level` orqali (Junior, Middle, Senior)
- Yo‘nalishlar `speciality_id` orqali (Backend, Frontend va h.k.)
- Random intervyu savollari
- Natija darajasi: Low / Medium / Strong

---

# 🏛 Model Strukturalari

Platforma mavjud jadvallarni buzmasdan, faqat kerakli joylarga **test_type** va yo‘nalish uchun **speciality_id** qo‘shilgan.

Quyida barcha modellarga to‘liq tavsif berilgan.

---

## 👤 User
Foydalanuvchi ma’lumotlari va autentifikatsiya:

| Ustun | Turi | Izoh |
|------|------|------|
| id | bigint | PK |
| name | string | Foydalanuvchi ismi |
| login | string | Login |
| email | string | Email |
| phone | string | Telefon raqami |
| password | string | Hashed |
| status | tinyint | 1=active, 0=inactive |
| photo | file | FileableTrait bilan saqlanadi |

### Aloqalar
- `userRole` → 1:1
- `detail` → student bilan BelongsTo

---

## 👤 UserRole

| Ustun | Turi | Izoh |
|-------|------|------|
| id | bigint | PK |
| role | string | Roli (admin, user, student) |
| name | string | To‘liq ism |
| user_id | FK | Userga bog‘langan |

---

## 🔑 UserLoginProviders

| Ustun | Turi | Izoh |
|-------|------|------|
| provider | string | OAuth provider nomi |
| provider_id | string | Provider ID |
| email | string | Email |
| full_name | string | To‘liq ism |
| photo | string | Profil rasmi URL |
| phone | string | Telefon |
| user_id | FK | Userga bog‘langan |

---

# 📚 Category (Fanlar — Sertifikat testlari uchun)

| Ustun | Turi | Izoh |
|-------|------|------|
| id | bigint | PK |
| name | string | Fan nomi |
| parent_id | bigint nullable | Parent category (agar bo‘lsa) |
| icon | file | Icon fayl |

### Aloqalar
- `children` → 1:M
- `parent` → M:1
- `questions` → 1:M

---

# 🧱 Level (Junior/Middle/Senior — Interview testlari uchun)

| Ustun | Turi | Izoh |
|-------|------|------|
| id | bigint | PK |
| name | string | Daraja nomi (Junior, Middle, Senior) |
| type | tinyint | Tur kodi |
| icon | file | Icon fayl |

### Aloqalar
- `questions` → 1:M

---

# 🏷 Speciality (Yo‘nalishlar — Interview testlari uchun)

| Ustun | Turi | Izoh |
|-------|------|------|
| id | bigint | PK |
| name | string | Yo‘nalish nomi (Backend, Frontend, DB va h.k.) |

### Aloqalar
- `tests` → M:N pivot `speciality_test`

---

# ❓ Question (Umumiy savollar bazasi)

Sertifikat va intervyu savollari **bitta jadvalda** saqlanadi.

| Ustun | Turi | Izoh |
|-------|------|------|
| id | bigint | PK |
| category_id | FK nullable | Sertifikat testlari uchun |
| level_id | FK nullable | Suhbat testlari uchun |
| question_text | text | Savol matni |
| photo | file | Chizma yoki diagramma |
| type | tinyint | 0=test, 1=open |

### Aloqalar
- `belongsTo`: Level
- `belongsTo`: Category
- `hasMany`: Answer

---

# ✅ Answer (Savolning variantlari)

| Ustun | Turi | Izoh |
|--------|------|------|
| id | bigint | PK |
| question_id | FK | Savolga bog‘langan |
| answer_text | text | Javob matni |
| is_correct | boolean | To‘g‘ri javob belgisi |
| type | tinyint | 0=standard, 1=open |

---

# 📝 Test (Test metadata)

‼️ **Mana shu jadval ikkala test turini boshqaradi — alohida sertifikat jadvali yo‘q.**

| Ustun | Turi | Izoh |
|-------|------|------|
| id | bigint | PK |
| name | string | Test nomi |
| category_id | FK nullable | Sertifikat testi uchun |
| level_id | FK nullable | Suhbat testi uchun |
| time_limit | int | Test davomiyligi (daqiqa) |
| questions_count | int | Testdagi savollar soni |
| randomize_questions | boolean | Savollarni tasodifiy aralashtirish |
| randomize_answers | boolean | Javoblarni tasodifiy aralashtirish |
| test_type | tinyint | 1=sertifikat, 2=suhbat |
| speciality_id | bigint nullable | Yo‘nalish (faqat interview uchun) |

### Pivot qo‘shimcha:

```sql
ALTER TABLE tests
ADD COLUMN test_type TINYINT DEFAULT 1,
ADD COLUMN speciality_id BIGINT NULL;
