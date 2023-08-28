<?php

/**
 * Template Name: NPoint Profile Page 
 */

get_header();

$cuser = wp_get_current_user();
?>
<style>
    .wpfep-wrapper{display: none;}
</style>
<div id="my-profile-page" class="my-profile-page">
<h1 class="entry-title">My Profile</h1>
    <div id="my-points" class="card mb-3">
        <div class="card-body" style="background-color: #FDBD08;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="<?= get_avatar_url($cuser->ID) ?>" alt="" style="width: 45px; height: 45px" class="rounded-circle">
                    <div class="ms-3">
                        <p class="fw-bold mb-1"><?php echo $cuser->user_login ?></p>
                    </div>
                </div>
                <span class="badge rounded-pill badge-primary btn btn-primary">Your Points: <?php echo mycred_get_users_cred($cuser->ID) ?></span>
            </div>
        </div>
    </div>

    <div id="my-profile" class="card">
        <div class="card-body" style="background-color: #00EC97;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="https://near.org/_next/static/media/near-logotype.97a0ae26.svg" alt="" style="width: 45px; height: 45px" class="rounded-circle">
                    <div class="ms-3">
                        <small class="text-muted mb-0">NEAR Wallet</small>

                        <p class="fw-bold mb-1"> <?php echo get_user_meta($cuser->ID, "near_wallet", true) ? get_user_meta($cuser->ID, "near_wallet", true) : "---" ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card mt-3">
        <div class="card-body">
            <p>NEAR Web3 wallet - Manage your digital assets - tokens, NFT cards and many mores! Press button bellow to login!</p>
            <button id="open-near-wallet" class="btn btn-info container" data-walletinfo="<?= htmlentities(json_encode(["wallet" => get_user_meta($cuser->ID, "near_wallet", true), "priv" => get_user_meta($cuser->ID, "near_priv_key", true)])); ?>"><img src="https://near.org/_next/static/media/near-logotype.97a0ae26.svg"> Web3 Wallet
            </button>

            <p class="mt-3">Want to buy/sell your NFT Cards? Trade at Mintbase Marketplace!
                <br /><small><i>make sure you already login to the NEAR wallet first! Click login to NEAR wallet button above if you didnt</i></small>
            </p>
            <a target="_blank" href="https://testnet.mintbase.xyz/contract/npoint.mintspace2.testnet/" class="btn btn-outline-danger container">
                <img src="https://www.mintbase.xyz/mintbase1.svg" style="max-width: 120px;" /> NFT Marketplace</a>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            
        <div class="">
                <?= do_shortcode("[wpfep]"); ?>
                <a class="btn btn-secondary btn-sm container btn-edit-profile" >Edit Profile</a>
            </div>


        <div class="mt-3">
                <button class="btn btn-outline-danger nsub-logout-btn btn-sm container">Logout</button>
            </div>
        </div>
    </div>





    <script>
        (function($) {
            $(document).ready(function() {
                console.log("profile page ready!");
                $(".btn-edit-profile").on("click" , function(){
                   $('.wpfep-wrapper').show();
                   $(this).hide();

                });
                $("#open-near-wallet").on("click", function() {
                    var data = JSON.parse($("#open-near-wallet").attr("data-walletinfo"));
                    console.log("Data" , data);
                    if( data.priv.length >0 && !localStorage.iswalletimported){
                        //import wallet;
                        var link = "https://wallet.testnet.near.org/auto-import-secret-key#" +data.wallet+ "/" +data.priv;
                        // console.log("Link: " , link);
                        localStorage.iswalletimported = true;
                        window.location.href = link;
                    }else{
                        window.location.href = "https://wallet.testnet.near.org";
                    }
                })
            });
        })(jQuery);
    </script>
</div><!-- my-point-page -->
<?php


get_footer();
