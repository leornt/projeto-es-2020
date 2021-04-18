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
				['name' => 'Salary', 'type' => 'income'],
				['name' => 'Bill', 'type' => 'expense'],
				['name' => 'Travel', 'type' => 'expense'],
				['name' => 'Reform', 'type' => 'expense'],
				['name' => 'Loan', 'type' => 'income'],
				['name' => 'Purchase', 'type' => 'expense']
			]
		);
	}
}
