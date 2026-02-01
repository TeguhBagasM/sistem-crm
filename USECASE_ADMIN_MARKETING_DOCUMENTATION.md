# 📋 CRM Use Case Diagram - Admin & Marketing Role

## 🎯 Ringkasan Diagram

Diagram usecase ini menunjukkan interaksi antara 2 role utama (Admin dan Marketing) dengan sistem CRM. Menggunakan hubungan **include** (wajib) dan **extends** (opsional).

---

## 👥 Actors

### 1. **Admin** 👨‍💼
**Tanggung Jawab:**
- Mengelola user accounts (create, edit, delete)
- Assign roles kepada users
- Konfigurasi sistem
- View system logs
- Akses dashboard admin

**Permission Level:** Full System Access

---

### 2. **Marketing** 📊
**Tanggung Jawab:**
- Manage leads & contacts
- Handle email communications
- Schedule & track activities
- View marketing dashboard
- Generate reports

**Permission Level:** Marketing Operations Only

---

## 🏢 Use Case Packages & Details

### 📌 **Admin Management** (Admin Only)

| Use Case | Include/Extend | Deskripsi |
|----------|---|-----------|
| **UC_admin_main** | Parent | Use case utama untuk admin |
| UC_admin_create_user | include | Membuat user account baru |
| UC_admin_edit_user | include | Mengedit profil user |
| UC_admin_delete_user | include | Menghapus user account |
| UC_admin_assign_role | include | Assign role (admin/marketing) |
| UC_admin_view_logs | extend | Melihat system logs (opsional) |
| UC_admin_config | extend | Konfigurasi sistem (opsional) |

**Hubungan Relationships:**
```
UC_admin_main
  ├── include → UC_admin_create_user
  ├── include → UC_admin_edit_user
  ├── include → UC_admin_delete_user
  ├── include → UC_admin_assign_role
  ├── extend → UC_admin_view_logs
  └── extend → UC_admin_config
```

---

### 📊 **Dashboard & Reporting** (Shared)

**Akses:** Admin + Marketing

| Use Case | Include/Extend | Deskripsi |
|----------|---|-----------|
| **UC_view_dashboard** | Parent | Menampilkan dashboard |
| UC_display_stats | include | Menampilkan statistik |
| UC_display_charts | include | Menampilkan chart/grafik |
| UC_filter_data | extend | Filter data (opsional) |

---

### 📌 **Lead & Contact Management** (Marketing Only)

#### Lead Management
| Use Case | Include/Extend | Deskripsi |
|----------|---|-----------|
| **UC_manage_leads** | Parent | Use case utama lead management |
| UC_create_lead | include | Membuat lead baru |
| UC_view_lead | include | Melihat detail lead |
| UC_edit_lead | include | Mengedit informasi lead |
| UC_delete_lead | include | Menghapus lead |
| UC_change_lead_status | extend | Ubah status lead (opsional) |
| UC_convert_lead_contact | extend | Konversi lead ke contact |

**Catatan:** 
- Fitur include adalah fitur inti yang selalu diakses
- Fitur extend adalah fitur tambahan yang optional

#### Contact Management
| Use Case | Include/Extend | Deskripsi |
|----------|---|-----------|
| **UC_manage_contacts** | Parent | Use case utama contact management |
| UC_create_contact | include | Membuat contact baru |
| UC_view_contact | include | Melihat detail contact |
| UC_edit_contact | include | Mengedit contact |
| UC_delete_contact | include | Menghapus contact |
| UC_assign_tags | extend | Assign tags/label (opsional) |
| UC_segment_contacts | extend | Segmentasi contacts (opsional) |
| UC_set_priority | extend | Set prioritas contact (opsional) |

---

### 📧 **Email Management** (Marketing Only)

| Use Case | Include/Extend | Deskripsi |
|----------|---|-----------|
| **UC_manage_email** | Parent | Use case utama email management |
| UC_view_email_list | include | Melihat daftar email |
| UC_create_email | include | Membuat email record |
| UC_send_email | include | Mengirim email |
| UC_edit_email | include | Mengedit email |
| UC_delete_email | include | Menghapus email record |
| UC_draft_email | extend | Draft email (opsional) |
| UC_validate_email | extend | Validasi email address |
| UC_track_email | extend | Track status email |

**Sub-relationships:**
```
UC_send_email
  ├── extend → UC_validate_email (validasi address)
  └── extend → UC_track_email (tracking)

UC_create_email
  └── extend → UC_draft_email (save as draft)
```

---

### 📅 **Activity Management** (Marketing Only)

| Use Case | Include/Extend | Deskripsi |
|----------|---|-----------|
| **UC_manage_activities** | Parent | Use case utama activity management |
| UC_create_activity | include | Membuat aktivitas baru |
| UC_view_activity | include | Melihat detail aktivitas |
| UC_edit_activity | include | Mengedit aktivitas |
| UC_delete_activity | include | Menghapus aktivitas |
| UC_view_calendar | include | Melihat kalender aktivitas |
| UC_change_activity_status | extend | Ubah status aktivitas (opsional) |
| UC_filter_activities | include | Filter aktivitas berdasarkan tanggal |

---

## 🔄 Hubungan Include vs Extend

### **Include (→)** - Wajib Dilakukan
- Menunjukkan fitur yang **pasti diakses** saat menjalankan use case parent
- Merupakan bagian integral dari use case utama
- **Contoh:** Saat user membuka "Manage Leads", user **pasti bisa** melihat lead details

### **Extend (--|>)** - Opsional
- Menunjukkan fitur yang **mungkin diakses** (kondisional)
- Fitur tambahan yang melengkapi use case utama
- **Contoh:** Saat membuat lead, user dapat **memilih untuk** convert ke contact (atau tidak)

---

## 👤 Access Matrix

| Use Case | Admin | Marketing |
|----------|:-----:|:---------:|
| Manage System | ✅ | ❌ |
| View Dashboard | ✅ | ✅ |
| Manage Leads | ❌ | ✅ |
| Manage Contacts | ❌ | ✅ |
| Manage Email | ❌ | ✅ |
| Manage Activities | ❌ | ✅ |

---

## 📝 Notes

1. **Separation of Concerns**: Admin dan Marketing memiliki usecase yang terpisah dan jelas
2. **Scalability**: Dapat dengan mudah menambah role baru (e.g., Manager, Supervisor)
3. **Flexibility**: Include/Extend memungkinkan fitur optional tanpa mengubah core functionality
4. **Security**: Setiap role hanya dapat akses use case yang sesuai dengan permission mereka

---

## 🔗 File Terkait

- [USECASE_ROLE_ADMIN_MARKETING.puml](USECASE_ROLE_ADMIN_MARKETING.puml) - PlantUML Diagram
- [CRM_USECASE_DIAGRAM.puml](CRM_USECASE_DIAGRAM.puml) - Diagram sebelumnya

---

**Dibuat:** Februari 2026  
**Version:** 1.0  
**Status:** ✅ Complete
