@extends('dashboard')
@section('navigation')
	@include('navigation')  
@endsection
@section('sidebar')
   @include('sidebar')  
@endsection
@section('content')
<div class="col-lg-12"> <br>
  @if (Session::has('message'))
  <div class="alert alert-success">
    <p>{{ Session::get('message') }}</p>
  </div>
  @endif
  @if (Session::has('error'))
  <div class="alert alert-danger">
    <p>{{ Session::get('error') }}</p>
  </div>
  @endif
  <div class="panel panel-default">
    <div class="panel-heading"> <i class="fa fa-list"></i> Post not found
      <div class="pull-right">
        <div class="btn-group open"> </div>
      </div>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
    Please check your <a href="{{$url}}">url</a> and try again.
    </div>
    <!-- /.panel-body --> 
  </div>
  <!-- /.panel --> 
</div>
@endsection

@section('customscript') 
<script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script> 
@endsection 