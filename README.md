# Aplikasi Antrian Puskesmas

**Dibuat oleh: Adrian Rahmandanu**
[GitHub Saya](https://github.com/arahmandanu)  <!-- Ganti USERNAME dengan username GitHub-mu -->

---

## Deskripsi

Aplikasi Antrian Puskesmas adalah sistem yang dirancang untuk mempermudah manajemen antrian pasien di Puskesmas. Dengan aplikasi ini, pasien dapat melihat nomor antrian secara real-time, sedangkan petugas dapat memanggil pasien dengan lebih efisien. Tujuan utama aplikasi ini adalah mengurangi waktu tunggu dan meningkatkan pengalaman pasien di layanan kesehatan.

---

## Fitur

- **Pendaftaran Antrian**: Pasien dapat mendaftar dan mendapatkan nomor antrian secara online.
- **Pemanggilan Antrian**: Petugas dapat memanggil nomor antrian dengan suara dan tampilan digital.
- **Dashboard Real-time**: Monitoring antrian secara langsung untuk petugas dan pasien.
- **Riwayat Antrian**: Menyimpan data antrian sebelumnya untuk keperluan laporan.
- **Responsif & User-friendly**: Tampilan yang mudah digunakan di berbagai perangkat.

---

## Teknologi yang Digunakan

- **Frontend**: HTML, CSS, Tailwind CSS, JavaScript
- **Backend**: PHP / Laravel (sesuaikan dengan implementasi)
- **Database**: MySQL / PostgreSQL
- **Realtime**: WebSocket / Pusher (jika ada fitur notifikasi real-time)

---

## Cara Menjalankan Aplikasi

1. Clone repository ini
   ```bash
   git clone https://github.com/arahmandanu/antrian_puskesmas_v1.git

2. Install dependensi
    ```bash composer install
    npm install
3. Konfigurasi .env sesuai kebutuhan (database, API, dll.)
4. Jalankan server lokal
    php artisan serve
5. Buka aplikasi melalui browser di http://localhost:8000

## MIT License

Copyright (c) 2025 Adrian Rahmandanu

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

