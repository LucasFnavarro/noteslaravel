<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('notes')->insert([
            [
                'title' => 'O gato de botas',
                'text' => 'O gato de botas blá blá blá blá blá blá',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'O gato de botas 2',
                'text' => 'O gato de botas blá blá blá blá blá blá',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'O gato de botas 3',
                'text' => 'O gato de botas blá blá blá blá blá blá',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
