# Gradlink - Alumni Tracking System

Sistem Pelacakan Alumni berbasis Web yang menggunakan AI untuk memvalidasi jejak digital alumni secara otomatis. Proyek ini dikembangkan sebagai bagian dari tugas mata kuliah Rekayasa Kebutuhan A

## Fitur Utama
- **AI Tracking Automatis**: Menggunakan **Gemini 3.1 Flash Lite** dan **Serper.dev API** untuk melacak status pekerjaan alumni di web publik (LinkedIn, Jobstreet, dll).
- **Premium Dark Mode**: Antarmuka modern dengan skema warna *Deep Slate* dan *Glassmorphism* untuk kenyamanan visual pengguna.
- **Master Data Management**: Pengelolaan data alumni (CRUD) dengan validasi data yang ketat.
- **Dashboard Statistik**: Visualisasi data integritas alumni secara real-time.

## Tech Stack
- **Framework**: Laravel 12
- **Frontend**: Tailwind CSS
- **Database**: MySQL
- **AI Service**: Google Gemini AI
- **Search API**: Serper.dev (Google Search API)

## Hasil Pengujian Berdasarkan Use Case
Proyek ini diuji berdasarkan desain *Use Case Diagram* yang mencakup 4 Aktor (Sistem, Admin, Google Scholar/Web, dan Database) serta 7 fungsionalitas utama.

### Tabel Pengujian Fungsionalitas
| ID | Use Case | Deskripsi Pengujian | Hasil | Status |
|----|----------|-------------------|-------|--------|
| UC-01 | **Kelola Data Master** | Admin melakukan Tambah, Edit, dan Hapus (Delete) data alumni. | Seluruh fitur CRUD berjalan stabil, termasuk mekanisme penghapusan data. | BERHASIL |
| UC-02 | **Cari Data Publik** | Sistem memicu pencarian data melalui aktor Google Scholar/Web. | Integrasi **Serper.dev API** berhasil menarik data publik secara akurat. | BERHASIL |
| UC-03 | **Ambil Data Alumni** | Sistem mengambil data dari Database untuk diproses (*Included* by UC-02). | Sistem berhasil menarik data mentah sebelum tahap pencarian dilakukan. | BERHASIL |
| UC-04 | **Generate Query** | Sistem membentuk kata kunci pencarian otomatis (*Included* by UC-02). | Algoritma berhasil membuat variasi query untuk meningkatkan hasil pencarian. | BERHASIL |
| UC-05 | **Skoring & Disambiguasi** | Sistem memproses hasil pencarian menggunakan Kecerdasan Buatan (AI). | Menggunakan **Gemini 3.1 Flash Lite** untuk memvalidasi identitas alumni. | BERHASIL |
| UC-06 | **Update Status & Bukti** | Sistem memperbarui Database dengan status dan bukti (*Included* by UC-05). | Data status dan link bukti tersimpan otomatis ke dalam database. | BERHASIL |
| UC-07 | **Verifikasi Manual** | Admin meninjau hasil skoring yang bersifat ambigu (*Extended* from UC-05). | Admin dapat melakukan intervensi manual pada data hasil pelacakan. | BERHASIL |

### Detail Implementasi Teknologi & Alasan
Saya menggunakan AI untuk memastikan data valid:
1. **Gemini 3.1 Flash Lite**:
   - **Alasan**: Alasan saya menggunakan ini karena ini adalah AI yang efisien dari google agar saya dap dengan mudah mengekstraksi data **Disambiguasi** (membedakan orang yang namanya sama) berdasarkan konteks universitas dan prodi.
2. **Serper.dev API**:
   - **Alasan**: Memberikan akses langsung ke data Google Search tercepat tanpa hambatan *scraping*. Hal ini krusial untuk aktor **Google Scholar/Web** agar bisa memberikan data publik secara *real-time* kepada sistem.

**Status Akhir**: Seluruh use case yang didefinisikan telah **100% Berhasil** diimplementasikan ke dalam kode program
