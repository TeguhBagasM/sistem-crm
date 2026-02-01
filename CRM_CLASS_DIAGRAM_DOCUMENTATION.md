# 📊 CRM Class Diagram Dokumentasi

## 🎯 Overview

Class diagram untuk sistem CRM menampilkan struktur database dari migration files dan relationships antar models. Diagram ini menggunakan notasi **public (+)**, **protected (#)**, dan **private (-)**.

---

## 🏗️ Classes & Attributes

### 1️⃣ **User** (Default Laravel + Custom)

**Tujuan:** Authentifikasi & authorization system

**Public Attributes (+):**
| Attribute | Type | Deskripsi |
|-----------|------|-----------|
| `id` | Integer (PK) | Primary key |
| `name` | String | Nama user |
| `email` | String (Unique) | Email untuk login |
| `password` | String | Password (hashed) |
| `role` | String | admin atau marketing1-4 |
| `created_at` | Timestamp | Waktu pembuatan |
| `updated_at` | Timestamp | Waktu update terakhir |

**Public Methods (+):**
- `getCalonPelangganCreated()` - Ambil semua lead yang dibuat user
- `getPelangganOwned()` - Ambil semua customer yang dimiliki user
- `getEmailSent()` - Ambil semua email yang dikirim user
- `getActivityCreated()` - Ambil semua aktivitas yang dibuat user

---

### 2️⃣ **CalonPelanggan** (Lead/Prospek)

**Tujuan:** Mengelola prospek/lead calon pelanggan

**Public Attributes (+):**
| Attribute | Type | Deskripsi |
|-----------|------|-----------|
| `id` | Integer (PK) | Primary key |
| `nama` | String | Nama prospek |
| `email` | String | Email (nullable) |
| `no_telepon` | String | Nomor telepon |
| `sumber` | String | Asal lead (IG/Website/WA) |
| `alamat` | String | Alamat (nullable) |
| `status_lead` | Enum | Status: baru, dihubungi, qualified, dikonversi, gagal |
| `catatan` | Text | Catatan tambahan |
| `dibuat_oleh` | Integer (FK) | Reference ke User |
| `created_at` | Timestamp | Waktu pembuatan |
| `updated_at` | Timestamp | Waktu update |

**Protected Attributes (#):**
| Attribute | Tipe | Deskripsi |
|-----------|------|-----------|
| `$table` | String | Nama table: 'calon_pelanggan' |
| `$fillable` | Array | Fields yang bisa di-mass assign |

**Public Methods (+):**
- `pembuatData()` - Relasi ke User (dibuat oleh siapa)
- `pelanggan()` - Relasi ke Pelanggan (saat dikonversi)
- `scopeBaru()` - Query leads dengan status 'baru'
- `scopeDihubungi()` - Query leads dengan status 'dihubungi'
- `scopeQualified()` - Query leads dengan status 'qualified'
- `scopeDikonversi()` - Query leads dengan status 'dikonversi'
- `scopeGagal()` - Query leads dengan status 'gagal'

**Private Methods (-):**
- `getStatusBadgeClass()` - Get CSS class untuk badge status

**Status Progression:**
```
baru → dihubungi → qualified → dikonversi ✓
                             ↘ gagal ✗
```

---

### 3️⃣ **Pelanggan** (Customer/Contact)

**Tujuan:** Mengelola pelanggan yang sudah qualified/dikonversi

**Public Attributes (+):**
| Attribute | Type | Deskripsi |
|-----------|------|-----------|
| `id` | Integer (PK) | Primary key |
| `id_calon_pelanggan` | Integer (FK) | Reference ke CalonPelanggan (nullable) |
| `nama` | String | Nama pelanggan |
| `email` | String | Email (nullable) |
| `no_telepon` | String | Nomor telepon |
| `perusahaan` | String | Nama perusahaan (nullable) |
| `website` | String | Website perusahaan (nullable) |
| `alamat` | String | Alamat lengkap (nullable) |
| `catatan_internal` | Text | Internal notes (nullable) |
| `status_pelanggan` | Enum | aktif atau tidak_aktif |
| `kategori_pelanggan` | String | Kategori customer (nullable) |
| `rating_pelanggan` | String | VIP, High, Medium, Low |
| `sumber_pelanggan` | String | Sumber customer (nullable) |
| `kontak_terakhir` | Timestamp | Waktu kontak terakhir |
| `pemilik_data` | Integer (FK) | Reference ke User (pemilik) |
| `created_at` | Timestamp | Waktu pembuatan |
| `updated_at` | Timestamp | Waktu update |

**Protected Attributes (#):**
| Attribute | Tipe | Deskripsi |
|-----------|------|-----------|
| `$table` | String | Nama table: 'pelanggan' |
| `$fillable` | Array | Fields yang bisa di-mass assign |
| `$casts` | Array | Type casting (kontak_terakhir → datetime) |

**Public Methods (+):**
- `calonPelanggan()` - Relasi ke CalonPelanggan (source lead)
- `pemilik()` - Relasi ke User (pemilik data)
- `riwayatEmail()` - Relasi ke RiwayatEmail (history email)
- `jadwalAktivitas()` - Relasi ke JadwalAktivitas (activities)
- `scopeAktif()` - Query pelanggan aktif
- `scopeTidakAktif()` - Query pelanggan tidak aktif

**Private Methods (-):**
- `getStatusBadgeClass()` - Get CSS class untuk badge status
- `getRatingBadgeClass()` - Get CSS class berdasarkan rating
- `getWhatsAppLink()` - Generate WhatsApp link
- `getCallLink()` - Generate tel: link
- `getEmailLink()` - Generate mailto: link

---

### 4️⃣ **RiwayatEmail** (Email History)

**Tujuan:** Mencatat setiap email yang dikirim ke pelanggan

**Public Attributes (+):**
| Attribute | Type | Deskripsi |
|-----------|------|-----------|
| `id` | Integer (PK) | Primary key |
| `id_pelanggan` | Integer (FK) | Reference ke Pelanggan |
| `id_calon_pelanggan` | Integer (FK) | Reference ke CalonPelanggan (nullable) |
| `subjek` | String | Subject email |
| `isi_pesan` | Text | Isi pesan email |
| `dikirim_oleh` | Integer (FK) | Reference ke User (pengirim) |
| `waktu_kirim` | Timestamp | Waktu pengiriman email |
| `status_kirim` | Enum | draft, sent, atau failed |
| `waktu_terkirim` | Timestamp | Waktu email terkirim (nullable) |
| `error_message` | Text | Pesan error jika gagal (nullable) |
| `created_at` | Timestamp | Waktu record dibuat |
| `updated_at` | Timestamp | Waktu record diupdate |

**Protected Attributes (#):**
| Attribute | Tipe | Deskripsi |
|-----------|------|-----------|
| `$table` | String | Nama table: 'riwayat_email' |
| `$fillable` | Array | Fields yang bisa di-mass assign |
| `$casts` | Array | Type casting timestamps |

**Public Methods (+):**
- `pelanggan()` - Relasi ke Pelanggan (tujuan email)
- `calonPelanggan()` - Relasi ke CalonPelanggan (untuk lead)
- `pengirim()` - Relasi ke User (yang mengirim)

**Private Methods (-):**
- `getStatusBadgeClass()` - Get CSS class untuk badge status
- `getStatusLabel()` - Get label readable: "Terkirim ✓", "Draft", "Gagal Dikirim ✗"

**Status Email:**
```
draft → sent ✓
     ↘ failed ✗
```

---

### 5️⃣ **JadwalAktivitas** (Activity/Reminder)

**Tujuan:** Mengelola jadwal aktivitas/reminder untuk pelanggan

**Public Attributes (+):**
| Attribute | Type | Deskripsi |
|-----------|------|-----------|
| `id` | Integer (PK) | Primary key |
| `judul` | String | Judul aktivitas |
| `deskripsi` | Text | Deskripsi detail (nullable) |
| `jenis_aktivitas` | Enum | email, followup, atau konten |
| `tanggal_jadwal` | Date | Tanggal jadwal aktivitas |
| `status_aktivitas` | Enum | direncanakan atau selesai |
| `id_pelanggan` | Integer (FK) | Reference ke Pelanggan (nullable) |
| `dibuat_oleh` | Integer (FK) | Reference ke User (pembuat) |
| `created_at` | Timestamp | Waktu pembuatan |
| `updated_at` | Timestamp | Waktu update |

**Protected Attributes (#):**
| Attribute | Tipe | Deskripsi |
|-----------|------|-----------|
| `$table` | String | Nama table: 'jadwal_aktivitas' |
| `$fillable` | Array | Fields yang bisa di-mass assign |
| `$casts` | Array | Type casting tanggal_jadwal → date |

**Public Methods (+):**
- `pelanggan()` - Relasi ke Pelanggan (target activity)
- `pembuat()` - Relasi ke User (yang membuat activity)
- `scopeDirencanakan()` - Query activity yang direncanakan
- `scopeSelesai()` - Query activity yang sudah selesai
- `scopeEmail()` - Query activity jenis email
- `scopeFollowup()` - Query activity jenis followup
- `scopeKonten()` - Query activity jenis konten

**Private Methods (-):**
- `getStatusBadgeClass()` - Get CSS class untuk badge status
- `getJenisBadgeClass()` - Get CSS class untuk badge jenis activity

**Jenis Aktivitas:**
```
- email: Campaign email
- followup: Follow-up call/contact
- konten: Content creation/posting
```

---

## 🔗 Relationships Diagram

```
User (1)
  ├─→ (1...*) CalonPelanggan (dibuat_oleh)
  ├─→ (1...*) Pelanggan (pemilik_data)
  ├─→ (1...*) RiwayatEmail (dikirim_oleh)
  └─→ (1...*) JadwalAktivitas (dibuat_oleh)

CalonPelanggan (1)
  ├─→ (0..1) Pelanggan (dikonversi_menjadi)
  └─→ (1...*) RiwayatEmail (untuk_lead)

Pelanggan (1)
  ├─→ (0..1) CalonPelanggan (berasal_dari)
  ├─→ (1...*) RiwayatEmail (menerima_email)
  └─→ (1...*) JadwalAktivitas (memiliki_aktivitas)
```

---

## 🔐 Access Modifiers Penjelasan

### (+) Public
- Dapat diakses dari luar class
- Biasanya attributes dan methods yang dibutuhkan external code
- **Contoh:** `$id`, `$nama`, `pembuatData()`

### (#) Protected
- Hanya dapat diakses dalam class dan class yang inherit
- Biasanya untuk properties Laravel khusus seperti `$table`, `$fillable`
- **Contoh:** `$table`, `$fillable`, `$casts`

### (-) Private
- Hanya dapat diakses dalam class itu sendiri
- Biasanya helper methods yang hanya digunakan internal
- **Contoh:** `getStatusBadgeClass()`, `getRatingBadgeClass()`

---

## 📝 Database Schema Summary

| Table | Records | Purpose |
|-------|---------|---------|
| users | 2-10 | User authentification & authorization |
| calon_pelanggan | 50-500 | Lead/Prospek management |
| pelanggan | 20-200 | Customer/Contact management |
| riwayat_email | 100-1000 | Email communication history |
| jadwal_aktivitas | 100-500 | Activity/Reminder management |

---

## 🎯 Key Points

1. **Separation of Concerns**
   - CalonPelanggan: untuk prospek baru
   - Pelanggan: untuk customer yang sudah qualified
   - RiwayatEmail: tracking komunikasi
   - JadwalAktivitas: reminder & follow-up

2. **Foreign Key Relationships**
   - Semua table connected ke User (untuk audit trail)
   - Pelanggan bisa berasal dari CalonPelanggan
   - RiwayatEmail & JadwalAktivitas linked ke Pelanggan

3. **Status Tracking**
   - CalonPelanggan: baru → dihubungi → qualified → dikonversi/gagal
   - RiwayatEmail: draft → sent/failed
   - JadwalAktivitas: direncanakan → selesai

4. **Helper Methods**
   - Private methods untuk UI concerns (badges, links)
   - Public scope methods untuk querying
   - Public relation methods untuk data access

---

## 📋 Files Terkait

- [CRM_CLASS_DIAGRAM.puml](CRM_CLASS_DIAGRAM.puml) - PlantUML Diagram
- [USECASE_ROLE_ADMIN_MARKETING.puml](USECASE_ROLE_ADMIN_MARKETING.puml) - Use Case Diagram
- Database migrations di [database/migrations](database/migrations/)
- Models di [app/Models](app/Models/)

---

**Dibuat:** Februari 2026  
**Version:** 1.0  
**Status:** ✅ Complete
