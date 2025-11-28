# Vacancy Statistics Test Task - Setup Guide

## 📋 Umumiy Ma'lumot

Bu test task uchun minimal kodlar va struktura. To'liq task tavsifi: `BACKEND_DEVELOPER_TEST_TASK.md`

---

## 🚀 Setup

### 1. Laravel Project Yaratish

```bash
# Yangi Laravel project yaratish
composer create-project laravel/laravel vacancy-statistics-task

# Yoki mavjud Laravel project'ga qo'shish
cd your-laravel-project
```

### 2. Stub Kodlarni Ko'chirish

```bash
# Stub kodlarni project'ga ko'chirish
cp -r test-task-stubs/app/* app/
cp -r test-task-stubs/Modules/* Modules/
cp -r test-task-stubs/database/* database/
```

### 3. Database Setup

```bash
# Migration'larni ishga tushirish
php artisan migrate

# Yoki SQL fayllarni to'g'ridan-to'g'ri import qilish
mysql -u root -p your_database < database/schema/vacancies_structure.sql
```

### 4. Dependencies

```bash
# Laravel Modules (agar kerak bo'lsa)
composer require nwidart/laravel-modules

# Boshqa dependencies
composer require ...
```

---

## 📁 Fayl Strukturasi

```
your-project/
├── app/
│   └── Models/
│       └── Vacancy/
│           └── VacancyView.php (stub)
├── Modules/
│   └── Company/
│       └── App/
│           ├── Services/
│           │   └── Vacancy/
│           │       ├── Interface/
│           │       │   └── iVacancyStatisticsService.php
│           │       └── VacancyStatisticsService.php (stub)
│           └── Http/
│               └── Controllers/
│                   └── Vacancy/
│                       └── VacancyStatisticsController.php (stub)
└── database/
    ├── migrations/
    │   └── 2024_01_01_000000_create_vacancy_views_table.php (stub)
    └── schema/
        └── vacancies_structure.sql
```

---

## ✅ Vazifalar

### 1. Migration To'ldirish
- `vacancy_views` jadvalini yaratish
- Index'lar qo'shish
- Foreign key'lar qo'shish

### 2. Model To'ldirish
- `VacancyView` model to'ldirish
- Relationships qo'shish
- Scopes (agar kerak)

### 3. Service Implementation
- `VacancyStatisticsService` to'ldirish
- Matching score algoritmini yozish
- Statistika hisoblash logikasi

### 4. Controller Implementation
- `VacancyStatisticsController` to'ldirish
- Request validation
- Error handling
- Resource transformation

### 5. Routes
- API route qo'shish
- Middleware (agar kerak)

---

## 📝 Eslatmalar

- Barcha stub fayllarda `TODO` comment'lar bor
- Real business logic kodlarni o'zingiz yozishingiz kerak
- Database schema faqat struktura, real ma'lumotlar yo'q
- Test ma'lumotlarni o'zingiz yaratishingiz kerak

---

## 🔗 Foydali Linklar

- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Modules](https://nwidart.com/laravel-modules/)
- [Eloquent Relationships](https://laravel.com/docs/eloquent-relationships)

---

**Omad tilaymiz! 🚀**

