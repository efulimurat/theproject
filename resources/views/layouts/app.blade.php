<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/plugins/fontawesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/plugins/jqueryui/jquery-ui.css" rel="stylesheet">
    <link href="/css/layout.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/default.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        @include("report.menu")

        @yield('content')
    </div>

    <!-- Scripts -->
    <script type='text/javascript' src="/js/app.js"></script>
    <script type='text/javascript' src="/js/jquery.js"></script>
    <script type='text/javascript' src="/plugins/jqueryui/jquery-ui.js"></script>
    <script type='text/javascript' src="/js/jscroll.js"></script>
    <script type='text/javascript' src="/js/scripts.js"></script>
</body>
</html>
