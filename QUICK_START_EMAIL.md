# 🎯 PANDUAN SINGKAT: Email Management dengan Mailtrap

## Langkah-Langkah Cepat

### 1️⃣ Buka Email Management

```
Menu Lateral → Email Management → Kirim Email Baru
```

### 2️⃣ Isi Formulir

| Field                | Cara Isi                               |
| -------------------- | -------------------------------------- |
| **Pelanggan**        | Pilih dari dropdown (yang punya email) |
| **Subjek Email**     | Tulis subjek email                     |
| **Isi Email**        | Tulis konten email                     |
| **Waktu Pencatatan** | Auto isi waktu sekarang (bisa diubah)  |

### 3️⃣ Pilih Tindakan

- ⭕ **Simpan Riwayat Saja** → Hanya catat, tidak dikirim
- ⭕ **Kirim Email Langsung** → Catat + Kirim ke Mailtrap

### 4️⃣ Klik "Simpan Riwayat"

### 5️⃣ Cek Hasil

#### 🟢 Jika BERHASIL

- Alert: "Email berhasil dikirim dan dicatat!"
- Pergi ke **Email Management**
- Status email: **"Terkirim"** (hijau)

#### 🔴 Jika GAGAL

- Alert: "Gagal mengirim email: [ERROR MESSAGE]"
- Cek error message
- Kemungkinan: Pelanggan tidak punya email

---

## 🧪 Verifikasi Email Sampai Tujuan

### Metode 1: Lihat di Aplikasi

```
Email Management → (list email) → Klik detail email
```

Cek:

- ✓ Status: "Terkirim ✓"
- ✓ Waktu Terkirim: [Tanggal & Jam]

### Metode 2: Lihat di Mailtrap

```
1. Buka: https://mailtrap.io
2. Login dengan akun Mailtrap Anda
3. Pergi: Email Testing → Inbox
4. Lihat email yang terkirim (paling baru di atas)
```

Cek:

- ✓ From: CRM System <noreply@crm.local>
- ✓ To: (email pelanggan)
- ✓ Subject: (sesuai yang dikirim)
- ✓ Body: (sesuai isi email)

---

## 📊 Status Email

| Status       | Icon | Warna     | Arti                         |
| ------------ | ---- | --------- | ---------------------------- |
| **Terkirim** | ✓    | 🟢 Hijau  | Email sampai ke Mailtrap     |
| **Draft**    | ⏳   | 🟡 Kuning | Hanya dicatat, belum dikirim |
| **Gagal**    | ✗    | 🔴 Merah  | Ada error saat pengiriman    |

---

## ⚠️ Troubleshooting Cepat

### Pelanggan tidak punya email

**Solusi**: Masuk ke menu Pelanggan → Edit → Isi email

### Email gagal terkirim

**Solusi**:

1. Clear config cache: `php artisan config:cache`
2. Restart server
3. Coba lagi

### Email tidak muncul di Mailtrap

**Solusi**:

1. Refresh halaman Mailtrap
2. Cek folder Spam
3. Pastikan login ke Mailtrap yang benar

---

## 🔗 Useful Links

- 🌐 Mailtrap Dashboard: https://mailtrap.io
- 📚 Docs Lengkap: Buka file `MAILTRAP_SETUP.md`

---

**💡 Tips**: Untuk development, gunakan Mailtrap. Untuk production, ganti dengan SendGrid/AWS SES/Mailgun.
