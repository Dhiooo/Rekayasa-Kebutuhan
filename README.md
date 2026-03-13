# Alumni Tracking System - Universitas Muhammadiyah Malang (UMM)

Sistem Pelacakan Alumni berbasis Web yang menggunakan kecerdasan buatan (AI) untuk memvalidasi jejak digital alumni secara otomatis. Proyek ini dikembangkan sebagai bagian dari tugas mata kuliah Rekayasa Kebutuhan.

## 🚀 Fitur Utama
- **AI Tracking Automatis**: Menggunakan **Gemini 3.1 Flash Lite** dan **Serper.dev API** untuk melacak status pekerjaan alumni di web publik (LinkedIn, Jobstreet, dll).
- **Premium Dark Mode**: Antarmuka modern dengan skema warna *Deep Slate* dan *Glassmorphism* untuk kenyamanan visual.
- **Master Data Management**: Pengelolaan data alumni (CRUD) dengan validasi data yang ketat.
- **Dashboard Statistik**: Visualisasi data integritas alumni secara real-time.

## 🛠️ Tech Stack
- **Framework**: Laravel 12
- **Frontend**: Tailwind CSS
- **Database**: SQLite (Development) / MySQL (Production Ready)
- **AI Service**: Google Gemini AI
- **Search API**: Serper.dev (Google Search API)

## 📋 Pengujian Kualitas Perangkat Lunak
Sesuai dengan aspek kualitas yang ditentukan pada desain Daily Project 2, berikut adalah hasil pengujian aplikasi:

| No | Aspek Kualitas | Parameter Uji | Hasil yang Diharapkan | Status |
|----|----------------|---------------|-----------------------|--------|
| 1  | **Functionality** | Fitur Delete Alumni | Data terhapus secara permanen dari database setelah konfirmasi. | ✅ Berhasil |
| 2  | **Functionality** | AI tracking (Gemini) | Sistem dapat memvalidasi hubungan alumni dengan UMM melalui data publik. | ✅ Berhasil |
| 3  | **Usability** | Dark Mode Interface | Antarmuka nyaman dipandang dan elemen teks terbaca jelas (High Contrast). | ✅ Berhasil |
| 4  | **Usability** | Responsivitas UI | Tampilan Dashboard proporsional di berbagai perangkat. | ✅ Berhasil |
| 5  | **Reliability** | Validasi Input | Sistem menolak input tahun kelulusan yang tidak valid (misal: < 1900). | ✅ Berhasil |

