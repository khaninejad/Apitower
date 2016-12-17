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
    <div class="panel-heading"> <i class="fa fa-list"></i> Filter domain for post list
      <div class="pull-right">
        <div class="btn-group open"> </div>
      </div>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
      <form class="form-horizontal" role="form" method="POST" action="{{ url('/post/postlist') }}">
        <table width="400" border="0">
          <tbody>
            <tr>
              <td>
            <tr>
              <select name="filter_domain">
                  
             @foreach ($domains->all() as $item)
             
                <option value="{{$item->id}}">{{$item->domain_title}}</option>
                  
          	 
                @endforeach
             
              </select>
            </tr>
              </td>
            
            <tr>
              <td><input type="submit" value="Filter domain" /></td>
            </tr>
          </tbody>
        </table>
      </form>
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