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
				<div class="panel-heading">Create Website</div>
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

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/website/store') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Domain Title</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="domain_title" value="{{ old('domain_title') }}" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Domain URL</label>
							<div class="col-md-6">
								<input type="url" class="form-control" id="domain_url" name="domain_url" value="{{ old('domain_url') }}" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Domain Endpoint</label>
							<div class="col-md-6">
								<input type="url" class="form-control" id="domain_endpoint" name="domain_endpoint" value="{{ old('domain_endpoint') }}" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Domain Type</label>
							<div class="col-md-6">
								Wordpress
							</div>
						</div>
                        
                        <div class="form-group">
							<label class="col-md-4 control-label">Domain User</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="domain_user" value="{{ old('domain_user') }}" required>
							</div>
						</div>
                        
                         <div class="form-group">
							<label class="col-md-4 control-label">Domain Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="domain_password" required>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Create
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
  <script>
 $(document).ready(function(){
	 function isUrlValid(url) {
    return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
}
$( "#domain_url" )
  .focusout(function() {
		var url=$( "#domain_url" ).val();
		if(isUrlValid(url)){
		$( "#domain_endpoint" ).val(url+'/xmlrpc.php');
		}
  })
 }); 
</script>
@endsection