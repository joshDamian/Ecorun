<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'label' => 'eco-regular',
                'description' => 'eco-regulars are regular ecorun users',
                'canuse' => 'user',
                'credit' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'label' => 'online store',
                'description' => 'an online store is a shop created on ecorun',
                'canuse' => 'business',
                'credit' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'label' => 'business owner',
                'description' => 'a business owner owns a business on ecorun',
                'canuse' => 'user',
                'credit' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'label' => 'service',
                'description' => 'a service is a business that sells services',
                'canuse' => 'business',
                'credit' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'label' => 'business',
                'description' => 'a business on ecorun',
                'canuse' => 'business',
                'credit' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        foreach ($data as $key => $value) {
            # code...
            DB::table('badges')->insert($value);
        }
    }
}
