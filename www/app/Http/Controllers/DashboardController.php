<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
	public function index()
	{
		return view(
			'dashboard.index',
			[
				'transactions' => Transaction::where('user_id', Auth::id())->orderBy('date')->get()
			]
		);
	}
}
