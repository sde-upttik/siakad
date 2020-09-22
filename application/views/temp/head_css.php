	<meta charset="utf-8">
    <meta name="author" content="UPT. TIK (Software Davelopment)">
    <link rel="icon" href="<?=base_url()?>assets/images/Logo_untad.png">

    <title>Sistem Informasi Akademik</title>

	<!-- Bootstrap v4.0.0-beta -->
	<link rel="stylesheet" href="<?=base_url()?>assets/components/bootstrap/dist/css/bootstrap.css">

	<!-- font awesome -->
	<link rel="stylesheet" href="<?=base_url()?>assets/components/font-awesome/css/font-awesome.css">

	<!-- ionicons -->
	<link rel="stylesheet" href="<?=base_url()?>assets/components/Ionicons/css/ionicons.css">

	<!-- Fandu Select2 (Silahkan hapus jika ada kendala, tapi konfirmasi dulu) -->
	<link rel="stylesheet" href="<?=base_url()?>assets/components/select2/dist/css/select2.min.css">

	<!-- theme style -->
	<link rel="stylesheet" href="<?=base_url()?>assets/css/master_style.css">

	<!-- horizontal menu style -->
	<link rel="stylesheet" href="<?=base_url()?>assets/css/horizontal_menu_style.css">

	<!-- maximum_admin skins. choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="<?=base_url()?>assets/css/skins/_all-skins.css">

	<!-- morris chart -->
	<link rel="stylesheet" href="<?=base_url()?>assets/components/morris.js/morris.css">

	<!-- jvectormap -->
	<link rel="stylesheet" href="<?=base_url()?>assets/components/jvectormap/jquery-jvectormap.css">

	<!-- date picker -->
	<link rel="stylesheet" href="<?=base_url()?>assets/components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css">

	<!-- daterange picker -->
	<link rel="stylesheet" href="<?=base_url()?>assets/components/bootstrap-daterangepicker/daterangepicker.css">

	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="<?=base_url()?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css">

	<!-- Bootstrap time Picker -->
	<link rel="stylesheet" href="<?=base_url()?>assets/plugins/timepicker/bootstrap-timepicker.min.css">

	<link rel="stylesheet" href="<?=base_url()?>assets/plugins/jasny/jasny-bootstrap.min.css">

    <link rel="stylesheet" href="<?=base_url('assets/css/pado_style.css')?>">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="<?=base_url()?>https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="<?=base_url()?>https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- google font -->
	<link href="<?=base_url()?>assets/css/font.css" rel="stylesheet">

	<!-- wawan Sweet Alert -->
    <link href="<?= base_url('assets/plugins/sweetalert/dist/sweetalert.css'); ?>" rel="stylesheet" type="text/css"/>

    <!--Saya matikan css swAlert2 (fadli)  -->
    <!-- <link href="<?=base_url()?>assets/plugins/sweetalert2/dist/sweetalert2.min.css"> -->



    <style type="text/css">
        .modal_loading {
            display:    none;
            position:   fixed;
            z-index:    9999999;
            top:        0;
            left:       0;
            height:     100%;
            width:      100%;
            color: #FF0000;
            padding: 220px 0;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            background: rgba( 255, 255, 255, .8 )
                        url('<?= base_url('assets/images/ajax-loader.gif')?>')
                        50% 50%
                        no-repeat;
            background-size: 75px;
        }

        body.loading {
            overflow: hidden;
        }

        body.loading .modal_loading {
            display: block;
        }
    </style>
