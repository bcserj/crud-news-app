<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        \App\Models\User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin')
        ]);

        \App\Models\User::factory(10)
            ->create()
            ->each(function ($user) {
                $randomPosts = rand(null, 10);
                \App\Models\Post::factory($randomPosts)->create(
                    ['user_id' => $user->id]
                )
                    ->each(function ($post) use ($user) {
                        $randomComments = rand(null, 10);
                        $randomVote = rand(0, 5);

                        \App\Models\Comment::factory($randomComments)->create([
                            'user_id' => $user->id,
                            'post_id' => $post->id
                        ]);

                        \App\Models\Vote::factory($randomVote)->create([
                            'user_id' => $user->id,
                            'post_id' => $post->id
                        ]);
                    });
            });


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
