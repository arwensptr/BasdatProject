namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DataWarehouseSeeder extends Seeder
{
    public function run()
    {
        // 1. ISI DIMENSI STATUS AKHIR
        // Sesuaikan dengan status order di aplikasimu
        $statuses = ['Pending', 'Processing', 'Shipped', 'Delivered', 'Canceled', 'Returned'];
        foreach ($statuses as $status) {
            DB::table('dim_status_akhir')->insertOrIgnore([
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. ISI DIMENSI METODE LAYANAN
        // Contoh kurir
        $couriers = [
            ['jenis_order' => 'Reguler', 'nama_kurir' => 'JNE'],
            ['jenis_order' => 'Reguler', 'nama_kurir' => 'SiCepat'],
            ['jenis_order' => 'Instant', 'nama_kurir' => 'GoSend'],
            ['jenis_order' => 'Instant', 'nama_kurir' => 'GrabExpress'],
        ];
        foreach ($couriers as $courier) {
            DB::table('dim_metode_layanan')->insertOrIgnore(array_merge($courier, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // 3. ISI DIMENSI WAKTU (Untuk tahun ini)
        // Kita isi manual untuk 365 hari ke depan agar query ready
        $startDate = Carbon::create(2025, 1, 1); // Mulai 1 Jan 2025
        $endDate = Carbon::create(2025, 12, 31);

        while ($startDate->lte($endDate)) {
            DB::table('dim_waktu')->insertOrIgnore([
                'full_date'  => $startDate->format('Y-m-d'),
                'hari'       => $startDate->day,
                'bulan'      => $startDate->month,
                'nama_bulan' => $startDate->format('F'), // January
                'tahun'      => $startDate->year,
                'quarter'    => 'Q' . $startDate->quarter,
                'nama_hari'  => $startDate->format('l'), // Sunday
            ]);
            
            $startDate->addDay();   
        }
    }
}