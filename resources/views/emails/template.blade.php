<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
    <title>@yield('title')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css" emogrify="no">

		h1,h2,h3 {
			margin-top: 0;
			margin-bottom: 0;
		}
		a,
		a:link {
			color: #000000;
			text-decoration: none
		}

		a[x-apple-data-detectors] {
			color: inherit !important;
			text-decoration: inherit !important;
			font-size: inherit !important;
			font-family: inherit !important;
			font-weight: inherit !important;
			line-height: inherit !important;
		}
		.jx_preheader {
			display: none !important;
			mso-hide: all !important;
			mso-line-height-rule: exactly;
			visibility: hidden !important;
			line-height: 0px !important;
			font-size: 0px !important;
		}

		body {
			width: 100% !important;
			-webkit-text-size-adjust: 100%;
			-ms-text-size-adjust: 100%;
			margin: 0;
			padding: 0;
		}

		img {
			outline: none;
			text-decoration: none;
			-ms-interpolation-mode: bicubic;
			border: none;
		}

		img.jx_img {
			width: 100% !important;
		}

		a img {
			border: none;
			color: #000 !important;
		}

		.jx-hide {
			display: none;
			display: none !important;
		}
		.jx_wrap {
			margin: auto;
		}
		@media (max-width: 480px) {
			.jx_wrap {
				display: block !important;
				width: 100% !important;
			}
		}
	</style>
</head>
<body>
<?php if (isset($preheader) && $preheader) { ?>
	<div class="jx_preheader"> {{ $preheader }}</div>
<?php } ?>
	<table id="jx_wrap" width="480px" align="center">
		<tr>
			<td>
	            @yield('content')
			</td>
		</tr>
	</table>
</body>
</html>
