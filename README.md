<p align="center">
  <a href="https://www.instagram.com/codebym_" target="_blank">
    <img src="https://img.shields.io/badge/Built%20by-Codebym-00bcd4?style=for-the-badge" alt="Built by Codebym">
  </a>
</p>

# 🧭 Task Management System (Görev Yönetim Sistemi)

A modern PHP-based web application that allows users to create, update, complete, and delete personal tasks.  
This project demonstrates secure CRUD operations, user authentication, and responsive UI using Bootstrap 5.

---

## <img src="https://twemoji.maxcdn.com/v/latest/svg/1f1ec-1f1e7.svg" width="20"/> English Version  

### 🎯 Overview
**Task Management System** is a fully functional web application built with **PHP**, **MySQL**, and **Bootstrap 5**, allowing users to manage their own tasks with authentication and user-specific data handling.

### ⚙️ Key Features
✅ User authentication (register, login, logout)  
✅ Secure password hashing (bcrypt)  
✅ SQL injection protection (prepared statements)  
✅ CRUD operations for personal tasks  
✅ Responsive UI with modern gradient design  
✅ Statistics dashboard (total, completed, pending)  
✅ Modal-based task creation and editing  
✅ Client-side and server-side validation  
✅ XSS protection via `htmlspecialchars`

### 🧱 Technologies Used
| Technology | Purpose |
|-------------|----------|
| **PHP** | Backend logic & authentication |
| **MySQL** | Database for users & tasks |
| **HTML5 / Bootstrap 5** | Responsive front-end design |
| **JavaScript** | UI interactions & validation |
| **CSS (Glassmorphism)** | Modern styling & animations |

---

### 📁 Folder Structure
```
gorev-yonetim-sistemi/
│
├── assets/
│   ├── css/style.css        # Modern CSS design (gradients, blur, responsive)
│   ├── js/script.js         # UI interactions, form validation
│   └── img/icon.png         # App logo
│
├── auth/
│   ├── login.php            # Login logic with sessions
│   ├── register.php         # User registration (hashed passwords)
│   └── logout.php           # Session destroy & redirect
│
├── config/
│   └── db.php               # Database connection (MySQLi, utf8mb4)
│
├── tasks/
│   ├── create.php           # Add new tasks
│   ├── update.php           # Mark as completed / edit
│   └── delete.php           # Delete tasks securely
│
├── includes/
│   ├── header.php           # Navigation bar, Bootstrap links
│   └── footer.php           # Footer and JS includes
│
├── index.php                # Main task list / dashboard
├── login_form.php           # Login page (modern gradient form)
├── register_form.php        # Register page
└── database.sql             # SQL schema (users & tasks tables)
```

---

### 🗄️ Database Schema
```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  is_completed BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

---

### 🚀 Installation & Setup
1. Clone the repository:
   ```bash
   git clone https://github.com/code-by-m/gorev-yonetim-sistemi.git
   ```
2. Import `database.sql` into your MySQL (phpMyAdmin or CLI)
3. Update your database credentials inside `config/db.php`
4. Start your local server (XAMPP, Laragon, etc.)
5. Open:
   ```
   http://localhost/gorev-yonetim-sistemi
   ```

---

### 📜 License

[MIT License © 2025](LICENSE) — [CodeByM](https://github.com/code-by-m)  

This project is licensed under the MIT License and is developed exclusively under the **CodeByM** brand.  
Removing or altering the “Design by CodeByM” signature is **not recommended**.  
Maintaining this attribution helps preserve the identity and consistency of the CodeByM brand.

---

### 📣 Contact

📩 Instagram: [@codebym_](https://www.instagram.com/codebym_)  
🌐 GitHub: [code-by-m](https://github.com/code-by-m)  
💼 LinkedIn: [Mehmet Kara](https://www.linkedin.com/in/mehmetkara-dv)

---

## <img src="https://twemoji.maxcdn.com/v/latest/svg/1f1f9-1f1f7.svg" width="20"/> Türkçe Versiyon


### 🎯 Genel Bakış
**Görev Yönetim Sistemi**, kullanıcıların görevlerini oluşturabileceği, düzenleyebileceği, tamamlayabileceği ve silebileceği PHP tabanlı bir web uygulamasıdır.  
Kullanıcı bazlı oturum yönetimi, güvenli CRUD işlemleri ve modern Bootstrap 5 tasarımı içerir.

### ⚙️ Temel Özellikler
✅ Kullanıcı kayıt & giriş sistemi (PHP Sessions)  
✅ Şifre hashleme (bcrypt)  
✅ SQL Injection koruması (prepared statements)  
✅ XSS koruması (`htmlspecialchars`)  
✅ Görev ekleme, düzenleme, silme  
✅ Tamamlanan görevleri işaretleme  
✅ Duyarlı (responsive) tasarım  
✅ Modern gradient ve glassmorphism arayüz  
✅ İstatistik kartları ve filtreleme özellikleri  

---

### 🧱 Kullanılan Teknolojiler
| Teknoloji | Kullanım Alanı |
|------------|----------------|
| **PHP** | Sunucu tarafı işlemler |
| **MySQL** | Veritabanı yönetimi |
| **Bootstrap 5** | Arayüz tasarımı |
| **JavaScript** | Etkileşimli öğeler |
| **CSS** | Tasarım ve animasyonlar |

---
### 📁 Klasör Yapısı
```
gorev-yonetim-sistemi/
│
gorev-yonetim-sistemi/
├── assets/
│   ├── css/style.css          # Modern CSS tasarımı (gradientler, bulanıklık efekti, duyarlı yapı)
│   ├── js/script.js           # Arayüz etkileşimleri, form doğrulama işlemleri
│   └── img/icon.png           # Uygulama logosu
│
├── auth/
│   ├── login.php              # Kullanıcı girişi
│   ├── register.php           # Kullanıcı kaydı (şifreler hashlenmiş)
│   ├── logout.php             # Kullanıcı çıkışı
│   └── db.php                 # Veritabanı bağlantısı (MySQLi, utf8mb4 karakter seti)
│
├── tasks/
│   ├── create.php             # Yeni görev ekleme
│   ├── complete.php           # Görevi tamamlandı olarak işaretleme
│   └── delete.php             # Görev silme işlemi
│
├── includes/
│   ├── header.php             # Navigasyon çubuğu, Bootstrap bağlantıları
│   └── footer.php             # Alt bilgi ve JS dosyaları dahil etme
│
├── index.php                  # Ana sayfa – tüm görevleri listeleme / kontrol paneli
├── login.php                  # Giriş formu
├── register.php               # Kayıt formu
└──  database.sql               # SQL şeması (kullanıcılar ve görevler tabloları)

