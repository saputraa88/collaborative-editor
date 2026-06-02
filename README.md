# Collaborative Editor

Aplikasi Collaborative Editor berbasis Laravel yang memungkinkan banyak pengguna mengedit dokumen secara realtime menggunakan Laravel Reverb dan WebSocket.

## Fitur

- Realtime Collaborative Editing
- Realtime Cursor Tracking
- Document Version History
- Conflict Resolution (Edit Logs)
- Multi User Collaboration
- Laravel Reverb WebSocket Integration
- Rich Text Editor (Quill.js)

## Teknologi

- Laravel 12
- Laravel Reverb
- MySQL
- Quill.js
- Laravel Echo
- Pusher JS

## Instalasi

Clone repository:

```bash
git clone https://github.com/USERNAME/collaborative-editor.git
cd collaborative-editor
```

Install dependency:

```bash
composer install
npm install
```

Copy file environment:

```bash
cp .env.example .env
```

Generate key:

```bash
php artisan key:generate
```

Konfigurasi database pada file `.env`.

Migrasi database:

```bash
php artisan migrate
```

Build frontend:

```bash
npm run build
```

atau saat development:

```bash
npm run dev
```

## Menjalankan Aplikasi

Jalankan Laravel:

```bash
php artisan serve
```

Jalankan Reverb:

```bash
php artisan reverb:start
```

Buka aplikasi:

```text
http://127.0.0.1:8000/document/1
```

## Struktur Fitur

### Realtime Editing

Setiap perubahan dokumen akan dikirim melalui event:

- DocumentUpdated

### Cursor Tracking

Posisi cursor pengguna lain ditampilkan secara realtime melalui event:

- CursorMoved

### Version History

Riwayat perubahan dokumen tersimpan pada tabel:

- document_versions

### Conflict Resolution

Aktivitas pengguna tersimpan pada tabel:

- edit_logs

Data yang dicatat:

- Nama Editor
- Waktu Perubahan
- Isi Dokumen

## Pengujian

### Skenario

1. Buka dokumen pada 2 browser berbeda.
2. Masukkan nama pengguna yang berbeda.
3. Ketik pada browser pertama.
4. Perubahan muncul secara realtime pada browser kedua.
5. Periksa History dan Edit Logs.

## Database

Tabel utama:

- documents
- document_versions
- edit_logs

