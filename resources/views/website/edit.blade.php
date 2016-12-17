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

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/website/update/'.$domain->id) }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Domain Title</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="domain_title" value="{{ $domain->domain_title }}" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Domain URL</label>
							<div class="col-md-6">
								<input type="url" class="form-control" name="domain_url" value="{{ $domain->domain_url }}" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Domain Endpoint</label>
							<div class="col-md-6">
								<input type="url" class="form-control" name="domain_endpoint" value="{{ $domain->domain_endpoint }}" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Domain Type</label>
							<div class="col-md-6">
                            <select name="website_type" id="website_type">
                                <option value="">Select</option>
                                <option value="wordpress">Wordpress</option>
                                <option value="custom">Custom</option>
                            </select>
								
							</div>
						</div>
                        
                        <div class="form-group">
							<label class="col-md-4 control-label">Domain User</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="domain_user" value="{{ $domain->domain_user }}" required>
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

