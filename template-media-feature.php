<?php
/**
 * Template Name: Media Feature
 **/
?>
<?php get_header(); the_post(); ?>

</div> <!-- close .container -->
<div class="container-fullwidth page-media" id="<?php echo $post->post_name; ?>">
	<div class="page-media-header">

		<!-- START custom page header content -->

		<style>
		/* Media header page template */
		#header-nav-wrap {
			z-index: 2;
		}

		@media (max-width: 480px) {
			#header-nav-wrap {
				left: 20px; /* gutter width */
				position: absolute;
				right: 20px;
			}
		}

		.page-media {
			position: relative;
			top: -70px;
			z-index: 1;
		}

		@media (max-width: 767px) {
			.page-media {
				margin-left: -20px;
				margin-right: -20px;
				top: -96px;
			}
		}

		@media (max-width: 480px) {
			.page-media {
				top: -72px;
			}
		}

		.page-media-header {
			box-sizing: border-box;
			min-height: 550px;
			padding-top: 70px;
			position: relative;
		}

		@media (max-width: 767px) {
			.page-media-header {
				padding-top: 90px;
			}
		}

		@media (max-width: 480px) {
			.page-media-header {
				padding-top: 134px;
			}
		}

		.page-media-container {

		}

		.page-media-content {

		}
		</style>
		<style>
		/* Page-specific */
		#header-menu li a {
			color: #fff;
		}

		#header-menu li.last a {
			color: #000;
		}

		.page-media-header {
			background: url('//placehold.it/1600x900') center center no-repeat;
			background-size: cover;
		}

		.media-content-wrapper {
		}
		</style>

		<div class="page-media-container">
			<div class="media-content-wrapper">
				<div class="container">
					<div class="row">
						<div class="span12">
							Custom page title and background image/video here...
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END custom page header content -->
	</div>
	<div class="page-content page-media-content">
		<article role="main">
			<?php the_content(); ?>
		</article>
	</div>
</div>
<div class="container">
	<?php get_footer();?>
