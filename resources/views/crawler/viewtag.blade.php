<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>{{$title}}</title>
<link href="{{ asset('/css/tag.css') }}" rel="stylesheet">
<script src="http://code.jquery.com/jquery-2.1.4.min.js" ></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
   <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
</head>
<body>
<div id="iframeDiv" style="right: 345px; left: 0px">
  <iframe src="{{url('/crawler/viewoutput/') }}" sandbox="allow-same-origin allow-scripts" id="xpcpeerM2BX" name="xpcpeerM2BX"></iframe>
</div>
<div id="taggingDiv">
  <div id="taggingDivInner">
    <div id="cardWrapper" style="display: block;">
      <div class="WsjYwc">
   
			<div class="panel panel-default">
            <a href="{{ url() }}">Home</a>
				<div class="panel-heading">Tag website data</div>
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
<p>{{ Session::get('message') }}</p>
</div>
@endif
@if (Session::has('error'))
<div class="alert alert-danger">
<p>{{ Session::get('error') }}</p>
</div>
@endif
       <form class="form-horizontal" role="form" method="POST" action="{{ url('/setup/storetag/'.$domain_feeds->id) }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="url" value="{{$url}}" />
<div id="accordion">
@foreach ($domain_fields as $item)
<h3>{{ $item->title }}</h3>
<div>
<div class="form-group">
  <div class="col-md-8">
  	<input type="text" class="form-control" name="{{ $item->title }}" value="{{ $item->domain_field_tag }}" >
  </div>
  <div class="col-md-8"> 
     <select name="{{ $item->title }}_type">
     @if ($item->type=='tag')
     <option value="tag" selected>tag</option><option value="value">value</option>
     @else ($item->type=='value')
     <option value="tag">tag</option><option value="value" selected>value</option>
     @endif
     </select>
  </div>
</div>
</div>
	@endforeach
    
    @foreach ($domain_custom_fields as $item)
    <h3>{{ $item->domain_custom_fields_key }}</h3>
    <div class="form-group">
  <div class="col-md-8">
  	<input type="text" class="form-control" name="{{ $item->domain_custom_fields_key }}" value="{{ $item->domain_custom_field_tag }}" >
  </div>
  <div class="col-md-8"> 
     <select name="{{ $item->domain_custom_fields_key }}_type">
       @if ($item->type=='tag')
     <option value="tag" selected>tag</option><option value="value">value</option>
     @else ($item->type=='value')
     <option value="tag">tag</option><option value="value" selected>value</option>
     @endif
     </select>
  </div>
</div>
	@endforeach
  
		 </div>			
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Update
								</button>
							</div>
						</div>
</div>
					</form>
                    </div>
                   
                    
                    
      </div>
    </div>
    <div id="htmlWrapper" class="jSjIhd" style="display: none"></div>
    <input id="defaultMarkupFormat" value="microdata" type="hidden">
  </div>
</div>

<script type="text/javascript">
$( document ).ready(function() {
	 $( "#accordion" ).accordion();
   $("i").click(function(){
	 var elementID=  $(this).attr("id");
	  	alert("error"+  $(this).attr("id"));
   });
    $('#iframeDiv').on('load', function(){
        $(this).show();
       alert('load the iframe')
    });

});
function putdata(selector){
	  $("input:text").click(function() { 
		  $(this).val(selector);
		  selector="";
		//alert(selector+"yep");
	  
	  } );
	
}
</script>



</body>
</html>