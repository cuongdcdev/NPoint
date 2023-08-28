<?php 

// if( get_current_blog_id() == 1 ){

// 	die("go to your store please! ");
// }

// $rs = mycred_add( 'scan_qr_code', 9, 1, 'Checkin at the store' ); 
// var_dump($rs);
// die("Addedpoint");

if(is_user_logged_in()){
	if( current_user_can("administrator") ){
		require_once("templates/home-admin-logged-in.php");
	}else{
		require_once("templates/home-logged-in.php");
	}
}else{
	require_once("templates/home-not-login.php");
}