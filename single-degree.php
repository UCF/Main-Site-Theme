<?php disallow_direct_load('single-degree.php');?>
<?php get_header(); the_post();?>
<?php $post = append_degree_profile_metadata($post); ?>

<?php
	$css_key = get_theme_option('cloud_font_key');
	if ($css_key) {
		print '<link rel="stylesheet" href="'.$css_key.'" type="text/css" media="all" />';
	}

?>

	<style>
	/**
	 * TODO: Move to style.css/style-responsive.css when design drafting is done
	 **/
	#breadcrumbs {
		border-bottom: 2px solid #eee;
		font-family: 'Gotham SSm 4r', 'Gotham SSm A', 'Gotham SSm B';
		font-size: 12.5px;
		margin-bottom: 25px;
	}
	#breadcrumbs .breadcrumb-search {
		display: block;
		float: left;
		font-weight: 500;
		padding: 8px 0; /* match .breadcrumb top/bottom padding */
		width: 20%;
	}
	#breadcrumbs .breadcrumb-hierarchy {
		background: #fff;
		display: block;
		float: left;
		list-style-type: none;
		margin-bottom: 0;
	}
	#breadcrumbs .breadcrumb-search + .breadcrumb-hierarchy {
		padding-left: 0;
		padding-right: 0;
		width: 80%;
	}
	@media (min-width: 768px) and (max-width: 979px) {
		#breadcrumbs .breadcrumb-search {
			width: 24%;
		}
		#breadcrumbs .breadcrumb-search + .breadcrumb-hierarchy {
			width: 76%;
		}
	}
	@media (max-width: 767px) {
		/* Hiding breadcrumbs at mobile size seems to be a standard convention--not sure if I agree, but sticking with this for now */
		#breadcrumbs {
			display: none;
		}
	}


	#contentcol,
	#sidebar_right {
		font-family: 'Gotham SSm 4r', 'Gotham SSm A', 'Gotham SSm B';
		font-size: 14px;
	}
	#sidebar_right {
		box-sizing: border-box;
		padding-left: 15px;
	}
	.ie7 #sidebar_right {
		padding-left: 0;
	}
	@media (max-width: 767px) {
		#sidebar_right {
			display: block; /* unset display: none; */
			margin-top: 30px;
			padding-left: 0;
		}
	}
