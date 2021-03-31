@extends('layouts.app')

@section('content')

@php

$date = $current->isEmpty() ? date_format(date_create(), 'Y/m/d') : $current->first()->date;
$display_month = $current->isEmpty() ? date_format(date_create(), 'F Y') : $current->first()->PrintableDate();
$month_total = $current->isEmpty() ? 0 : $current->first()->value;

@endphp

<div class="d-flex flex-column align-items-center">
	<h2>Available budget in <span style="font-weight: bold;">{{ $display_month }}</span></h2>
	<p>
		<span style="font-size: 32px; font-weight: bold; color: {{ $month_total < 0 ? 'red' : $month_total > 0 ? 'green' : 'black' }}">
			R$ {{ $month_total }}
		</span>
	</p>

	<form method="POST" action="/">
		@csrf
		<div class="form-row">
			<input type="hidden" name="date" value="{{ $date }}">
			<div class="col-5">
				<input class="form-control" type="text" name="description" required>
			</div>
			<div class="col-2">
				<input class="form-control" type="number" name="value" required>
			</div>
			<div class="col-3">
				<select name="transaction-type" class="form-control">
					@foreach ($t_types as $t)
					<option>{{ $t->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-2">
				<input class="form-control" type="submit">
			</div>
		</div>
	</form>
</div>

@endsection