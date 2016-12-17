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
				<div class="panel-heading">Update Website Tags</div>
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
@if (Session::has('message'))
<div class="alert alert-success">
<p>{!! Session::get('message') !!}</p>
</div>
@endif
@if (Session::has('error'))
<div class="alert alert-danger">
<p>{{ Session::get('error') }}</p>
</div>
@endif

									<br/>
							
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/setup/storetag/'.$domain_feeds->id) }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
                       
@foreach ($domain_fields as $item)
<div class="form-group">
 <label class="col-md-4 control-label">{{ $item->title }}</label>
  <div class="col-md-3">
  	<input type="text" class="form-control" name="{{ $item->title }}" value="{{ $item->domain_field_tag }}" >
  </div>
  <div class="col-md-3"> 
     <select name="{{ $item->title }}_type">
     @if ($item->type=='tag')
     <option value="tag" selected>tag</option><option value="value">value</option>
     @else ($item->type=='value')
     <option value="tag">tag</option><option value="value" selected>value</option>
     @endif
     </select>
  </div>
</div>

	@endforeach
    
    @foreach ($domain_custom_fields as $item)
    <div class="form-group">
 <label class="col-md-4 control-label">{{ $item->domain_custom_fields_key }}</label>
  <div class="col-md-3">
  	<input type="text" class="form-control" name="{{ $item->domain_custom_fields_key }}" value="{{ $item->domain_custom_field_tag }}" >
  </div>
  <div class="col-md-3"> 
     <select name="{{ $item->domain_custom_fields_key }}_type">
       @if ($item->type=='tag')
     <option value="tag" selected>tag</option><option value="value">value</option>
     @else ($item->type=='value')
     <option value="tag">tag</option><option value="value" selected>value</option>
     @endif
     </select>
  </div>
</div>
	@endforeach
  
					
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
