@extends('layouts.app')

@section('content')

@php

$date = $current->isEmpty() ? request()->route()->parameter('date') : $current->first()->date;
$display_month = $current->isEmpty() ? date_format(date_create($date), 'F Y') : $current->first()->PrintableDate();
$month_total = $current->isEmpty() ? 0 : $current->sum('value');

@endphp

<div class="d-flex flex-row justify-content-center">
	<div class="align-self-start">
		<div class="list-group">
			@foreach ($all as $month)
			<div class="list-group-item d-flex flex-row" style="background-color: {{ $month->total < 0 ? '#FFA0A0' : '#B0FFAE' }}; color: {{ $month->total < 0 ? '#8B0000' : '#228B22' }};">
				<a style="color: {{ $month->total < 0 ? '#8B0000' : '#228B22' }};" class="col-8" href="/{{ $month->date }}">
					{{ $month->PrintableDate() }}
				</a>
				<span class="col-2">{{ $month->total }}</span>
			</div>
			@endforeach
		</div>
	</div>

	<div class="d-flex flex-column align-items-center">
		<h2>Available budget in <span style="font-weight: bold;">{{ $display_month }}</span></h2>
		<p>
			<span style="font-size: 32px; font-weight: bold; color: {{ $month_total < 0 ? 'red' : 'green' }}">
				R$ {{ $month_total }}
			</span>
		</p>

		<form class="my-5" method="POST" action="/">
			@csrf
			<div class="form-row">
				<input type="hidden" name="date" value="{{ $date }}">
				<div class="col-5">
					<input class="form-control" type="text" name="description" required maxlength="40">
				</div>
				<div class="col-2 d-flex flex-row align-items-center">
					<span style="margin: 0px 4px 0px 0px;">R$</span>
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
					<input class="form-control" type="submit" value="Add">
				</div>
			</div>
		</form>

		<div class="d-flex flex-row">
			<div class="list-group">
				@foreach ($current as $t)
				<div class="list-group-item">
					<form method="POST" action="/">
						@method('DELETE')
						@csrf

						<input type="hidden" name="date" value="{{ $date }}">
						<input type="hidden" name="id" value="{{ $t->id }}">
						<button type="submit" class="btn btn-sm mr-4 bg-danger text-white border rounded-3">-</button>
						{{ $t->description }} - {{ $t->value }}
					</form>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>

@endsection