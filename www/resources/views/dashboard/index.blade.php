@extends('layouts.app')

@section('content')

<ul>
@foreach($all_transactions as $trans)
	<li><a href="{{ $trans->date }}">{{ $trans->PrintableDate() }}</a> = {{ $trans->total }}</li>
@endforeach
</ul>

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