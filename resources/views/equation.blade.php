@extends('master')

@section('content')
    <div class="title m-b-md">
        Equations:
        <div>
            <ul>
                @foreach($equations as $equation)
                    <li>{{ $equation }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
