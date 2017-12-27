<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{   

    public function run()    
    {        
        $this->call(StaffSeeder::class);    
        $this->call(LanguageSeeder::class);
        $this->call(NavSeeder::class);
    }
}