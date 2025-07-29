# 📡 SIPADES API Documentation

## 📋 Overview

SIPADES menyediakan RESTful API untuk integrasi dengan sistem eksternal dan pengembangan aplikasi mobile. API ini menggunakan authentication berbasis token dan mengikuti standar REST.

## 🔑 Authentication

### API Token
```http
Authorization: Bearer {your_api_token}
Content-Type: application/json
Accept: application/json
```

### Mendapatkan Token
```bash
# Generate personal access token
php artisan tinker
$user = User::find(1);
$token = $user->createToken('API Token')->plainTextToken;
echo $token;
```

## 🌐 Base URL

```
Production: https://your-domain.com/api
Development: http://localhost:8000/api
```

## 📚 API Endpoints

### 🔐 Authentication Endpoints

#### Login
```http
POST /api/auth/login
```

**Request Body:**
```json
{
    "email": "admin@sipades.com",
    "password": "password"
}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "user": {
            "id": 1,
            "name": "Administrator",
            "email": "admin@sipades.com",
            "role": "admin"
        },
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
    },
    "message": "Login successful"
}
```

#### Logout
```http
POST /api/auth/logout
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "message": "Logout successful"
}
```

#### User Profile
```http
GET /api/auth/user
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Administrator",
        "email": "admin@sipades.com",
        "nik": "1234567890123456",
        "role": "admin",
        "created_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

---

### 👥 Users Management

#### Get All Users
```http
GET /api/users
Authorization: Bearer {token}
```

**Query Parameters:**
- `page` (int): Page number (default: 1)
- `per_page` (int): Items per page (default: 15)
- `search` (string): Search term
- `role` (string): Filter by role

**Response:**
```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "name": "Administrator",
                "email": "admin@sipades.com",
                "nik": "1234567890123456",
                "role": "admin",
                "created_at": "2024-01-01T00:00:00.000000Z"
            }
        ],
        "first_page_url": "http://localhost:8000/api/users?page=1",
        "last_page": 1,
        "total": 1
    }
}
```

#### Get User by ID
```http
GET /api/users/{id}
Authorization: Bearer {token}
```

#### Create User
```http
POST /api/users
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "nik": "1234567890123456",
    "password": "password123",
    "role": "penduduk"
}
```

#### Update User
```http
PUT /api/users/{id}
Authorization: Bearer {token}
```

#### Delete User
```http
DELETE /api/users/{id}
Authorization: Bearer {token}
```

---

### 📄 Pengajuan Surat

#### Get All Pengajuan
```http
GET /api/pengajuan-surat
Authorization: Bearer {token}
```

**Query Parameters:**
- `page` (int): Page number
- `per_page` (int): Items per page
- `status` (string): Filter by status (pending, diproses, selesai, ditolak)
- `jenis_surat_id` (int): Filter by jenis surat
- `tanggal_pengajuan` (date): Filter by date (YYYY-MM-DD)

**Response:**
```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "nomor_surat": "001/SIPADES/2024",
                "jenis_surat": {
                    "id": 1,
                    "nama_surat": "Surat Keterangan Domisili"
                },
                "user": {
                    "id": 2,
                    "name": "John Doe",
                    "nik": "1234567890123456"
                },
                "keperluan": "Untuk keperluan melamar kerja",
                "status": "pending",
                "tanggal_pengajuan": "2024-01-15",
                "tanggal_diproses": null,
                "catatan": null,
                "petugas": null
            }
        ],
        "total": 1
    }
}
```

#### Get Pengajuan by ID
```http
GET /api/pengajuan-surat/{id}
Authorization: Bearer {token}
```

#### Create Pengajuan
```http
POST /api/pengajuan-surat
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "jenis_surat_id": 1,
    "keperluan": "Untuk keperluan melamar kerja",
    "data_tambahan": {
        "alamat_lengkap": "Jl. Contoh No. 123",
        "nomor_telepon": "081234567890"
    }
}
```

#### Update Status Pengajuan
```http
PUT /api/pengajuan-surat/{id}/status
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "status": "diproses",
    "catatan": "Sedang dalam proses verifikasi dokumen"
}
```

#### Approve Pengajuan
```http
POST /api/pengajuan-surat/{id}/approve
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "catatan": "Dokumen telah diverifikasi dan disetujui"
}
```

#### Reject Pengajuan
```http
POST /api/pengajuan-surat/{id}/reject
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "catatan": "Dokumen tidak lengkap, harap melengkapi persyaratan"
}
```

---

### 📋 Jenis Surat

#### Get All Jenis Surat
```http
GET /api/jenis-surat
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "nama_surat": "Surat Keterangan Domisili",
            "persyaratan": [
                "Fotocopy KTP",
                "Fotocopy KK",
                "Surat Pengantar RT/RW"
            ],
            "template": "template_domisili.pdf",
            "created_at": "2024-01-01T00:00:00.000000Z"
        }
    ]
}
```

#### Get Jenis Surat by ID
```http
GET /api/jenis-surat/{id}
Authorization: Bearer {token}
```

#### Create Jenis Surat
```http
POST /api/jenis-surat
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "nama_surat": "Surat Keterangan Usaha",
    "persyaratan": [
        "Fotocopy KTP",
        "Fotocopy KK",
        "Foto lokasi usaha"
    ],
    "template": "template_usaha.pdf"
}
```

---

### 👤 Penduduk

#### Get All Penduduk
```http
GET /api/penduduk
Authorization: Bearer {token}
```

**Query Parameters:**
- `search` (string): Search by name or NIK
- `page` (int): Page number
- `per_page` (int): Items per page

#### Get Penduduk by NIK
```http
GET /api/penduduk/nik/{nik}
Authorization: Bearer {token}
```

#### Create Penduduk
```http
POST /api/penduduk
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "nik": "1234567890123456",
    "nama": "John Doe",
    "tempat_lahir": "Jakarta",
    "tanggal_lahir": "1990-01-01",
    "jenis_kelamin": "L",
    "alamat": "Jl. Contoh No. 123",
    "agama": "Islam",
    "status_perkawinan": "Belum Kawin",
    "pekerjaan": "Karyawan",
    "kewarganegaraan": "WNI"
}
```

---

### 📊 Statistik & Laporan

#### Dashboard Statistics
```http
GET /api/dashboard/stats
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "total_pengajuan": 150,
        "pengajuan_pending": 25,
        "pengajuan_diproses": 15,
        "pengajuan_selesai": 100,
        "pengajuan_ditolak": 10,
        "total_users": 200,
        "total_penduduk": 1500,
        "pengajuan_bulan_ini": 45,
        "pengajuan_per_jenis": [
            {
                "jenis_surat": "Surat Keterangan Domisili",
                "total": 50
            }
        ]
    }
}
```

#### Laporan Pengajuan
```http
GET /api/laporan/pengajuan
Authorization: Bearer {token}
```

**Query Parameters:**
- `start_date` (date): Tanggal mulai (YYYY-MM-DD)
- `end_date` (date): Tanggal akhir (YYYY-MM-DD)
- `status` (string): Filter status
- `jenis_surat_id` (int): Filter jenis surat
- `format` (string): Response format (json, pdf, excel)

---

### 🔔 Notifikasi

#### Get User Notifications
```http
GET /api/notifications
Authorization: Bearer {token}
```

#### Mark as Read
```http
PUT /api/notifications/{id}/read
Authorization: Bearer {token}
```

#### Mark All as Read
```http
POST /api/notifications/mark-all-read
Authorization: Bearer {token}
```

---

## 📁 File Upload

### Upload Document
```http
POST /api/upload/document
Authorization: Bearer {token}
Content-Type: multipart/form-data
```

**Request Body:**
```
file: (binary file)
type: document_type (optional)
```

**Response:**
```json
{
    "success": true,
    "data": {
        "filename": "document_20240115_123456.pdf",
        "path": "documents/document_20240115_123456.pdf",
        "size": 2048576,
        "mime_type": "application/pdf"
    }
}
```

---

## 🚫 Error Responses

### Error Format
```json
{
    "success": false,
    "message": "Error description",
    "errors": {
        "field_name": [
            "Validation error message"
        ]
    }
}
```

### HTTP Status Codes
- `200` - Success
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error
- `500` - Internal Server Error

### Common Errors

#### Authentication Error
```json
{
    "success": false,
    "message": "Unauthenticated",
    "code": 401
}
```

#### Validation Error
```json
{
    "success": false,
    "message": "The given data was invalid",
    "errors": {
        "email": [
            "The email field is required."
        ],
        "password": [
            "The password must be at least 8 characters."
        ]
    },
    "code": 422
}
```

#### Not Found Error
```json
{
    "success": false,
    "message": "Resource not found",
    "code": 404
}
```

---

## 📱 Mobile App Integration

### React Native Example
```javascript
import AsyncStorage from '@react-native-async-storage/async-storage';

