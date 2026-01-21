# ⚡ QUICK START - Email Management

## 🎯 Dalam 5 Menit

### Step 1: Setup (First Time Only)

```bash
php artisan config:cache  # Clear config cache
```

### Step 2: Access Feature

```
Login → Menu: Email Management → Kirim Email Baru
```

### Step 3: Create Email

```
1. Pilih Pelanggan (dengan email)
2. Isi Subjek
3. Isi Konten
4. Pilih Aksi:
   ⭕ Simpan Riwayat Saja   (Draft)
   ⭕ Kirim Email Langsung  (Send to Mailtrap)
5. Klik "Simpan Riwayat"
```

### Step 4: Verify

```
✓ Status: "Terkirim" atau "Draft"?
✓ Email muncul di list dengan badge benar
✓ Klik detail untuk lihat info lengkap
```

---

## 🟢 Success = Email di Mailtrap

### Cek di Mailtrap

```
1. Buka: https://mailtrap.io
2. Login
3. Email Testing → Inbox
4. Lihat email terbaru (paling atas)
```

### Apa yang dilihat?

```
From: CRM System <noreply@crm.local>
To: [email pelanggan]
Subject: [subjek email]
Body: [isi email yang anda kirim]
```

---

## 🔴 Error? Cek Ini

| Error                                | Solusi                            |
| ------------------------------------ | --------------------------------- |
| Alert: "Pelanggan tidak punya email" | Tambah email di data pelanggan    |
| Status: "Gagal" (merah)              | Cek error message di detail email |
| Email tidak muncul di Mailtrap       | Refresh halaman Mailtrap          |
| Opsi "Kirim Email" disabled          | Pelanggan tidak punya email       |

---

## 📊 Status Email

| Badge    | Warna | Arti                         |
| -------- | ----- | ---------------------------- |
| Draft    | 🟡    | Hanya dicatat, belum dikirim |
| Terkirim | 🟢    | Berhasil dikirim ke Mailtrap |
| Gagal    | 🔴    | Ada error saat pengiriman    |

---

## 💡 Tips

- **Mailtrap adalah sandbox** - Email tidak benar-benar sampai ke pengguna
- **Development purpose** - Untuk testing sebelum production
- **Cek logs** - `storage/logs/laravel.log` jika ada issue teknis

---

## 📖 Need More Info?

- Quick reference: `QUICK_START_EMAIL.md`
- Full setup: `MAILTRAP_SETUP.md`
- Testing: `TESTING_GUIDE.md`
- Visual reference: `VISUAL_REFERENCE.md`

---

**Ready to send emails? 🚀**

Mulai dari: **Email Management → Kirim Email Baru**
