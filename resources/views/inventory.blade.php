@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			@foreach ($user_item_list as $user_item)
			<div class="panel panel-default">
				<div class="panel-heading">{{ $user_item->name}}</div>
				<div class="panel-body">
					Count: {{ $user_item->number}}
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
@endsection