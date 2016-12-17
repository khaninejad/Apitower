@extends('dashboard')
@section('navigation')
	@include('navigation')  
@endsection
@section('sidebar')
   @include('sidebar')  
@endsection
@section('content')
<div class="col-lg-12">
<br>

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
                        <div class="panel-heading">
                            <i class="fa fa-list"></i> Post List
                            <div class="pull-right">
                                <div class="btn-group open">
                                    <a href="{{ url('/post/export/'.$domain_id) }}" class="btn btn-primary btn-xs">
                                        Export
                                       
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          
                          <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Domain</th>
                <th>Action</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>Domain</th>
                <th>Action</th>
            </tr>
        </tfoot>
 
        <tbody>
            @foreach ($posts as $item)
            <tr>
          	   <td><a href="#">{{$item->title}}</a></td>
                <td><a href="{{ url('/post/destroy/'.$item->id) }}"><i class="fa fa-times"></i></a></td>
             </tr>
			@endforeach
        </tbody>
    </table>
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
