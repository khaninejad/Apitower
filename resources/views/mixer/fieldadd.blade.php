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
				<div class="panel-heading">New field mixer</div>
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

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/mixer/fieldstore') }}">
						<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Domain</label>
							<div class="col-md-6">
                           
                             
                            <select name="domain_id" id="domain_id">
                           <option value="0">Select a Domain</option>
                            @foreach ($domains as $item)
                            <option value="{{ $item->id }}"> {{ $item->domain_title }}</option>
    @endforeach</select>
							</div>
						</div>
                        <div class="form-group">
							<label class="col-md-4 control-label">Feed</label>
							<div class="col-md-6">
                           
                             
                            <select name="feed_id" id="feed_id">
                           <option value="0">Select a feed</option>
                           </select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Field</label>
							<div class="col-md-6">
                           
                             
                            <select name="field_id" id="field_id">
                           <option value="0">Select a Field</option>
                          </select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Position</label>
							<div class="col-md-6">
								<select name="field_positon" id="field_positon">
                                  <option value="before">Before</option>
                                  <option value="after">After</option>
                                </select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Type</label>
							<div class="col-md-6">
								<select name="mixer_field_type" id="mixer_field_type">
                                  <option value="tag">Tag</option>
                                  <option value="value">Value</option>
                                </select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Value</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="mixer_field_value" value="{{ old('mixer_field_value') }}">
							</div>
						</div>
                        
                       <div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Create a new mixer
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
		$('#field_id').empty();
		 $.ajax({
            type: "POST",
			headers: { 'X-CSRF-Token' : $_token }, 
            url: "/mixer/getfields",
            data: { 'domain_id': option,'_token':$_token  },
            success: function(data){
				try {
					 var opts = $.parseJSON(data);
					$.each(opts, function(i, d) {
						$('#field_id').append('<option value="' + d + '">' + i + '</option>');
					});
				} catch(e) {
					 $('#field_id').empty();
				}
               
            }
        });
		////////////////////////
		$('#feed_id').empty();
		 $.ajax({
            type: "POST",
			headers: { 'X-CSRF-Token' : $_token }, 
            url: "/mixer/getfeeds",
            data: { 'domain_id': option,'_token':$_token  },
            success: function(data){
				try {
					 var opts = $.parseJSON(data);
					$.each(opts, function(i, d) {
						$('#feed_id').append('<option value="' + d + '">' + i + '</option>');
					});
				} catch(e) {
					 $('#feed_id').empty();
				}
               
            }
        });
	});
});

</script>
@endsection
