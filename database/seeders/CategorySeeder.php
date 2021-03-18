<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'class_name'      => 'Kelas 7',
                'description'     => 'Kelas 7 SMP',
            ],
            [
                'class_name'      => 'Kelas 8',
                'description'     => 'Kelas 8 SMP',
            ],
            [
                'class_name'      => 'Kelas 9',
                'description'     => 'Kelas 9 SMP',
            ],
            [
                'class_name'      => 'Kelas 10',
                'description'     => 'Kelas 10 SMA',
            ],
            [
                'class_name'      => 'Kelas 11',
                'description'     => 'Kelas 11 SMA',
            ],
            [
                'class_name'      => 'Kelas 12',
                'description'     => 'Kelas 12 SMA',
            ],

        ]);
    }
}
