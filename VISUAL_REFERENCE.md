# 📊 Visual Reference - Email Management Flow

## 🎬 User Journey

```
┌─────────────────────────────────────────────────────────────┐
│                    USER OPENS BROWSER                       │
│              Menu → Email Management → Home                 │
└────────────────────────┬────────────────────────────────────┘
                         │
        ┌────────────────┴────────────────┐
        │                                 │
    [BUTTON]                         [BUTTON]
   Kirim Email                      View List
      Baru                         (see all emails)
        │                              │
        ▼                              ▼
   ┌─────────────┐         ┌──────────────────┐
   │ CREATE FORM │         │  EMAIL LIST PAGE │
   └────────────┬┘         └────────┬─────────┘
                │                   │
           [FILL FORM]          [CLICK EMAIL]
                │                   │
                ▼                   ▼
     ┌──────────────────┐  ┌──────────────────┐
     │  CHOOSE ACTION   │  │  DETAIL PAGE     │
     │                  │  │  (View Status)   │
     │ ⭕ Save Only    │  └──────────────────┘
     │ ⭕ Send Email   │
     └────────┬─────────┘
              │
     ┌────────┴────────┐
     │                 │
   [SAVE]          [SEND]
     │                 │
     ▼                 ▼
[DRAFT]           [PROCESS]
                      │
                 ┌────┴────┐
                 │         │
            Success    Failed
                 │         │
                 ▼         ▼
            [SENT] ❌ [ERROR]
```

---

## 🔄 Technical Flow

```
┌─────────────────────────────────────────┐
│         Form Submission (POST)          │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│     RiwayatEmailController@store         │
│  1. Validate input                      │
│  2. Get action & pelanggan data         │
└────────────────┬────────────────────────┘
                 │
         ┌───────┴───────┐
         │               │
    [SAVE ONLY]     [SEND EMAIL]
         │               │
         ▼               ▼
    ┌────────┐    ┌──────────────┐
    │ Status │    │ Validate:    │
    │ DRAFT  │    │ Pelanggan has│
    └────────┘    │ email? ──YES──┐
                  └───────┬───────┘
                          │
                  ┌───────NO──────┐
                  │               │
            [ERROR]         [SEND]
            (Show Alert)      │
                              ▼
                        ┌──────────────────┐
                        │ Mail::raw()      │
                        │ Via SMTP/Mailtrap│
                        └────────┬─────────┘
                                 │
                          ┌──────┴──────┐
                          │             │
                       Success      Exception
                          │             │
                          ▼             ▼
                     ┌────────┐   ┌────────┐
                     │ SENT   │   │ FAILED │
                     │ Status │   │ Status │
                     │Time:OK │   │Error:✗ │
                     └────────┘   └────────┘
                          │             │
                          └──────┬──────┘
                                 │
                                 ▼
                        ┌──────────────────┐
                        │ Redirect to List │
                        │ Show Message     │
                        └──────────────────┘
```

---

## 📧 Email Status Lifecycle

```
CREATE EMAIL
    │
    ├─→ ACTION: SAVE ONLY
    │       │
    │       └─→ Status: DRAFT (🟡 Kuning)
    │           └─→ Email hanya di database
    │               Tidak dikirim
    │
    └─→ ACTION: SEND EMAIL
        │
        └─→ Validate Pelanggan Email
            ├─ NO EMAIL?
            │   └─→ ERROR (Show Alert)
            │       └─→ Status: DRAFT (Fallback)
            │
            └─ HAS EMAIL?
                └─→ SEND VIA SMTP
                    ├─ SUCCESS
                    │   └─→ Status: SENT (🟢 Hijau)
                    │       └─→ waktu_terkirim: Recorded
                    │       └─→ Email di Mailtrap: YES
                    │
                    └─ FAILED
                        └─→ Status: FAILED (🔴 Merah)
                            └─→ error_message: Recorded
                            └─→ Email di Mailtrap: NO
```

---

## 🗂️ Database Structure

