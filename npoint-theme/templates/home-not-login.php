<?php

/**
 * Template Name: Home not login
 */

get_header();
?>
<?php
$cuser = wp_get_current_user();
?>
<div class="row" style="background-color:#ffffff;">
    <div class="col-xs-12 col-md-6 bg-image hover-overlay ripple mb-3" data-mdb-ripple-color="light">
        <div class="img-fluid p-2">
            <img src="<?php 
                $img = get_field( "store_image","option");
            echo $img ? $img : "https://near.org/bos-meta.png" ?>" class="img-fluid"  />

            <div class="desc pt-3" style="text-align: center;">
                <?php echo get_field( "store_desc" , "option" )  ?>
            </div>

        </div>
    </div>

    <div class="col-xs-12 col-md-6 ">
        <?php
        echo do_shortcode("[npoint-user-register-form]");
        echo do_shortcode("[nsub_login]");
        ?>
    </div>
</div>

<?php
get_footer();
