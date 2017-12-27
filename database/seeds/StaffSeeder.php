<?php

use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $staff = new \App\Models\Staff();
        $staff->name = 'root';
        $staff->password = md5('rootroot');
        $staff->save();

    }
}
