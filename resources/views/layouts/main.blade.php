<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('head.title')</title>
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
	<!-- <link href='https://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'> -->
	<link href='https://fonts.googleapis.com/css?family=Oswald:700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="/css/admin.css">
	<meta name="_token" content="{!! csrf_token() !!}"/>
	@if (auth() && (auth()->user()))
	<script type="text/javascript">
		var logout = 0;
		function markTimeOnline(isUnload) {
			$.ajax({
				url: "/timeonline",
				type: "POST",
				beforeSend: function (xhr) {
					var token = $('meta[name="_token"]').attr('content');

					if (token) {
						return xhr.setRequestHeader('X-CSRF-TOKEN', token);
					}
				},
				data: {UserID: {!! auth()->user()->getAuthIdentifier() !!}, unload: isUnload },
				success: function (data) {
					console.log(data);
				}, error: function () {
					console.log("error!!!!");
				}
			}); //end of ajax
		}
		window.onbeforeunload = closingCode;
		function closingCode(){
			if (logout == 0)
				markTimeOnline(1);
			return null;
		}
	</script>
	@endif
	<script type='text/javascript'>
		function saveIP() {
			console.log('start ajax');
			$.ajax({
				url: "/trackip",
				type: "POST",
				beforeSend: function (xhr) {
					var token = $('meta[name="_token"]').attr('content');

					if (token) {
						return xhr.setRequestHeader('X-CSRF-TOKEN', token);
					}
				},
				@if (auth() && (auth()->user()))
				data: {UserID: {!! auth()->user()->getAuthIdentifier() !!} },
				@endif
				success: function (data) {
					console.log(data);
				}, error: function () {
					console.log("error!!!!");
				}
			}); //end of ajax
		}
	</script>
	@yield('head.css')
</head>
@if (auth() && (auth()->user()))
<body onload="markTimeOnline(0); saveIP();">
@else
<body onload="saveIP();">
@endif
	<div class="wrapper">
		@include('layouts.header')
		@include('layouts.navbar')
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="container">
			<div class=" row">
				<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">

				</div>
				<div class=" col-lg-6 col-sm-12 col-md-6 col-xs-12">					
					@yield('body.content')
				</div>
				<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
				</div>
			</div>
		</div>
		</div>
		@include('layouts.footer')
	</div>
		<script type="text/javascript" src="/js/jquery/jquery.js"></script>
		<script type="text/javascript" src="/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/js/style.js"></script>
		@yield('body.js')
	
</body>
</html>
