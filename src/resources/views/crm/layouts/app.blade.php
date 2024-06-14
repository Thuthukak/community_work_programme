<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="x-csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title', Option::get('app_name', 'Aplikasi Laravel'))</title>

    @yield('ext_css')
    <link rel="stylesheet" href="{{ url('assets/css/app.css') }}">
</head>
<body>
    <div id="wrapper">

    @include('../../../../layouts.includes.sidebar')
        <div id="page-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
        @include('crm.layouts.partials.footer')
    </div>
    <!-- /#wrapper -->

    <script src="{{ url('assets/js/jquery.js') }}"></script>
    <script src="{{ url('assets/js/bootstrap.min.js') }}"></script>
    @include('crm.layouts.partials.noty')
    <script src="{{ url('assets/js/plugins/metisMenu/metisMenu.min.js') }}"></script>
    @yield('ext_js')
    <script src="{{ url('assets/js/sb-admin-2.js') }}"></script>

    <script type="text/javascript">
    (function() {
        $("div.alert.notifier, div.alert.add-cart-notifier").delay(5000).slideUp('slow');
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="x-csrf-token"]').attr('content')
            },
            beforeSend: function(xhr){
                xhr.setRequestHeader('Authorization', 'Bearer ' + "{{ auth()->user()->api_token }}");
            }
        });
    })();
    </script>

    @yield('script')

</body>
</html>