```

---

### 🗄️ Veritabanı Şeması
```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  is_completed BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```
---

### 🚀 Kurulum
1. Reponun klonunu oluştur:
   ```bash
   git clone https://github.com/code-by-m/gorev-yonetim-sistemi.git
   ```
2. `database.sql` dosyasını MySQL’e aktar.  
3. `config/db.php` içinde veritabanı bilgilerini düzenle.  
4. Local sunucuyu çalıştır (XAMPP veya Laragon).  
5. Tarayıcıda:
   ```
   http://localhost/gorev-yonetim-sistemi
   ```

---

### 📜 Lisans

[MIT Lisansı © 2025](LICENSE) — [CodeByM](https://github.com/code-by-m)  

Bu proje **CodeByM markası** altında geliştirilmiş olup MIT Lisansı ile lisanslanmıştır.  
“Design by CodeByM” ibaresinin kaldırılması veya değiştirilmesi **önerilmez**.  
Bu ibarenin korunması, markanın kimliğini ve tutarlılığını sürdürmeye yardımcı olur.

---

### 📣 İletişim

📩 Instagram: [@codebym_](https://www.instagram.com/codebym_)  
🌐 GitHub: [code-by-m](https://github.com/code-by-m)  
💼 LinkedIn: [Mehmet Kara](https://www.linkedin.com/in/mehmetkara-dv)

---

## 🖼️ Screenshots / Ekran Görüntüleri

---

### 🏠 Homepage  
Landing screen shown to users before logging in.  
Kullanıcıların giriş yapmadan önce gördüğü açılış ekranı.  
![Homepage](https://github.com/code-by-m/gorev-yonetim-sistemi/blob/main/assets/img/pages/homepage.png?raw=true)

---

### 🔐 Login Page  
Clean and minimal login screen with email and password fields.  
Temiz ve sade giriş ekranı; email ve şifre alanları içerir.  
![Login Page](https://github.com/code-by-m/gorev-yonetim-sistemi/blob/main/assets/img/pages/login.png?raw=true)

---

### 🧾 Register Page  
Simple registration form with username, email, and password inputs.  
Kullanıcı adı, email ve şifre alanlarına sahip basit kayıt formu.  
![Register Page](https://github.com/code-by-m/gorev-yonetim-sistemi/blob/main/assets/img/pages/register.png?raw=true)

---

### 🧭 Task Dashboard  
The main screen where users view their tasks, including statistics cards and filtering options.  
Kullanıcının görevlerini görüntülediği ana ekran. İstatistik kartları ve filtreleme seçenekleri içerir.  
![Dashboard](https://github.com/code-by-m/gorev-yonetim-sistemi/blob/main/assets/img/pages/dashboard.png?raw=true)

---

### ➕ Add Task Modal  
Modal window for adding a new task with title and description fields.  
Başlık ve açıklama alanlarıyla yeni görev ekleme penceresi.  
![Add Task Modal](https://github.com/code-by-m/gorev-yonetim-sistemi/blob/main/assets/img/pages/add-task.png?raw=true)

---

### ✏️ Edit Task Modal  
Modal window for editing an existing task.  
Mevcut görevleri düzenlemek için kullanılan modal pencere.  
![Edit Task Modal](https://github.com/code-by-m/gorev-yonetim-sistemi/blob/main/assets/img/pages/edit-task.png?raw=true)

---

### 📱 Mobile View  
Responsive layout shown on mobile devices.  
Mobil cihazlarda uygulamanın duyarlı (responsive) görünümü.  
![Mobile View](https://github.com/code-by-m/gorev-yonetim-sistemi/blob/main/assets/img/pages/mobile-view-dashboard.png?raw=true)

---

<p align="center">
  Designed & Built by <strong><a href="https://www.instagram.com/codebym_" target="_blank">Codebym</a></strong>
</p>
