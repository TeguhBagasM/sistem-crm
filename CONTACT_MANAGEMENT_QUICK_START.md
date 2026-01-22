# 📖 Contact Management - Quick Start Guide

## 🎯 What's New?

Your Contact Management system now includes:

1. ✨ **Search & Convert Leads** - Find qualified leads and convert them to customers instantly
2. 📊 **Customer Categorization** - Organize customers by type, priority, and source
3. 💬 **Direct Messaging** - One-click WhatsApp, Call, or Email
4. 📝 **Internal Notes** - Keep team notes separate from customer-facing info
5. 🎯 **Priority Tracking** - VIP/High/Medium/Low ratings for follow-up prioritization

---

## 🚀 How to Use

### Adding a New Customer (from Lead)

```
1. Go to Contact Management → Add Customer
2. Look for "Konversi dari Lead" section
3. Type customer name/email in search box
4. Click matching lead from results
5. Form auto-fills: Nama, Email, No. Telepon, Alamat
6. Complete categorization fields:
   - Kategori: Select customer type (Retail/Wholesale/Corporate/Distributor/Lainnya)
   - Rating: Set priority (⭐ VIP/High/Medium/Low)
   - Sumber: Where they came from (Website/Referral/Social/Ads/Event/Sales/Other)
7. Add internal notes if needed
8. Click "Simpan Pelanggan"
```

### Adding a Customer (Direct Entry)

```
1. Skip the lead search section (leave empty)
2. Fill in customer data manually
3. Fill categorization fields (required)
4. Add internal notes (optional)
5. Click "Simpan Pelanggan"
```

### Quick Contact Actions

#### From List View:

```
- WhatsApp Button (green) → Opens WhatsApp conversation directly
- Call Button (blue) → Initiates phone call
- Email Button (yellow) → Opens email client
```

#### From Detail View:

```
- Same 3 buttons at top of customer details
- Large, easy to click for quick actions
```

### Filtering Customers

On the list page, use filters to find:

- **Search:** By customer name or phone number
- **Status:** Active or Inactive customers
- **Owner:** Filter by team member responsible

### Understanding Ratings

- **⭐ VIP** - Top priority customers, red badge
- **High** - Important customers, orange badge
- **Medium** - Normal priority, blue badge
- **Low** - Lower priority, gray badge

Use ratings to:

- Know who to follow up with first
- Track customer importance
- Identify high-value accounts

### Categorization Examples

**Kategori (Customer Type):**

- Retail: Small shops/stores
- Wholesale: Bulk buyers
- Corporate: Large companies
- Distributor: Resellers
- Lainnya: Other types

**Sumber (Where They Came From):**

- Website: From company website
- Referral: Recommended by someone
- Media Sosial: From social media
- Iklan: From advertising campaign
- Event: From trade show/event
- Sales Call: Direct sales contact
- Lainnya: Other source

**Example:** A customer from Facebook ads → Rating: High, Kategori: Retail, Sumber: Iklan

---

## 💡 Pro Tips

### Maximize Lead Conversion

1. Keep leads updated in the system
2. Use the lead search when creating customers
3. Rating auto-tracks on creation
4. Use categories to segment follow-ups

### Quick Customer Communication

```
Instead of: Search email, copy phone, find WhatsApp contact
Now: One click on WhatsApp button from customer list
```

### Track Engagement

```
When contacting customer:
- Update the Kontak Terakhir date (auto-filled on edit)
- Add notes to Catatan Internal
- Change rating if priority changed
```

### Team Collaboration

```
Use Catatan Internal for:
- Status updates: "Waiting for decision"
- Follow-up notes: "Called 3x, will retry Friday"
- Special requests: "Prefers email over calls"
- Contact person: "Ask for Budi, extension 123"
```

### Smart Filtering Workflow

**Monday Morning: Review VIPs**

```
1. Filter by Rating: VIP
2. Check Kontak Terakhir
3. Plan follow-ups for inactive VIPs
```

**Weekly: Check by Source**

```
1. Filter by Sumber: Iklan (or other source)
2. See which sources are converting
3. Adjust marketing accordingly
```

**End of Month: Category Analysis**

```
1. Filter by Kategori: Wholesale
2. Export for monthly wholesale analysis
3. Identify trends
```

---

