<!doctype html>
<html class="no-js" lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- <link rel="icon" sizes="16x16" type="image/png" href="{{route('frontend.index')}}/img/favicon_icon/{{settings()->favicon}}"> --}}
        <title>@yield('title', app_name())</title>

        <!-- Meta -->
        <meta name="description" content="@yield('meta_description', 'Default Description')">
        <meta name="author" content="@yield('meta_author', 'Viral Solani')">
        <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
        @yield('meta')

        <!-- Styles -->
        @yield('before-styles')

        <!-- Check if the language is set to RTL, so apply the RTL layouts -->
        <!-- Otherwise apply the normal LTR layouts -->
        @langrtl
            {{ Html::style(getRtlCss(mix('css/backend.css'))) }}
        @else
            {{ Html::style(mix('css/backend.css')) }}
        @endlangrtl

        {{ Html::style(mix('css/backend-custom.css')) }}
        @yield('after-styles')

        <!-- Html5 Shim and Respond.js IE8 support of Html5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        {{ Html::script('https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js') }}
        {{ Html::script('https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js') }}
        <![endif]-->
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <!-- Scripts -->
        <script>
            window.Laravel = {!! json_encode([ 'csrfToken' => csrf_token() ]) !!};
        </script>
        <style type="text/css">
            .lds-ring {
              display: inline-block;
              position: relative;
              width: 80px;
              height: 80px;
            }
            .lds-ring div {
              box-sizing: border-box;
              display: block;
              position: absolute;
              width: 64px;
              height: 64px;
              margin: 8px;
              border: 8px solid #fff;
              border-radius: 50%;
              animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
              border-color: #fff transparent transparent transparent;
            }
            .lds-ring div:nth-child(1) {
              animation-delay: -0.45s;
            }
            .lds-ring div:nth-child(2) {
              animation-delay: -0.3s;
            }
            .lds-ring div:nth-child(3) {
              animation-delay: -0.15s;
            }
            @keyframes lds-ring {
              0% {
                transform: rotate(0deg);
              }
              100% {
                transform: rotate(360deg);
              }
            }
            .full-loader {
              position: fixed;
              z-index: 999;
              height: 2em;
              width: 2em;
              margin: auto;
              top: 0;
              left: 0;
              bottom: 0;
              right: 0;
            }

            /* Transparent Overlay */
            .full-loader:before {
              content: '';
              display: block;
              position: fixed;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
                background: radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0, .8));

              background: -webkit-radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0,.8));
            }
        </style>
    </head>
    <body class="skin-{{ config('backend.theme') }} {{ config('backend.layout') }}">
        <div class="loading" style="display:none"></div>
        <div class="full-loader" style="display: none;">
            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
        </div>
        @include('includes.partials.logged-in-as')

        <div class="wrapper" id="app">
            @include('backend.includes.header')
            @include('backend.includes.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    @yield('page-header')
                    <!-- Breadcrumbs would render from routes/breadcrumb.php -->
                    @if(Breadcrumbs::exists())
                        {!! Breadcrumbs::render() !!}
                    @endif
                </section>

                <!-- Main content -->
                <section class="content">
                    @include('includes.partials.messages')
                    @yield('content')
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->

            @include('backend.includes.footer')
        </div><!-- ./wrapper -->

        <!-- JavaScripts -->
        @yield('before-scripts')
        {{ Html::script(mix('js/backend.js')) }}
        
        {{ Html::script(('js/backend-custom.js')) }}
        {{ Html::script(('js/backend/jquery.PrintArea.js'))}}
        <!-- {{ Html::script(('js/backend/jquery.min.js'))}} -->
        @yield('after-scripts')

        <script type="text/javascript">
          $(document).ready(function () {

              $(".notifications-menu").on("hide.bs.dropdown", function(event){

                  $.ajax({
                      type: 'GET',
                      url: '{{ url("admin/notification/clearcurrentnotifications") }}',
                      dataType: "JSON",
                      success: function(data){
                          getNotifications();
                      }
                  });

              });

              getNotifications();
              setInterval(function () {
                  getNotifications();
              }, 60000);
          });

          function getNotifications() {
              $.ajax({
                  type: "GET",
                  url: '{{ url("admin/notification/getlist") }}',
                  dataType: "JSON",
                  success: function (result) {
                      $(".notification-counter").text(result.count);
                      $(".notification-menu-container").html(result.view);
                  }
              });
          }
        </script>

    </body>
</html>