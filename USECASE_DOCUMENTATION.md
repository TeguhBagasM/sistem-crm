# 📊 CRM Use Case Diagram

## 🎯 Overview

PlantUML use case diagram untuk sistem CRM dengan aktor, use cases, dan relationships.

## 👥 Aktor

### 1. **Admin**

- Full access ke semua fitur
- Manage users
- View dashboard

### 2. **Marketing User** (Marketing 1-4)

- Manage leads
- Manage contacts
- Manage emails
- Manage activities
- View dashboard mereka sendiri

---

## 📋 Use Cases Utama

### 🔐 User Management (UC1)

**Hanya untuk Admin**

| Use Case           | Deskripsi                        |
| ------------------ | -------------------------------- |
| UC1A - Create User | Buat user baru dengan role       |
| UC1B - Edit User   | Ubah data user                   |
| UC1C - Delete User | Hapus user                       |
| UC1D - Assign Role | Assign role (admin/marketing1-4) |

**Relationship**: UC1 → UC1A, UC1B, UC1C, UC1D (include)

---

### 📌 Lead Management (UC2)

**Untuk Marketing Users**

| Use Case                  | Deskripsi                | Relationship |
| ------------------------- | ------------------------ | ------------ |
| UC2A - Create Lead        | Buat lead baru           | include      |
| UC2B - View Lead          | Lihat detail lead        | include      |
| UC2C - Edit Lead          | Ubah data lead           | include      |
| UC2D - Delete Lead        | Hapus lead               | include      |
| UC2E - Change Status      | Ubah status lead         | include      |
| UC2F - Convert to Contact | Konversi lead ke contact | extend       |

**Special Rule**: Jika lead sudah dikonversi ke contact, statusnya tidak bisa diubah lagi

**Relationship**: UC2 → UC2A/B/C/D/E (include), UC2F (extend)

---

### 👤 Contact Management (UC3)

**Untuk Marketing Users**

| Use Case               | Deskripsi                              | Relationship |
| ---------------------- | -------------------------------------- | ------------ |
| UC3A - Create Contact  | Buat contact baru                      | include      |
| UC3B - View Contact    | Lihat detail contact                   | include      |
| UC3C - Edit Contact    | Ubah data contact                      | include      |
| UC3D - Delete Contact  | Hapus contact                          | include      |
| UC3E - Assign Tags     | Assign tags ke contact                 | extend       |
| UC3F - Segment Contact | Set segmentasi (VIP/Regular/Potential) | extend       |
| UC3G - Set Priority    | Set prioritas (Tinggi/Normal/Rendah)   | extend       |

**Relationship**: UC3 → UC3A/B/C/D (include), UC3E/F/G (extend)

---

### 📧 Email Management (UC4)

**Untuk Marketing Users**

| Use Case               | Deskripsi                  | Relationship |
| ---------------------- | -------------------------- | ------------ |
| UC4A - View Email List | Lihat daftar email         | include      |
| UC4B - Create Record   | Catat email ke database    | include      |
| UC4C - Send Email      | Kirim email langsung       | include      |
| UC4D - Edit Email      | Ubah data email            | include      |
| UC4E - Delete Record   | Hapus email dari riwayat   | include      |
| UC4F - Validate Email  | Validasi alamat email      | include      |
| UC4G - Track Status    | Tracking status pengiriman | include      |

**Special**: UC4C memerlukan UC4F (validate email address terlebih dahulu)

**Relationship**: UC4 → UC4A/B/C/D/E/F/G (include), UC4C --|> UC4F (extend)

---

### 📅 Activity Management (UC5)

**Untuk Marketing Users**

| Use Case               | Deskripsi                   | Relationship |
| ---------------------- | --------------------------- | ------------ |
| UC5A - Create Activity | Buat aktivitas baru         | include      |
| UC5B - View Activity   | Lihat detail aktivitas      | include      |
| UC5C - Edit Activity   | Ubah data aktivitas         | include      |
| UC5D - Delete Activity | Hapus aktivitas             | include      |
| UC5E - Change Status   | Ubah status aktivitas       | extend       |
| UC5F - View Calendar   | Lihat calendar view         | include      |
| UC5G - Filter by Date  | Filter aktivitas by tanggal | include      |

**Relationship**: UC5 → UC5A/B/C/D/F/G (include), UC5E (extend), UC5F --> UC5G (include)

---

### 📊 Dashboard (UC6)

**Untuk Admin & Marketing Users**

