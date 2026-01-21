# 🧪 TESTING GUIDE - Email Management

## ✅ Pre-Test Checklist

- [x] `.env` sudah update (MAIL_MAILER=smtp)
- [x] Config cache sudah clear
- [x] Controller updated dengan send logic
- [x] Views updated dengan form baru
- [x] Model updated dengan helper methods

---

## 🚀 Start Testing

### Setup Test Data (Optional)

Pastikan ada pelanggan dengan email:

```
Menu → Pelanggan Management → Create atau Edit
Email: test@example.com (atau email valid apapun)
```

---

## 📝 Test Case 1: Save Riwayat Saja

### Scenario

Catat email tanpa mengirim

### Steps

1. Login → Email Management → Kirim Email Baru
2. Isi Form:
    - **Pelanggan**: Pilih salah satu
    - **Subjek**: "Test: Penawaran Produk"
    - **Isi**: "Halo, kami punya penawaran menarik..."
    - **Waktu**: Default (sekarang)
3. Pilih: **"Simpan Riwayat Saja"** ⭕
4. Klik: **"Simpan Riwayat"**

### Expected Result

```
✓ Alert: "Riwayat email berhasil ditambahkan!"
✓ Redirect ke: Email Management list
✓ Email muncul dengan Status: "Draft" (kuning)
✓ Waktu Terkirim: Kosong (tidak dikirim)
```

### Verify

- Buka email dari list
- Lihat detail:
    - Status: "Draft (Belum Dikirim)"
    - Error: Tidak ada
    - Waktu Terkirim: Kosong

---

## 📨 Test Case 2: Kirim Email (Berhasil)

### Scenario

Catat & kirim email ke Mailtrap

### Prerequisites

- Pelanggan punya email yang valid
- Mailtrap credentials benar di `.env`
- Config cache sudah clear

### Steps

1. Login → Email Management → Kirim Email Baru
2. Isi Form:
    - **Pelanggan**: Pilih yang punya email (contoh: "Budi - budi@gmail.com")
    - **Subjek**: "Test: Email Berhasil"
    - **Isi**: "Ini adalah email test untuk verifikasi Mailtrap"
    - **Waktu**: Default
3. Perhatikan: Alert muncul dengan email tujuan
4. Pilih: **"Kirim Email Langsung"** ⭕
5. Klik: **"Simpan Riwayat"**

### Expected Result

```
✓ Alert: "Email berhasil dikirim dan dicatat!"
✓ Redirect ke: Email Management list
✓ Email muncul dengan Status: "Terkirim" (hijau)
```

### Verify di Aplikasi

1. Dari list, klik email yang baru dibuat
2. Lihat detail:
    - Status Kirim: **"Terkirim ✓"**
    - Waktu Terkirim: **[Tanggal & Jam]** ← Important!
    - Error: Kosong

### Verify di Mailtrap

1. Buka: https://mailtrap.io
2. Login dengan credentials Mailtrap
3. Pergi: Email Testing → Inbox
4. Lihat email terakhir:
    ```
    From: CRM System <noreply@crm.local>
    To: [email pelanggan]
    Subject: Test: Email Berhasil
    Body: Ini adalah email test untuk verifikasi Mailtrap
    ```

---

## ❌ Test Case 3: Kirim Email (Gagal - Tidak Ada Email)

### Scenario

Pelanggan tidak punya email, kirim email harus gagal

### Steps

1. Login → Email Management → Kirim Email Baru
2. Isi Form:
    - **Pelanggan**: Pilih yang TIDAK punya email (atau email kosong)
    - **Subjek**: "Test Gagal"
    - **Isi**: "Test"
    - **Waktu**: Default
3. Perhatikan: Alert tidak muncul (karena tidak ada email)
4. Opsi "Kirim Email Langsung" TIDAK BISA dipilih (disabled)
5. Hanya bisa "Simpan Riwayat Saja"
6. Klik: **"Simpan Riwayat"**

### Expected Result

```
✓ Email hanya disimpan sebagai Draft
✓ Tidak ada percobaan pengiriman
✓ Status: "Draft" (kuning)
```

### Fix Test Case Ini

- Edit pelanggan dan tambah email
- Edit email draft, ubah ke "Kirim Email Langsung"
- Submit lagi → seharusnya berhasil sekarang

---

## 🔧 Test Case 4: Dynamic Pelanggan Email Display

### Scenario

Ketika pilih pelanggan, email harus tampil/hilang

### Steps

1. Login → Email Management → Kirim Email Baru
2. Awalnya: Alert email info TIDAK terlihat
3. Pilih pelanggan dengan email:
    ```
    Alert muncul: "Email akan dikirim ke: budi@gmail.com"
    ```
