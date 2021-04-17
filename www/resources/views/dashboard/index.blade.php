@extends('layouts.app')

@section('content')

<div class="container-fluid px-4">
	<div class="row">
		<table class="table table-hover table-borderless col-2">
			<tbody>
				@foreach ($all as $month)
				<tr>
					<td><a style="font-weight: bold;" href="/{{ $month->date }}">{{ $month->PrintableDate() }}</a></td>
					<td><span style="font-weight: bold; float: right;" class="{{ $month->total >= 0 ? 'text-success' : 'text-danger' }}">{{ number_format($month->total, 2) }}</span></td>
				</tr>
				@endforeach
			</tbody>
		</table>

		<div class="col-10">
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

				<div class="row pb-5 justify-content-center">
					<div class="col-8">
						<form class="row" method="POST" action="/{{ $date }}">
							@csrf
							<div class="col-6">
								<input type="text" class="form-control form-control-sm" required name="description" placeholder="Description" tabindex="1">
							</div>
							<div class="col-3">
								<input type="number" class="form-control form-control-sm" step="any" required name="value" placeholder="R$" min="0" tabindex="2">
							</div>
							<div class="col-2">
								<select name="transaction-type" class="form-control form-control-sm" tabindex="3">
									@foreach ($t_types as $transaction_type)
									<option>{{ $transaction_type->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-1">
								<input type="submit" class="btn btn-light btn-outline-secondary btn-sm" value="Add" tabindex="4">
							</div>
						</form>
					</div>
				</div>

				<div class="row">
					<div class="container-fluid">
						<div class="row">
							<div class="col" style="text-align: center;">
								<div class="container-fluid">
									<div class="row justify-content-center">
										<span class="text-success pb-3" style="font-weight: bold; font-size: 24px">INCOME</span>
									</div>
									<form method="POST" action="/{{ $date }}">
										@csrf
										@method('DELETE')
										<table class="table table-borderless">
											<tbody>
												@foreach ($current as $transaction)
												@if($transaction->type == 'income')
												<tr class="row align-items-center" style="font-size: 20px;">
													<td class="col-2">
														<input type="hidden" name="id" value="{{ $transaction->id }}">
														<input type="submit" class="btn btn-light" value="-">
													</td>
													<td class="col-7" style="text-align: left;">
														{{ $transaction->description }}
													</td>
													<td class="col-3 text-success" style="font-weight: bold; text-align: left;">
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
									<form method="POST" action="/{{ $date }}">
										@csrf
										@method('DELETE')
										<table class="table table-borderless">
											<tbody>
												@foreach ($current as $transaction)
												@if($transaction->type == 'expense')
												<tr class="row align-items-center" style="font-size: 20px;">
													<td class="col-2">
														<input type="hidden" name="id" value="{{ $transaction->id }}">
														<input type="submit" class="btn btn-light" value="-">
													</td>
													<td class="col-7" style="text-align: left;">
														{{ $transaction->description }}
													</td>
													<td class="col-3 text-danger" style="font-weight: bold; text-align: left;">
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