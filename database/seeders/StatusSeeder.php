<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'menunggu persetujuan'],
            ['name' => 'disetujui'],
        ];

        \App\Models\Status::insert($data);
    }
}
