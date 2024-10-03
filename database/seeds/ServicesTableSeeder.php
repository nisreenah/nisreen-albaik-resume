<?php

use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [
                'en_title' => 'Solving any logical error',
                'ar_title' => '',
                'en_details' => 'Debugging and solving any logical error that may occur after delivery ',
                'ar_details' => '',
                'icon' => 'ion-social-buffer'
            ],
            [
                'en_title' => 'Developing a new extra feature',
                'ar_title' => '',
                'en_details' => 'Development a new feature after delivery the project with extra price',
                'ar_details' => '',
                'icon' => 'ion-qr-scanner'
            ],
            [
                'en_title' => 'Source code',
                'ar_title' => '',
                'en_details' => 'Delivery of the source code with the database',
                'ar_details' => '',
                'icon' => 'ion-printer'
            ],
            [
                'en_title' => 'Building Unit test classes with extra 400$',
                'ar_title' => '',
                'en_details' => 'Building Unit test for every single method to ensure that everything working well by run one command',
                'ar_details' => '',
                'icon' => 'ion-paintbucket'
            ],
        ];

        foreach ($services as $service){
            \App\Service::create($service);
        }
    }
}