class SipadesAPI {
    constructor() {
        this.baseURL = 'https://your-domain.com/api';
    }

    async getAuthToken() {
        return await AsyncStorage.getItem('api_token');
    }

    async request(endpoint, options = {}) {
        const token = await this.getAuthToken();
        
        const config = {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                ...(token && { 'Authorization': `Bearer ${token}` })
            },
            ...options
        };

        const response = await fetch(`${this.baseURL}${endpoint}`, config);
        return await response.json();
    }

    async login(email, password) {
        const response = await this.request('/auth/login', {
            method: 'POST',
            body: JSON.stringify({ email, password })
        });

        if (response.success) {
            await AsyncStorage.setItem('api_token', response.data.token);
        }

        return response;
    }

    async getPengajuanSurat() {
        return await this.request('/pengajuan-surat');
    }
}
```

### Flutter/Dart Example
```dart
import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class SipadesAPI {
  static const String baseURL = 'https://your-domain.com/api';

  Future<String?> getAuthToken() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    return prefs.getString('api_token');
  }

  Future<Map<String, dynamic>> request(String endpoint, {
    String method = 'GET',
    Map<String, dynamic>? body,
  }) async {
    String? token = await getAuthToken();
    
    Map<String, String> headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };

    if (token != null) {
      headers['Authorization'] = 'Bearer $token';
    }

    http.Response response;
    Uri url = Uri.parse('$baseURL$endpoint');

    switch (method.toUpperCase()) {
      case 'POST':
        response = await http.post(url, headers: headers, body: json.encode(body));
        break;
      case 'PUT':
        response = await http.put(url, headers: headers, body: json.encode(body));
        break;
      case 'DELETE':
        response = await http.delete(url, headers: headers);
        break;
      default:
        response = await http.get(url, headers: headers);
    }

    return json.decode(response.body);
  }

  Future<Map<String, dynamic>> login(String email, String password) async {
    Map<String, dynamic> response = await request('/auth/login',
        method: 'POST', body: {'email': email, 'password': password});

    if (response['success']) {
      SharedPreferences prefs = await SharedPreferences.getInstance();
      await prefs.setString('api_token', response['data']['token']);
    }

    return response;
  }
}
```

---

## 🧪 API Testing

### Using cURL
```bash
# Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email":"admin@sipades.com","password":"password"}'

