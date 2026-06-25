<?php

namespace Database\Seeders;

use App\Models\Coa;
use Illuminate\Database\Seeder;

class CoaSeeder extends Seeder
{
    public function run(): void
    {
        Coa::insert([
            [
                'id' => 1,
                'category_id' => 1,
                'code' => '401',
                'name' => 'Gaji Karyawan'
            ],
            [
                'id' => 2,
                'category_id' => 1,
                'code' => '402',
                'name' => 'Gaji Ketua MPR'
            ],
            [
                'id' => 3,
                'category_id' => 2,
                'code' => '403',
                'name' => 'Profit Trading'
            ],
            [
                'id' => 4,
                'category_id' => 3,
                'code' => '601',
                'name' => 'Biaya Sekolah'
            ],
            [
                'id' => 5,
                'category_id' => 4,
                'code' => '602',
                'name' => 'Bensin'
            ],
            [
                'id' => 6,
                'category_id' => 4,
                'code' => '603',
                'name' => 'Parkir'
            ],
            [
                'id' => 7,
                'category_id' => 5,
                'code' => '604',
                'name' => 'Makan Siang'
            ],
            [
                'id' => 8,
                'category_id' => 5,
                'code' => '605',
                'name' => 'Makanan Pokok Bulanan'
            ],
        ]);
    }
}