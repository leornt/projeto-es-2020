@extends('layouts.app')

@section('content')

<div class="container-fluid h-100">
	<div class="row w-auto h-100">
		<div class="col-2 bg-white px-0 py-4 shadow w-auto" style="z-index: 1;">
			<img src="{{ asset('images/icon.png') }}" class="mx-auto d-block w-25 py-4">

			@if ($all->isEmpty())
			<p class="py-2" style="text-align: center;">Add transactions and your monthly balance list will appear in here!</p>
			@endif

			<table class="table table-hover table-borderless">
				<tbody>
					@foreach ($all as $month)
					<tr class="bg-secondary">
						<td><a class="text-dark" style="font-weight: bold;" href="/budget/{{ $month->date }}">{{ $month->PrintableDate() }}</a></td>
						<td><span style="font-weight: bold; float: right;" class="{{ $month->total >= 0 ? 'text-success' : 'text-danger' }}">R$ {{ number_format($month->total, 2) }}</span></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="col-10 py-4 px-0">
			<div class="container-fluid">
				<div style="text-align: center; font-size: 20px;" class="row justify-content-center">
					<div class="col">Available budget in <span style="font-weight: bold;">{{ date_format(date_create(request()->route()->parameter('date')), 'F Y') }}</span></div>
				</div>
				@php
				$currentBudget = number_format($current->sum('value'), 2);
				@endphp
				<div class="row pb-5 justify-content-center {{ $currentBudget >= 0 ? 'text-success' : 'text-danger' }}" style="text-align: center; font-weight: bold; font-size: 48px;">
					R$ {{ $currentBudget }}
				</div>

				<div class="row bg-secondary justify-content-center">
					<div class="col-8 my-3">
						<form class="row" method="POST" action="/budget/{{ $date }}">
							@csrf
							<div class="col-6">
								<input type="text" class="form-control form-control-sm border-dark" required name="description" placeholder="Description" tabindex="1" maxlength="64">
							</div>
							<div class="col-3">
								<input type="number" class="form-control form-control-sm border-dark" step="any" required name="value" placeholder="R$" min="0" tabindex="2">
							</div>
							<div class="col-2">
								<select name="transaction-type" class="form-control form-control-sm border-dark" tabindex="3">
									@foreach ($t_types as $transaction_type)
									<option>{{ $transaction_type->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-1">
								<input type="submit" class="btn btn-light btn-outline-dark btn-sm" value="✓" tabindex="4">
							</div>
						</form>
					</div>
				</div>

				<div class="row py-4">
					<div class="container-fluid">
						<div class="row">
							<div class="col" style="text-align: center;">
								<div class="container-fluid">
									<div class="row justify-content-center">
										<span class="text-success pb-3" style="font-weight: bold; font-size: 24px">INCOME</span>
									</div>
									<form method="POST" action="/budget/{{ $date }}">
										@csrf
										@method('DELETE')
										<table class="table table-borderless">
											<tbody>
												@foreach ($current as $transaction)
												@if($transaction->type == 'income')
												<tr class="row align-items-center" style="font-size: 20px;">
													<td style="word-wrap: break-word;" class="col-2">
														<input type="hidden" name="id" value="{{ $transaction->id }}">
														<input type="submit" class="btn btn-secondary rounded-circle" value="-">
													</td>
													<td class="col-7" style="text-align: left; word-wrap: break-word;">
														{{ $transaction->description }} ({{ $transaction->transaction_name }})
													</td>
													<td class="col-3 text-success" style="font-weight: bold; text-align: left; word-wrap: break-word;">
														R$ {{ number_format($transaction->value, 2) }}
													</td>
												</tr>
												@endif
												@endforeach
											</tbody>
										</table>
									</form>
								</div>
							</div>
							<div class="col" style="text-align: center;">
								<div class="container-fluid">
									<div class="row justify-content-center">
										<span class="text-danger pb-3" style="font-weight: bold; font-size: 24px">EXPENSES</span>
									</div>
									<form method="POST" action="/budget/{{ $date }}">
										@csrf
										@method('DELETE')
										<table class="table table-borderless">
											<tbody>
												@foreach ($current as $transaction)
												@if($transaction->type == 'expense')
												<tr class="row align-items-center" style="font-size: 20px; word-wrap: break-word;">
													<td class="col-2">
														<input type="hidden" name="id" value="{{ $transaction->id }}">
														<input type="submit" class="btn btn-secondary rounded-circle" value="-">
													</td>
													<td class="col-7" style="text-align: left; word-wrap: break-word;">
														{{ $transaction->description }} ({{ $transaction->transaction_name }})
													</td>
													<td class="col-3 text-danger" style="font-weight: bold; text-align: left; word-wrap: break-word;">
														R$ {{ number_format(abs($transaction->value), 2) }}
													</td>
												</tr>
												@endif
												@endforeach
											</tbody>
										</table>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
