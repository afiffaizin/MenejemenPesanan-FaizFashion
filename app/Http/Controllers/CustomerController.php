<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;


class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::with('sizes.category');

        if ($request->has('search') && $request->search != null) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('gender') && $request->gender != null) {
            $query->where('gender', $request->gender);
        }

        if ($request->has('category') && $request->category != null) {
            $query->whereHas('sizes.category', function ($q) use ($request) {
                $q->where('nameCategory', $request->category);
            });
        }

        


        $customers = $query->latest()->paginate(5)->withQueryString();


        $title = 'Hapus Data!';
        $text = "Data tidak bisa dikembalikan!";
        confirmDelete($title, $text);

        return view('customers.index', compact('customers'));
    }

    // Simpan Customers and size
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:20',
            'phone'          => 'nullable|string|max:20',
            'gender'        => 'required|in:L,P',
            'address'        => 'nullable|string|max:50',
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
            DB::transaction(function () use ($request) {
                $customer = Customer::create([
                    'name'    => $request->name,
                    'phone'   => $request->phone,
                    'address' => $request->address,
                    'gender' => $request->gender,
                ]);

                $category = Category::firstOrCreate(
                    ['nameCategory' => ucfirst(strtolower($request->nameCategory))]
                );


                $customer->sizes()->create([
                    'category_id'      => $category->id,
                    // atasan
                    'panjang'          => $request->panjang,
                    'lingkar_badan'    => $request->lingkar_badan,
                    'lingkar_pinggang' => $request->lingkar_pinggang,
                    'punggung'         => $request->punggung,
                    'panjang_lengan'   => $request->panjang_lengan,

                    // bawahan
                    'panjang_pinggang' => $request->panjang_pinggang,
                    'pinggul'          => $request->pinggul,
                    'pisak'            => $request->pisak,
                    'pangkal_paha'     => $request->pangkal_paha,

                    'keterangan'       => $request->keterangan,
                ]);
            });

            Alert::success('Berhasil', 'Data pelanggan berhasil ditambahkan!');
            return back();
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menyimpan data.');

            return back()->withInput();
        }
    }

    public function show(Customer $customer)
    {
        $customer->load([
            'sizes.category',
        ]);

        return view('customers.show', compact('customer'));
    }

    // edit data customer
    public function edit(Customer $customer)
    {
        $customer->load([
            'sizes.category',
        ]);

        return view('customers.editCustomer', compact('customer'));
    }

    // update data customer
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name'           => 'required|string|max:100',
            'phone'          => 'nullable|string|max:20',
            'gender'         => 'required|in:L,P',
            'address'        => 'nullable|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($request, $customer) {
                // Update data utama customer
                $customer->update([
                    'name'    => $request->name,
                    'phone'   => $request->phone,
                    'address' => $request->address,
                    'gender'  => $request->gender,
                ]);
            });

            Alert::success('Berhasil', 'Data pelanggan berhasil diperbarui!');
            return redirect()->route('customers.show', $customer->id);
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui data.');
            return back()->withInput();
        }
    }



    public function destroy(Customer $customer)
    {

        try {
            $customer->delete();

            Alert::success('Berhasil', 'Data pelanggan berhasil dihapus!');
            return back();
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data.');

            return back();
        }
    }
}
