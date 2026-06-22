<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Size;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SizeController extends Controller
{
    public function store(Request $request, Customer $customer)
    {
        $request->validate([
            'nameCategory'   => 'required|string|in:Atasan,Bawahan,atasan,bawahan',

            // atasan
            'panjang'        => 'nullable|numeric',
            'lingkar_badan'  => 'nullable|numeric',
            'lingkar_pinggang' => 'nullable|numeric',
            'punggung'       => 'nullable|numeric',
            'panjang_lengan' => 'nullable|numeric',

            // bawahan
            'panjang_pinggang' => 'nullable|numeric',
            'pinggul'        => 'nullable|numeric',
            'pisak'          => 'nullable|numeric',
            'pangkal_paha'   => 'nullable|numeric',

            'keterangan'     => 'nullable|string',
        ]);

        try {
            $categoryName = ucfirst(strtolower($request->nameCategory));
            $category = Category::firstOrCreate(
                ['nameCategory' => $categoryName]
            );

            $customer->sizes()->create([
                'category_id'      => $category->id,
                'panjang'          => $request->panjang,
                'lingkar_badan'    => $request->lingkar_badan,
                'lingkar_pinggang' => $request->lingkar_pinggang,
                'punggung'         => $request->punggung,
                'panjang_lengan'   => $request->panjang_lengan,
                'panjang_pinggang' => $request->panjang_pinggang,
                'pinggul'          => $request->pinggul,
                'pisak'            => $request->pisak,
                'pangkal_paha'     => $request->pangkal_paha,
                'keterangan'       => $request->keterangan,
            ]);

            Alert::success('Berhasil', 'Ukuran baru berhasil ditambahkan!');
            return back();
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menambahkan ukuran.');
            return back()->withInput();
        }
    }

    public function update(Request $request, Size $size)
    {
        $request->validate([
            // atasan
            'panjang'        => 'nullable|numeric',
            'lingkar_badan'  => 'nullable|numeric',
            'lingkar_pinggang' => 'nullable|numeric',
            'punggung'       => 'nullable|numeric',
            'panjang_lengan' => 'nullable|numeric',

            // bawahan
            'panjang_pinggang' => 'nullable|numeric',
            'pinggul'        => 'nullable|numeric',
            'pisak'          => 'nullable|numeric',
            'pangkal_paha'   => 'nullable|numeric',

            'keterangan'     => 'nullable|string',
        ]);

        try {
            $size->update([
                'panjang'          => $request->panjang,
                'lingkar_badan'    => $request->lingkar_badan,
                'lingkar_pinggang' => $request->lingkar_pinggang,
                'punggung'         => $request->punggung,
                'panjang_lengan'   => $request->panjang_lengan,
                'panjang_pinggang' => $request->panjang_pinggang,
                'pinggul'          => $request->pinggul,
                'pisak'            => $request->pisak,
                'pangkal_paha'     => $request->pangkal_paha,
                'keterangan'       => $request->keterangan,
            ]);

            Alert::success('Berhasil', 'Ukuran berhasil diperbarui!');
            return back();
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui ukuran.');
            return back()->withInput();
        }
    }

    public function destroy(Size $size)
    {
        try {
            $size->delete();
            Alert::success('Berhasil', 'Ukuran berhasil dihapus!');
            return back();
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus ukuran.');
            return back();
        }
    }
}
