<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $userIds = User::query()->select('id');
        if (env('APP_ENV') != 'testing') {
            $userIds = $userIds->where('id', '!=', 1);
        }
        $userIds = $userIds->pluck('id');

        return [
            'user_id'          => $userIds->random(),
            'title'            => fake()->text(rand(20, 40)),
            'description'      => fake()->text(),
            'publication_date' => Carbon::now()->addMinutes(rand(-20160, 10080))->seconds(0),
        ];
    }
}
