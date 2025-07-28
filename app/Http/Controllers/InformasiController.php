<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InformasiKelurahan;

class InformasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // Method untuk admin dan petugas (input/edit informasi)
    public function index()
    {
        // Cek jika user adalah admin atau petugas
        if (auth()->user()->hasRole(['admin', 'petugas'])) {
            $informasi = InformasiKelurahan::orderBy('created_at', 'desc')->get();
            return view('informasi.index', compact('informasi'));
        }
        
        // Jika user biasa, tampilkan view public
        $informasi = InformasiKelurahan::where('is_published', true)
                                     ->orderBy('created_at', 'desc')
                                     ->get();
        
        return view('informasi.public', compact('informasi'));
    }
    
    // Method untuk warga (view-only)
    public function publicView()
    {
        $informasi = InformasiKelurahan::where('is_active', true)
                                     ->orderBy('created_at', 'desc')
                                     ->get();
        
        return view('informasi.public', compact('informasi'));
    }
    
    // Method untuk create (hanya admin dan petugas)
    public function create()
    {
        $this->middleware(['role:admin|petugas']);
        return view('informasi.create');
    }
    
    // Method untuk store (hanya admin dan petugas)
    public function store(Request $request)
    {
        $this->middleware(['role:admin|petugas']);
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'is_published' => 'boolean'
        ]);
        
        InformasiKelurahan::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'is_published' => $request->has('is_published'),
            'dibuat_oleh' => auth()->id(),
            'tanggal_publish' => now()
        ]);
        
        return redirect()->route('informasi.index')
                        ->with('success', 'Informasi berhasil ditambahkan!');
    }
    
    // Method untuk show detail
    public function show($id)
    {
        $informasi = InformasiKelurahan::findOrFail($id);
        
        // Jika user biasa, cek apakah informasi aktif
        if (!auth()->user()->hasRole(['admin', 'petugas'])) {
            if (!$informasi->is_published) {
                abort(404);
            }
            return view('informasi.show', compact('informasi'));
        }
        
        return view('informasi.show', compact('informasi'));
    }
    
    // Method untuk edit (hanya admin dan petugas)
    public function edit($id)
    {
        $this->middleware(['role:admin|petugas']);
        $informasi = InformasiKelurahan::findOrFail($id);
        return view('informasi.edit', compact('informasi'));
    }
    
    // Method untuk update (hanya admin dan petugas)
    public function update(Request $request, $id)
    {
        $this->middleware(['role:admin|petugas']);
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'is_published' => 'boolean'
        ]);
        
        $informasi = InformasiKelurahan::findOrFail($id);
        $informasi->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'is_published' => $request->has('is_published'),
            'tanggal_publish' => now()
        ]);
        
        return redirect()->route('informasi.index')
                        ->with('success', 'Informasi berhasil diupdate!');
    }
    
    // Method untuk delete (hanya admin dan petugas)
    public function destroy($id)
    {
        $this->middleware(['role:admin|petugas']);
        
        $informasi = InformasiKelurahan::findOrFail($id);
        $informasi->delete();
        
        return redirect()->route('informasi.index')
                        ->with('success', 'Informasi berhasil dihapus!');
    }
}
