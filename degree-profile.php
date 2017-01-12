<?php get_header(); ?>
<?php
	$search_page_url = get_permalink( get_page_by_title( 'Degree Search' ) );
	$css_gradient = "linear-gradient(to top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 80%, rgba(0, 0, 0, 0.6) 115%), ";
?>
</div>

<?php if ( $post->header_image ): ?>
<div class="container-fullwidth page-media degree-header" id="<?php echo $post->post_name; ?>">
	<div class="page-media-header" style="background-image: <?php echo $css_gradient; ?>url(<?php echo $post->header_image; ?>)">
<?php else: ?>
<div class="container-fullwidth page-media degree-header no-header-image" id="<?php echo $post->post_name; ?>">
	<div class="page-media-header" style="background-image: <?php echo $css_gradient; ?>">
<?php endif; ?>
		<div class="page-media-container container">
			<h1><?php echo $post->post_title; ?></h1>
		</div>
	</div>
</div>

<div class="container" id="degree-single">
	<div class="row">
		<div class="col-md-8 degree">
			<div id="contentcol">
				<dl class="degree-details clearfix">
					<dt>Degree:</dt>
					<dd><?php echo $post->tax_program_type->name; ?></dd>

					<?php if ( $post->tax_college ): ?>
					<dt>College:</dt>
					<dd>
						<?php
						$college_url = get_term_custom_meta( $post->tax_college->term_id, 'colleges', 'college_url' );
						if ( $college_url ):
						?>
						<a target="_blank" href="<?php echo $college_url; ?>"><?php echo $post->tax_college->name; ?></a>
						<?php else: ?>
						<?php echo $post->tax_college->name; ?>
						<?php endif;?>
					</dd>
					<?php endif; ?>

					<?php if ( $post->tax_department ): ?>
					<dt>Department:</dt>
					<dd>
						<?php if ( $post->degree_website && $post->degree_website !== 'n/a' ): ?>
							<a href="<?php echo $post->degree_website; ?>">
								<?php echo $post->tax_department->name; ?>
							</a>
						<?php else: ?>
							<?php echo $post->tax_department->name; ?>
						<?php endif; ?>
					</dd>
					<?php endif; ?>
				</dl>
				<div class="visible-xs call-to-action">
					<?php if ( $post->degree_hours ): ?>
						<h3 class="degree-credit-hours"><span class="hours"><?php echo $post->degree_hours; ?></span> total credit hours</h3>
					<?php endif; ?>
					<a href="<?php echo $post->application_url; ?>" class="btn btn-ucf-gold btn-lg btn-block">
						<span class="fa fa-pencil-square-o"></span> Apply Now
					</a>
					<a href="https://apply.ucf.edu/forms/campus-tour/" class="btn btn-ucf-gold btn-lg btn-block">
						<span class="fa fa-map-marker"></span> Visit UCF
					</a>
				</div>
				<div class="degree-description">
					<?php if ( $post->degree_description ) : ?>
						<?php echo apply_filters( 'the_content', $post->degree_description ); ?>
					<?php else : ?>
							You can find a full description of this degree in the
							<a data-ga-category="Degree Search" data-ga-action="Catalog Link Clicked" data-ga-label="<?php echo $post->post_title; ?>"
								href="<?php echo $post->degree_pdf; ?>" target="_blank">course catalog</a>.
					<?php endif; ?>
				</div>
				<div class="social-wrap">
					<?php echo display_social( get_permalink( $post->ID ), $post->post_title, 'UCF Degree: ' . $post->post_title, 'Check out this degree at the University of Central Florida.' ); ?>
				</div>
				<?php echo display_degree_callout( $post->ID ); ?>
				<div class="row">
					<div class="degree-promo-button-wrapper">
					<?php if ( $post->degree_pdf ) : ?>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<a href="<?php echo $post->degree_pdf; ?>" class="degree-promo-button">
								<span class="degree-promo-icon fa fa-file-pdf-o"></span> <span class="degree-promo-text">Download Catalog PDF</span>
							</a>
						</div>
					<?php endif; ?>
					<?php if ( $post->degree_website ) : ?>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<a href="<?php echo $post->degree_website; ?>" class="degree-promo-button">
								<span class="degree-promo-icon fa fa-external-link-square"></span> <span class="degree-promo-text">Visit Program Website</span>
							</a>
						</div>
					<?php endif; ?>
					</div>
				</div>
			</div>
		</div><!-- end .col-md-8 -->
		<div class="col-md-4" id="sidebar_right">
			<div class="hidden-xs call-to-action">
				<?php if ( $post->degree_hours ): ?>
					<h3 class="degree-credit-hours"><span class="hours"><?php echo $post->degree_hours; ?></span> total credit hours</h3>
				<?php endif; ?>
				<a href="<?php echo $post->application_url; ?>" class="btn btn-ucf-gold btn-lg btn-block">
					<span class="fa fa-pencil-square-o"></span> Apply Now
				</a>
				<a href="https://apply.ucf.edu/forms/campus-tour/" class="btn btn-ucf-gold btn-lg btn-block">
					<span class="fa fa-map-marker"></span> Visit UCF
				</a>
				<?php if ( !( $post->degree_hours ) ): ?>
					<div class="highlight-block tuition-missing-block">
						<a href="<?php echo $post->degree_pdf; ?>">See catalog for credit hours</a>
					</div>
				<?php endif; ?>
			</div>
			<?php if ( $post->tuition_estimates && $post->degree_hide_tuition != 'on' ) : ?>
				<div class="tuition-info">
				<h2>Tuition and Fees</h2>
					<ul class="nav nav-tabs" id="tuition-tabs">
						<li class="active"><a href="#in-state" data-toggle="tab">In State</a></li>
						<li><a href="#out-of-state" data-toggle="tab">Out of State</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="in-state">
							<?php if ( $post->tuition_value_message ) : ?>
								<div class="tuition-value-message">
									<?php echo $post->tuition_value_message; ?>
									<div class="highlight-block tuition-total-block">
										<div class="tuition-total">
											<p id="in-state-amount">$<?php echo number_format( (float)$post->tuition_estimates['in_state_rate'] * 30, 0 ); ?> <span class="tuition-period">per year</span></p>
										</div>
										<p class="tuition-description">The approximate tuition cost* for one year in this program at UCF based on a full time schedule (30 credit hours per year)</p>
									</div>
								</div>
							<?php endif; ?>
						</div>
						<div class="tab-pane" id="out-of-state">
							<?php if ( $post->tuition_value_message ) : ?>
								<div class="tuition-value-message">
									<?php echo $post->tuition_value_message; ?>
									<div class="highlight-block tuition-total-block">
										<div class="tuition-total">
											<p id="out-of-state-amount">$<?php echo number_format( (float)$post->tuition_estimates['out_of_state_rate'] * 30, 0 ); ?> <span class="tuition-period">per year</span></p>
										</div>
										<p class="tuition-description">The approximate tuition cost* for one year in this program at UCF based on a full time schedule (30 credit hours per year)</p>
									</div>
								</div>
							<?php endif; ?>
						</div>
						<p><small>*Visit our <a href="http://tuitionfees.ikm.ucf.edu/" target="blank">Tuition and Fees Website</a> for more information on the cost of this degree.</small></p>
					</div>
					<?php if ( $post->financial_aid_message ) : ?>
						<p class="financial-aid-message"><?php echo $post->financial_aid_message; ?><p/>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<div id="breadcrumbs" class="breadcrumbs-bottom clearfix">
		<!-- Note: link click is modified to go back 1 pg via js if last page was Degree Search -->
		<a id="breadcrumb-search" href="<?php echo $search_page_url; ?>">&laquo; Back to Degree Search</a>

		<ul class="breadcrumb-hierarchy breadcrumb">
			<li>
				<?php $programs_url = $search_page_url . '?' . http_build_query( array( 'program-type' => array( $post->tax_program_type->slug ) ) ); ?>
				<a href="<?php echo $programs_url; ?>"><?php echo $post->tax_program_type->name; ?>s</a>
			</li>
			<?php if ( $post->tax_college ): // Some programs may have been imported with colleges that were later deleted ?>
			<li>
				<?php $college_programs_url = $search_page_url . '?' . http_build_query( array( 'program-type' => array( $post->tax_program_type->slug ), 'college' => array( $post->tax_college->slug ) ) ); ?>
				<a href="<?php echo $college_programs_url; ?>"><?php echo $post->tax_college->name; ?></a>
			</li>
			<?php endif; ?>
			<li class="active">
				<?php the_title(); ?>
			</li>
		</ul>
	</div>
</div>
<div class="container">
	<?php get_footer( 'gray' );?>
