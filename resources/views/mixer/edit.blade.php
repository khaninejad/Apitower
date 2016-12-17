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
				<div class="panel-heading">Update Website</div>
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

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/feeds/update/'.$feed->id) }}">
							<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Domain</label>
							<div class="col-md-6">
                           
                             
                            <select name="domain_id" id="domain_id">
                            <option value="0">Select a Domain</option>
                            @foreach ($domains as $item)
                           		@if($item->id==$feed->domain_id)
                            <option value="{{ $item->id }}" selected> {{ $item->domain_title }}</option>
                            	@else 
                                 <option value="{{ $item->id }}"> {{ $item->domain_title }}</option>
                                 @endif
    @endforeach</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Domain Category</label>
							<div class="col-md-6">
								<select name="domain_category" id="domain_category">
                                 @foreach ($categories as $key => $value)
                                 	@if($key==$feed->domain_category)
                                 <option value="{{$key }}" selected> {{ $value }}</option>
                                 	@else
                                 <option value="{{$key }}"> {{ $value }}</option>
                                 	@endif
                                 @endforeach
                                </select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Domain URL</label>
							<div class="col-md-6">
								<input type="url" class="form-control" name="domain_url" value="{{ $feed->domain_url }}" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Domain Feed URL</label>
							<div class="col-md-6">
								<input type="url" class="form-control" name="domain_feed" value="{{ $feed->domain_feed }}">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Update
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
		//alert('ss');
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
