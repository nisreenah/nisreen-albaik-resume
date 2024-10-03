<?php

use Illuminate\Database\Seeder;

class EducationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Education::create([
            'en_major' => 'Faculty of Information Technology',
            'ar_major' => 'Faculty of Information Technology',
            'en_university' =>'Islamic University Of Gaza',
            'ar_university' =>'Islamic University Of Gaza',
            'start_date' => '2010-06-01',
            'end_date' => '2015-06-01'
        ]);
    }
}
