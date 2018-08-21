<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ADESR | Larastarter 5.6</title>
	<meta name="keywords" content="adesr starter page" />
	<meta name="description" content="adesr starter page">
	<meta name="author" content="adesr">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<!-- fonts -->
    <link rel="stylesheet" type="text/css" href="{{ url('template/assets/fonts/open-sans/open-sans.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('template/assets/fonts/glyphicons-pro/glyphicons-pro.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('template/assets/fonts/icomoon/icomoon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('template/assets/fonts/iconsweets/iconsweets.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('template/assets/fonts/octicons/octicons.css') }}">
	<!-- plugins -->
	<link rel="stylesheet" type="text/css" href="{{ url('template/vendor/plugins/datepicker/css/bootstrap-datetimepicker.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ url('template/vendor/plugins/select2/css/select2.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ url('template/vendor/plugins/fancytree/skin-lion/ui.fancytree.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ url('template/vendor/plugins/datatables/datatables.min.css') }}">
	<!-- core template -->
	<link rel="stylesheet" type="text/css" href="{{ url('template/assets/skin/default_skin/css/theme.css') }}">
	<link rel="shortcut icon" href="{{ url('template/assets/img/favicon.ico') }}">
</head>
<body class="sb-l-m">

	<div id="main">
		<!-- start header -->
		<header class="navbar navbar-fixed-top navbar-shadow">
			<div class="navbar-branding">
				<a class="navbar-brand" href="">
					Adesr Page
				</a>
				<span id="toggle_sidemenu_l" class="ad ad-lines"></span>
			</div>
			<ul class="nav navbar-nav navbar-left">
				
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown menu-merge">
					<a href="javascript:" class="dropdown-toggle fw600 p15" data-toggle="dropdown">
						<img src="{{ url('template/assets/img/avatars/placeholder.png') }}" alt="avatar" class="mw30 br64">
						<span class="hidden-xs pl15"> Adminsitrator </span>
						<span class="caret caret-tp hidden-xs"></span>
					</a>
					<ul class="dropdown-menu list-group dropdown-persist w250" role="menu">
						<li class="list-group-item">
							<a href="" class="animated animated-short fadeInUp">
								<span class="fa fa-lock"></span> Change Password
							</a>
						</li>
						<li class="dropdown-footer">
							<a href="{{ url('logout') }}">
								<span class="fa fa-power-off pr5"></span> Logout
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</header>
		<!-- end header -->
		<!-- start left bar -->
		<aside id="sidebar_left" class="nano nano-light affix">
			<div class="sidebar-left-content nano-content">
				<ul class="nav sidebar-menu"></ul>
			</div>
		</aside>
		<!-- end left bar -->
		<!-- start content wrapper -->
		<section id="content_wrapper">
			<!-- start content -->
			<div id="content" class="container-fluid animated fadeIn pn">
				@yield('content')
			</div>
			<!-- end content -->
		</section>
		<!-- end content wrapper -->
	</div>

	<!-- page loading -->
	<div class="modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalProgress">
		<div class="modal-dialog modal-sm" style="margin-top: 200px; width: 200px;">
			<div class="modal-content" style="padding: 5px;">
				<img src="{{ url('template/assets/img/ajax-loader.gif') }}" style="width: 32px"/>&nbsp;&nbsp;&nbsp;Loading content ...
			</div>
		</div>
	</div>
	<!-- end page loading -->

	<!-- dependencies -->
	<script src="{{ url('template/vendor/jquery/jquery-1.11.1.min.js') }}"></script>
	<script src="{{ url('template/vendor/jquery/jquery_ui/jquery-ui.min.js') }}"></script>
	<!-- plugins -->
	<script src="{{ url('template/vendor/plugins/globalize/globalize.min.js') }}"></script>
	<script src="{{ url('template/vendor/plugins/moment/moment.min.js') }}"></script>
	<script src="{{ url('template/vendor/plugins/nprogress/nprogress.js') }}"></script>
	<script src="{{ url('template/vendor/plugins/pnotify/pnotify.js') }}"></script>
	<script src="{{ url('template/vendor/plugins/select2/select2.min.js') }}"></script>
	<script src="{{ url('template/vendor/plugins/datepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
	<script src="{{ url('template/vendor/plugins/fancytree/jquery.fancytree-all-deps.min.js') }}"></script>
	<script src="{{ url('template/vendor/plugins/fancytree/modules/jquery.fancytree.table.js') }}"></script>
	<script src="{{ url('template/vendor/plugins/autonumeric/autoNumeric.min.js') }}"></script>
	<script src="{{ url('template/vendor/plugins/datatables/datatables.min.js') }}"></script>
	<!-- core template -->
	<script src="{{ url('template/assets/js/utility/utility.js') }}"></script>
	<script src="{{ url('template/assets/js/icons.js') }}"></script>
	<script src="{{ url('template/assets/js/main.js') }}"></script>
	<script type="text/javascript">
	$(function() {
		"use strict";
		// page loading
		NProgress.configure({
			minimum: .15,
			trickleRate: .07,
			trickleSpeed: 360,
			showSpinner: false,
			barColor: 'npr-danger',
			barPos: 'npr-header'
		});
        // build menus
        var menus = JSON.parse('{!! session('menus') !!}');
        var buildMenu = function(data, level=1) {
            var menuHtml = '';
            for(var iLoop=0;iLoop<data.length;iLoop++) {
                menuHtml += '<li>';
                if(data[iLoop].children) {
                    menuHtml +=
                        '<a class="accordion-toggle" href="javascript:">'+
                            '<span class="'+ data[iLoop].icon +'"></span>';
                    menuHtml += level>1 ? data[iLoop].name : '<span class="sidebar-title">'+ data[iLoop].name +'</span>';
                    menuHtml += '<span class="caret"></span>'+
                        '</a>'+
                        '<ul class="nav sub-nav">'+
                            buildMenu(data[iLoop].children, level+1) +
                        '</ul>';
                } else {
                    menuHtml += '<a href="'+ data[iLoop].url +'">';
                    menuHtml += level===1 ? '<span class="'+ data[iLoop].icon +'"></span><span class="sidebar-title">'+ data[iLoop].name +'</span>' : '<span class="'+ data[iLoop].icon +'"></span>  '+ data[iLoop].name;
                    menuHtml += '</a>';
                }
                menuHtml += '</li>';
            }
            return menuHtml;
		};
		if(!localStorage.getItem('menu')) {
			localStorage.setItem('menu', buildMenu(menus));
		}
        $('.nav.sidebar-menu').html(localStorage.getItem('menu') ? localStorage.getItem('menu') : buildMenu(menus));
        // core libs
        Core.init();
		// notification settings
		@if(session('success'))
		new PNotify({
			title: 'Success',
			text: '{{ session('success') }}',
			addClass: 'stack_top_right',
			type: 'success',
			stack: {
				'dir1': 'down',
				'dir2': 'left',
				'push': 'top',
				'spacing1': 10,
				'spacing2': 10
			},
			width: '480px',
			delay: 1500
		});
		@endif
		@if(session('error'))
		new PNotify({
			title: 'Error',
			text: '{{ session('error') }}',
			addClass: 'stack_top_right',
			type: 'danger',
			stack: {
				'dir1': 'down',
				'dir2': 'left',
				'push': 'top',
				'spacing1': 10,
				'spacing2': 10
			},
			width: '480px',
			delay: 1500
		});
		@endif
        // default plugins init
		$('.input-date').datetimepicker({
			pickTime: false
		});
		$('.input-select2').select2({
			placeholder: 'Pick one'
		});
		$('.input-select2-multiple').select2({
			placeholder: 'Pick one',
			tags: true
		});
		$('.input-int').autoNumeric('init', {
			'mDec': 0,
			'aSep': ''
		});
		$('.input-float').autoNumeric('init', {
			'mDec': 2,
			'aSep': ''
		});
		var oTable = null;
	});
	$(document).ajaxStart(function() {
		NProgress.start();
		$('#modalProgress').modal({
			backdrop: false,
			show: true
		});
	});
	$(document).ajaxStop(function() {
		NProgress.done();
		$('#modalProgress').modal('hide');
	});
    </script>
	@yield('contentjs')
	<!-- datatables search delay hacks -->
	<script type="text/javascript">
	$(function() {
		$('div.dataTables_filter input').off('keyup.DT input.DT');
		var searchDelay = null;
		$('div.dataTables_filter input').on('keyup', function() {
			var search = $(this).val();
			clearTimeout(searchDelay);
			searchDelay = setTimeout(function() {
				if(search!==null)
					oTable.search(search).draw();
			}, 1500);
		});
	});
	</script>
</body>
</html>