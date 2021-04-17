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
					['name' => 'Salário'],
					['name' => 'Investmento'],
					['name' => 'Aluguel'],
					['name' => 'Conta'],
					['name' => 'Imposto'],
					['name' => 'Viagem'],
					['name' => 'Reforma'],
					['name' => 'Empréstimo']
				]
			);
	}
}
