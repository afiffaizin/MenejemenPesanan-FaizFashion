<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Category;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $uniqueNames = [
            "Aria Nova", "Zephyr Chen", "Luna Sterling", "Orion Vance", "Lyra Vance",
            "Cassian Reed", "Seraphina Vance", "Kaelen Voss", "Nova Lin", "Elara Vance",
            "Silas Thorne", "Pramoedya Baskara", "Airlangga Mahawira", "Daniswara Putra", "Nareswari Kirana",
            "Larasati Adipati", "Bhadrika Wira", "Kenzo Argani", "Mikael Evander", "Kira Valerius",
            "Ravelino Tristan", "Valerie Krystal", "Aureliano Max", "Xavier Niscala", "Zayn Malik",
            "Arjuna Dirgantara", "Bima Sakti", "Citra Kirana", "Dian Sastro", "Erlangga Bima",
            "Fahri Hamzah", "Gita Gutawa", "Hafiz Sastra", "Indira Gandhi", "Jaya Baya",
            "Kartini Putri", "Lestari Ayu", "Maheswari Bunga", "Narendra Putra", "Oka Antara",
            "Pandu Dewanata", "Qori Aina", "Rama Shinta", "Sinta Nuriyah", "Tari Candra",
            "Umar Bin", "Vera Vania", "Wira Yudha", "Xena Xenia", "Yudistira Bima",
            "Zara Zulaikha", "Zayn Surya", "Aisyah Nabila", "Bagus Setiawan", "Cahaya Purnama",
            "Dinda Lestari", "Eka Putra", "Fajar Nugraha", "Galih Rakasiwi", "Hana Melati"
        ];

        // 1. Update Existing Data to look realistic
        $existingCustomers = Customer::all();
        $baseDate = Carbon::now()->subMonths(11);
        
        foreach ($existingCustomers as $customer) {
            // Update customer date
            $randomDays = rand(0, 300);
            $cDate = (clone $baseDate)->addDays($randomDays);
            
            // Fix generic names
            if (in_array(strtolower($customer->name), ['qqq', 'tes', 'afif faizin', 'afif noerr ff'])) {
                $customer->name = array_pop($uniqueNames) ?? $customer->name;
            }
            $customer->created_at = $cDate;
            $customer->updated_at = $cDate;
            $customer->save();

            // Update sizes for this customer
            foreach ($customer->sizes as $size) {
                $size->created_at = $cDate;
                $size->updated_at = $cDate;
                $size->save();
            }

            // Update orders for this customer
            $orders = Order::where('customer_id', $customer->id)->get();
            foreach ($orders as $order) {
                $order->created_at = $cDate;
                
                if (strtolower($order->status) === 'selesai') {
                    $order->updated_at = (clone $cDate)->addDays(rand(3, 14));
                } else {
                    $order->updated_at = clone $cDate;
                }
                $order->save();
            }
        }

        // 2. Generate new customers (Total 60 new)
        $atasanCategory = Category::firstOrCreate(['nameCategory' => 'Atasan']);
        $bawahanCategory = Category::firstOrCreate(['nameCategory' => 'Bawahan']);

        // Shuffle remaining names
        shuffle($uniqueNames);

        for ($i = 0; $i < 60; $i++) {
            // Dates over the last 12 months
            $cDate = Carbon::now()->subDays(rand(1, 350));
            $isMale = rand(0, 1) === 1;

            $name = count($uniqueNames) > 0 ? array_pop($uniqueNames) : "Pelanggan Unik " . Str::random(4);

            $streetNames = ['Sudirman', 'Thamrin', 'Gatot Subroto', 'Diponegoro', 'Pahlawan', 'Merdeka', 'Melati', 'Mawar', 'Anggrek', 'Kenangan', 'Gajah Mada', 'Hayam Wuruk', 'Sisingamangaraja', 'Antasari', 'Ahmad Yani', 'Veteran', 'Kemerdekaan', 'Pattimura', 'Hasanuddin', 'Malioboro', 'Soekarno Hatta', 'Cendrawasih', 'Rajawali', 'Merpati', 'Cempaka', 'Teratai', 'Mangga', 'Jambu', 'Durian', 'Kebon Jeruk', 'Beringin', 'Flamboyan'];
            $street = $streetNames[array_rand($streetNames)];

            $customer = Customer::create([
                'name' => $name,
                'phone' => '08' . rand(1000000000, 9999999999),
                'address' => 'Jl. ' . $street . ' No. ' . rand(1, 150),
                'gender' => $isMale ? 'L' : 'P',
                'created_at' => $cDate,
                'updated_at' => $cDate,
            ]);

            // Random category Atasan or Bawahan
            $isAtasan = rand(0, 1) === 1;
            
            if ($isAtasan) {
                $size = Size::create([
                    'customer_id' => $customer->id,
                    'category_id' => $atasanCategory->id,
                    'panjang' => rand(65, 80),
                    'lingkar_badan' => rand(90, 120),
                    'lingkar_pinggang' => rand(80, 110),
                    'punggung' => rand(40, 50),
                    'panjang_lengan' => rand(55, 65),
                    'keterangan' => rand(0, 1) ? 'Tolong lengannya jangan terlalu ketat' : null,
                    'created_at' => $cDate,
                    'updated_at' => $cDate,
                ]);
                $catId = $atasanCategory->id;
            } else {
                $size = Size::create([
                    'customer_id' => $customer->id,
                    'category_id' => $bawahanCategory->id,
                    'panjang_pinggang' => rand(90, 110), // used for panjang cln/rok
                    'pinggul' => rand(90, 120),
                    'pisak' => rand(60, 70),
                    'pangkal_paha' => rand(50, 70),
                    'keterangan' => rand(0, 1) ? 'Bahan melar, tolong disesuaikan' : null,
                    'created_at' => $cDate,
                    'updated_at' => $cDate,
                ]);
                $catId = $bawahanCategory->id;
            }

            // Order Status: 80% Selesai, 20% Pending
            $isSelesai = rand(1, 100) <= 80;
            
            // If completed, completion date is 3-14 days after created_at
            // Ensure updated_at is not in the future
            $daysToComplete = rand(3, 14);
            $uDate = (clone $cDate)->addDays($daysToComplete);
            if ($uDate->isFuture()) {
                $uDate = Carbon::now();
            }

            Order::create([
                'customer_id' => $customer->id,
                'size_id' => $size->id,
                'category_id' => $catId,
                'status' => $isSelesai ? 'Selesai' : 'Pending',
                'created_at' => $cDate,
                'updated_at' => $isSelesai ? $uDate : $cDate,
            ]);
        }
    }
}
