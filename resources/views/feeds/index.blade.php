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
                            <i class="fa fa-list"></i> Feed List
                            <div class="pull-right">
                                <div class="btn-group open">
                                    <a href="{{ url('/feeds/create') }}" class="btn btn-primary btn-xs">
                                        Create New

                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <a class="btn btn-primary" href="{{ url('/feeds/readall') }}">Read all</a>

                          <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Domain</th>
                <th>Action</th>
                 <th>Action</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th>Domain</th>
                <th>Action</th>
                <th>Date</th>
            </tr>
        </tfoot>

        <tbody>
            @foreach ($feeds->all() as $item)
            <tr>
          	   <td><a href="{{$item->domain_feed}}">{{$item->domain_url}}</a></td>
                <td><a href="{{ url('/feeds/destroy/'.$item->id) }}"><i class="fa fa-times"></i></a> <a href="{{ url('/feeds/edit/'.$item->id) }}"><i class="fa fa-pencil-square-o"></i></a> <a href="{{ url('/setup/tag/'.$item->id) }}">Setup Tag</a> | <a href="{{ url('/feeds/readfeed/'.$item->id) }}">Read Feed</a> | <a href="{{ url('/feeds/single/'.$item->id) }}">Single URL</a> | <a href="{{ url('/feeds/multi/'.$item->id) }}">Multi</a></a></td>
                <td>{{$item->created_at}}</td>
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
