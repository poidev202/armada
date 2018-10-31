<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" id="titleLogoIcon" href="<?php echo base_url();?>assets/images/logo-rapi.png">
    <?php 
        if (!isset($halaman_title) || $halaman_title == "") {
            $halaman_title = "Empty Header Title";
        }
    ?>
    <title>
        <?php echo $halaman_title; ?>
    </title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <!-- Page plugins css -->
    <link href="<?php echo base_url();?>assets/plugins/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
    <!-- Color picker plugins css -->
    <link href="<?php echo base_url();?>assets/plugins/jquery-asColorPicker-master/css/asColorPicker.css" rel="stylesheet">
    <!-- Date picker plugins css -->
    <link href="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker plugins css -->
    <link href="<?php echo base_url();?>assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- select2 version 4 -->
    <!-- <link href="<?php //echo base_url();?>assets/plugins/select2/dist/css/select2.css" rel="stylesheet" type="text/css" /> -->


    <!-- Popup CSS -->
    <link href="<?php echo base_url();?>assets/plugins/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/dropify/dist/css/dropify.min.css">


    <!-- chartist CSS -->
    <link href="<?php echo base_url();?>assets/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/plugins/chartist-js/dist/chartist-init.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">

    <!-- morris CSS -->
    <link href="<?php echo base_url();?>assets/plugins/morrisjs/morris.css" rel="stylesheet">

    <!-- select2 version 3 -->
    <!-- <link href="<?php //echo base_url();?>assets/plugins/select2-3.5.4/select2.css" rel="stylesheet" type="text/css" />
    
    <link href="<?php //echo base_url();?>assets/plugins/select2-3.5.4/select2-bootstrap.css" rel="stylesheet" type="text/css" /> -->

    <!-- select2 version 4.0.6-rc.1 -->
    <link href="<?php echo base_url();?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    
    <link href="<?php echo base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />

    <link href="<?php echo base_url();?>assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
    
    <!--alerts CSS -->
    <link href="<?php echo base_url();?>assets/plugins/sweetalert2/sweetalert2.css" rel="stylesheet" type="text/css">

    <!-- Custom CSS -->
    <link href="<?php echo base_url();?>assets/css/style.css?vc=101" rel="stylesheet">

    <!-- You can change the theme colors from here -->
    <link href="<?php echo base_url();?>assets/css/colors/blue.css" id="theme" rel="stylesheet">


    <?php assets_css("general.css"); ?>   

    <!-- ============================================================== -->
    <script src="<?php echo base_url();?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- select 2 -->
    <script src="<?php echo base_url();?>assets/plugins/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/plugins/wnumb/wNumb.js"></script>

    <script type="text/javascript">
        var moneyFormat = wNumb({
                mark: ',',
                // decimals: 2,
                thousand: '.',
                prefix: 'Rp. ',
                suffix: ''
              });

        var user_role = '<?php echo $this->user_role; ?>';
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header  card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <!-- menu header -->
           <?php $this->load->view('layouts/menu_head'); ?>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <?php $this->load->view('layouts/menu_side'); ?>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <?php 
                        if (!isset($header_title) || $header_title == "") {
                          $header_title = "Empty Header Title";
                        }

                        if (!isset($small_title)) {
                            $small_title = "";
                        }
                     ?>
                    <h3 class="text-themecolor"><?php echo $header_title; ?>
                        <?php if($small_title != "") : ?>
                            <small> <i class="fa fa-chevron-right"></i> <?php echo $small_title; ?></small>
                        <?php endif ?>
                    </h3>

                </div>
                <?php if (isset($breadcrumbs)): ?>
                    <div class="col-md-7 align-self-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">Home</a></li>
                            <!-- <li class="breadcrumb-item active">Dashboard</li> -->
                            <?php 
                                if (isset($breadcrumbs)) {
                                    if (is_array($breadcrumbs)) {
                                        foreach ($breadcrumbs as $key => $value) {
                            ?>
                                            <li class="breadcrumb-item <?php echo $value == '' ? 'active' : ''; ?>">
                                                <?php if ($value != "") { ?>
                                                    <a href="<?php echo $value; ?>"><?php echo $key; ?></a>
                                                <?php } else { ?>
                                                    <?php echo $key; ?>
                                                <?php } ?>
                                            </li>
                                  <?php 
                                        }
                                    } else {
                                  ?>
                                        <li class="breadcrumb-item active"><?php echo $breadcrumbs; ?></li>
                            <?php
                                    }
                                } 
                            ?>
                        </ol>
                    </div>
                <?php endif ?>
                <!-- <div>
                    <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                </div> -->
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">