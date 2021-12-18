
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>PMS - @yield('title')</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/global_assets/css/icons/fontawesome/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/layout.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/colors.min.css') }} " rel="stylesheet" type="text/css">
    @stack('css')
    <link href="{{ asset('assets/css/custom.css') }} " rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

</head>

<body>

	<!-- Main navbar -->
    @include('layouts.inc.navbar')
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		@include('layouts.inc.sidebar')
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			@yield('content')


			<!-- Footer -->
			@include('layouts.inc.footer')
			<!-- /footer -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<!-- Core JS files -->
	<script src="{{ asset('assets/global_assets/js/main/jquery.min.js') }}"></script>
	<script src="{{ asset('assets/global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('assets/global_assets/js/plugins/loaders/blockui.min.js') }}"></script>
	<script src="{{ asset('assets/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-notify/bootstrap-notify-3.1.3.min.js') }}"></script>
    <!-- /core JS files -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

	{{-- <script>
		function keyAction() {
			var whichKey = event.keyCode;
			switch (whichKey) {
			case 66 /*B or b*/:
				window.history.back();
			break;
			case 68 /*D or d*/:
				window.location.href = "http://nabiul-accounts.sar/deposit";
			break;
			}
		}
		document.onkeydown = function () {
			//Run this function on keypress
			keyAction();
		}

	</script> --}}

	{{-- <script>
		window.addEventListener('keydown', function (event) {
			if (event.shiftKey && event.code === 'KeyB') {
				window.history.back();
			}

			if (event.shiftKey && event.code === 'KeyD') {
				window.location.href = '/deposit';
			}
		});
	</script> --}}
    @if(session('errorMessage'))
        <script>
            $.notify({
                title: "Error : ",
                message: '{{ session('errorMessage') }}'
            },{
                type: "danger",
                placement: {
                    from: "top",
                    align: "right"
                }
            });
        </script>
    @endif

    @if(session('successMessage'))
        <script>
            $.notify({
                title: "Success : ",
                message: '{{ session('successMessage') }}'
            },{
                type: "success",
                placement: {
                    from: "top",
                    align: "right"
                }
            });
        </script>
    @endif
	@stack('js')
</body>
</html>
