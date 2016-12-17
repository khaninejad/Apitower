@extends('dashboard')
@section('navigation')
	@include('navigation')  
@endsection
@section('sidebar')
   @include('sidebar')  
@endsection
@section('content')
<div class="row">
  <div class="col-lg-8">
    <div class="panel panel-default">
      <div class="panel-heading"> <i class="fa fa-clock-o fa-fw"></i> Get Started with Apitower </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
        <ul class="timeline">
          <li> @if($domain_count==0)
            <div class="timeline-badge"><i class="fa fa-plus-square"></i> </div>
            @else
            <div class="timeline-badge success"><i class="fa fa-thumbs-up"></i> </div>
            @endif
            <div class="timeline-panel">
              <div class="timeline-heading">
                <h4 class="timeline-title">Setup Domain</h4>
                <p> <small class="text-muted">First step</small> </p>
              </div>
              <div class="timeline-body">
                <p>Before start you need to connect one website to your node.</p>
                <p>To setup, please click <a href="{{ URL::to('website') }}">here</a> or click website menu at left corner.</p>
                <p><a href="http://apitower.com/help/connect-website">More Help</a></p>
              </div>
            </div>
          </li>
          <li class="timeline-inverted"> @if($feed_count==0)
            <div class="timeline-badge warning"><i class="fa fa-rss"></i> </div>
            @else
            <div class="timeline-badge success"><i class="fa fa-thumbs-up"></i> </div>
            @endif
            <div class="timeline-panel">
              <div class="timeline-heading">
                <h4 class="timeline-title">Setup Feed</h4>
                <p> <small class="text-muted">Second step</small> </p>
              </div>
              <div class="timeline-body">
                <p>To web mine data from source website you need to connect them feed address.</p>
                <p>To setup, please click <a href="{{ URL::to('feeds') }}">here</a> or click Feeds menu at left corner.</p>
                <p><a href="http://apitower.com/help/connect-feeds">More Help</a></p>
              </div>
            </div>
          </li>
          <li class="timeline"> @if($field_count==0)
            <div class="timeline-badge warning"><i class="fa fa-credit-card"></i> </div>
            @else
            <div class="timeline-badge success"><i class="fa fa-thumbs-up"></i> </div>
            @endif
            <div class="timeline-panel">
              <div class="timeline-heading">
                <h4 class="timeline-title">Extract Data</h4>
                <p> <small class="text-muted">Third step</small> </p>
              </div>
              <div class="timeline-body">
                 <p>Time to hard work, you need to identify fields and get their unique CSS selector. So we can extract them later.</p>
                <p>To extract specific website, please click <a href="{{ URL::to('feeds') }}">here</a> or click Feeds menu at left corner.</p>
                <p><a href="http://apitower.com/help/extract-data">More Help</a></p>
              </div>
            </div>
          </li>
          <li class="timeline-inverted">
            <div class="timeline-badge danger"><i class="fa fa-newspaper-o"></i> </div>
            <div class="timeline-panel">
              <div class="timeline-heading">
                <h4 class="timeline-title">Read Feeds</h4>
                <p> <small class="text-muted">Fourth step</small> </p>
              </div>
              <div class="timeline-body">
                <p>If you think you're done with identify website data and ready see your result, visit feeds section and read your feeds, then click on the one of the links and see what data collected.</p>
              </div>
            </div>
          </li>
         <!-- <li>
            <div class="timeline-badge info"><i class="fa fa-save"></i> </div>
            <div class="timeline-panel">
              <div class="timeline-heading">
                <h4 class="timeline-title">Timeline Event</h4>
              </div>
              <div class="timeline-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vel justo eu mi scelerisque vulputate. Aliquam in metus eu lectus aliquet egestas.</p>
                <hr>
                <div class="btn-group">
                  <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-cog"></i> <span class="caret"></span> </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a> </li>
                    <li><a href="#">Another action</a> </li>
                    <li><a href="#">Something else here</a> </li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a> </li>
                  </ul>
                </div>
              </div>
            </div>
          </li>
          <li>
            <div class="timeline-panel">
              <div class="timeline-heading">
                <h4 class="timeline-title">Timeline Event</h4>
              </div>
              <div class="timeline-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vel justo eu mi scelerisque vulputate. Aliquam in metus eu lectus aliquet egestas.</p>
              </div>
            </div>
          </li>
          <li class="timeline-inverted">
            <div class="timeline-badge success"><i class="fa fa-thumbs-up"></i> </div>
            <div class="timeline-panel">
              <div class="timeline-heading">
                <h4 class="timeline-title">Timeline Event</h4>
              </div>
              <div class="timeline-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vel justo eu mi scelerisque vulputate. Aliquam in metus eu lectus aliquet egestas.</p>
              </div>
            </div>
          </li>-->
        </ul>
      </div>
      <!-- /.panel-body --> 
    </div>
    <!-- /.panel --> 
  </div>
  <!-- /.col-lg-8 -->
  <div class="col-lg-4">
    <div class="panel panel-default">
      <div class="panel-heading"> <i class="fa fa-bell fa-fw"></i> Notifications Panel </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
        <div class="list-group"> <a href="#" class="list-group-item"> <i class="fa fa-comment fa-fw"></i> Account State <span class="pull-right text-muted small"><em>{{$plandata['client']['state']}}</em> </span> </a><a href="#" class="list-group-item"> <i class="fa fa-comment fa-fw"></i> Version <span class="pull-right text-muted small"><em>{{$apitower}}</em> </span> </a> <a href="#" class="list-group-item"> <i class="fa fa-twitter fa-fw"></i> Created <span class="pull-right text-muted small"><em>{{$plandata['client']['created_at']}}</em> </span> </a> <a href="#" class="list-group-item"> <i class="fa fa-envelope fa-fw"></i> Credit Card <span class="pull-right text-muted small"><em>{{$plandata['user']['stripe_active']}}</em> </span> </a> <a href="#" class="list-group-item"> <i class="fa fa-tasks fa-fw"></i> Plan <span class="pull-right text-muted small"><em>{{$plandata['user']['stripe_plan']}}</em> </span> </a> <a href="#" class="list-group-item"> <i class="fa fa-upload fa-fw"></i> Trial Ends <span class="pull-right text-muted small"><em>{{$plandata['user']['trial_ends_at']}}</em> </span> </a> <a href="#" class="list-group-item"> <i class="fa fa-bolt fa-fw"></i> Subscription Ends <span class="pull-right text-muted small"><em>{{$plandata['user']['subscription_ends_at']}}</em> </span> </a> 
        @foreach($plandata['permissions'] as $perm)
        <a href="#" class="list-group-item"> <i class="fa fa-circle"></i> {{$perm['title']}} <span class="pull-right text-muted small"><em>{{$perm['value']}}</em> </span> </a> 
        @endforeach
        </div>
    </div>
  </div>
  <!-- /.col-lg-4 --> 
</div>
@endsection 