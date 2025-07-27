<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Penduduk;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserApprovalNotification;

class UserApprovalController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Approval Akun Penduduk',
            'pendingUsers' => $this->getUsersWithPenduduk('pending'),
            'approvedUsers' => $this->getApprovedUsers(),
            'rejectedUsers' => $this->getRejectedUsers()
        ];
        
        return view('admin.user_approval.index', $data);
    }
    
    private function getUsersWithPenduduk($status)
    {
        return User::select('users.*', 'penduduk.nama_lengkap', 'penduduk.jenis_kelamin', 'penduduk.tempat_lahir', 'penduduk.tanggal_lahir', 'penduduk.alamat', 'penduduk.pekerjaan')
            ->leftJoin('penduduk', 'penduduk.nik', '=', 'users.nik')
            ->whereHas('roles', function($query) {
                $query->where('name', 'user');
            })
            ->when($status === 'pending', function($query) {
                return $query->where('users.is_active', false)
                           ->where('users.is_pending', true);
            }, function($query) {
                return $query->where('users.is_active', true)
                           ->where('users.is_pending', false);
            })
            ->get();
    }
    
    private function getApprovedUsers()
    {
        return User::whereHas('roles', function($query) {
                $query->where('name', 'user');
            })
            ->where('is_active', true)
            ->whereDate('updated_at', today())
            ->get();
    }
    
    private function getRejectedUsers()
    {
        return User::whereHas('roles', function($query) {
                $query->where('name', 'user');
            })
            ->where('is_active', false)
            ->whereDate('updated_at', today())
            ->get();
    }
    
    public function approve($id)
    {
        try {
            $user = User::find($id);
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan'
                ]);
            }
            
            if ($user->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'User sudah diproses sebelumnya'
                ]);
            }
            
            // Update user status
            $user->update([
                'is_active' => true,
                'is_pending' => false
            ]);
            
            // Send email notification
            try {
                Mail::to($user->email)->send(new UserApprovalNotification($user, 'approved'));
            } catch (\Exception $e) {
                \Log::error('Failed to send approval email: ' . $e->getMessage());
            }
            
            return response()->json([
                'success' => true,
                'message' => 'User berhasil disetujui dan email notifikasi telah dikirim'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error approving user: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem'
            ]);
        }
    }
    
    public function reject($id, Request $request)
    {
        try {
            $request->validate([
                'rejection_reason' => 'required|min:10'
            ]);
            
            $user = User::find($id);
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan'
                ]);
            }
            
            if ($user->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'User sudah diproses sebelumnya'
                ]);
            }
            
            // Update user status
            $user->update([
                'is_active' => false,
                'is_pending' => false
            ]);
            
            // Send email notification
            try {
                Mail::to($user->email)->send(new UserApprovalNotification($user, 'rejected', $request->rejection_reason));
            } catch (\Exception $e) {
                \Log::error('Failed to send rejection email: ' . $e->getMessage());
            }
            
            return response()->json([
                'success' => true,
                'message' => 'User berhasil ditolak dan email notifikasi telah dikirim'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error rejecting user: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem'
            ]);
        }
    }
}
