<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ADESR | Login</title>
	<meta name="keywords" content="adesr starter page" />
	<meta name="description" content="adesr starter page">
	<meta name="author" content="adesr">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<!-- fonts -->
    <link rel="stylesheet" type="text/css" href="{{ url('template/assets/fonts/open-sans/open-sans.css') }}">
	<!-- core template -->
	<link rel="stylesheet" type="text/css" href="{{ url('template/assets/skin/default_skin/css/theme.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ url('template/assets/admin-tools/admin-forms/css/admin-forms.css') }}">
	<link rel="shortcut icon" href="{{ url('template/assets/img/favicon.ico') }}">
</head>
<body class="external-page sb-l-c sb-r-c">

	<div id="main" class="animated fadeIn">
		<!-- start content wrapper -->
		<section id="content_wrapper">
            <!-- start canvas -->
            <div id="canvas-wrapper">
                <canvas id="demo-canvas"></canvas>
            </div>
			<!-- start content -->
			<div id="content" class="container-fluid animated fadeIn pn">
                <div class="admin-form theme-info" id="login1">
                    <div class="row mb15 table-layout">
                        <div class="col-xs-6 va-m pln">
                            <a href="javascript:" title="Logo">
                                <img src="{{ url('template/assets/img/logos/logo_white.png') }}" title="AdminDesigns Logo" class="img-responsive w250">
                            </a>
                        </div>
                        <div class="col-xs-6 text-right va-b pr5">
                            <div class="login-links">
                                <a href="javascript:" class="active" title="Login">Please login..</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-info mt10 br-n">
                        <form method="post" action="{{ url('login') }}">
                            {{ csrf_field() }}
                            <div class="panel-body bg-light p30">
                                <div class="row">
                                    <div class="col-sm-5 va-m">
                                        <h2 class="">Laravel</h2>
                                        <h3 class="mb25">Starter Project</h3>
                                    </div>
                                    <div class="col-sm-7 br-l br-grey">
                                        <div class="section">
                                            <label for="username" class="field prepend-icon">
                                                <input type="text" name="username" id="username" class="gui-input" placeholder="Enter username">
                                                <label for="username" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                            </label>
                                        </div>
                                        <div class="section">
                                            <label for="password" class="field prepend-icon">
                                                <input type="password" name="password" id="password" class="gui-input" placeholder="Enter password">
                                                <label for="password" class="field-icon">
                                                    <i class="fa fa-lock"></i>
                                                </label>
                                            </label>
                                            @if(session('error'))
                                            <span class="help-block mt5 text-danger">
                                                <i class="fa fa-exclamation"></i> Username or password is invalid!
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer clearfix p10 ph15">
                                <button type="submit" class="button btn-primary mr10 pull-right">Login</button>
                                <label class="switch ib pull-left input-align mt10">
                                    <span>&copy; adesr 2018</span>
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
			</div>
			<!-- end content -->
		</section>
		<!-- end content wrapper -->
	</div>

	<!-- dependencies -->
	<script src="{{ url('template/vendor/jquery/jquery-1.11.1.min.js') }}"></script>
	<script src="{{ url('template/vendor/jquery/jquery_ui/jquery-ui.min.js') }}"></script>
    <!-- plugins -->
    <script src="{{ url('template/vendor/plugins/canvasbg/canvasbg.js') }}"></script>
	<!-- core template -->
	<script src="{{ url('template/assets/js/utility/utility.js') }}"></script>
	<script src="{{ url('template/assets/js/demo/demo.js') }}"></script>
	<script src="{{ url('template/assets/js/main.js') }}"></script>
	<script type="text/javascript">
	$(function() {

		"use strict";
		Core.init();
		Demo.init();

		CanvasBG.init({
            Loc: {
                x: window.innerWidth / 2,
                y: window.innerHeight / 3.3
            }
        });

        // clear old storage
        localStorage.clear();

	});
	</script>
</body>
</html>