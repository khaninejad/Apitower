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
                            <i class="fa fa-list"></i> Feed List ({{$last_read}})
                            <div class="pull-right">
                             <div class="btn-group open">
                                    <a href="{{ url('/feeds/readall') }}" class="btn btn-primary btn-xs">
                                        Refresh
                                       
                                    </a>
                                </div>
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

  </div>
 @foreach ($feeds as $item)
    <div class="item">
      <h2><a href="{{$item->feed_url}}"><i class="fa fa-external-link"></i>
</a><a href="{{ url('/post/?url=').$item->feed_url.'&feed='.$item->feeds_id.'&domain='.$item->domain()->first()->domain_id }}">{{{ $item->feed_title }}}</a> </h2>
      <p>{!! $item->feed_description !!}</p>
      <p><small>Created on {{ $item->created_at }}</small></p>
    </div>
  @endforeach
  
        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
@endsection

@section('customscript')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/JavaScript">
<!--
function timedRefresh(timeoutPeriod) {
	setTimeout("location.reload(true);",timeoutPeriod);
}
//   -->
</script>
<script>
$(document).ready(function() {
    $('#example').DataTable();
	timedRefresh(15000);
	console.log("refresh trigged");
} );
</script>
@endsection
