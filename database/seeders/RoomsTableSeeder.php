<?php
// filepath: /database/seeders/RoomsTableSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Room::create([
            'room_name' => 'Class 1a',
            'temp' => 22.5,
            'electricity_usage' => 150.0,
        ]);

        Room::create([
            'room_name' => 'Class 2b',
            'temp' => 20.0,
            'electricity_usage' => 100.0,
        ]);
    }
}