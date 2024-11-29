<?php

namespace App\Http\Controllers;

use App\Models\HistoryLaporan;
use App\Models\Pelaporan;
use App\Models\Jenis;
use App\Models\StatusLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LaporanController extends Controller
{
    // Method untuk menampilkan form laporan

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal_laporan' => 'required|date',
            'jenis_id' => 'required|exists:jenis,id',
            'kategori_id' => 'required|exists:kategori,id',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:400',
            'media' => 'nullable|array',
        ]);

        $mediaPaths = [];

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                // Validasi file berdasarkan ekstensi
                $ext = $file->getClientOriginalExtension();
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'svgz', 'webp', 'bmp'])) {
                    // Jika file adalah gambar
                    $this->validate($request, [
                        'media.*' => 'mimes:jpg,jpeg,png,gif,svg,svgz,webp,bmp|max:10240',
                    ]);
                } elseif (in_array($ext, ['mp4', 'f4v', 'flv', 'm4v', 'mov', 'mpe', 'mpeg', 'mpg', 'ogv', 'qt', 'swf', 'swfl', 'ts', 'webm', 'avi', 'mkv', 'hevc'])) {
                    // Jika file adalah video
                    $this->validate($request, [
                        'media.*' => 'mimes:mp4,f4v,flv,m4v,mov,mpe,mpeg,mpg,ogv,qt,swf,swfl,ts,webm,avi,mov,mkv,hevc|max:50000',
                    ]);
                } else {
                    // Jika ekstensi file tidak didukung
                    return back()->with('error', 'File yang diupload tidak didukung.');
                }

                // Menyimpan file ke storage
                // $uploadedFileUrl = cloudinary()->upload($file->getRealPath())->getSecurePath(); //cludinary
                $mediaPaths[] = $file->store('media', 'public');
            }
        }
        //$mediaPath = implode(',', $mediaPaths);
        Pelaporan::create([
            'judul' => $request->judul,
            'tanggal_laporan' => $request->tanggal_laporan,
            'jenis_id' => $request->jenis_id,
            'kategori_id' => $request->kategori_id,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'nama_pelapor' => Auth::user()->name, // Anda bisa mendapatkan nama pelapor dari Auth
            'user_id' => Auth::id(),
            'media' => json_encode($mediaPaths), // Menyimpan path media dalam format JSON
            'status_id' => 1, // Status ID bisa ditetapkan langsung atau dari variabel yang sesuai
        ]);

        // Simpan notifikasi ke session
        Session::flash('notification', 'Laporan Anda telah berhasil dikirim.');

        return redirect()->back()->with('success', 'Laporan berhasil disimpan.');
    }

    public function getKategori($jenis_id)
    {
        $jenis = Jenis::with('kategori')->find($jenis_id);
        if ($jenis && $jenis->kategori) {
            return response()->json(['kategori_id' => $jenis->kategori->id, 'kategori_name' => $jenis->kategori->name]);
        }
        return response()->json(['error' => 'Kategori tidak ditemukan'], 404);
    }

    // laporan halaman admin
        public function admin() {
            // Ambil laporan yang belum selesai (status_id != 3) dengan relasinya
            $pelaporan = Pelaporan::with(['status', 'jenis', 'kategori'])
            ->where('status_id', '!=', 3)
            ->get();
            $status = StatusLaporan::all();
            return view('admin.laporan', compact('pelaporan', 'status'));
        }
    
        public function viewadmin($id) {
            // Mengambil detail laporan berdasarkan ID dengan relasi 'status', 'jenis', dan 'kategori'
            $pelaporan = Pelaporan::with(['status', 'jenis', 'kategori'])->findOrFail($id);
    
            return view('admin.laporan_detail', compact('pelaporan'));
        }
    
    
        // Mengupdate status laporan
        public function updateStatus(Request $request, $id)
        {
            // Cari laporan berdasarkan ID
            $laporan = Pelaporan::find($id);
    
            // Pastikan laporan ditemukan
            if (!$laporan) {
                return redirect()->back()->with('error', 'Laporan tidak ditemukan.');
            }
    
            // Update status laporan
            $laporan->status_id = $request->input('status_id');
            $laporan->save();
    
            //masukkan ke history_laporan
            if ($laporan->status_id == 3) { // Misalnya status_id 3 berarti selesai
                HistoryLaporan::create([
                    'laporan_id' => $laporan->id,
                    'user_id' => Auth::id(),
                    'tanggal_selesai' => now(),
                ]);
            }
    
            // Redirect dengan pesan sukses
            return redirect()->route('admin.laporan')->with('success', 'Status laporan berhasil diupdate.');
        }
        //menghapus status laporan
    public function deleteLaporan($id)
    {
        $laporan = Pelaporan::findOrFail($id);
        $laporan->delete();
        if ($laporan->votings()->exists()) {
            return redirect()->back()->with('error', 'Laporan tidak bisa dihapus karena memiliki data voting.');
        }

        $laporan->delete();
        return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    }
}
