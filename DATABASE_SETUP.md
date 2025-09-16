# Setup Database untuk Buku Tamu

## Langkah-langkah Setup Database:

1. **Buat Database MySQL:**
   ```sql
   CREATE DATABASE buku_tamu;
   ```

2. **Update file .env:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=buku_tamu
   DB_USERNAME=root
   DB_PASSWORD=your_password_here
   ```

3. **Jalankan Migration:**
   ```bash
   php artisan migrate
   ```

4. **Jalankan Server:**
   ```bash
   php artisan serve
   ```

## URL Admin Dashboard:
- Login: http://127.0.0.1:8001/login
- Register: http://127.0.0.1:8001/register
- Admin Dashboard: http://127.0.0.1:8001/admin/dashboard

## Fitur yang Telah Diinstall:
- ✅ Laravel AdminLTE template
- ✅ Authentication system (login/register)
- ✅ Admin dashboard dengan template buku tamu
- ✅ Menu navigasi yang disesuaikan untuk aplikasi buku tamu
- ✅ Frontend assets (CSS/JS) compiled
- ✅ Custom styling untuk dashboard

## Next Steps:
1. Setup database MySQL
2. Buat model dan migration untuk:
   - Guests (tamu)
   - Guest entries (entri buku tamu)
   - Events
3. Implementasi CRUD untuk manajemen tamu dan buku tamu