```
┌─────────────────────────────────────────┐
│         TABLE: riwayat_email            │
├─────────────────────────────────────────┤
│ id              INT (Primary)           │
│ id_pelanggan    INT (FK to pelanggan)   │
│ subjek          VARCHAR(255)            │
│ isi_pesan       TEXT                    │
│ dikirim_oleh    INT (FK to users)       │
│ waktu_kirim     DATETIME                │
│ status_kirim    ENUM('draft','sent',    │ ← NEW
│                 'failed')               │ ← NEW
│ waktu_terkirim  DATETIME (nullable)     │ ← NEW
│ error_message   TEXT (nullable)         │ ← NEW
│ created_at      TIMESTAMP               │
│ updated_at      TIMESTAMP               │
└─────────────────────────────────────────┘
```

---

## 🎨 Frontend Status Display

```
┌─────────────────────────────────────────┐
│         EMAIL LIST (INDEX PAGE)         │
├─────────────────────────────────────────┤
│                                         │
│ From Pelanggan | Subjek | Waktu | Status │
│                                         │
│ Budi - budi@..| Test 1 | 14:30 | 🟡 │ ← DRAFT
│ Ani - ani@..  | Test 2 | 14:35 | 🟢 │ ← SENT
│ Citra - cite..| Test 3 | 14:40 | 🔴 │ ← FAILED
│                                         │
└─────────────────────────────────────────┘

Status Color Reference:
├─ 🟡 (Yellow) = bg-warning = DRAFT
├─ 🟢 (Green)  = bg-success = SENT
└─ 🔴 (Red)    = bg-danger  = FAILED
```

---

## 🔗 API/Route Flow

```
HTTP Request Flow:
────────────────────────────────────────

GET  /emails              → List all emails (index)
     └─ Show: Draft, Sent, Failed emails

GET  /emails/create       → Show create form
     └─ Select pelanggan, compose email

POST /emails              → Store email (our main logic)
     ├─ Validate: subjek, isi, pelanggan, action
     ├─ If action=save_only → Save as draft
     ├─ If action=send_email → Send & save
     └─ Redirect: /emails with message

GET  /emails/{id}         → Show email detail
     └─ Display status, waktu_terkirim, error

GET  /emails/{id}/edit    → Edit form

PUT  /emails/{id}         → Update email

DELETE /emails/{id}       → Delete email
```

---

## 🌐 Mailtrap Integration

```
┌─────────────────────────────────────────┐
│       Laravel Application               │
│  (CRM System - Email Management)        │
└────────────────┬────────────────────────┘
                 │
        [Mail::raw() called]
                 │
                 ▼
┌─────────────────────────────────────────┐
│        SMTP Configuration               │
│  • Host: smtp.mailtrap.io              │
│  • Port: 587                            │
│  • Username: e105be366b7c77            │
│  • Password: 3f350bd3e90a60            │
│  • Encryption: TLS                      │
└────────────────┬────────────────────────┘
                 │
        [TCP Connection]
                 │
                 ▼
┌─────────────────────────────────────────┐
│      Mailtrap SMTP Server               │
│    (Development Email Testing)          │
│                                         │
│  • Intercepts email                     │
│  • Does NOT forward to real inbox       │
│  • Stores in test inbox                 │
└────────────────┬────────────────────────┘
                 │
        [Email Stored]
                 │
                 ▼
┌─────────────────────────────────────────┐
│   Mailtrap Dashboard (Email Testing)    │
│   https://mailtrap.io                   │
│                                         │
│   Inbox: [Emails received]              │
│   ├─ Email 1: Subject, From, To         │
│   ├─ Email 2: ...                       │
│   └─ Email 3: ...                       │
└─────────────────────────────────────────┘
```

---

## 📊 Status Matrix

