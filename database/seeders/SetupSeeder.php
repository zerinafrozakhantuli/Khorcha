<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\carbon;

class SetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::table('users')->insert([
            'name' => 'Zerin Afroza Khan',
            'phone' => '01537017539',
            'email' => 'zerinafroza.tuli@gmail.com',
            'password' => Hash::make('12345678'),
            'username'=> 'Zerin',
            'role'=> 1,
            'slug'=>'U'.uniqid(20),
            'created_at'=>Carbon::now()->toDateTimeString(),
        ]);

         DB::table('basics')->insert([
            'basic_company' => 'UY LAB IT System',
            'basic_title' => 'IT Training Institute',
            'basic_creator' => 1,
            'basic_slug'=>'B'.uniqid(20),
            'created_at'=>Carbon::now()->toDateTimeString(),
        ]);

          DB::table('social_media')->insert([
            'sm_facebook' => 'www.facebook.com',
            'sm_twitter' => '#',
            'sm_creator' => 1,
            'sm_slug'=>'SM'.uniqid(20),
            'created_at'=>Carbon::now()->toDateTimeString(),
        ]);

          DB::table('contact_information')->insert([
            'ci_phone1' => '01537017539',
            'ci_email1' => 'info@admin.com',
            'ci_address1' => 'Shyamoli,Dhaka',
            'ci_creator'=> 1,
            'ci_slug'=>'CI'.uniqid(20),
            'created_at'=>Carbon::now()->toDateTimeString(),
        ]);

          //role data table start seed

          $roles=['Superadmin','Admin','Author','Editor','Subscriber'];
          foreach(  $roles as $urole) {
            
            DB::table('roles')->insert([
            'role_name' => $urole,
            'role_slug'=>'R'.uniqid(20),
            'created_at'=>Carbon::now()->toDateTimeString(),
        ]);
            
          }
    }
}
