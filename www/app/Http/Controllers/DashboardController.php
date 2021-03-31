<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\TransactionType;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
	public function index($date)
	{
		$carbon = ($date != null) ? Carbon::createFromFormat('Y-m-d', $date) : Carbon::now();

		$current = Transaction::where('user_id', Auth::id())
			->where('date', '>=', $carbon->startOfMonth()->format('Y-m-d'))
			->where('date', '<=', $carbon->endOfMonth()->format('Y-m-d'))
			->get();

		$all = Transaction::selectRaw('date, SUM(value) as total')
			->where('user_id', Auth::id())
			->groupBy('date')
			->orderBy('date', 'desc')
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

		return redirect('/' . request('date'));
	}

	public function delete()
	{
		Transaction::destroy(request('id'));
		return redirect('/' . request('date'));
	}
}
