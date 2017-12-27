<?php

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $language = new \App\Models\Languages();
        $language->name = '简体中文';
        $language->english = 'chinese_simple';
        $language->save();

        $language = new \App\Models\Languages();
        $language->name = 'english';
        $language->english = 'english';
        $language->save();

        $language = new \App\Models\Languages();
        $language->name = '繁体中文';
        $language->english = 'chinese_traditional';
        $language->save();
    }
}
