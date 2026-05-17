# Collaborative Editor

Collaborative Editor adalah aplikasi web editor dokumen kolaboratif real-time yang terinspirasi dari Google Docs. Project ini dikembangkan menggunakan Laravel, MySQL, Quill.js, dan Laravel Reverb WebSocket. Aplikasi ini memungkinkan banyak pengguna untuk mengakses dan mengedit dokumen yang sama secara bersamaan serta melihat pengguna yang sedang online secara real-time.

Tujuan utama dari project ini adalah mengimplementasikan sistem collaborative editing dan komunikasi real-time pada aplikasi berbasis web. Pengguna dapat menulis, mengedit, dan menyimpan dokumen menggunakan rich text editor yang dibuat menggunakan Quill.js. Isi dokumen akan disimpan ke database MySQL sehingga data tetap tersedia meskipun halaman di-refresh.

Laravel digunakan sebagai backend framework untuk mengatur routing, controller, database, dan logika aplikasi, sedangkan Laravel Reverb digunakan untuk fitur WebSocket agar sinkronisasi data antar pengguna dapat berjalan secara real-time.

## Fitur

- Realtime collaborative editing
- Multi-user document access
- Online users tracking
- Automatic document synchronization
- Rich text editor menggunakan Quill.js
- Penyimpanan dokumen menggunakan MySQL
- WebSocket communication menggunakan Laravel Reverb

## Teknologi yang Digunakan

- Laravel
- PHP
- MySQL
- Quill.js
- Laravel Reverb
- Vite
- JavaScript

## Instalasi

Clone repository:

```bash
git clone https://github.com/username/collaborative-editor.git
