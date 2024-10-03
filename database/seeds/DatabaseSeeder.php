<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
             UsersTableSeeder::class,
             ProfileTableSeeder::class,
             SkillsTableSeeder::class,
             ServicesTableSeeder::class,
             EducationsTableSeeder::class,
             ExperiencesTableSeeder::class,
             TestimonialsTableSeeder::class,
             BlogsTableSeeder::class,
         ]);
    }
}
