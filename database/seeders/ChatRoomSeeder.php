<?php

namespace Database\Seeders;

use App\Models\ChatRoom;
use Illuminate\Database\Seeder;

class ChatRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChatRoom::create([
            'name' => 'Global'
        ]);

        ChatRoom::create([
            'name' => 'Tech talk'
        ]);
    }
}
