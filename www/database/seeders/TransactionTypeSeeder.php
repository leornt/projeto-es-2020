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
				['name' => 'Salário', 'type' => 'income'],
				['name' => 'Investmento', 'type' => 'expense'],
				['name' => 'Aluguel', 'type' => 'expense'],
				['name' => 'Conta', 'type' => 'expense'],
				['name' => 'Imposto', 'type' => 'expense'],
				['name' => 'Viagem', 'type' => 'expense'],
				['name' => 'Reforma', 'type' => 'expense'],
				['name' => 'Empréstimo', 'type' => 'income'],
				['name' => 'Compra', 'type' => 'expense']
			]
		);
	}
}
