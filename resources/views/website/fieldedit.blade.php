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
        <div class="panel-body"> @if (count($errors) > 0)
          <div class="alert alert-danger"> <strong>Whoops!</strong> There were some problems with your input.<br>
            <br>
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
          <form class="form-horizontal" role="form" method="POST" action="{{ url('/website/fieldupdate/'.$field->id) }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <label class="col-md-4 control-label">Field key</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="fieldkey" value="{{ $field->domain_custom_fields_key }}" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 control-label">Field key id</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="fieldkeyid" value="{{ $field->domain_custom_fields_key_id }}" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 control-label">Field value</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="fieldvalue" value="{{ $field->domain_custom_fields_value }}">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary"> Update </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection 