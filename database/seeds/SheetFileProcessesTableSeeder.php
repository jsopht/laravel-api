<?php

use App\SheetFileProcess;
use Illuminate\Database\Seeder;

class SheetFileProcessesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SheetFileProcess::create(['status' => 'none']);
    }
}
