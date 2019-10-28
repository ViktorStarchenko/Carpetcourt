<?php

get_header(); ?>

<div id="primary" class="content-area store-profile-wrap">
	<main id="main" role="main">

		<!-- SLIDER-WRAP STARTS -->
		<section class="slider-wrap map-wrap">
			<?php
				//map shortcode
			echo do_shortcode('[wpsl_map id="'.get_the_ID().'"]');
			?>

			<div class="caption">
				<div class="vert-middle">
					<div class="wrap">
						<h1 class="title"><?php echo get_the_title(); ?></h1>
					</div>
				</div>
			</div>

		</section>
		<!-- SLIDER-WRAP ENDS -->

		<?php

		$ph_no  = get_post_meta( get_the_ID(), 'wpsl_phone', true );
		$wpsl_email  = get_post_meta( get_the_ID(), 'wpsl_email', true );
		$w_show_hide = get_field( 'w_show_hide', get_the_ID() );
		$welcome_title = get_field( 'welcome_title', get_the_ID() );
		$welcome_message = get_field( 'welcome_message', get_the_ID() );
		$w_image = get_field( 'w_image', get_the_ID() );


// testimonial
		$t_show_hide = get_field( 't_show_hide', get_the_ID() );
		$store_testimonial = get_field( 'store_testimonial', get_the_ID() );
		// about_show_hide about us
		$about_show_hide = get_field( 'about_show_hide', get_the_ID() );
		$store_about_us = get_field( 'store_about_us', get_the_ID() );

		// gallery_show_hide gallery
		$gallery_show_hide = get_field( 'gallery_show_hide', get_the_ID() );
		$gallery_content = get_field( 'gallery_content', get_the_ID() );

		// community_show_hide
		$community_show_hide = get_field( 'community_show_hide', get_the_ID() );
		$community_content = get_field( 'community_content', get_the_ID() );
		?>

		<div class="page-scroll-nav container wow fadeInUp">
			<ul>
				<?php
				if ( $w_show_hide == 'show' ) { ?>

				<li>
					<a href="#welcome">Welcome</a>
				</li>

				<?php }

				if ( $t_show_hide == 'show' ) { ?>

				<li>
					<a href="#testimonials">Testimonials</a>
				</li>

				<?php }

				if ( $about_show_hide == 'show' ) { ?>

				<li>
					<a href="#about">About</a>
				</li>

				<?php }

				if ( $gallery_show_hide == 'show' ) { ?>

				<li>
					<a href="#gallery">Gallery</a>
				</li>

				<?php } ?>
				<?php
				if ( $community_show_hide == 'show' ) { ?>

				<li>
					<a href="#news">Community News</a>
				</li>
				<?php }

				/*if ( comments_open() ) {

				?>
				<li>
					<a href="#customer-review">Customer Reviews</a>
				</li>
				<?php }*/ ?>
				<li>
					<a href="#contact">Contact & Location</a>
				</li>
			</ul>
		</div>

		<?php

		if ( $w_show_hide == 'show' ) { ?>
		<!-- WELCOME STARTS -->
		<section id="welcome">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_border_width_3 vc_sep_pos_align_center vc_sep_color_grey wow fadeInUp vc_separator-has-text animated" style="visibility: visible; animation-name: fadeInUp;">
							<span class="vc_sep_holder vc_sep_holder_l">
								<span class="vc_sep_line"></span>
							</span>
							<h4>Welcome</h4>
							<span class="vc_sep_holder vc_sep_holder_r">
								<span class="vc_sep_line"></span>
							</span>
						</div>
					</div>

					<div class="col-md-12  wow fadeInUp">
						<div class="intro-text">
							<?php
							if ( !empty( $welcome_message ) ) {
								echo $welcome_message;
							}

							if ( !empty( $w_image ) ) {
								$welcome_image = wp_get_attachment_image_src( $w_image, 'large' );
								?>

								<img src="<?php echo $welcome_image[0]; ?>" alt="welcome">
								<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- WELCOME ENDS -->

		<?php }

		if ( $t_show_hide == 'show' ) { ?>
		<!-- TESTIMONIALS STARTS -->
		<section id="testimonials">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_border_width_3 vc_sep_pos_align_center vc_sep_color_grey wow fadeInUp vc_separator-has-text animated" style="visibility: visible; animation-name: fadeInUp;">
							<span class="vc_sep_holder vc_sep_holder_l">
								<span class="vc_sep_line"></span>
							</span>
							<h4>Testimonials</h4>
							<span class="vc_sep_holder vc_sep_holder_r">
								<span class="vc_sep_line"></span>
							</span>
						</div>
					</div>

					<div class="col-md-12  wow fadeInUp">
						<ul class="bxslider">
							<?php
							foreach ( $store_testimonial as $store_testimonial_value) { ?>

							<li class="slides">
								<span class="quote">
									<?php
									if ( !empty( $store_testimonial_value['testimonial_content'] ) ) {
										echo strip_tags($store_testimonial_value['testimonial_content'], '<p>');
									}
									$store_image = wp_get_attachment_image_src( $store_testimonial_value['testimonial_image'], 'cc_gal_image', true );
									?>
								</span>
								<?php if ( !empty( $store_image[0] ) ) { ?>
								<span class="user-img">

									<img src="<?php echo $store_image[0]; ?>" >
								</span>
								<?php } ?>
								<?php if ( !empty( $store_testimonial_value['testimonial_name'] ) ) { ?>
								<span class="user-detail"><?php echo $store_testimonial_value['testimonial_name']; ?></span>
								<?php } ?>
							</li>

							<?php
						}
						?>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<!-- TESTIMONIALS ENDS -->
	<?php }

	if ( $about_show_hide == 'show' ) { ?>

	<!-- ABOUT STARTS -->
	<section id="about">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_border_width_3 vc_sep_pos_align_center vc_sep_color_grey wow fadeInUp vc_separator-has-text animated" style="visibility: visible; animation-name: fadeInUp;">
						<span class="vc_sep_holder vc_sep_holder_l">
							<span class="vc_sep_line"></span>
						</span>
						<h4>About Us</h4>
						<span class="vc_sep_holder vc_sep_holder_r">
							<span class="vc_sep_line"></span>
						</span>
					</div>
				</div>
			</div>

			<?php
			if ( !empty( $store_about_us ) ) {
				echo $store_about_us;
			}
			?>
		</div>
	</section>
	<!-- ABOUT ENDS -->

	<?php }

	if ( $gallery_show_hide == 'show' ) { ?>

	<!-- GALLERY STARTS -->
	<section id="gallery">
		<div class="container">
			<?php
			if ( !empty( $gallery_content ) ) {
				echo $gallery_content;
			}
			?>
		</div>
		<div class="space" style="height:50px;"></div>
	</section>
	<!-- GALLERY STARTS -->
	<?php }

	if ( $community_show_hide == 'show' ) { ?>

	<!-- TEAM STARTS -->
	<section id="news">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_border_width_3 vc_sep_pos_align_center vc_sep_color_grey wow fadeInUp vc_separator-has-text animated" style="visibility: visible; animation-name: fadeInUp;">
						<span class="vc_sep_holder vc_sep_holder_l">
							<span class="vc_sep_line"></span>
						</span>
						<h4>Community News</h4>
						<span class="vc_sep_holder vc_sep_holder_r">
							<span class="vc_sep_line"></span>
						</span>
					</div>
				</div>

				<div class="col-md-12">
					<?php
					$news_title = get_field( 'news_title', get_the_ID() );
					$news_image = get_field( 'news_image', get_the_ID() );
					$community_content = get_field( 'community_content', get_the_ID() );

					$store_news_image = wp_get_attachment_image_src( $news_image, 'cc_gal_image', true );
					?>

					<div class="row">
						<?php
						if ( !empty( $store_news_image[0] ) ) { ?>

						<div class="col-md-4">
							<div class="news-user">
								<img src="<?php echo $store_news_image[0];?>" alt="<?php echo $news_title; ?>">
							</div>
						</div>
						<?php
					}
					?>

					<div class="col-md-8">
						<div class="news-info">
							<?php
							if ( !empty( $news_title ) ) { ?>

							<h3><?php echo $news_title; ?></h3>
							<?php
						}

						if ( !empty( $community_content ) ) {
							echo $community_content;
						}
						?>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
</section>
<!-- TEAM ENDS -->
<?php } ?>

<?php if ( comments_open() ) { ?>
<!-- CUstomre Review start -->

<section id="customer-review">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_border_width_3 vc_sep_pos_align_center vc_sep_color_grey wow fadeInUp vc_separator-has-text animated" style="visibility: visible; animation-name: fadeInUp;">
					<span class="vc_sep_holder vc_sep_holder_l">
						<span class="vc_sep_line"></span>
					</span>
					<h4>Customer Rating & Reviews</h4>
					<span class="vc_sep_holder vc_sep_holder_r">
						<span class="vc_sep_line"></span>
					</span>
				</div>
				<div class="col-md-12">
					<?php comments_template('/comments-store.php'); ?>
				</div>
			</div>
		</div>
	</div>

</section>
<!-- CUstomre Review End -->
<?php } ?>


<!-- CONTACT STARTS -->
<section id="contact">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_border_width_3 vc_sep_pos_align_center vc_sep_color_grey wow fadeInUp vc_separator-has-text animated" style="visibility: visible; animation-name: fadeInUp;">
					<span class="vc_sep_holder vc_sep_holder_l">
						<span class="vc_sep_line"></span>
					</span>
					<h4>Contact & Location</h4>
					<span class="vc_sep_holder vc_sep_holder_r">
						<span class="vc_sep_line"></span>
					</span>
				</div>
			</div>

			<?php
			$current_status = cpm_get_store_status( get_the_ID() );
			?>

			<?php
			$phone_no = get_post_meta( get_the_ID(), 'wpsl_phone', true );
			$store_email = get_post_meta( get_the_ID(), 'wpsl_email', true );
			$store_address = get_post_meta( get_the_ID(), 'wpsl_address', true );
			$phone_string = str_replace(' ', '', $phone_no);
			?>

			<div class="col-md-12  wow fadeInUp">
				<div class="contact-details">
					<?php if ( !empty( $phone_no ) ) { ?>
					<a href="tel:<?php echo $phone_string; ?>" class="call">
						<i class="fa fa-phone"></i><?php echo $phone_no; ?>
					</a>
					<?php
				}

				if ( !empty( $store_email ) ) { ?>
				<a href="mailto:<?php echo $store_email; ?>" class="mail">
					<i class="fa fa-envelope"></i><?php echo $store_email; ?>
				</a>
				<?php } ?>

				<?php if ( !empty( $store_address ) ) { ?>
				<a href="javascript:void(0)">
					<i class="fa fa-map-marker"></i><?php echo $store_address; ?>
				</a>
				<?php } ?>
				<a href="javascript:void(0)"><i class="fa fa-lightbulb-o"></i><?php echo $current_status; ?></a>

			</div>
		</div>

		<div class="col-md-3  wow fadeInUp">
			<div class="contact-hours">
				<i class="fa fa-clock-o"></i>

				<?php echo do_shortcode('[wpsl_hours id="'.get_the_ID().'"]'); ?>
			</div>
		</div>

		<div class="col-md-9  wow fadeInUp">
			<div class="contact-form">
				<form action="" class="form-horizontal" method="post" id="cpm-store-profile-form">
					<?php
					$store_email = get_post_meta( get_the_ID(), 'wpsl_email', true );
					$mail = get_option('admin_email');
					?>

					<input type="hidden" name="to_email" value="<?php echo $store_email; ?>"></input>
					<div class="col-wrap">
						<input type="text" placeholder="YOUR-NAME" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" name="your_name" aria-invalid="false">
					</div>

					<div class="col-wrap">
						<input type="text" placeholder="YOUR-EMAIL" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" name="your_email" aria-invalid="false">
					</div>


					<textarea name="your_message" placeholder="YOUR-MESSAGE" cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea" aria-invalid="false"></textarea>

					<input type="submit" value="Submit" class="wpcf7-form-control wpcf7-submit">
				</form>
			</div>
		</div>
	</div>
</div>

<div class="space" style="height:50px;"></div>

</section>
<!-- CONTACT ENDS -->

</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
