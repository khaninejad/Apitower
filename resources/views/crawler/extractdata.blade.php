<form class="form-horizontal" role="form" method="POST" action="{{ url('/crawler/queuedata/'.$domain_id) }}">
	<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

<button type="submit" >Extract Data</button>
<textarea name="urls"></textarea> 

</form>