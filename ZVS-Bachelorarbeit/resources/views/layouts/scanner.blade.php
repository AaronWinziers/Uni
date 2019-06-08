<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('vendor/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{asset('vendor/metisMenu/metisMenu.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{asset('css/sb-admin-2.css')}}" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="{{asset('vendor/morrisjs/morris.css')}}" rel="stylesheet">

    <!-- Datatables CSS -->
    <link href="{{asset('vendor/datatables/css/jquery.dataTables.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/datatables/css/dataTables.bootstrap.css')}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="wrapper">
    @include('inc.scannerbar')
    <div class="col-sm-1"></div>
    <div style="min-height: 936px;" class="col-sm-10">
        <div class="row">
            <h1 class="page-header">
                @yield('header')
            </h1>
        </div>
        @include('inc.messages')
        @yield('content')
    </div>
</div>

<!-- Scripts -->

<!-- jQuery -->
<script src="{{asset("vendor/jquery/jquery.min.js")}}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{asset("vendor/bootstrap/js/bootstrap.min.js")}}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{asset("vendor/metisMenu/metisMenu.min.js")}}"></script>

<!-- Morris Charts JavaScript -->
<script src="{{asset("vendor/raphael/raphael.min.js")}}"></script>
<script src="{{asset("vendor/morrisjs/morris.min.js")}}"></script>
<script src="{{asset("vendor/morrisjs/morris-data.js")}}"></script>

<!-- Datatables JavaScript -->
<script src="{{asset("vendor/datatables/js/jquery.dataTables.js")}}"></script>
<script src="{{asset("vendor/datatables/js/dataTables.bootstrap.js")}}"></script>

<!-- Custom Theme JavaScript -->
<script src="{{asset("js/sb-admin-2.js")}}"></script>

@yield('scripts')
<script>
    setTimeout(function () {
        window.location.href='/'; // the redirect goes here

    },30000);
</script>

<script>
    $(document).ready(
        function(){
            $('#table_id').DataTable({
                responsive:true,
                dom: 'Bfrtip',
            });
        }
    );
</script>
</body>
</html>
