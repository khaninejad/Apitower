<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ isset($title) ? $title : 'ApiTower' }}</title>

   <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/2.0.2/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('/css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- DataTables CSS -->
    <link href="{{ asset('/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ asset('/bower_components/datatables-responsive/css/dataTables.responsive.css') }}" rel="stylesheet">
<link href="{{ asset('/css/timeline.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ asset('/bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
@yield('head')
</head>

<body>

    <div id="wrapper">
		
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ URL::to('/') }}">Apitower</a>
            </div>
            <!-- /.navbar-header -->
@yield('navigation')
@yield('sidebar')
                <!-- /.sidebar-collapse -->
          
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
        @yield('content')
            
        </div>
        <!-- /#page-wrapper -->
          <div class="col-md-8 col-md-offset-2">
    <div style="text-align:center">
   Powered by <a href="http://apitower.com?url={{ url('/') }}" target="_blank">Apitower</a>
   </div>
</div>

    </div>
    <!-- /#wrapper -->

   <!-- jQuery -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
   <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>

  
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('/js/sb-admin-2.js') }}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ asset('/bower_components/metisMenu/dist/metisMenu.min.js') }}"></script>

    <!-- DataTables JavaScript -->
    <script src="{{ asset('/bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') }}"></script>


    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    @yield('customscript')
 
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-42742037-1', 'auto');
  ga('send', 'pageview');

</script>
</body>

</html>
