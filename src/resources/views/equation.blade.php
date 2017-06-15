@extends('master')




@section('content')
    <style>
        .random-equation:hover {
            color: green;

        }
    </style>
    <h1>Equations for ticket {{$ticket}}:</h1>
    @foreach($equations as $index => $equation)
		<p class="lead">
			Equation {{$index + 1}}
			(the result will be the green part of the ticket:
			{{ substr("dddddd", 0, $index*2) }}<font color="green">{{ strtoupper(substr("dddddd", $index*2, 2)) }}</font>{{ substr("dddddd", $index*2+2, 6) }}
        <h2>{!! $equation !!}</h2>
    @endforeach
@endsection
