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
    - to‘g‘ri javoblar bozori
    - qiyin savollar reytingi

### 2) Ishga Kirish Suhbat Testlari (test_type = 2)
- Darajalar `Level` orqali (Junior, Middle, Senior)
- Yo‘nalishlar `speciality_id` orqali (Backend, Frontend va h.k.)
- Random intervyu savollari
- Natija darajasi: Low / Medium / Strong

---

# 🏛 Model Strukturalari

Platforma senga tegishli jadvallarni buzmasdan, faqat kerakli joylarga test turini belgilash uchun **test_type** va yo‘nalish uchun **speciality_id** qo‘shilgan.

Quyida to‘liq tavsif berilgan.

---

## 👤 User
Foydalanuvchi ma’lumotlari va autentifikatsiya:

| Ustun | Turi | Izoh |
|------|------|------|
| id | bigint | PK |
| name | string | Foydalanuvchi ismi |
| login | string | Login |
| email | string | Email |
| phone | string | Telefon |
| password | string | Hashed |
| status | tinyint | 1=active, 0=inactive |
| photo | file | FileableTrait bilan |

### Aloqalar
- **userRole** → 1:1
- **detail** → student bilan BelongsTo

---

## 👤 UserRole
| Ustun | Turi |
|-------|------|
| id | bigint |
| role | string |
| name | string |
| user_id | foreign key |

---

## 🔑 UserLoginProviders
| Ustun | Turi |
|-------|------|
| provider | string |
| provider_id | string |
| email | string |
| full_name | string |
| photo | string |
| phone | string |
| user_id | foreign key |

---

# 📚 Category (Fanlar — Sertifikat testlari uchun)
| Ustun | Turi |
|-------|------|
| id | bigint |
| name | string |
| parent_id | nullable |
| icon | file |

### Aloqalar
- children → 1:M
- parent → M:1
- questions → 1:M

---

# 🧱 Level (Junior/Middle/Senior — Interview testlari uchun)
| Ustun | Turi |
|-------|------|
| id | bigint |
| name | string |
| type | tinyint |
| icon | file |

### Aloqalar
- questions → 1:M

---

# ❓ Question (Umumiy savollar bazasi)
Sertifikat va intervyu savollari **bitta jadvalda** saqlanadi.

| Ustun | Turi | Izoh |
|-------|------|------|
| id | bigint | PK |
| category_id | FK | Sertifikat testlari uchun |
| level_id | FK | Suhbat testlari uchun |
| question_text | text | Savol |
| photo | file | Chizma |
| type | tinyint | 0=test, 1=open |

### Aloqalar
- belongsTo: Level
- belongsTo: Category

---

# ✅ Answer (Savolning variantlari)
| Ustun | Turi |
|--------|------|
| id | bigint |
| question_id | FK |
| answer_text | text |
| is_correct | boolean |
| type | tinyint |

---

# 📝 Test (Test metadata)

‼️ **Mana shu jadval ikkala test turini boshqaradi — alohida sertifikat jadvali yo‘q.**

| Ustun | Turi | Izoh |
|-------|------|------|
| id | bigint |
| name | string |
| category_id | FK | Sertifikat testi uchun |
| level_id | FK | Suhbat testi uchun |
| time_limit | int |
| questions_count | int |
| randomize_questions | boolean |
| randomize_answers | boolean |
| test_type | tinyint | 1=sertifikat, 2=suhbat |
| speciality_id | bigint nullable | Yo‘nalish (Backend va boshqalar) |

Minimal qo‘shimcha:

```sql
ALTER TABLE tests
ADD COLUMN test_type TINYINT DEFAULT 1,
ADD COLUMN speciality_id BIGINT NULL;
