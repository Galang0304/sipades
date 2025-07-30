# 📧 PANDUAN SETUP GMAIL UNTUK SIPADES

## Langkah 1: Aktifkan 2-Factor Authentication
1. Buka https://myaccount.google.com/security
2. Login dengan akun: kelurahankuinsel@gmail.com
3. Cari "2-Step Verification" dan aktifkan
4. Ikuti instruksi untuk setup dengan nomor HP

## Langkah 2: Generate App Password
1. Setelah 2FA aktif, buka: https://myaccount.google.com/apppasswords
2. Pilih "Mail" sebagai app
3. Pilih "Other (custom name)" untuk device
4. Ketik nama: "SIPADES Laravel App"
5. Klik "Generate"
6. **SIMPAN password 16 karakter yang muncul** (contoh: abcd efgh ijkl mnop)

## Langkah 3: Update File .env
Ganti password di file .env dengan App Password yang baru:

```
MAIL_PASSWORD="password_16_karakter_dari_step2"
```

## Langkah 4: Alternative - Coba STARTTLS
Jika masih error, coba ganti konfigurasi ke:

```
MAIL_PORT=587
MAIL_ENCRYPTION=tls
```

## Langkah 5: Test Email
Jalankan: `php test_email.php`

---
**Note:** Jangan gunakan password login Gmail biasa, harus App Password!
