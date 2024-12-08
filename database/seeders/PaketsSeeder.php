<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pakets;
use App\Models\Destinations;
use App\Models\Hotels;
use App\Models\Transports;

class PaketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat beberapa destinasi
        $destination1 = Destinations::create([
            'nama_destinasi' => 'Pantai Kuta',
            'deskripsi' => 'Pantai yang terkenal dengan pasir putih dan ombak yang cocok untuk surfing.',
            'lokasi' => 'Bali',
            'htm' => 15000,
        ]);

        $destination2 = Destinations::create([
            'nama_destinasi' => 'Gunung Bromo',
            'deskripsi' => 'Gunung berapi aktif dengan pemandangan sunrise yang indah.',
            'lokasi' => 'Jawa Timur',
            'htm' => 25000,
        ]);

        // Buat beberapa hotel
        $hotel1 = Hotels::create([
            'nama_hotel' => 'Kuta Beach Hotel',
            'alamat' => 'Jalan Raya Kuta No. 10',
            'harga_per_malam' => 500000,
            'destination_id' => $destination1->id,
        ]);

        $hotel2 = Hotels::create([
            'nama_hotel' => 'Bromo Mountain Lodge',
            'alamat' => 'Jalan Gunung Bromo No. 5',
            'harga_per_malam' => 750000,
            'destination_id' => $destination2->id,
        ]);

        // Buat beberapa transportasi
        $transport1 = Transports::create([
            'nama_transport' => 'Bus Pariwisata Bali',
            'tipe_transport' => 'bis',
            'destination_id' => $destination1->id,
        ]);

        $transport2 = Transports::create([
            'nama_transport' => 'Travel Surabaya-Bromo',
            'tipe_transport' => 'travel',
            'destination_id' => $destination2->id,
        ]);

        // Buat beberapa paket wisata
        Pakets::create([
            'nama_paket' => 'Liburan di Pantai Kuta',
            'deskripsi' => 'Paket wisata 3 hari 2 malam di Pantai Kuta.',
            'harga_total' => 1000000,
            'destination_id' => $destination1->id,
            'hotel_id' => $hotel1->id,
            'transport_id' => $transport1->id,
            'rating' => 5,
            'ulasan' => 120,
            'total_pembelian' => 300,
        ]);

        Pakets::create([
            'nama_paket' => 'Eksplorasi Gunung Bromo',
            'deskripsi' => 'Paket wisata 2 hari 1 malam di Gunung Bromo.',
            'harga_total' => 1500000,
            'destination_id' => $destination2->id,
            'hotel_id' => $hotel2->id,
            'transport_id' => $transport2->id,
            'rating' => 4,
            'ulasan' => 200,
            'total_pembelian' => 500,
        ]);
    }
}
