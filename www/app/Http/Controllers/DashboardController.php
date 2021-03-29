<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
	public function index($date = null)
	{
		$carbon = ($date != null) ? Carbon::createFromFormat('Y-m-d', $date) : Carbon::now();
		return view(
			'dashboard.index',
			[
				'transactions' => Transaction
					::where('user_id', Auth::id())
					->where('date', '>=', $carbon->startOfMonth()->format('Y-m-d'))
					->where('date', '<=', $carbon->endOfMonth()->format('Y-m-d'))
					->get()
			]
		);
	}
}
