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
				<div class="panel-heading">New Feed</div>
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

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/feeds/store') }}">
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
							<label class="col-md-4 control-label">Domain Category</label>
							<div class="col-md-6">
								<select name="domain_category" id="domain_category">
                                </select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Domain URL</label>
							<div class="col-md-6">
								<input type="url" class="form-control" name="domain_url" value="{{ old('domain_url') }}" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Domain Feed URL</label>
							<div class="col-md-6">
								<input type="url" class="form-control" name="domain_feed" value="{{ old('domain_feed') }}">
							</div>
						</div>
                        
                       <div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Create New
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
		$('#domain_category').empty();
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
