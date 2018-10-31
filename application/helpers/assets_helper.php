<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');

	/**
	* @package for assets file often modified => javascript or css
	*/
	function assets_css($filename,$echo=true)
	{
		$filenya = "assets/css/custom/".$filename;
		if (file_exists($filenya)) {
			$result = base_url().$filenya."?vfm=".filemtime($filenya);
			if ($echo) {
				echo '<link rel="stylesheet" href="'.$result.'" />';
			} else {
				return '<link rel="stylesheet" href="'.$result.'" />';
			}
		} else {
			echo "File css ".base_url($filenya)." not found..!!";
		}
	}

	function assets_css_general($filename,$echo=true)
	{
		$filenya = "assets/css/".$filename;
		if (file_exists($filenya)) {
			$result = base_url().$filenya."?vfm=".filemtime($filenya);
			if ($echo) {
				echo '<link rel="stylesheet" href="'.$result.'" />';
			} else {
				return '<link rel="stylesheet" href="'.$result.'" />';
			}
		} else {
			echo "File css ".base_url($filenya)." not found..!!";
		}
	}

	function assets_script($filename,$echo=true)
	{
		$filenya = "assets/js/custom/".$filename;
		if (file_exists($filenya)) {
			$result = base_url().$filenya."?vfm=".filemtime($filenya);
			if ($echo) {
				echo '<script type="text/javascript" src="'.$result.'"></script>';
			} else {
				return '<script type="text/javascript" src="'.$result.'"></script>';
			}
		} else {
			echo "File script ".base_url($filenya)." not found..!!";
		}
	}

	function assets_script_dashboard($filename,$echo=true)
	{
		$filenya = "dashboard/".$filename;
		assets_script($filenya,$echo);
	}

	function assets_script_master($filename,$echo=true)
	{
		$filenya = "master/".$filename;
		assets_script($filenya,$echo);
	}

	function assets_script_transaksi($filename,$echo=true)
	{
		$filenya = "transaksi/".$filename;
		assets_script($filenya,$echo);
	}

	function assets_script_laporan($filename,$echo=true)
	{
		$filenya = "laporan/".$filename;
		assets_script($filenya,$echo);
	}

	function assets_script_performa($filename,$echo=true)
	{
		$filenya = "performa/".$filename;
		assets_script($filenya,$echo);
	}

	function assets_script_pendapatan($filename,$echo=true)
	{
		$filenya = "pendapatan/".$filename;
		assets_script($filenya,$echo);
	}

	function assets_script_umum($filename,$echo=true)
	{
		$filenya = "umum/".$filename;
		assets_script($filenya,$echo);
	}