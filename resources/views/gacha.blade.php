@extends('app')

@section('content')
<link href="{{ asset('/css/gacha.css') }}" rel="stylesheet">
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default normal-gacha">
				<div class="panel-heading">Normal Gacha</div>

				<div class="panel-body">
					<button class="btn btn-primary btn-get-coin" type="button">Draw</button>
					<div class="normal-gacha result">
					</div>
				</div>
			</div>
			<div class="panel panel-default expensive-gacha">
				<div class="panel-heading">Expensive Gacha</div>

				<div class="panel-body">
					<button class="btn btn-primary btn-get-coin" type="button">Draw</button>
					<div class="expensive-gacha result">
					</div>
				</div>
			</div>
			<div class="panel panel-default box-gacha">
				<div class="panel-heading">Box Gacha</div>

				<div class="panel-body">
					<button class="btn btn-primary btn-get-coin" type="button">Draw</button>
					<div class="box-gacha result">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$( document ).ready(function() {
	var base_url = "{{URL::to('/')}}";
	console.log(base_url);
	$('.btn-get-coin').on('click', function(e){
		$('.result').text('');
		if($(this).parents('.normal-gacha').length){
			var post_url = '/gacha/drawNormal';
		}
		else if ($(this).parents('.expensive-gacha').length){
			var post_url = '/gacha/drawExpensive';
		}
		else if ($(this).parents('.box-gacha').length){
			var post_url = '/gacha/drawBox';
		}

		e.preventDefault();
		console.log('click');
		$.ajax({
            type: "POST",
            url: base_url+post_url,
            data: {
            	_token: "{{ csrf_token() }}"
            },
       		dataType: 'JSON',
            success: function( data ) {
            	console.log( data );
            	var result = data['gacha'];
            	var msg  = data['msg'];
            	console.log( result );
            	if(post_url=='/gacha/drawNormal'){
            		if(data['status']=='success'){
            			$('.normal-gacha.result').text(data.gacha.name).css('color','green');
            			$('.coin_area').text(data.gacha.current_coin);
            		}
            		else
            			$('.normal-gacha.result').text(msg).css('color','red');
				}
				else if (post_url=='/gacha/drawExpensive'){
				if(data['status']=='success'){
						$('.expensive-gacha.result').text(data.gacha.name).css('color','green');
						$('.coin_area').text(data.gacha.current_coin);
					}
					else
            			$('.expensive-gacha.result').text(msg).css('color','red');
				}
				else if (post_url=='/gacha/drawBox'){
					if(data['status']=='success'){
						$('.box-gacha.result').text(data.gacha.name).css('color','green');
						$('.coin_area').text(data.gacha.current_coin);
					}
					else
            			$('.box-gacha.result').text(msg).css('color','red');
				}
				if(data['status']=='success' && data.gacha.price > 0){
					$('.coin_area').css('color','red');
				}
            },
            error: function(data) { // the data parameter here is a jqXHR instance
		        var errors = data.responseJSON;
		        console.log('server errors',data);
		    }
        });
	});
});
</script>
@endsection