# Get pengajuan surat with token
curl -X GET http://localhost:8000/api/pengajuan-surat \
  -H "Authorization: Bearer your_token_here" \
  -H "Accept: application/json"
```

### Using Postman Collection
```json
{
  "info": {
    "name": "SIPADES API",
    "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
  },
  "auth": {
    "type": "bearer",
    "bearer": [
      {
        "key": "token",
        "value": "{{api_token}}",
        "type": "string"
      }
    ]
  },
  "variable": [
    {
      "key": "base_url",
      "value": "http://localhost:8000/api"
    },
    {
      "key": "api_token",
      "value": ""
    }
  ]
}
```

---

## 🔐 Security Best Practices

### Rate Limiting
API menggunakan rate limiting:
- **Authentication endpoints**: 5 requests per minute
- **General endpoints**: 60 requests per minute
- **File upload**: 10 requests per hour

### Token Security
- Tokens expire after 24 hours
- Use HTTPS in production
- Store tokens securely
- Implement token refresh mechanism

### Input Validation
- All inputs are validated
- SQL injection protection
- XSS protection
- File upload restrictions

---

## 📈 API Versioning

Current version: `v1`

Future versions will be available at:
```
/api/v2/endpoint
```

---

**📚 Need Help?**

- API Issues: Create issue on GitHub
- Integration Support: contact@sipades.com
- Documentation Updates: Contribute via PR
