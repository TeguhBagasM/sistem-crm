# 📧 Setup & Verifikasi Email dengan Mailtrap (Development)

## 🎯 Overview

Fitur email management sekarang support 2 aksi:

1. **Simpan Riwayat Saja** - Hanya mencatat tanpa mengirim email
2. **Kirim Email Langsung** - Mencatat dan langsung mengirim ke email pelanggan

Untuk development, menggunakan **Mailtrap** untuk menangkap email tanpa benar-benar mengirim ke inbox pengguna.

---

## 📋 Konfigurasi Mailtrap

### Step 1: Setup di .env

File `.env` sudah dikonfigurasi dengan:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=e105be366b7c77
MAIL_PASSWORD=3f350bd3e90a60
MAIL_FROM_ADDRESS=noreply@crm.local
MAIL_FROM_NAME="CRM System"
```

> ⚠️ **Catatan**: Username dan password sudah ada. Jika ingin change, update di [Mailtrap Dashboard](https://mailtrap.io)

### Step 2: Clear Config Cache

Jika .env sudah diubah, clear cache Laravel:

```bash
php artisan config:cache
```

---

## 🧪 Cara Test & Verify Email

### Metode 1: Kirim Email dari Create Form

1. **Login ke aplikasi** dan pergi ke **Email Management → Kirim Email Baru**

2. **Isi form:**
    - Pilih Pelanggan (yang punya email)
    - Isi Subjek Email
    - Isi Isi Email
    - Pilih Tanggal/Waktu

3. **Pilih Tindakan:**
    - ✅ Centang **"Kirim Email Langsung"** untuk benar-benar mengirim

4. **Klik "Simpan Riwayat"** dan perhatikan:
    - ✅ Jika **BERHASIL** → Alert "Email berhasil dikirim dan dicatat!"
    - ❌ Jika **GAGAL** → Alert menampilkan error message

### Metode 2: Cek di Mailtrap Dashboard

1. **Buka** https://mailtrap.io/signin

2. **Login dengan akun:**
    - Email: (sesuai akun Mailtrap Anda)
    - Password: (sesuai)

3. **Pergi ke "Email Testing" → Inbox**

4. **Lihat email yang terkirim:**
    ```
    From: CRM System <noreply@crm.local>
    To: (email pelanggan)
    Subject: (subjek yang Anda kirim)
    Body: (isi email)
    ```

### Metode 3: Lihat Status di Application

1. **Pergi ke Email Management → Daftar Email**

2. **Kolom "Status" menampilkan:**
    - 🟢 **Terkirim** (badge hijau) - Email berhasil dikirim ke Mailtrap
    - 🟡 **Draft** (badge kuning) - Email hanya dicatat, belum dikirim
    - 🔴 **Gagal** (badge merah) - Ada error saat pengiriman

3. **Klik email di list untuk lihat detail lengkap:**
    - Status pengiriman (Terkirim/Draft/Gagal)
    - Waktu terkirim (jika berhasil)
    - Error message (jika gagal)

---

## ✅ Checklist Verifikasi

Saat email dikirim, pastikan:

- [ ] Status berubah dari **"Draft"** ke **"Terkirim"**
- [ ] Waktu terkirim muncul di detail email
- [ ] Email muncul di Mailtrap Inbox
- [ ] Nama pengirim: "CRM System"
- [ ] Email pengirim: "noreply@crm.local"
- [ ] Subject dan body sesuai dengan yang dikirim

---

## 🐛 Troubleshooting

### ❌ Email Gagal Terkirim

**Kemungkinan Penyebab:**

1. **Pelanggan tidak punya email**
    - Solusi: Pastikan pelanggan sudah punya email di database
    - Cek: Email Management → Pilih Pelanggan dengan email

2. **SMTP Connection Error**
    - Solusi: Pastikan `.env` sudah benar
    - Cek: `php artisan config:cache` & restart server

3. **Username/Password Mailtrap Salah**
    - Solusi: Update di Mailtrap Dashboard
    - Copy username & password baru ke `.env`

### ❌ Email Terkirim tapi Tidak Muncul di Mailtrap

1. Refresh halaman Mailtrap
2. Pastikan pergi ke "Email Testing" → Inbox yang benar
3. Check Spam/Junk folder

### ✅ Email Terkirim tapi Ingin Ubah Pesan

- Edit email dari Email Management
- Catatan: Email yang sudah "Terkirim" tidak bisa diubah
- Solusi: Buat email baru

---

## 🔄 Workflow Penggunaan

```
1. Buat Email
   ↓
2. Pilih Aksi:
   - Simpan Saja    → Status: Draft
   - Kirim Langsung → Proses Pengiriman
   ↓
3. Jika Kirim Langsung:
   ✓ Berhasil → Status: Terkirim
   ✗ Gagal    → Status: Gagal + Error Message
   ↓
4. Cek di:
   - Aplikasi: Email Management List
   - Mailtrap: Email Testing → Inbox
```

---

## 📝 Important Notes

- **Mailtrap adalah untuk development saja** - Email tidak benar-benar terkirim ke inbox pengguna
- **Untuk production**, ganti dengan email provider seperti:
    - SendGrid
    - AWS SES
    - Mailgun
    - Gmail SMTP (terbatas)

- **Status Email:**
    - `draft` - Hanya dicatat, belum dikirim
    - `sent` - Berhasil dikirim ke SMTP server
    - `failed` - Ada error saat pengiriman

---

## 🎓 Tambahan: Test Email dengan Artisan Tinker

Jika ingin test langsung dari terminal:

```bash
php artisan tinker
```

Kemudian jalankan:

```php
Mail::raw('Test message', fn($m) => $m->to('test@mailtrap.io')->subject('Test'));
```

Jika tidak ada error, email berhasil dikirim ke Mailtrap!

---

**Status**: ✅ Ready untuk Development
**Last Updated**: 2026-01-22
