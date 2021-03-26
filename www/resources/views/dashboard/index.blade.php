@extends('layouts.app')

@section('content')

<h1>Dashboard</h1>

<table>
	<thead>
		<tr>
			<th>Description</th>
			<th>Date</th>
			<th>Value</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($transactions as $trans)
		<tr style="color: {{ $trans->IsExpense() ? 'red' : 'green' }};">
			<td>{{ $trans->description }}</td>
			<td>{{ $trans->date }}</td>
			<td>{{ $trans->value }}</td>
		</tr>
		@endforeach
	</tbody>
</table>

@endsection