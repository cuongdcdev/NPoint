<?php

/**
 * Template Name: Home logged in
 */

get_header();
?>
<?php
$cuser = wp_get_current_user();
?>
<div class="row" style="background-color:#ffffff;">
	<div class="col-xs-12 col-md-6 bg-image hover-overlay ripple mb-3" data-mdb-ripple-color="light">
		<div id="my-profile" class="card">
			<div class="card-body" style="background-color: #00EC97;">
				<div class="d-flex justify-content-between align-items-center">
					<div class="d-flex align-items-center">
						<img src="https://near.org/_next/static/media/near-logotype.97a0ae26.svg" alt="" style="width: 45px; height: 45px" class="rounded-circle">
						<div class="ms-3">
							<p class="fw-bold mb-1"><?php echo $cuser->user_login ?></p>
							<small class="text-muted mb-0">Wallet: <?php echo get_user_meta($cuser->ID, "near_wallet", true) ? get_user_meta($cuser->ID, "near_wallet", true) : "---" ?></small>
						</div>
					</div>
					<span class="badge rounded-pill badge-primary btn btn-primary">Your Points: <?php echo mycred_get_users_cred($cuser->ID) ?></span>
				</div>
			</div>
    
		</div>

		<div id="my-qr-code" class="img-fluid card p-2" >
			<div class="desc" style="text-align: center;">
				Your QR Code
			</div>

		</div>

		<script>
			(($) => {
				$(document).ready(function() {
					var qrcode = new QRCode("my-qr-code");

					qrcode.makeCode(JSON.stringify(<?php
						$cuser = wp_get_current_user();
						$json = json_encode([
							"id" => $cuser->ID,
							"name" => $cuser->user_login,
							"email" => $cuser->user_email,
							"wallet" => get_user_meta($cuser->ID, "near_wallet", true)
						]);
						echo $json;
						?>));
				});
			})(jQuery)
		</script>
	</div>

	<div class="col-xs-12 col-md-6 ">
		<h2>Recent activities</h2>
		<?php
		if (!is_user_logged_in()) {
			echo do_shortcode("[npoint-user-register-form]");
			echo do_shortcode("[nsub_login]");
		} else {
			echo get_mycred_points_history();
		}
		?>
	</div>
</div>

<?php
// wp_login_form();

get_footer();
