<?php

use Illuminate\Database\Seeder;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = [
            [
                'name' => 'Laravel',
                'summary'=> 'I am a professional Laravel developer, which I have worked on all Laravel versions from 5.2 to 10',
                'percentage' => '95'
            ],
            [
                'name' => 'PHP',
                'summary'=> 'I have an experience of the PHP version 7 and 8 ',
                'percentage' => '90'
            ],
            [
                'name' => 'APIs',
                'summary'=> 'Building APIs in Laravel by using Passport OAuth2 for authentication, then Documenting APIs.',
                'percentage' => '99'
            ],
            [
                'name' => 'Unit testing (PHPUnit)',
                'summary'=> 'Building testing classes of all APIs',
                'percentage' => '90'
            ],
            [
                'name' => 'AWS integrations',
                'summary'=> 'integrating AWS services with Laravel projects like: S3, SQS, and SES',
                'percentage' => '90'
            ],
            [
                'name' => 'Payments gateways integrations',
                'summary'=> 'Payments gateways integrations like: Paytabs, Tap, Moyasar, and AlRajhi',
                'percentage' => '95'
            ],
            [
                'name' => 'Front-end skills',
                'summary'=> 'Good knowledge on HTML, CSS, Bootstrap, basic concepts of JS.',
                'percentage' => '70'
            ],
            [
                'name' => 'Performance',
                'summary'=> 'Improving queries performance and decrease execution time',
                'percentage' => '70'
            ],
            [
                'name' => 'Handling exceptions',
                'summary'=> 'Handling all exceptions types',
                'percentage' => '80'
            ],
        ];

        foreach ($skills as $skill){
            \App\Skill::create($skill);
        }

    }
}
