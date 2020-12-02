<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class posted extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\posted::factory(100)->create();
    }
}
