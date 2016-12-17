@extends('dashboard')

@section('head')
<script src="//cdn.ckeditor.com/4.5.1/full/ckeditor.js"></script>
	<script src="js/editor.js"></script>
	<link rel="stylesheet" href="css/samples.css">
@endsection
@section('navigation')
	@include('navigation')  
@endsection
@section('sidebar')
   @include('sidebar')  
@endsection
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-9">
			<div class="panel panel-default">
				<div class="panel-heading">New Feed</div>
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
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/post/publish').'/'.$domain_id }}">
						<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
 <div class="form-group">
					@foreach ($post_data as $data)
                            @if ($data->title=="title")
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="{{$data->title}}" value="{{ trim($data->value) }}" placeholder="{{$data->title}}" required>
                                </div>
                            @elseif ($data->title=='description')
                                <div class="col-md-12">
                                <textarea class="form-control" id="editor" name="{{$data->title}}" required>{{ $data->value }}</textarea>
                                </div>
                            @elseif ($data->title=='link')
                                <div class="col-md-12">
                               <input type="url" class="form-control" name="{{$data->title}}" value="{{ $data->value }}" placeholder="{{$data->title}}">
                                </div>
                            @elseif ($data->title=='mt_keywords')
                                <div class="col-md-12">
                               <input type="text" class="form-control" name="{{$data->title}}" value="{{ $data->value }}" placeholder="{{$data->title}}" required>
                                </div>
                            @elseif ($data->title=='wp_post_thumbnail')
                                <div class="col-md-12">
                               <input type="url" class="form-control" name="{{$data->title}}" value="{{ $data->value }}" placeholder="{{$data->title}}">
                                </div>
                                <img src="{{ $data->value }}" width="50" height="50" />
                            @endif
					@endforeach
                    	</div>
                     </div></div>   
                       
                <div class="panel panel-default">
				<div class="panel-heading">Custom Fields</div>
				<div class="panel-body">
					@foreach ($custom_fields as $data)
                     <div class="form-group">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="{{$data->title}}" value="{{ $data->value }}" placeholder="{{$data->title}}">
                                </div>
						</div>
                    @endforeach
                      
				
				</div>
                </div>
			</div>
	
        <div class="col-md-3">
        <div class="panel panel-default">
				<div class="panel-heading">Action</div>
				<div class="panel-body">
                 <div class="form-group">
                 <div class="col-md-6 col-md-offset-4">
                  <a href="{{ url('/crawler/tag').'/'.$feed_id.'/?url='.$url }}" class="btn btn-default">Edit tags</a>
                  </div><br>

							<div class="col-md-6 col-md-offset-4">
                           
								<button type="submit" class="btn btn-primary">
									Publish
								</button>
							</div>
						</div>
                </div>
                </div>
                 <div class="panel panel-default">
            <div class="panel-heading">Category</div>
				<div class="panel-body">
          <div class="form-group">
                                <div class="col-md-8">
                                
                                 <select name="post_category[]" multiple>
                                    @foreach ($post_category as $data)
                                    <option value="{{$data->title}}">{{$data->title}}</option>
                                     @endforeach
                                 </select>
                                </div>
						</div>
        </div>
        </div>
        </div>
    
        	</form>
	</div>
</div>



@endsection
@section('customscript')
<script type="text/javascript">
initSample();
</script>
@endsection
