# Buku Tamu Digital PTSP Kemenag Nganjuk

Aplikasi Buku Tamu Digital yang modern, aman, dan terintegrasi dengan notifikasi WhatsApp untuk mendukung digitalisasi pelayanan publik di PTSP Kementerian Agama Kabupaten Nganjuk.

## 🚀 Fitur Utama

### 1. **Frontend Modern & Responsive**
- **Single Page Design**: Tampilan satu halaman tanpa scroll (100vh)
- **Compact Header**: Logo Kemenag + judul minimal
- **Grid Layout**: Form 2 kolom yang otomatis menjadi 1 kolom di mobile
- **Theme Kemenag**: Warna hijau konsisten dengan identitas Kemenag
- **Touch-Friendly**: Tombol besar dan mudah diakses di perangkat mobile
- **Real-time Validation**: Validasi form langsung saat input

### 2. **Sistem UUID untuk Keamanan**
- **UUID Primary Key**: Mengganti ID auto-increment dengan UUID
- **Enhanced Security**: Mencegah enumerasi ID dan prediksi data
- **Privacy Protection**: Melindungi informasi jumlah tamu
- **Scalable**: Siap untuk sistem terdistribusi dan API

### 3. **WhatsApp Notification System**
- **Auto Notification**: Notifikasi otomatis ke admin dan tamu setelah check-in
- **Checkout Links**: Link checkout dikirim via WhatsApp
- **API Integration**: go-whatsapp-web-multidevice API
- **Template Messages**: Format pesan standar dengan info lengkap

### 4. **Admin Panel Comprehensive**
- **Dashboard AdminLTE**: Interface modern dengan statistik
- **CRUD Lengkap**: Manajemen tamu dan bidang
- **Pagination**: Daftar tamu dengan pagination efisien
- **WhatsApp Management**: Monitor dan test WhatsApp service
- **Report System**: Laporan kunjungan dengan filter dan export

### 5. **Security & HTTPS**
- **Force HTTPS**: Konfigurasi HTTPS di production
- **Security Headers**: HSTS, CSP protection
- **Middleware**: Custom security middleware
- **CSRF Protection**: Token validation

### 6. **Database & Performance**
- **Optimized Structure**: Relasi tabel yang efisien
- **Migration Strategy**: UUID migration tanpa data loss
- **Seeding System**: Data dummy untuk testing
- **Query Optimization**: Eloquent ORM yang optimal

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 8.x
- **Frontend**: Bootstrap 5.3, jQuery, FontAwesome
- **Database**: MySQL dengan UUID primary keys
- **Admin Panel**: AdminLTE 3.x
- **API Integration**: WhatsApp go-whatsapp-web-multidevice
- **Security**: HTTPS, CSRF, UUID, Middleware

## 📋 Struktur Fitur

### Frontend (Guest)
- Form check-in responsif
- Halaman success dengan info lengkap
- Halaman checkout dengan durasi kunjungan
- Print-friendly layout

### Backend (Admin)
- Dashboard dengan statistik
- Manajemen guestbook (CRUD)
- Manajemen bidang/divisi
- WhatsApp monitoring panel
- Laporan kunjungan
- Export data (Excel/CSV)

### Integrasi WhatsApp
- Notifikasi real-time
- Status monitoring
- Test message functionality
- Error handling & retry

## 🔐 Keamanan

- **UUID Implementation**: Primary key UUID untuk semua data sensitif
- **HTTPS Enforcement**: Force HTTPS di production
- **Route Validation**: UUID pattern validation
- **Middleware Protection**: Custom security middleware
- **CSRF Protection**: Laravel built-in CSRF

## 📱 Mobile Support

- **Responsive Design**: Mobile-first approach
- **Touch Optimization**: Button size minimal 44px
- **Breakpoint Strategy**: Desktop, tablet, mobile
- **Offline Ready**: Structure siap untuk PWA

## 🚀 Installation & Setup

```bash
# Clone repository
git clone https://github.com/rahmadjunianto/buku-tamu.git
cd buku-tamu

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed

# WhatsApp configuration
# Update .env with WhatsApp API settings
WHATSAPP_SERVICE_URL=https://your-whatsapp-api.com
WHATSAPP_AUTH_USERNAME=admin
WHATSAPP_AUTH_PASSWORD=admin

# Start development server
php artisan serve
```

## 📚 Dokumentasi

- [UUID Implementation Guide](UUID-IMPLEMENTATION.md)
- [HTTPS Deployment Guide](HTTPS-DEPLOYMENT.md)
- [WhatsApp Integration](wa-service.md)

## 🎯 Aktualisasi LATSAR

Aplikasi ini dikembangkan sebagai proyek aktualisasi LATSAR CPNS yang menunjukkan:
- **Inovasi Digital**: Modernisasi pelayanan publik
- **Keamanan Data**: Implementasi UUID dan HTTPS
- **Efisiensi Administrasi**: Otomasi notifikasi dan laporan
- **User Experience**: Interface modern dan mobile-friendly

## 📈 Monitoring & Analytics

- **WhatsApp Status**: Real-time monitoring koneksi
- **Guest Statistics**: Tracking kunjungan harian/bulanan
- **Performance Metrics**: Response time dan success rate
- **Error Logging**: Comprehensive error tracking

## 🔄 Future Development

- **API Public**: RESTful API untuk integrasi
- **Mobile App**: Native Android/iOS application
- **Advanced Analytics**: Dashboard analytics lengkap
- **Multi-tenant**: Support multiple instansi

## 📞 Support & Contact

- **Developer**: Rahmat Adjie Junianto
- **Institution**: PTSP Kemenag Nganjuk
- **Email**: [Your Email]
- **GitHub**: [@rahmadjunianto](https://github.com/rahmadjunianto)

---

© 2025 PTSP Kementerian Agama Kabupaten Nganjuk. All rights reserved.

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
