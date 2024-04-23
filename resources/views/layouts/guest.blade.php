<!--
=========================================================
* Corporate UI - v1.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/corporate-ui
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        @if (config('app.is_demo'))
            <title itemprop="name">
                Event Ticket Booking System
            </title>
            <meta name="twitter:card" content="summary" />
            <meta name="twitter:card" content="summary_large_image">
            <meta name="twitter:site" content="@CreativeTim" />
            <meta name="twitter:creator" content="@CreativeTim" />
            <meta name="twitter:title" content="Corporate UI Dashboard Laravel by Creative Tim & UPDIVISION" />
            <meta name="twitter:description"
                content="Fullstack tool for building Laravel apps with hundreds of UI components and
            ready-made CRUDs" />
            <meta name="twitter:image"
                content="https://s3.amazonaws.com/creativetim_bucket/products/737/original/corporate-ui-dashboard-laravel.jpg?1695288974" />
            <meta name="twitter:url" content="https://www.creative-tim.com/live/corporate-ui-dashboard-laravel" />
            <meta name="description"
                content="Fullstack tool for building Laravel apps with hundreds of UI components
            and ready-made CRUDs">
            <meta name="keywords"
                content="creative tim, updivision, html dashboard, laravel, api, html css dashboard laravel,  Corporate UI Dashboard Laravel,  Corporate UI Laravel,  Corporate Dashboard Laravel, UI Dashboard Laravel, Laravel admin, laravel dashboard, Laravel dashboard, laravel admin, web dashboard, bootstrap 5 dashboard laravel, bootstrap 5, css3 dashboard, bootstrap 5 admin laravel, frontend, responsive bootstrap 5 dashboard, corporate dashboard laravel,  Corporate UI Dashboard Laravel">
            <meta property="og:app_id" content="655968634437471">
            <meta property="og:type" content="product">
            <meta property="og:title" content="Corporate UI Dashboard Laravel by Creative Tim & UPDIVISION">
            <meta property="og:url" content="https://www.creative-tim.com/live/corporate-ui-dashboard-laravel">
            <meta property="og:image"
                content="https://s3.amazonaws.com/creativetim_bucket/products/737/original/corporate-ui-dashboard-laravel.jpg?1695288974">
            <meta property="product:price:amount" content="FREE">
            <meta property="product:price:currency" content="USD">
            <meta property="product:availability" content="in Stock">
            <meta property="product:brand" content="Creative Tim">
            <meta property="product:category" content="Admin &amp; Dashboards">
            <meta name="data-turbolinks-track" content="false">
        @endif
        <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
        <link rel="icon" type="image/png" href="../assets/img/favicon.png">
        <title>
            Event Ticket Booking System
        </title>
        <!--     Fonts and icons     -->
        <link
            href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700"
            rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>
        <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- CSS Files -->
        <link id="pagestyle" href="../assets/css/corporate-ui-dashboard.css?v=1.0.0" rel="stylesheet" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/additional-methods.min.js">
        </script>
        <script src="https://www.google.com/recaptcha/api.js?render=6LdG6qspAAAAABBpAPvltFclxYJ7h0DYroL7XaPb"></script>
        <script src="{{ asset('assets/js/validation.js') }}"></script>
    </head>

    <body class="">

        {{ $slot }}
        <!--   Core JS Files   -->
        <script src="../assets/js/core/popper.min.js"></script>
        <script src="../assets/js/core/bootstrap.min.js"></script>
        <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        </script>
        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Corporate UI Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="../assets/js/corporate-ui-dashboard.min.js?v=1.0.0"></script>
        <!-- Your existing HTML code -->

        <!-- Add this script and badge code at the bottom, just before the closing </body> tag -->
        <script src="https://www.google.com/recaptcha/api.js?render=YOUR_SITE_KEY_HERE"></script>
        <script>
            grecaptcha.ready(function() {
                grecaptcha.execute('6LefzKspAAAAAG9YZnsai30sgjebrpi-1J9C26e5', {
                    action: 'homepage'
                }).then(function(token) {
                    // Token logic here if needed
                });
            });
        </script>

    </body>

</html>
