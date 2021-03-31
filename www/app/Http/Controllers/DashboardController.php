<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\TransactionType;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Builder\Trait_;

use function PHPUnit\Framework\isEmpty;

class DashboardController extends Controller
{
	public function index($date = null)
	{
		$carbon = ($date != null) ? Carbon::createFromFormat('Y-m-d', $date) : Carbon::now();

		$all = Transaction::selectRaw('date, SUM(value) as total')
			->where('user_id', Auth::id())
			->groupBy('date')
			->orderBy('date', 'desc')
			->get();

		$current = Transaction::where('user_id', Auth::id())
			->where('date', '>=', $carbon->startOfMonth()->format('Y-m-d'))
			->where('date', '<=', $carbon->endOfMonth()->format('Y-m-d'))
			->get();

		$t_types = TransactionType::all();

		return view(
			'dashboard.index',
			[
				't_types' => $t_types,
				'all' => $all,
				'current' => $current
			]
		);
	}

	public function save()
	{
		$t = new Transaction();

		$t->user_id = Auth::id();
		$t->transaction_type_id = TransactionType::where('name', request("transaction-type"))->first()->id;
		$t->date = request('date');
		$t->description = request('description');
		$t->value = request('value');
		$t->type = $t->value < 0 ? "expense" : "income";

		$t->save();

		redirect('/');
	}
}