```
┌────────────┬──────────┬───────────────┬──────────────────┐
│ Status     │ Color    │ Meaning       │ Example View     │
├────────────┼──────────┼───────────────┼──────────────────┤
│ DRAFT      │ Yellow 🟡│ Not sent      │ Badge: "Draft"   │
│            │          │ Only saved    │ Color: bg-warning│
│            │          │              │ Info: No time    │
├────────────┼──────────┼───────────────┼──────────────────┤
│ SENT       │ Green 🟢 │ Sent to SMTP  │ Badge: "Terkirim"│
│            │          │ Success!      │ Color: bg-success│
│            │          │              │ Time: 14:35 WIB  │
├────────────┼──────────┼───────────────┼──────────────────┤
│ FAILED     │ Red 🔴   │ Send failed   │ Badge: "Gagal"   │
│            │          │ Error occurred│ Color: bg-danger │
│            │          │              │ Error: SMTP 550  │
└────────────┴──────────┴───────────────┴──────────────────┘
```

---

## 🧪 Testing Scenarios Flowchart

```
START TESTING
    │
    ├─→ TEST 1: SAVE ONLY
    │   ├─ Create → Select "Simpan Riwayat Saja"
    │   ├─ Submit
    │   ├─ Expected: Status = DRAFT
    │   └─ Verify: Not in Mailtrap
    │
    ├─→ TEST 2: SEND SUCCESS
    │   ├─ Create → Select "Kirim Email Langsung"
    │   ├─ Pelanggan HAS email
    │   ├─ Submit
    │   ├─ Expected: Status = SENT
    │   └─ Verify: In Mailtrap inbox
    │
    ├─→ TEST 3: SEND FAILED
    │   ├─ Create → Select "Kirim Email Langsung"
    │   ├─ Pelanggan NO email
    │   ├─ Submit
    │   ├─ Expected: Status = DRAFT (validation failed)
    │   └─ Verify: Error message shown
    │
    ├─→ TEST 4: DYNAMIC DISPLAY
    │   ├─ Select pelanggan with email
    │   ├─ Check: Email alert appears
    │   ├─ Select pelanggan without email
    │   ├─ Check: Email alert disappears
    │   └─ Verify: No page refresh needed
    │
    └─→ TEST 5: LIST & DETAIL
        ├─ Go to email list
        ├─ Check: Status badges show correct colors
        ├─ Click email detail
        ├─ Check: Full info displayed correctly
        └─ Verify: Timestamps accurate

ALL TESTS PASSED? → READY TO USE! 🎉
```

---

## 🛠️ Troubleshooting Decision Tree

```
Problem: Email tidak terkirim
    │
    ├─ Check 1: Status = DRAFT?
    │   ├─ YES → User hanya save, tidak send
    │   │        Action: Pilih "Kirim Email Langsung"
    │   │
    │   └─ NO → Go Check 2
    │
    ├─ Check 2: Status = FAILED?
    │   ├─ YES → Error occurred
    │   │        ├─ Check error_message field
    │   │        └─ Common: Pelanggan no email
    │   │
    │   └─ NO → Go Check 3
    │
    ├─ Check 3: Status = SENT?
    │   ├─ YES → Email terkirim ke Mailtrap
    │   │        └─ Check di https://mailtrap.io
    │   │
    │   └─ NO → Unknown status?
    │
    ├─ Check 4: Mailtrap inbox kosong?
    │   ├─ Refresh halaman
    │   ├─ Check spam folder
    │   └─ Check login ke Mailtrap yang benar
    │
    └─ Check 5: .env benar?
        ├─ MAIL_MAILER=smtp? (NOT log)
        ├─ MAIL_PORT=587?
        └─ Config cache cleared?
```

---

## 📱 Responsive Design Reference

```
MOBILE (320px)
┌──────────────┐
│ Email Form   │
│ [Stacked]    │  ← Dropdown to text input
│              │  ← Radio buttons vertical
│              │  ← Full width buttons
└──────────────┘

TABLET (768px)
┌────────────────────────┐
│ Email Form             │
│ [Fields: 2 col]        │  ← Multiple columns
│ [Radio: horizontal]    │
└────────────────────────┘

DESKTOP (1024px+)
┌────────────────────────────────────────┐
│ Email Form                             │
│ [Fields: Optimized layout]             │  ← Best UX
│ [All inline]                           │
└────────────────────────────────────────┘
```

---

**Last Updated**: 2026-01-22
**Version**: 1.0
**Status**: Complete ✅
