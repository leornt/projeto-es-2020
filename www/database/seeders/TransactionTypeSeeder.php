<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionTypeSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('transaction_types')->insert(
			[
				['name' => 'Salary (Income)', 'type' => 'income'],
				['name' => 'Bill (Expense)', 'type' => 'expense'],
				['name' => 'Travel (Expense)', 'type' => 'expense'],
				['name' => 'Reform (Expense)', 'type' => 'expense'],
				['name' => 'Loan (Income)', 'type' => 'income'],
				['name' => 'Purchase (Expense)', 'type' => 'expense'],
				['name' => 'Other (Income)', 'type' => 'income'],
				['name' => 'Other (Expense)', 'type' => 'expense']
			]
		);
	}
}
