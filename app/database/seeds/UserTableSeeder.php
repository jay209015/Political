<?php
class UsersTableSeeder extends Seeder {
    public function run(){
        User::create(
            array('first_name' =>'John',
                'last_name' => 'Doe', 'email' => 'test@test.com', 'password' => Hash::make('password')));
     }
}