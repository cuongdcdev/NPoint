<?php

/**
 * Template Name: Home logged in - scan qr 
 */

if (!empty($_POST["action"])  && $_POST["action"] == "npoint_get_activity") {



    echo get_mycred_points_history();
    die;
}

get_header();
?>
<?php
$cuser = wp_get_current_user();
$config = get_field("", "option");
?>
<div class="row" style="background-color:#ffffff;">
    <div class="col-xs-12 col-md-12 bg-image hover-overlay ripple mb-3" data-mdb-ripple-color="light">
        <div id="my-profile" class="card">
            <div class="card-body" style="background-color: #00EC97;">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="<?php $img = get_field("store_image", "option");
                                    echo $img ? $img : "https://near.org/bos-meta.png" ?>?>" style="width: 120px; height: 120px" class="rounded">
                        <div class="ms-3">
                            <p class="fw-bold mb-1"><?php echo $cuser->user_login ?></p>

                            <a href="https://wallet.testnet.near.org/" target=_blank class="btn btn-success btn-sm my-2">NEAR Wallet: <?php echo get_user_meta($cuser->ID, "near_wallet", true) ? get_user_meta($cuser->ID, "near_wallet", true) : "---" ?></a>
    <br/>
                            <a target="_blank" href="https://testnet.mintbase.xyz/contract/npoint.mintspace2.testnet/" class="btn btn-outline-danger btn-sm">
                                <img src="https://www.mintbase.xyz/mintbase1.svg" style="max-width: 60px;"> NFT Marketplace</a>


                        </div>


                    </div>
                </div>
            </div>

        </div>

        <div id="my-qr-code" class="img-fluid card p-2">
            <h2>Scan QR code</h2>
            <div id="reader" width="500px"></div>
        </div>

        <div class="mt-3">
            <h3>Activities</h3>
            <div id="scan-history">
                <?php
                echo do_shortcode('[mycred_history]');
                ?>
            </div>

        </div>

        <script>
            (($) => {
                $(document).ready(function() {
                    window.isScanning = false;
                    function onScanSuccess(decodedText, decodedResult) {
                        window.isScanning = false;
                        // handle the scanned code as you like, for example:
                        console.log(`Code matched = ${decodedText}`, decodedResult);
                        console.log("user in qr code: ", user);

                        var user = JSON.parse(decodedText);
                        if( !window.isScanning && confirm("Confirm process for user: " + user.name)  ){
                            window.isScanning = true;
                            scanQrCodeAjax(user);
                        }
                        // html5QrcodeScanner.clear();
                        // html5QrcodeScanner.render(onScanSuccess, onScanFailure);
                    }

                    function onScanFailure(error) {
                        // handle scan failure, usually better to ignore and keep scanning.
                        // for example:
                        console.warn(`Cant' scan user QR code, maybe the QR code has issue: ${error}`);
                        // alert("Cant' scan user QR code, maybe the QR code has issue!? ")
                    }

                    let html5QrcodeScanner = new Html5QrcodeScanner(
                        "reader", {
                            fps: 10,
                            qrbox: 250,
                        },
                        /* verbose= */
                        false);

                    html5QrcodeScanner.render(onScanSuccess, onScanFailure);


                    //scan qr code ajax
                    function scanQrCodeAjax(user) {
                        console.log("Scan qr code user:  ", user);
                        $.ajax({
                            method: "POST",
                            url: nsubObject.ajaxUrl,
                            data: {
                                action: "npoint_scan_qr",
                                userdata: JSON.stringify(user)
                            },
                            success: function(data) {
                                window.isScanning = false;
                                updateActivityTable();
                            },
                            error: function(err) {
                                console.log(err);
                            }
                        });
                    }
                    //end scan qr code ajax 

                    function updateActivityTable() {
                        $.ajax({
                            method: "POST",
                            url: location.href,
                            data: {
                                action: "npoint_get_activity",
                            },
                            success: function(data) {
                                console.log(data);
                                $("#scan-history").html("").html(data);
                            },
                            error: function(err) {
                                console.log("err", err);
                            }

                        })
                    }
                });
            })(jQuery)
        </script>
    </div>

    <div class="col-xs-12 col-md-12 ">

    </div>
</div>

<?php
// wp_login_form();

get_footer();