/*	#contentcol a,
	#sidebar_right a {
		color: #08c;
	}
	#sidebar_right a:hover,
	#sidebar_right a:active,
	#sidebar_right a:focus {
		text-decoration: underline;
	}
	#sidebar_right a.btn:hover,
	#sidebar_right a.btn:active,
	#sidebar_right a.btn:focus {
		text-decoration: none;
	}*/


	#contentcol p {
		margin: 0 0 10px;
	}
	#contentcol dt,
	#contentcol dd,
	#sidebar_right dt,
	#sidebar_right dd {
		display: inline;
	}
	#contentcol h2,
	#contentcol h3,
	#contentcol h4,
	#contentcol h5,
	#contentcol h6 {
		font-weight: 500;
		margin-bottom: 5px;
	}
	#contentcol h2 {
		font-size: 24px;
		line-height: 26px;
		margin-bottom: 8px;
		margin-top: 40px;
	}
	@media (max-width: 767px) {
		#contentcol h2 {
			font-size: 23px;
			line-height: 25px;
		}
	}
	#contentcol h3 {
		border-bottom: 1px solid #eee;
		font-size: 18.5px;
		line-height: 21px;
		margin-top: 30px;
	}
	#contentcol h4 {
		font-size: 15.5px;
		line-height: 18px;
		margin-top: 25px;
	}


	#contentcol .degree-details {
		margin-bottom: 30px;
	}
	@media (max-width: 767px) {
		#contentcol .degree-details {
			font-size: 12.5px;
			margin-bottom: 20px;
		}
	}
	#contentcol .degree-details dl {
		margin-bottom: 0;
		margin-top: 0;
	}


	#contentcol .degree-desc {
		margin-bottom: 30px;
	}


	#contentcol .degree-courses h3 {
		border-bottom: 1px solid #eee;
		padding-bottom: 5px;
	}


	#contentcol .degree-courses .degree-courses-credits {
		display: block;
		float: right;
		font-weight: 500;
		white-space: nowrap;
	}
	@media (max-width: 767px) {
		#contentcol .degree-courses .degree-courses-credits {
			float: none;
			margin-top: 5px;
		}
	}
	#contentcol .degree-courses h3 .degree-courses-credits {
		font-size: 15px;
	}


	@media (max-width: 767px) {
		#sidebar_right {
			border-top: 2px solid #eee;
			padding-top: 20px;
		}
	}
	#sidebar_right h2 {
		color: #888;
		font-size: 18px;
		font-weight: normal;
		line-height: 1.2;
		margin-bottom: 5px;
		margin-top: 20px;
	}
	#sidebar_right ul {
		list-style-type: none;
		margin-left: 0;
	}

	#sidebar_right .contact-name,
	#sidebar_right .contact-title/*,
	#sidebar_right .contact-email,
	#sidebar_right .contact-phone,
	#sidebar_right .contact-office */{
		display: block;
	}
	#sidebar_right .contact-name {
		font-weight: bold;
	}
	#sidebar_right .contact-title {
		font-style: italic;
	}
	#sidebar_right .contact-info-dl {
		margin-top: 5px;
	}
	</style>

	<div class="row page-content" id="degree-single">
		<div id="page_title" class="span12">
			<h1 class="span9"><?php the_title(); ?></h1>
			<?php esi_include('output_weather_data','span3'); ?>
		</div>

		<div id="breadcrumbs" class="span12 clearfix">
			<!-- Display .breadcrumb-search only if the user came from the degree search (check for GET param) -->
			<a class="breadcrumb-search" href="javascript:window.history.back();">&laquo; Back to Search Results</a>

			<!-- Always display hierarchy-based breadcrumbs-it also helps designate tracks/subplans -->
			<ul class="breadcrumb-hierarchy breadcrumb">
				<li>
					<a href="#"><?=$post->tax_program_type[0]?> Programs</a> <span class="divider">&gt;</span>
				</li>
				<li>
					<a href="#"><?=$post->tax_college[0]?></a> <span class="divider">&gt;</span>
				</li>
				<li class="active">
					<?php the_title(); ?>
				</li>
			</ul>
		</div>

		<div id="contentcol" class="span8 degree">
			<article role="main">
				<!-- Degree description -->
				<?php if ($post->degree_description) { ?>
					<?php echo apply_filters('the_content', $post->degree_description)?>
				<?php } else { ?>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus quod ad suscipit, necessitatibus deleniti temporibus similique exercitationem itaque officia molestias quos adipisci doloribus, aliquam qui! Repudiandae aliquam sequi accusantium culpa.</p>
				<?php } ?>
				<!-- Degree meta details -->
				<div class="row degree-details">
					<div class="span3">
						<dl>
							<dt>Degree:</dt>
							<dd><?=$post->tax_program_type[0]?><br></dd>
							<dt>Option:</dt>
							<dd>Dissertation<br></dd>
							<dt>Online Program:</dt>
							<dd>No</dd>
						</dl>
					</div>
					<div class="span5">
						<dl>
							<dt>College:</dt>
							<dd>
								<!-- TODO: better way of forcing linebreak after inline <dd>'s that is IE friendly? -->
								<a href="#"><?=$post->tax_college[0]?></a><br>
							</dd>
							<dt>Department:</dt>
							<dd>
								<a href="#"><?=$post->tax_department[0]?></a><br>
							</dd>
							<dt>Total Credit Hours:</dt>
							<dd>120</dd>
						</dl>
					</div>
				</div>

				<div class="visible-phone">
					<a class="btn btn-large btn-block btn-success">View Catalog</a>
					<a class="btn btn-large btn-block">Visit Program Website</a>
				</div>
			</article>
		</div>
		<div id="sidebar_right" class="span4 notoppad" role="complementary">

			<!-- Sidebar content -->

			<div class="hidden-phone">
				<a href="<?=$post->degree_pdf?>" target="_blank" class="btn btn-large btn-block btn-success">View Catalog</a>
				<a href="<?=$post->degree_website?>" class="btn btn-large btn-block">Visit Program Website</a>
			</div>

			<h2>Contact</h2>
			<h3 class="contact-name">Steve Sutton Ph.D.</h3>
			<span class="contact-title">Professor</span>
			<dl class="contact-info-dl">
				<dt>Email:</dt>
				<dd>
					<span class="contact-email">
						<?php if ($post->degree_email !== 'n/a') { ?><a href="mailto:<?=$post->degree_email?>"><?php } ?>
							<?=$post->degree_email?>
						<?php if ($post->degree_email !== 'n/a') { ?></a><?php } ?>
					</span>
					<br>
				</dd>
				<dt>Phone:</dt>
				<dd>
					<span class="contact-phone">
						<?php if ($post->degree_phone !== 'n/a') { ?><a href="tel:<?=$post->degree_phone?>"><?php } ?>
							<?=$post->degree_phone?>
						<?php if ($post->degree_phone !== 'n/a') { ?></a><?php } ?>
					</span>
					<br>
				</dd>
				<dt>Office:</dt>
				<dd>
					<span class="contact-office">
						<?php if ($post->degree_website !== 'n/a') { ?><a target="_blank" href="<?=$post->degree_website?>"><?php } ?>
							<?=$post->tax_college[0]?>
						<?php if ($post->degree_website !== 'n/a') { ?></a><?php } ?>
					</span>
				</dd>
			</dl>

		</div>
	</div>

<?php get_footer();?>
