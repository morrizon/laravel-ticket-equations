@extends('master')




@section('content')
    <style>
        .random-equation:hover {
            color: green;

        }
    </style>
    <h1>Equations:</h1>
    @foreach($equations as $equation)
        <h2>{!! $equation !!}</h2>
    @endforeach
@endsection
