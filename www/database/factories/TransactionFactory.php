<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Transaction;
use App\Models\TransactionType;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::where('email', 'kamisou@outlook.com')->first(),
			'transaction_type_id' => TransactionType::where('name', 'General')->first(),
			'type' => $this->faker->randomElement(['Income', 'Expense']),
			'date' => $this->faker->date(),
			'description' => $this->faker->sentence(),
			'value' => $this->faker->randomFloat(2, -320, 500)
        ];
    }
}
