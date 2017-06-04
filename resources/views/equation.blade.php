@extends('master')

@section('content')
    <h1>Equations:</h1>
    @foreach($equations as $equation)
        <h2>{{ $equation }}</h2>
    @endforeach
@endsection
