@extends('master')

@section('content')
    <div class="title m-b-md">
        Ticket
        <form method="post">
            {{ csrf_field() }}
            <input type="text" name="ticket">
            <input type="submit">
        </form>

    </div>
@endsection
