@extends('dashboard')
@section('navigation')
	@include('navigation')
@endsection
@section('sidebar')
   @include('sidebar')
@endsection
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Single URL</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/post/multi') }}">
						<input type="hidden" name="domain" id="domain" value="{{ $feed->domain_id }}">
                        <input type="hidden" name="feed" id="feed" value="{{ $feed->id }}">
                        <input type="hidden" name="single" id="single" value="true">


						<div class="form-group">
							<textarea class="col-md-10 control-label" name="url" type="url"></textarea>

                        <div class="col-md-2">
								<button type="submit" class="btn btn-primary">
									Proccess
								</button>
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>



@endsection
@section('customscript')
<script type="text/javascript">
$(document).ready( function ()
{
	$('#domain_id').change(function()
	{
		var option = $(this).find('option:selected').val();
		var $_token = $('#_token').val();
		 $.ajax({
            type: "POST",
			headers: { 'X-CSRF-Token' : $_token },
            url: "/feeds/getcategory",
            data: { 'catid': option,'_token':$_token  },
            success: function(data){
				try {
					 var opts = $.parseJSON(data);
					$.each(opts, function(i, d) {
						$('#domain_category').append('<option value="' + i + '">' + d + '</option>');
					});
				} catch(e) {
					 $('#domain_category').empty();
				}

            }
        });
	});
});

</script>
@endsection
