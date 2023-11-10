<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Vendor::create([
            'nama_vendor' => 'BUDI'
        ]);

        \App\Models\Vendor::create([
            'nama_vendor' => 'SIS'
        ]);

        \App\Models\Client::create([
            'kd_client' => 'RNBW',
            'nama_client' => 'Rainbow',
            'alamat_client' => 'Depok',
            'nomor_telepon_client' => '123',
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
