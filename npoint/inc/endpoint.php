<?php

//login or create new users with NEAR 
add_action("wp_ajax_nopriv_login_with_near", "login_with_near");
function login_with_near(){
    if (!is_user_logged_in() && wp_verify_nonce($_REQUEST['nonce'], "near-login") == 1) {
        //find userid by NEAR wallet name 
        $uwallet = strip_tags(trim($_POST["wallet"]));
        
        $usersByKey = get_users( array(
            'blog_id' => 0, //multisite quirk
            'meta_key' => 'near_wallet' , 
            'meta_value' => $uwallet,
            'number' => 1, 
            'count_total' => false
             ) );
        
        $uid = sizeof($usersByKey) > 0 ? $usersByKey[0]: false;
        // var_dump("uwallet:" . $uwallet);
        // var_dump( $usersByKey );
        // die;
        
        $loggedUser = false;
    
        if ($uid) {
            $loggedUser = get_user_by("ID", $uid->ID);

        } else {
            //create new user + login 
            $newuser = [
                'user_login' => $uwallet,
                'user_pass' => md5(rand()),
                'role' => get_option('default_role')
            ];
            $newuserId = wp_insert_user($newuser);
            update_user_meta( $newuserId, "near_wallet", $uwallet );
            // add_user_to_blog(  )
            $loggedUser = get_user_by("ID", $newuserId);
        }

        if ($loggedUser) {
            //login user 
            wp_clear_auth_cookie();
            wp_set_current_user($loggedUser->ID);
            wp_set_auth_cookie($loggedUser->ID);
            header("content-type:application-json");
            echo json_encode([
                "status" => "success",
                "message" => __( sprintf("Success logged in with wallet %s", $uwallet), NSUB_DOMAIN),
                "nonce" => wp_create_nonce("near-logout")
            ]);
            die;
        }

        header("content-type:application-json");
        echo json_encode([
            "status" => "error",
            "message" => __( sprintf("Something wrong during login %s, plz try again, maybe double check your username or password? " , $uwallet), NSUB_DOMAIN),
        ]);
        die;
    }
}//login with near 

add_action("wp_ajax_nopriv_nsub_login_with_password", "nsub_login_with_password");
function nsub_login_with_password(){
    if (!is_user_logged_in() && wp_verify_nonce($_REQUEST['nonce'], "near-login") == 1) {
        $uname = strip_tags(trim($_POST["username"]));
        $password = strip_tags(trim($_POST["password"]));
        $loggedUser = false;
        $user_creds = wp_signon( [
            "user_login" => $uname,
            "user_password" => $password,
            "remember" => true
        ], false );

        if (username_exists($uname) && !is_wp_error( $user_creds ) ) {
            $loggedUser = get_user_by("login", $uname);
                //login user 
                wp_clear_auth_cookie();
                wp_set_current_user($loggedUser->ID);
                wp_set_auth_cookie($loggedUser->ID);
    
                //return json 
                header("content-type:application-json");
                echo json_encode([
                    "status" => "success",
                    "message" => __( sprintf("Success logged in %s", $uname), NSUB_DOMAIN),
                    "nonce" => wp_create_nonce("near-logout")
                ]);
                die;
        } 
        header("content-type:application-json");
        echo json_encode([
            "status" => "error",
            "message" => __( sprintf("Something wrong during login %s, plz try again, maybe double check your username or password?" , $uname), NSUB_DOMAIN),
        ]);
        die;
    }
}//login with password 

