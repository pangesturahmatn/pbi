# PBI Company Profile Theme & Deploy

Repositori ini berisi kode sumber tema WordPress **PBI Company Profile** dan alat otomatisasi deployment untuk organisasi **Pesantren Bisnis Indonesia (PBI)**.

## Fitur Utama Tema
- **Modern Blog:** Halaman blog dengan layout 2-kolom, sidebar pencarian/kategori/tags, tanggal di bawah judul, placeholder cover otomatis, dan tombol Like interaktif.
- **Hero Banner:** Halaman beranda dengan layout responsif dan grafis ilustrasi Muslim entrepreneurs.
- **Riwayat Program Dinamis:** Daftar lengkap 60+ program kegiatan sejarah PBI (2016-2026) yang dapat dikelola dinamis melalui WordPress CPT (`pbi_program`) dan disaring instan di halaman depan.

## Struktur Direktori
- `/pbi-company-profile/` : Direktori utama kode sumber tema WordPress PBI.
- `/cache-cleaner/` : Skrip utilitas untuk pembersihan cache lokal.
- `deploy.ps1` : Skrip deployment manual dari lokal.

## Cara Kerja Deployment Otomatis
Setiap kali Anda melakukan push kode ke branch `main`, GitHub Actions akan otomatis menyinkronkan file tema ke server cPanel menggunakan FTP.

*Terakhir diperbarui: 29 Juli 2026 (cPanel User Updated).*
