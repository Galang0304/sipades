# 🔐 KUINSEL LOGIN CREDENTIALS

## 🌐 **Server Information**
- **URL**: http://127.0.0.1:8000
- **Framework**: Laravel 9.52.20
- **Environment**: Development

---

## 👥 **Available Login Accounts**

### 🔴 **ADMIN ACCOUNT**
```
Email: admin@kuinsel.com
Password: admin123
Role: Administrator
Status: Active
```
**Access Rights:**
- ✅ Full system access
- ✅ User approval management
- ✅ All dashboard features
- ✅ User management
- ✅ System settings

---

### 🟡 **LURAH ACCOUNT**
```
Email: lurah@kuinsel.com
Password: lurah123
Role: Lurah Desa
Status: Active
```
**Access Rights:**
- ✅ Final surat approval
- ✅ Lurah dashboard
- ✅ User approval (if needed)
- ✅ Surat validation
- ✅ Village management

---

### 🟢 **PETUGAS ACCOUNT**
```
Email: petugas@kuinsel.com
Password: petugas123
Role: Petugas Administrasi
Status: Active
```
**Access Rights:**
- ✅ Process surat applications
- ✅ First-stage surat approval
- ✅ Manage penduduk data
- ✅ Handle daily operations
- ✅ Administrative tasks

---

### 🔵 **WARGA/PENDUDUK ACCOUNTS**

#### **Warga 1 - Approved**
```
Email: warga1@gmail.com
Password: warga123
Name: Budi Santoso
Role: Warga
Status: Active
```

#### **Warga 2 - Approved**
```
Email: warga2@gmail.com
Password: warga123
Name: Siti Aminah
Role: Warga
Status: Active
```

**Access Rights (Both Warga):**
- ✅ Create surat applications
- ✅ View own surat status
- ✅ Submit pengaduan
- ✅ View informasi kelurahan
- ✅ Update profile

---

### ⚪ **PENDING ACCOUNT (For Testing)**
```
Email: pending@gmail.com
Password: pending123
Name: Ahmad Pending
Role: Warga
Status: PENDING APPROVAL
```
**Purpose:**
- 🧪 For testing user approval system
- 🧪 Admin can approve/reject this account
- 🧪 Demonstrates approval workflow

---

## 🎯 **Testing Workflow**

### **1. Admin Login Test**
1. Login as admin@sipades.com
2. Go to User Approval page
3. See pending user (Ahmad Pending)
4. Test approve/reject functionality

### **2. Role-Based Dashboard Test**
1. Login with different roles
2. Observe different dashboard layouts
3. Test role-specific features
4. Verify access restrictions

### **3. Surat Management Test**
1. Login as warga1@gmail.com
2. Create new surat application
3. Login as petugas@sipades.com
4. Process the surat (first approval)
5. Login as lurah@sipades.com
6. Final approval of the surat
7. Check email notifications

### **4. User Approval Test**
1. Login as admin@sipades.com
2. Navigate to User Approval
3. Approve/Reject pending@gmail.com
4. Check email notifications
5. Test login with approved/rejected account

---

## 📱 **Quick Access URLs**

- **Home/Dashboard**: http://127.0.0.1:8000
- **Login Page**: http://127.0.0.1:8000/login
- **Register Page**: http://127.0.0.1:8000/register
- **User Approval**: http://127.0.0.1:8000/admin/user-approval
- **Debug Dashboard**: http://127.0.0.1:8000/debug-dashboard

---

## 🔧 **Development Notes**

### **Database**
- All users have corresponding `penduduk` records
- Roles are managed by Spatie Permission package
- Foreign keys properly configured

### **Email System**
- Email notifications configured
- Approval/rejection emails available
- Testing environment ready

### **Security**
- Passwords are properly hashed
- CSRF protection enabled
- Role-based access control active

---

## 🚀 **Ready to Test!**

All accounts are **READY** and **FUNCTIONAL**. You can immediately:

1. ✅ **Login** with any of the above credentials
2. ✅ **Test** all role-based features  
3. ✅ **Demonstrate** the approval workflow
4. ✅ **Show** email notification system
5. ✅ **Verify** security and access controls

**Happy Testing! 🎉**