| Use Case                    | Deskripsi                             |
| --------------------------- | ------------------------------------- |
| UC6A - View Statistics      | Lihat statistik (total, pending, dll) |
| UC6B - View Charts          | Lihat visualisasi data                |
| UC6C - View Role-based Data | Lihat data sesuai role                |

**Relationship**: UC6 → UC6A, UC6B, UC6C (include)

---

### 🔐 Authentication (UC7)

**Untuk semua users**

| Use Case                    | Deskripsi                  |
| --------------------------- | -------------------------- |
| UC7A - Authenticate User    | Proses authentication      |
| UC7B - Validate Credentials | Validasi username/password |

**Relationship**: UC7 --> UC7A (include), UC7A --> UC7B (include)

---

## 🔄 Relationship Types

### Include (→)

Menunjukkan use case yang **selalu** dipanggil/diebutkan.

**Contoh:**

- UC1 (Manage Users) → UC1A (Create User) - Ketika manage users, pasti ada opsi create
- UC4 (Send Email) → UC4F (Validate Email) - Harus validate email sebelum kirim

### Extend (--|>)

Menunjukkan fungsionalitas **opsional/tambahan** yang bisa terjadi dalam kondisi tertentu.

**Contoh:**

- UC2F (Convert Lead) extends UC2 - Opsional untuk lead tertentu
- UC3E (Assign Tags) extends UC3 - Opsional, tidak semua contact perlu tags

---

## 📋 Tabel Komparasi: Include vs Extend

| Aspek          | Include             | Extend                |
| -------------- | ------------------- | --------------------- | --- |
| **Mandatory?** | Ya, selalu terjadi  | Tidak, opsional       |
| **Condition**  | Unconditional       | Conditional           |
| **Arrow**      | →                   | --                    | >   |
| **Contoh**     | Create → Input data | Send email → Validate |

---

## 🎯 Use Case Scenarios

### Scenario 1: Admin Manage User

```
1. Admin login (UC7)
2. Admin pergi ke User Management
3. Admin bisa:
   - Create User (UC1A)
   - Edit User (UC1B)
   - Delete User (UC1C)
   - Assign Role (UC1D)
```

### Scenario 2: Marketing Create & Send Email

```
1. Marketing login (UC7)
2. Marketing pergi ke Email Management
3. Marketing create email record (UC4B)
4. System validates email address (UC4F) ← extend
5. Marketing choose: Save only or Send (UC4C)
6. If Send: System tracks status (UC4G)
```

### Scenario 3: Marketing Convert Lead

```
1. Marketing view lead (UC2B)
2. Marketing bisa edit lead (UC2C)
3. Marketing bisa convert to contact (UC2F) ← extend
4. After conversion: Lead status locked (UC2E tidak bisa dijalankan)
```

---

## 📊 Actor-UseCase Matrix

|                | Admin              | Marketing         |
| -------------- | ------------------ | ----------------- |
| **User Mgmt**  | ✅ UC1             | ❌                |
| **Leads**      | ✅ UC2 (read-only) | ✅ UC2 (full)     |
| **Contacts**   | ✅ UC3 (read-only) | ✅ UC3 (full)     |
| **Emails**     | ✅ UC4 (read-only) | ✅ UC4 (full)     |
| **Activities** | ✅ UC5 (read-only) | ✅ UC5 (full)     |
| **Dashboard**  | ✅ UC6 (all data)  | ✅ UC6 (own data) |

---

## 🎨 Diagram File Location

📁 **Path**: `g:\Projects\joki\sistem-crm\CRM_USECASE_DIAGRAM.puml`

### Cara View:

1. **Online PlantUML Editor**: https://www.plantuml.com/plantuml/uml/
2. **VS Code Extension**: Install "PlantUML" extension
3. **Generate Image**:
    ```bash
    plantuml CRM_USECASE_DIAGRAM.puml -o CRM_USECASE_DIAGRAM.png
    ```

---

## 🔑 Key Points

✅ **Include digunakan untuk**:

- Mandatory sub-use cases
- Langkah-langkah yang selalu terjadi
- Fungsionalitas core

✅ **Extend digunakan untuk**:

- Opsional fungsionalitas
- Kondisi khusus
- Additional actions

✅ **Access Control**:

- Admin: Full access semua UC
- Marketing: Hanya UC2-UC6 untuk data mereka
- Authentication: UC7 untuk semua

---

## 📝 Notes

- Diagram ini menggambarkan **logical relationship** antar use cases
- Tidak menggambarkan UI/flow secara detail
- Fokus pada **functional requirements**
- Role-based access control diterapkan di implementation level

---

**Status**: ✅ Complete
**Format**: PlantUML (.puml)
**Last Updated**: 2026-01-22
