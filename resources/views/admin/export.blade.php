
@extends('layout')

@section('content')
	<h2>Voting Summary</h2>
	@foreach($aCandidates as $sKey => $aCandidates)
	<div>
		<h3>{{$sKey}}</h3>
		<div style="width: 100%">
			<table style="width: 100%; border: 1px solid gray;" class="table table-bordered table-striped">
				<tr style="background-color: gray;">
					<th>No.</th>
					<th>Student No.</th>
					<th>Name</th>
					<th>Partylist</th>
					<th>Section</th>
					<th>Vote Count</th>
				</tr>
				@foreach($aCandidates as $Pos => $Data)
				<tr>
					<th scope="row"> {{ $Pos + 1 }}</th>
			        <td>{{ $Data->student_id }}</td>
			        <td>{{ $Data->name }}</td>
			        <td>
			            @if($Data->partylist_id === 0)
			                {{ 'Independent '}}
			            @else
			                {{ $Data->partylist->name }}
			            @endif
			        </td>
			        <td>{{ $Data->section }}</td>
			        <td>
			            {{ $Data->vote->count() }}
			        </td>
				</tr>
				@endforeach
			</table>
		</div>
		<br>
	</div>
	

	@endforeach

@endsection