## 📱 WhatsApp Integration

### How It Works

- Click WhatsApp button
- Phone automatically formatted to international format (+62)
- Opens WhatsApp Web or App with conversation started
- Works with: 0812-3456-7890 → https://wa.me/6281234567890

### Examples

- Indonesian number "0812-3456-7890" → "+6281234567890"
- Already formatted "+62812-3456-7890" → Still works correctly

### Pro Tip

Always click WhatsApp button before sending bulk messages to:

- Verify phone number is correct
- Test connection
- Personal touch before bulk messaging

---

## ⚙️ Database Fields Reference

### Required Fields (Must Fill)

- **Nama** - Customer name
- **No. Telepon** - Phone number (required for WhatsApp/Call)
- **Kategori Pelanggan** - Customer type
- **Rating Pelanggan** - Priority level
- **Sumber Pelanggan** - Source/origin
- **Status Pelanggan** - Aktif or Tidak Aktif

### Optional Fields (Can Leave Blank)

- **Email** - Customer email (required for email button)
- **Perusahaan** - Company name
- **Website** - Company website URL
- **Alamat** - Customer address
- **Catatan Internal** - Internal team notes

### Auto-Updated Fields

- **Kontak Terakhir** - Updates when you edit customer (tracks last contact)

### Link Fields (Not Editable, Auto-Generated)

- **id_calon_pelanggan** - Link to original lead if converted from lead

---

## 🔍 Field Validation Rules

### Kategori Pelanggan

✅ Must select one:

- retail
- wholesale
- corporate
- distributor
- lainnya

### Rating Pelanggan

✅ Must select one:

- VIP
- High
- Medium
- Low

### Sumber Pelanggan

✅ Must select one:

- website
- referral
- media_sosial
- iklan
- event
- sales_call
- lainnya

### Website Field

✅ If filled, must be valid URL:

- ✓ https://example.com
- ✓ http://www.company.com
- ✗ example.com (missing protocol)
- ✗ not a url (invalid format)

### Email Field

✅ If filled, must be valid email:

- ✓ customer@company.com
- ✓ contact@mail.co.id
- ✗ customer@.com (incomplete)
- ✗ notanemail (no @ symbol)

---

## 🆘 Troubleshooting

### WhatsApp Button Not Working

1. Check if phone number is filled
2. Verify phone number format (0xxx or +62xxx)
3. Try with just numbers: "081234567890"
4. Check if WhatsApp account is connected

### Can't Find Lead to Convert

1. Lead might already be converted (appears once per lead)
2. Try searching by partial name
3. Try searching by email
4. Check if lead status is "Qualified" in Leads module

### Email Button Not Opening

1. Check if email field is filled
2. Verify email format is correct
3. Check browser's email client settings
4. Or use manual copy-paste from email field

### Internal Notes Not Showing

1. Must create/edit customer first (saved to Catatan Internal field)
2. Only shows if content exists
3. Visible in customer detail page under separate card

---

## 📊 Reporting & Analytics

### Suggested Analyses

1. **By Source:** Which sources generate most customers?
2. **By Category:** What customer types are most profitable?
3. **By Rating:** % of VIP vs. regular customers?
4. **Conversion Rate:** How many leads → customers?
5. **Response Time:** Average time from lead to customer

### For Management

- Track VIP customer count over time
- Monitor lead conversion rates by source
- Identify best customer categories for your business

---

## 🎓 Best Practices

### Daily Routine

1. ✓ Check rating for today's follow-ups
2. ✓ Use WhatsApp/Call buttons for quick contact
3. ✓ Update Catatan Internal after each contact

### Weekly Routine

1. ✓ Review VIP customers for engagement
2. ✓ Check inactive customers (old Kontak Terakhir)
3. ✓ Analyze new customers by source

### Monthly Routine

1. ✓ Export customer list by category
2. ✓ Review rating distribution
3. ✓ Update priority ratings as needed

---

## 📞 Need Help?

If you have questions about:

- **Adding customers** → See "How to Use" section
- **WhatsApp not working** → See "Troubleshooting" section
- **Field meanings** → See "Database Fields Reference" section
- **Filtering tips** → See "Smart Filtering Workflow" section

---

**Last Updated:** 2024
**System Version:** Enhanced Contact Management v1.0
