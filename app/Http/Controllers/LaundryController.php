<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LaundryController extends Controller
{
    public function showLogin()
    {
        if (session()->has('user_id')) {
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = DB::table('users')->where('email', $request->username)->first();

        $valid = false;
        if ($user) {
            if (Hash::check($request->password, $user->password) || md5($request->password) === $user->password) {
                $valid = true;
            }
        }

        if (!$valid) {
            return back()->with('error', 'Username atau password salah.');
        }

        session([
            'user_id'  => $user->id,
            'username' => $user->name,
            'role'     => $user->role ?? (str_contains($user->email, 'admin') ? 'admin' : 'kasir'),
        ]);

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }

    public function dashboard()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        return view('dashboard', [
            'totalLayanan' => Layanan::count(),
            'totalProses'  => Transaksi::where('status_pengerjaan', 'Proses')->count(),
            'totalSelesai' => Transaksi::where('status_pengerjaan', 'Selesai')->count(),
            'totalOmzet'   => Transaksi::sum('total_harga') ?? 0,
        ]);
    }

    public function layanan(Request $request)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        $editData = null;
        if ($request->filled('edit')) {
            if (session('role') !== 'admin') {
                return redirect()->route('dashboard')->with('error', 'Hanya Admin yang dapat mengubah data layanan.');
            }
            $editData = Layanan::find($request->edit);
        }

        return view('layanan', [
            'layanans' => Layanan::orderBy('id')->get(),
            'editData' => $editData,
        ]);
    }

    public function storeLayanan(Request $request)
    {
        if (session('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Hanya Admin yang dapat menambah layanan.');
        }

        $request->validate([
            'nama_layanan'   => 'required|string|max:50',
            'harga_per_kg'   => 'required|integer|min:1',
            'estimasi_waktu' => 'required|string|max:50',
        ]);

        Layanan::create($request->only('nama_layanan', 'harga_per_kg', 'estimasi_waktu'));

        return redirect()->route('layanan')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function updateLayanan(Request $request, $id)
    {
        if (session('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Hanya Admin yang dapat mengubah layanan.');
        }

        $request->validate([
            'nama_layanan'   => 'required|string|max:50',
            'harga_per_kg'   => 'required|integer|min:1',
            'estimasi_waktu' => 'required|string|max:50',
        ]);

        $layanan = Layanan::findOrFail($id);
        $layanan->update($request->only('nama_layanan', 'harga_per_kg', 'estimasi_waktu'));

        return redirect()->route('layanan')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroyLayanan($id)
    {
        if (session('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Hanya Admin yang dapat menghapus layanan.');
        }

        try {
            Layanan::findOrFail($id)->delete();
            return redirect()->route('layanan')->with('success', 'Layanan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('layanan')->with('error', 'Layanan tidak bisa dihapus karena sudah digunakan di transaksi.');
        }
    }

    public function transaksi()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        return view('transaksi', [
            'layanans'   => Layanan::orderBy('id')->get(),
            'transaksis' => Transaksi::with('layanan')->orderByDesc('id')->get(),
        ]);
    }

    public function storeTransaksi(Request $request)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        $request->validate([
            'nama_pelanggan' => 'required|string|max:100',
            'no_hp'          => 'required|string|max:20',
            'layanan_id'     => 'required|exists:layanans,id',
            'berat_kg'       => 'required|numeric|min:0.1',
        ]);

        $layanan = Layanan::findOrFail($request->layanan_id);
        $totalHarga = (int) round($request->berat_kg * $layanan->harga_per_kg);

        Transaksi::create([
            'nama_pelanggan'    => $request->nama_pelanggan,
            'no_hp'             => $request->no_hp,
            'layanan_id'        => $layanan->id,
            'berat_kg'          => $request->berat_kg,
            'total_harga'       => $totalHarga,
            'status_pengerjaan' => 'Proses',
        ]);

        return redirect()->route('transaksi')->with('success', 'Transaksi berhasil dicatat. Total: Rp ' . number_format($totalHarga, 0, ',', '.'));
    }

    public function selesaikanTransaksi($id)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update(['status_pengerjaan' => 'Selesai']);

        return redirect()->route('transaksi')->with('success', 'Status transaksi diperbarui menjadi Selesai.');
    }
}