4. Ubah ke pelanggan tanpa email:
    ```
    Alert hilang
    Opsi "Kirim Email Langsung" disabled
    ```
5. Ubah ke pelanggan dengan email lagi:
    ```
    Alert muncul lagi
    ```

### Expected Result

```
✓ Alert dynamic update berdasarkan pelanggan
✓ Tidak perlu refresh halaman
✓ JavaScript berfungsi dengan baik
```

---

## 📊 Test Case 5: List Email Status Badge

### Scenario

Status badge menampilkan warna & label yang benar

### Steps

1. Login → Email Management
2. Lihat daftar email
3. Cek setiap status:

### Verifikasi Status

- **Draft** (Kuning 🟡)
    ```
    Badge: "Draft"
    Warna: Kuning
    ```
- **Terkirim** (Hijau 🟢)
    ```
    Badge: "Terkirim"
    Warna: Hijau
    Catatan: Hanya muncul jika email berhasil dikirim ke Mailtrap
    ```
- **Gagal** (Merah 🔴)
    ```
    Badge: "Gagal"
    Warna: Merah
    Catatan: Hanya jika ada error (contoh: SMTP connection error)
    ```

---

## 🎬 Full Workflow Test

Langkah-langkah lengkap dari A-Z:

```
1. CREATE EMAIL (Save Only)
   └─ Status di database: Draft ✓

2. CREATE EMAIL (Send - Success)
   ├─ Validasi email pelanggan: OK ✓
   ├─ Send via SMTP: Success ✓
   ├─ Status di database: Sent ✓
   ├─ Waktu terkirim: Recorded ✓
   └─ Muncul di Mailtrap: Yes ✓

3. LIST EMAIL
   ├─ Draft email: Status kuning ✓
   ├─ Sent email: Status hijau ✓
   └─ Click detail → Lihat info lengkap ✓

4. DETAIL EMAIL
   ├─ Sent: Tampil waktu terkirim ✓
   ├─ Draft: Tidak ada waktu terkirim ✓
   └─ Failed: Tampil error message ✓

5. VERIFY MAILTRAP
   ├─ Buka Mailtrap: https://mailtrap.io ✓
   ├─ Login: OK ✓
   ├─ Pergi: Email Testing → Inbox ✓
   ├─ Email muncul: Yes ✓
   ├─ From: CRM System <noreply@crm.local> ✓
   ├─ To: [email pelanggan] ✓
   ├─ Subject: [sesuai input] ✓
   └─ Body: [sesuai input] ✓
```

---

## 🐛 Troubleshooting Test

### Problem: Alert tidak muncul untuk "Kirim Email Langsung"

**Debug:**

- Cek: Pelanggan punya email?
- Cek: JavaScript console ada error? (F12)
- Cek: Refresh halaman

### Problem: Email gagal dikirim

**Debug:**

- Cek: Error message apa?
- Cek: `.env` MAIL_MAILER = smtp? (bukan log)
- Cek: Config cache sudah clear?
- Jalankan: `php artisan config:cache`

### Problem: Mailtrap tidak terima email

**Debug:**

- Cek: Status di aplikasi "Terkirim"?
- Jika yes → Check folder spam di Mailtrap
- Jika no → Email gagal dikirim ke Mailtrap
- Cek: `.env` username/password benar?

### Problem: Character counter tidak update

**Debug:**

- Cek: Browser support textarea event?
- Try: Refresh browser atau ganti browser
- Check: F12 console ada error?

---

## ✅ Sign-Off Checklist

Sebelum declare "Ready for Production":

- [ ] Test Case 1 PASSED: Save only
- [ ] Test Case 2 PASSED: Send email success
- [ ] Test Case 3 PASSED: Validation error handling
- [ ] Test Case 4 PASSED: Dynamic email display
- [ ] Test Case 5 PASSED: Status badges correct
- [ ] Mailtrap email muncul di inbox
- [ ] Email detail info lengkap di aplikasi
- [ ] No JavaScript errors di console
- [ ] Responsive design OK (mobile test)
- [ ] All documentation read and understood

---

## 📞 Support

Jika ada masalah:

1. Baca `QUICK_START_EMAIL.md` untuk quick troubleshooting
2. Baca `MAILTRAP_SETUP.md` untuk detail setup
3. Check browser console (F12) untuk JS errors
4. Check Laravel logs: `storage/logs/laravel.log`

---

**Ready to test? Good luck! 🚀**

Start dari: **Email Management → Kirim Email Baru**
