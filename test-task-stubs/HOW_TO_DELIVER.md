# Test Task Berish Qo'llanmasi

## 🎯 Eng Yaxshi Yondashuv

**Tavsiya:** Minimal Kod + MD Fayl + Database Schema

---

## 📦 Dasturchiga Beriladigan Materiallar

### 1. Asosiy Fayllar (ZIP yoki GitHub)

```
test-task-vacancy-statistics.zip
├── BACKEND_DEVELOPER_TEST_TASK.md      # To'liq task tavsifi
├── TEST_TASK_DELIVERY_GUIDE.md        # Bu qo'llanma
├── README.md                          # Setup qo'llanmasi
├── test-task-stubs/                   # Minimal kodlar
│   ├── app/
│   ├── Modules/
│   └── database/
└── postman/                           # API collection (ixtiyoriy)
    └── VacancyStatisticsAPI.postman_collection.json
```

### 2. Nima Beriladi:

✅ **Beriladi:**
- Task tavsifi (MD fayl)
- Minimal stub kodlar (interface'lar, bo'sh class'lar)
- Database schema (SQL, ma'lumotlarsiz)
- Setup qo'llanmasi
- API documentation (Postman collection)

❌ **BERILMAYDI:**
- To'liq loyiha kodi
- Production database
- Real API keys
- Business logic kodlari
- Authentication secrets

---

## 📤 Topshirish Usullari

### Usul 1: GitHub Repository (Eng Yaxshi)

**Qadamlari:**

1. **Yangi repository yaratish:**
   ```bash
   mkdir test-task-vacancy-statistics
   cd test-task-vacancy-statistics
   git init
   ```

2. **Fayllarni yuklash:**
   ```bash
   # Minimal kodlarni ko'chirish
   cp -r test-task-stubs/* .
   cp BACKEND_DEVELOPER_TEST_TASK.md .
   cp TEST_TASK_DELIVERY_GUIDE.md .
   ```

3. **Commit va push:**
   ```bash
   git add .
   git commit -m "Initial test task setup"
   git remote add origin <repository-url>
   git push -u origin main
   ```

4. **Dasturchiga access berish:**
   - GitHub'da private repository yaratish
   - Dasturchiga collaborator sifatida qo'shish
   - Yoki invite link yuborish

**Afzalliklari:**
- ✅ Version control
- ✅ Pull request orqali review
- ✅ Code history
- ✅ Easy collaboration

---

### Usul 2: Zip Fayl

**Qadamlari:**

1. **Fayllarni zip qilish:**
   ```bash
   zip -r test-task-vacancy-statistics.zip \
     BACKEND_DEVELOPER_TEST_TASK.md \
     TEST_TASK_DELIVERY_GUIDE.md \
     README.md \
     test-task-stubs/ \
     postman/
   ```

2. **Yuborish:**
   - Email orqali
   - Cloud storage (Google Drive, Dropbox)
   - Password bilan shifrlash (ixtiyoriy)

**Afzalliklari:**
- ✅ Oddiy
- ✅ Tez
- ✅ Offline ishlatish mumkin

---

### Usul 3: GitLab/GitHub Gist

**Qadamlari:**

1. **Gist yaratish:**
   - GitHub Gist yoki GitLab Snippet
   - Barcha fayllarni yuklash
   - Private yoki public (private tavsiya)

2. **Link yuborish:**
   - Email orqali
   - Messaging orqali

**Afzalliklari:**
- ✅ Tez setup
- ✅ Version control
- ✅ Easy sharing

---

## 📧 Email Template

```
Subject: Backend Developer Test Task - Jobish Platform

Assalomu alaykum [Dasturchi ismi],

Sizni Jobish platformasi backend dasturchi pozitsiyasi uchun test task bilan tanishtirmoqchiman.

📋 Test Task:
- Vazifa: Vakansiya Statistika Moduli yaratish
- Vaqt: 3-5 kun
- Texnologiya: Laravel (PHP 8.1+)
- Daraja: Middle/Senior

📦 Materiallar:
1. Task tavsifi: [GitHub link yoki zip fayl]
2. Minimal kodlar: [Repository link]
3. Database schema: SQL fayllar ichida

📖 Qo'llanmalar:
- BACKEND_DEVELOPER_TEST_TASK.md - To'liq task tavsifi
- README.md - Setup qo'llanmasi
- TEST_TASK_DELIVERY_GUIDE.md - Bu qo'llanma

✅ Qadamlari:
1. Repository'ni clone qiling yoki zip faylni oching
2. README.md faylini o'qing
3. BACKEND_DEVELOPER_TEST_TASK.md faylini o'qing
4. Kod yozishni boshlang

❓ Savollar bo'lsa, murojaat qiling.

Omad tilaymiz!
[Ismingiz]
```

---

## ✅ Checklist: Berishdan Oldin

- [ ] BACKEND_DEVELOPER_TEST_TASK.md tayyor
- [ ] Minimal kodlar yaratilgan (stub'lar)
- [ ] Database schema tayyor (ma'lumotlarsiz)
- [ ] README.md yozilgan
- [ ] Xavfsizlik tekshirilgan (hech qanday secret yo'q)
- [ ] Repository yaratilgan yoki zip tayyor
- [ ] Postman collection tayyor (ixtiyoriy)
- [ ] Email template tayyor

---

## 🔒 Xavfsizlik Tekshiruvi

### ✅ Xavfsiz (Berilishi Mumkin):
- Database schema (ma'lumotlarsiz)
- Model strukturalari
- Interface'lar
- API endpoint strukturalari
- Test ma'lumotlar (fake data)

### ❌ Xavfsizlik Xavfi (BERILMASLIGI KERAK):
- Production database dump
- Real API keys va tokens
- Business logic kodlari
- Authentication secrets
- Third-party service credentials
- User ma'lumotlari
- Production .env fayl

---

## 🎓 Dasturchi Qo'llab-quvvatlash

### Qanday Yordam Berish Mumkin:
1. **Clarification** - Task haqida savollar
2. **Technical Support** - Setup muammolari
3. **Progress Check** - Vaqt-vaqti bilan tekshirish

### Qanday Yordam BERILMASLIGI Kerak:
- ❌ To'liq kod yozish
- ❌ Business logic tushuntirish (faqat task'da bo'lishi kerak)
- ❌ Database ma'lumotlarini berish

---

## 📊 Topshirishdan Keyin

### 1. Code Review
- Pull request orqali review
- Code quality tekshirish
- Best practices tekshirish

### 2. Testing
- Manual testing
- API testing
- Edge cases tekshirish

### 3. Baholash
- Functionality (40%)
- Code Quality (30%)
- Performance (15%)
- Documentation (10%)
- Testing (5%)

---

**Eslatma:** Bu qo'llanma test taskni xavfsiz va samarali berish uchun yaratilgan.

