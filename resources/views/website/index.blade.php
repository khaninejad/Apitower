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
                            <i class="fa fa-list"></i> Website List
                            <div class="pull-right">
                                <div class="btn-group open">
                                    <a href="{{ url('/website/create') }}" class="btn btn-primary btn-xs">
                                        Create New
                                       
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          
                          <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
        </tfoot>
 
        <tbody>
            @foreach ($domains->all() as $item)
            <tr>
                <td><a href="{{ $item->domain_url }}">{{ $item->domain_title }}</a></td>
                <td>{{ $item->domain_type }}</td>
                <td>{{$item->created_at}}</td>
                <td><a href="{{ url('/website/edit/'.$item->id) }}"><i class="fa fa-pencil-square-o"></i></a> <a href="{{ url('/website/destroy/'.$item->id) }}"><i class="fa fa-times"></i></a>  <a href="{{ url('/setup/domain/'.$item->id) }}">Setup</a> | <a href="{{ url('/website/fields/'.$item->id) }}">Fields</a></td>
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