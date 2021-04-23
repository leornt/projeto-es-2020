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
				['name' => 'Salary', 'type' => 'Income'],
				['name' => 'Bill', 'type' => 'Expense'],
				['name' => 'Travel', 'type' => 'Expense'],
				['name' => 'Reform', 'type' => 'Expense'],
				['name' => 'Loan', 'type' => 'Income'],
				['name' => 'Purchase', 'type' => 'Expense'],
				['name' => 'Other', 'type' => 'Income'],
				['name' => 'Other', 'type' => 'Expense']
			]
		);
	}
}
