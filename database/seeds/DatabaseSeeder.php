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
        // $this->call(UsersTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(TeachersTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CoursesTableSeeder::class);
        $this->call(LessonsTableSeeder::class);
        $this->call(ClassroomsTableSeeder::class);
        $this->call(ClassroomUserTableSeeder::class);
        $this->call(ClassroomCourseTableSeeder::class);
    }
}
