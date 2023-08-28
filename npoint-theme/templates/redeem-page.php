<?php

/**
 * Template Name: Redeem page
 */

get_header();
$allsites = get_sites();
$cuser = wp_get_current_user();
?>
<h1 class="entry-title">Redeem</h1>
		<div id="my-profile" class="card mt-3 mb-3">
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
<h5>Available gifts in all stores </h5>
<?php
foreach ($allsites as $b) {
    switch_to_blog($b->blog_id);
?>
    <div class="store-wrap">
        <?php if (strlen(get_field("store_image", "option")) > 10) : ?>
            <div class="bg-image p-5 text-center shadow-1-strong rounded mb-3 mt-3 text-white" style="background-size:cover; 
        background-image: url('<?php echo get_field("store_image", "option") ?>'); max-height:150px">
                <h2 class="mb-3 h2" style="background: rgba(0, 0, 0, 0.5);"><?= get_bloginfo("name") ?></2>
            </div>
        <?php endif; ?>

        <div class="row row-cols-2 row-cols-md-2">
            <?php
            $fields =  get_field("redeem_points", "option");
            if ($fields) foreach ($fields as $p) :
                $p["storename"] =  get_blog_details()->blogname;
                $p["storeid"] = get_blog_details()->blog_id;

            ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="<?= $p['image'] ?>" class="card-img-top" alt="<?= $p["title"] ?>" />
                        <div class="card-body">
                            <h5 class="card-title"><?= $p["title"] ?></h5>
                            <p class="card-text"><?= $p["description"] ?></p>
                            <a href="#!" class="btn btn-outline-success btn-redeem" data-redeem="<?= htmlentities(json_encode($p)) ?>">Redeem (<?=$p["price"]?> points)</a>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div> <!-- rows -->



    </div><!-- store-wrap -->
<?php
} //endforeach sites 
?>

<script>
    (($) => {
        $(document).ready(function() {
            console.log("redeem page ready!");


            $(".btn-redeem").on("click", function() {

                console.log("data redeem: ", $(this).attr("data-redeem"));
                var data = JSON.parse($(this).attr("data-redeem"));

                if (confirm("Redeem: " + data.title + ", will cost you: " + data.price + " points, please confirm?")) {
                    $.ajax({
                        method: "POST",
                        url: nsubObject.ajaxUrl,
                        data: {
                            action: "npoint_redeem_point",
                            data: JSON.stringify(data)
                        },
                        success: function(data) {
                            var rs = JSON.parse(data);
                           alert( rs.message );
                           console.log("Redeem rs" , data);
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                }
            });

            function redeem() {

            }

        }) //dom ready

    })(jQuery);
</script>

<?php
restore_current_blog();
get_footer();
