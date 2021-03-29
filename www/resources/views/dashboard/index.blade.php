@extends('layouts.app')

@section('content')

<table class="table-sm table-hover">
	<thead>
		<tr>
			<th>Description</th>
			<th>Value</th>
		</tr>
	</thead>
	<tbody>
		@foreach($transactions as $trans)
		<tr>
			<td>{{ $trans->description }}</td>
			<td>{{ $trans->AbsoluteValue() }}</td>
			<td>{{ $trans->date }}</td>
		</tr>
		@endforeach
	</tbody>
</table>

@endsection