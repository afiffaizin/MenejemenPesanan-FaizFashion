<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('name')->get();

        $totalCustomers = $customers->count();
        $pendingOrders = Order::where('status', 'Pending')->count();
        $orderanSelesai = Order::where('status', 'Selesai')->count();
        // total pesanan
        $totalOrderan = Order::count();

        // Chart.js data: Monthly order trend (last 12 months)
        $monthlyData = [];
        $monthlyLabels = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyLabels[] = $date->translatedFormat('M Y');
            $monthlyData[] = Order::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Chart.js data: Status breakdown for doughnut chart
        $statusPending = $pendingOrders;
        $statusSelesai = $orderanSelesai;

        // Recent pending orders for the dashboard table
        $recentOrders = Order::with(['customer', 'size.category'])
            ->where('status', 'Pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'customers',
            'totalCustomers',
            'pendingOrders',
            'orderanSelesai',
            'totalOrderan',
            'monthlyLabels',
            'monthlyData',
            'statusPending',
            'statusSelesai',
            'recentOrders'
        ));
    }


    public function getOrders()
    {
        $customers = Customer::orderBy('name')->get();
        $orders = Order::with(['customer', 'size', 'category'])
            ->where('status', '!=', 'Selesai')
            ->orderBy('created_at', 'desc');

        // pencarian
        if ($search = request('search')) {
            $orders->whereHas('customer', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            });
        }

        $orders = $orders->paginate(10);

        $title = 'Hapus Data!';
        $text = "Data tidak bisa dikembalikan!";
        confirmDelete($title, $text);

        return view('pesanan.index', compact('orders', 'customers'));
    }
    public function history()
    {
        $orders = Order::with(['customer', 'size', 'category'])
            ->where('status', '=', 'Selesai')
            ->orderBy('updated_at', 'desc');

        if ($search = request('search')) {
            $orders->whereHas('customer', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            });
        }

        $orders = $orders->paginate(10);

        // Jika Anda menggunakan confirmDelete di history, aktifkan. 
        // Jika tidak, Anda bisa menghapusnya.
        $title = 'Hapus Data!';
        $text = "Data riwayat tidak bisa dikembalikan!";
        confirmDelete($title, $text);

        return view('pesanan.riwayatPesanan', compact('orders'));
    }


    public function store(Request $request)
    {
        Log::info('Order store request received', [
            'all_data' => $request->all(),
            'customerType' => $request->input('customerType')
        ]);

        $customerType = $request->input('customerType', 'existing');

        if ($customerType === 'existing') {
            $validated = $request->validate(
                [
                    'customer_id' => 'required|exists:customers,id',
                    'size_id'     => 'required|exists:sizes,id',
                    'category_id' => 'required|exists:categories,id',
                ],
                [
                    'customer_id.required' => 'Silakan pilih pelanggan',
                    'customer_id.exists' => 'Pelanggan tidak ditemukan',
                    'size_id.required' => 'Silakan pilih ukuran',
                    'size_id.exists' => 'Ukuran tidak ditemukan',
                    'category_id.required' => 'Kategori tidak ditemukan',
                    'category_id.exists' => 'Kategori tidak valid',
                ]
            );

            try {
                Log::info('Creating order for existing customer', $validated);

                $order = Order::create([
                    'customer_id' => $validated['customer_id'],
                    'size_id'     => $validated['size_id'],
                    'category_id' => $validated['category_id'],
                    'status'      => 'Pending',
                ]);

                Log::info('Order created successfully', ['order_id' => $order->id]);

                Alert::success('Berhasil', 'Data pelanggan berhasil ditambahkan!');
                return back();
            } catch (\Exception $e) {
                Log::error('Error creating order', ['error' => $e->getMessage()]);
                Alert::error('Gagal', 'Terjadi kesalahan saat menyimpan data.');
                return back()->withInput();
            }
        } else {
            // Validate new customer
            $validated = $request->validate(
                [
                    'name'             => 'required|string|max:100',
                    'phone'            => 'nullable|string|max:20',
                    'gender'           => 'required|in:L,P',
                    'address'          => 'nullable|string|max:255',
                    'nameCategory'     => 'required|string|in:Atasan,Bawahan,atasan,bawahan',
                    'panjang'          => 'nullable|numeric',
                    'lingkar_badan'    => 'nullable|numeric',
                    'lingkar_pinggang' => 'nullable|numeric',
                    'punggung'         => 'nullable|numeric',
                    'panjang_lengan'   => 'nullable|numeric',
                    'pinggul'          => 'nullable|numeric',
                    'pisak'            => 'nullable|numeric',
                    'pangkal_paha'     => 'nullable|numeric',
                    'keterangan'       => 'nullable|string',
                ],
                [
                    'name.required' => 'Nama pelanggan harus diisi',
                    'name.max' => 'Nama maksimal 100 karakter',
                    'gender.required' => 'Gender harus dipilih',
                    'nameCategory.required' => 'Kategori pakaian harus dipilih',
                ]
            );

            try {
                Log::info('Creating new customer and order', ['name' => $validated['name']]);

                DB::transaction(function () use ($validated) {
                    // Create new customer
                    $customer = Customer::create([
                        'name'    => $validated['name'],
                        'phone'   => $validated['phone'],
                        'address' => $validated['address'],
                        'gender'  => $validated['gender'],
                    ]);

                    Log::info('Customer created', ['customer_id' => $customer->id]);

                    // Create or get category
                    $categoryName = ucfirst(strtolower($validated['nameCategory']));
                    $category = Category::firstOrCreate(
                        ['nameCategory' => $categoryName]
                    );

                    Log::info('Category resolved', ['category_id' => $category->id]);

                    $size = $customer->sizes()->create([
                        'category_id'      => $category->id,
                        'panjang'          => $validated['panjang'] ?? null,
                        'lingkar_badan'    => $validated['lingkar_badan'] ?? null,
                        'lingkar_pinggang' => $validated['lingkar_pinggang'] ?? null,
                        'punggung'         => $validated['punggung'] ?? null,
                        'panjang_lengan'   => $validated['panjang_lengan'] ?? null,
                        'panjang_pinggang' => $validated['panjang_pinggang'] ?? null,
                        'pinggul'          => $validated['pinggul'] ?? null,
                        'pisak'            => $validated['pisak'] ?? null,
                        'pangkal_paha'     => $validated['pangkal_paha'] ?? null,
                        'keterangan'       => $validated['keterangan'] ?? null,
                    ]);

                    Log::info('Size created', ['size_id' => $size->id]);

                    // Create order
                    $order = Order::create([
                        'customer_id' => $customer->id,
                        'size_id'     => $size->id,
                        'category_id' => $category->id,
                        'status'      => 'Pending',
                    ]);

                    Log::info('Order created for new customer', ['order_id' => $order->id]);
                });

                Alert::success('Berhasil', 'Pelanggan dan pesanan berhasil ditambahkan!');

                return redirect()->route('orders.getOrders');
            } catch (\Exception $e) {
                Log::error('Error creating customer/order', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
                Alert::error('Gagal', 'Terjadi kesalahan saat menyimpan data.');
                return back()->withInput();
            }
        }
    }


    public function updateStatus(Order $order)
    {
        try {
            $order->update([
                'status' => 'Selesai',
            ]);

            Alert::success('Berhasil', 'Status pesanan berhasil diperbarui!');
            return back();
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Gagal memperbarui status pesanan.');
            return back();
        }
    }

    // delete
    public function destroy(Order $order)
    {
        try {
            $order->delete();

            Alert::success('Berhasil', 'Pesanan berhasil dihapus!');
            return back();
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Gagal menghapus pesanan.');
            return back();
        }
    }
    public function show(Order $order)
    {
        $order->load(['customer', 'size.category']);

        return view('orders.show', compact('order'));
    }

    /**
     * Get customer sizes via AJAX
     */
    public function getSizes(Customer $customer)
    {
        try {
            $sizes = $customer->sizes()->with('category')->get();

            return response()->json([
                'success' => true,
                'sizes' => $sizes,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data ukuran',
            ], 500);
        }
    }
}
