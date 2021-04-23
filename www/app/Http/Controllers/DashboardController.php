<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\TransactionType;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
	public function index($date = null)
	{
		if ($date == null)
			return redirect('/budget/' . date_format(date_create(), 'Y-m-d'));
		$carbon = Carbon::createFromFormat('Y-m-d', $date);

		$current = Transaction::where('user_id', Auth::id())
			->where('date', '>=', $carbon->startOfMonth()->format('Y-m-d'))
			->where('date', '<=', $carbon->endOfMonth()->format('Y-m-d'))
			->join('transaction_types', 'transaction_type_id', '=', 'transaction_types.id')
			->select('transactions.*', 'transaction_types.name as name', 'transaction_types.type as type')
			->get();

		$all = Transaction::selectRaw('date, SUM(value) as total')
			->where('user_id', Auth::id())
			->groupBy('date')
			->orderBy('date', 'desc')
			->get();

		$t_types = TransactionType::select()->orderBy('name')->get();

		return view(
			'dashboard.index',
			[
				'all' => $all,
				'date' => $date,
				'current' => $current,
				't_types' => $t_types
			]
		);
	}

	public function save($date)
	{
		$t = new Transaction();
		$tt = TransactionType::whereRaw('CONCAT(name, " (", type, ")") LIKE ?', [request("transaction-type")])->first();
		$value = ($tt->type == 'Expense') ? -floatval(request('value')) : request('value');

		$t->user_id = Auth::id();
		$t->transaction_type_id = $tt->id;

		$t->date = $date;
		$t->description = request('description');
		$t->value = $value;

		$t->save();

		return redirect('/budget/' . $date);
	}

	public function delete($date)
	{
		Transaction::destroy(request('id'));
		return redirect('/budget/' . $date);
	}
}