//register new account by login to NEAR wallet 
add_action("wp_ajax_nopriv_nsub_register_new_account" , "register_with_near");
function register_with_near(){
    if ( !is_user_logged_in() &&  wp_verify_nonce($_REQUEST['nonce'] , "near-login") == 1) {
        $uname = strip_tags(trim($_POST["username"]));
        $password = trim($_POST['password']);
        $uwallet = trim($_POST['wallet']);
        $loggedUser = false;

        if (username_exists($uname)) {
           header("content-type:application-json");
            echo json_encode([
                "status" => "error",
                "message" => "Username already exist",
            ]);
            die;
        } else {
            //create new user + login 
            $newuser = [
                'user_login' => $uname,
                'user_pass' => $password,
                'role' => get_option('default_role')
            ];
            $newuserId = wp_insert_user($newuser);
            nsub_create_near_account( $newuserId, $uwallet );
            $loggedUser = get_user_by("ID", $newuserId);
        }

        if ($loggedUser) {
            //login user 
            wp_clear_auth_cookie();
            wp_set_current_user($loggedUser->ID);
            wp_set_auth_cookie($loggedUser->ID);
            add_user_to_blog( 4 ,$loggedUser->ID , "subscriber");

            //return json 
            header("content-type:application-json");
            echo json_encode([
                "status" => "success",
                "message" => __( sprintf("Success created & logged in with wallet %s", $uname), NSUB_DOMAIN),
            ]);
            die;
        }

        header("content-type:application-json");
        echo json_encode([
            "status" => "error",
            "message" => __( sprintf("Something wrong during create account %s, plz try again", $uname), NSUB_DOMAIN),
        ]);
        die;
    }else{
        die( "Verify nonce: " . wp_verify_nonce($_REQUEST['nonce']) );
    }
}
//logout with NEAR 
add_action("wp_ajax_logout_with_near", function () {
    if (is_user_logged_in() && wp_verify_nonce($_REQUEST['nonce'], "near-logout")) {
        wp_clear_auth_cookie();
        wp_set_current_user(0);
        wp_logout();

        header("content-type:application-json");
        echo json_encode([
            "status" => "success",
            "message" => __("User logged out!", NSUB_DOMAIN)
        ]);
        die;
    }
});

//scan qr code action
add_action(  "wp_ajax_npoint_scan_qr" , function(){

    if( !current_user_can("administrator") ) {
        echo json_encode([
            "status"=> "error" ,
            "message" => "Only admin can do this!"
        ]);
        exit;
    }
    
    $userdata = json_decode( stripslashes($_POST["userdata"]) , true);

    $rs = mycred_add( 'scan_qr_code', $userdata["id"], NPOINT_DEFAULT_POINT_VALUE, 'Check in at ' . get_blog_details()->blogname , get_current_blog_id() );
    echo json_encode([
        "status"=> "success" ,
        "message" => "Added point success to user: " . $userdata["name"]
    ]);
    die;

});
//end scan qr code action

//npoint redeem point 
add_action("wp_ajax_npoint_redeem_point" , function(){
    //TODO: Potential security issues!!
    $data = json_decode(stripslashes($_POST["data"]) , true );
    $price = intval($data["price"]);
    $uid = get_current_user_id();
    $userbalance = intval(mycred_get_users_balance($uid)); 

    if( $userbalance < $price  ){
        echo json_encode([
            "status"=> "error" ,
            "message" => "Not enough balance! " 
        ]);
        die;
    }

    $rs = mycred_add( 'scan_qr_code', get_current_user_id(), -1*$price, 'Redeem: ' . $data["title"]. ' | store: ' .$data["storename"] , $data["storeid"] );
    echo json_encode([
        "status"=> "success" ,
        "message" => "Redeem poitn success, you got: "  . $data["title"] 
    ]);
    
    $userwallet = get_user_meta($uid , "near_wallet", true);
    if( $data["type"] == "NFT Card" ){
        //redeem to NFT card
        $rs = npoint_near_transfer_nft( $userwallet , $data["image"], strip_tags($data["title"]) , strip_tags(  $data["description"]));
        // var_dump($rs); die;
        echo $rs;
    }else{
        //redeem to coin 

    }
    //do action redeem with NEAR here
     

    die;
});//npoint redeem point 

//get NFT info ajax 
add_action("wp_ajax_nsub_get_nft_info" , function(){
    wp_send_json([
        "status" => "success", 
        "message" => nsub_get_nft_info($_POST["nft_id"])
    ]);
});
