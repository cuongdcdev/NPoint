<?php

/**
 * Template Name: My point page 
 */
get_header();
$cuser = wp_get_current_user();
?>

<div id="my-points-page" class="my-point-page">
<h1 class="entry-title">My Points Activity</h1>
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

    <p>View your activities here </p> 

    

    <?php 
        echo get_mycred_points_history();
    ?>
</div><!-- my-point-page -->
<?php


get_footer();
