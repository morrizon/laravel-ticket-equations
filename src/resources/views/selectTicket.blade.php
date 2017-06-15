@extends('master')

@section('content')
	<h1>Ticket</h1>
	<p class="lead">Select a ticket to generate the equations. If you resolv the equations, you will have internet!</p>
	<form method="post">
		<div class="form-group">
			{{ csrf_field() }}
			<select type="text" class="form-control" name="ticket">
				@for($ticket=1;$ticket<=$numberOfTickets;$ticket++)
					<option value="{{$ticket}}">Ticket {{$ticket}}</option>
				@endfor
			</select>
			<button type="submit" class="btn btn-default">Generate equations</button>
		</div>
	</form>
@endsection
