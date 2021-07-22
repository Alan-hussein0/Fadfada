<?php

namespace Database\Factories;

use App\Models\Messanger;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessangerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Messanger::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        do {
            $from = rand(1,15);
            $to = rand(1,15);
        } while ($from == $to);
        return [
            'from_user_id'=>$from,
            'to_user_id'=>$to,
            'text'=>$this->faker->sentence
        ];
    }
}
