<?php

use App\Post;
use App\User;
use Illuminate\Database\Seeder;

class BloggersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (SupervisorUsersSeeder::$emails as $email) {
            $supervisor = User::whereEmail($email)->first();

            factory(Post::class, 10)->create([
                'author_id' => $supervisor->id
            ]);

            factory(User::class, 10)->create()->each(function ($user) use ($supervisor) {
                $supervisor->bloggers()->save($user);

                factory(Post::class, 30)->create([
                    'author_id' => $user->id
                ]);
            });
        }
    }
}
