@extends('dashboard')
@section('head')
<style type="text/css">
#feed_list a:visited {
    color: #9EB3F7;
} 
</style>
@endsection
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
                        <div class="panel-body" id="feed_list">
             <div class="header">
    <h3><a href="{{ $feeds['permalink'] }}">{{ $feeds['title'] }}</a></h3>
  </div>

  @foreach ($feeds['items'] as $item)
    <div class="item">
      <h2><a href="{{ url('/post/?url=').$item->get_permalink().'&feed='.$feed->id.'&domain='.$feed->domain_id }}">{{{ $item->get_title() }}}</a></h2>
      <p><small>Posted on {{ $item->get_date('j F Y | g:i a') }}</small></p>
    </div>
  @endforeach
       
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
