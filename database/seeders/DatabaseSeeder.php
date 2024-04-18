<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Listing;
use Illuminate\Database\Seeder;
use Database\Factories\ListingFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $user=User::factory()->create([
            "name"=>"mans",
            "email"=>"mans@bd.com"
        ]);
        Listing::factory(1)->create(
            [   'user_id'=>$user->id]
           );
    }
}
