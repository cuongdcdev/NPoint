</main><!-- /#main -->

<?php if (is_user_logged_in() && !current_user_can("administrator")  ) : ?>
	<nav id="bottom-menu" class="navbar navbar-expand-sm fixed-bottom">
		<div class="container-fluid justify-content-center">

			<ul class="navbar-nav flex-row">

				<li class="nav-item px-2" id="menu-home">
					<a class="nav-link" aria-current="page" href="/">
						<span class="dashicons dashicons-admin-home"></span>
						Home</a>
				</li>


				<li class="nav-item px-2" id="menu-home">
					<a class="nav-link" aria-current="page" href="/?page_id=47">
						<span class="dashicons dashicons-buddicons-tracking"></span>
						Redeem</a>
				</li>



				<li class="nav-item px-2" id="menu-points">

					<a class="nav-link" href="/?page_id=23">
						<span class="dashicons dashicons-heart"></span>
						Points</a>
				</li>


				<li class="nav-item px-2" id="menu-cards">
					<a class="nav-link" href="/?page_id=25">
						<span class="dashicons dashicons-star-filled"></span>
						Cards</a>
				</li>

				<li class="nav-item px-2" id="menu-profile">
					<a class="nav-link" href="/?page_id=27">
						<span class="dashicons dashicons-admin-users"></span>
						Profile</a>
				</li>
			</ul>
		</div>
	</nav>

<?php elseif( current_user_can("administrator") ): ?>

	<nav id="bottom-menu" class="navbar navbar-expand-sm fixed-bottom">
		<div class="container-fluid justify-content-center">

			<ul class="navbar-nav flex-row">

				<li class="nav-item px-2" id="menu-home">
					<a class="nav-link" aria-current="page" href="/">
						<span class="dashicons dashicons-camera-alt"></span>
						Scan</a>
				</li>


				<li class="nav-item px-2" id="menu-home">
					<a class="nav-link" aria-current="page" href="<?=get_home_url()."/wp-admin/admin.php?page=site_settings"?>">
						<span class="dashicons dashicons-buddicons-tracking"></span>
						Config Store & Redeem</a>
				</li>



				<li class="nav-item px-2" id="menu-points">

					<a class="nav-link" href="<?= get_home_url()."/wp-admin/admin.php?page=mycred" ?>">
						<span class="dashicons dashicons-clock"></span>
						User Activities</a>
				</li>


				<li class="nav-item px-2" id="menu-profile">
					<a class="nav-link" href="<?= get_home_url(). "/wp-admin/profile.php" ?>">
						<span class="dashicons dashicons-admin-users"></span>
						Profile</a>
				</li>
			</ul>
		</div>
	</nav>

	<style>
		.nav-link{text-align: center !important;}
	</style>

<?php endif; ?>

<script>
	 window.wpUserSignedIn = <?= is_user_logged_in() ? "true" : "false"; ?>;
</script>
</div><!-- /#wrapper -->
<?php
wp_footer();
?>
</body>

</html>