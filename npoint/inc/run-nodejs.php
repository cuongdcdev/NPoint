<?php 

/**
 * @userId
 * @nearwallet
 * @return array json {"status" : "success",
            // "wallet" : newAccountId , 
            // "privKey": "ed25519:" + keyPair.secretKey,
            // "message" : "Create account success! "}
 */
function nsub_create_near_account( $userId, $nearwallet){
    $r =  shell_exec( escapeshellcmd('node ' . NPOINT_NODEJS_PATH .'/create-near-account.js ' .  $nearwallet));
    $matches = preg_grep('/{.+/', explode("\n", $r));

    $rs = json_decode(  $matches[0], true); 
    // var_dump($rs); die;
    if($rs["status"] == "success"){
        update_user_meta($userId , "near_wallet" , $nearwallet);
        update_user_meta($userId , "near_priv_key" , $rs["privKey"]);
        return $rs;
    }else{
        return false;
    }
}

/**
 * transfer Near token to receiver
 * @return array json [status & message]
 */
function npoint_near_transfer_token( $userwallet, $amount){
    $cmd =  sprintf('node ' . NPOINT_NODEJS_PATH .'/transfer-near.js "%s" "%s"', $userwallet,  $amount);
    $r =  shell_exec( escapeshellcmd($cmd) );
    $matches = preg_grep('/{.+/', explode("\n", $r));

    $rs = json_decode(  $matches[0], true); 
    // var_dump($rs); die;
    if($rs["status"] == "success"){

        return $rs;
    }else{
        return false;
    }
}

/**
 * Transfer NFT to receiver 
 * @return array json [status & message]
 */
function npoint_near_transfer_nft( $userwallet, $img, $title, $desc){
    $cmd = sprintf( 'node ' . NPOINT_NODEJS_PATH. '/transfer-nft.js "%s" "%s" "%s" "%s"', $userwallet, $img, $title, $desc);
    $cmd = escapeshellcmd($cmd);
    $r =  shell_exec($cmd);
    // var_dump("Command to run: " . $cmd );
    // var_dump($r) ; die;
    $matches = preg_grep('/{.+/', explode("\n", $r));

    $rs = json_decode(  $matches[0], true); 
    // var_dump($rs); die;
    if($rs["status"] == "success"){
        return $rs;
    }else{
        return false;
    }
}





