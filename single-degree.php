<?php disallow_direct_load('single-degree.php');?>
<?php get_header(); the_post();?>
<?php
	$post = append_degree_metadata( $post, true );
	$search_page_url = get_permalink( get_page_by_title( 'Degree Search' ) );
?>
	<div class="row page-content" id="degree-single">
		<div id="page_title" class="span12">
			<h1 class="span9"><?php the_title(); ?></h1>
			<?php esi_include( 'output_weather_data', 'span3' ); ?>
		</div>

		<div id="breadcrumbs" class="span12 clearfix">
			<!-- Note: link click is modified to go back 1 pg via js if last page was Degree Search -->
			<a id="breadcrumb-search" href="<?php echo $search_page_url; ?>">&laquo; Back to Degree Search</a>

			<ul class="breadcrumb-hierarchy breadcrumb">
				<li>
					<?php $programs_url = $search_page_url . '?' . http_build_query( array( 'program-type' => array( $post->tax_program_type->slug ) ) ); ?>
					<a href="<?php echo $programs_url; ?>"><?php echo $post->tax_program_type->name; ?>s</a> <span class="divider">&gt;</span>
				</li>
				<?php if ( $post->tax_college ): // Some programs may have been imported with colleges that were later deleted ?>
				<li>
					<?php $college_programs_url = $search_page_url . '?' . http_build_query( array( 'program-type' => array( $post->tax_program_type->slug ), 'college' => array( $post->tax_college->slug ) ) ); ?>
					<a href="<?php echo $college_programs_url; ?>"><?php echo $post->tax_college->name; ?></a> <span class="divider">&gt;</span>
				</li>
				<?php endif; ?>
				<li class="active">
					<?php the_title(); ?>
				</li>
			</ul>
		</div>

		<div id="contentcol" class="span8 degree">
			<article role="main">
				<!-- Degree meta details -->
				<div class="row">
					<div class="span8">
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
							<dt>Total Credit Hours:</dt>
							<dd>
								<?php if ( $post->degree_hours ): ?>
									<?php echo $post->degree_hours; ?> credit hours
								<?php else: ?>
									<a href="<?php echo $post->degree_pdf; ?>">See catalog for credit hours</a>
								<?php endif; ?>
							</dd>
						</dl>
					</div>
				</div>

				<div class="mobile-degree-cta visible-phone">
					<a data-ga-category="Degree Search" data-ga-action="Catalog Link Clicked" data-ga-value="<?php echo $post->post_title; ?>" href="<?php echo $post->degree_pdf; ?>" target="_blank" class="ga-event btn btn-large btn-block btn-success">
						View Catalog
					</a>
					<?php if ( $post->degree_website ): ?>
					<a data-ga-category="Degree Search" data-ga-action="Program Page Clicked" data-ga-value="<?php echo $post->post_title; ?>" href="<?php echo $post->degree_website; ?>" class="ga-event btn btn-large btn-block">
						Visit Program Website
					</a>
					<?php endif; ?>
				</div>	

				<!-- Degree description -->
				<div class="degree-description">
					<?php if ( $post->degree_description ) { ?>
						<?php echo apply_filters( 'the_content', $post->degree_description ); ?>
					<?php } else { ?>
							You can find a full description of this degree in the 
							<a data-ga-category="Degree Search" data-ga-action="Catalog Link Clicked" data-ga-value="<?php echo $post->post_title; ?>" 
								href="<?php echo $post->degree_pdf; ?>" target="_blank">course catalog</a>.
					<?php } ?>
				</div>	

				<?php if ( $post->post_content ) { ?>
					<hr>
					<h2>About This Degree</h2>
					<?php the_content(); ?>
				<?php } ?>			
				<div class="social-wrap">
					<?php echo display_social( get_permalink( $post->ID ), $post->post_title ); ?>
				</div>

				<?php echo display_degree_callout( $post->ID ); ?>
			</article>
		</div>
		<div id="sidebar_right" class="span4 notoppad" role="complementary">

			<!-- Sidebar content -->

			<div class="hidden-phone">
				<a data-ga-category="Degree Search" data-ga-action="Catalog Link Clicked" data-ga-value="<?php echo $post->post_title; ?>" href="<?php echo $post->degree_pdf; ?>" target="_blank" class="ga-event btn btn-large btn-block btn-success">
					View Catalog
				</a>
				<?php if ( $post->degree_website ): ?>
				<a data-ga-category="Degree Search" data-ga-action="Program Page Clicked" data-ga-value="<?php echo $post->post_title; ?>" href="<?php echo $post->degree_website; ?>" class="ga-event btn btn-large btn-block">
					Visit Program Website
				</a>
				<?php endif; ?>
			</div>
			
			<?php
			if ( $post->degree_phone || $post->degree_email || $post->degree_contacts ) : ?>
				<h2>Contact</h2>

				<?php if ( $post->degree_phone || $post->degree_email ): ?>
					<div class="contact-info">
						<h3 class="contact-name">General Inquiries</h3>
						<dl class="contact-info-dl clearfix">
							<?php if ( $post->degree_email ) : ?>
								<dt>Email:</dt>
								<dd>
									<span class="contact-email">
										<a href="mailto:<?php echo $post->degree_email; ?>">
											<?php echo $post->degree_email; ?>
										</a>
									</span>
								</dd>
							<?php endif; ?>
							<?php if ( $post->degree_phone ) : ?>
								<dt>Phone:</dt>
								<dd>
									<span class="contact-phone">
										<a href="tel:<?php echo $post->degree_phone; ?>">
											<?php echo $post->degree_phone; ?>
										</a>
									</span>
								</dd>
							<?php endif; ?>
						</dl>
					</div>
				<?php endif;?>

				<?php
				if ( $post->degree_contacts ):
					foreach ( $post->degree_contacts as $contact ) :
				?>
					<div class="contact-info">
						<h3 class="contact-name"><?php echo $contact['contact_name']; ?></h3>
						<dl class="contact-info-dl clearfix">
							<?php if ( ! empty( $contact['contact_email'] ) ) : ?>
								<dt>Email:</dt>
								<dd>
									<span class="contact-email">
										<a href="mailto:<?php echo $contact['contact_email']; ?>">
											<?php echo $contact['contact_email']; ?>
										</a>
									</span>
								</dd>
							<?php endif; ?>
							<?php if ( ! empty( $contact['contact_phone'] ) ) : ?>
								<dt>Phone:</dt>
								<dd>
									<span class="contact-phone">
										<a href="tel:<?php echo $contact['contact_phone']; ?>">
											<?php echo $contact['contact_phone']; ?>
										</a>
									</span>
								</dd>
							<?php endif; ?>
						</dl>
					</div>
			<?php
					endforeach;
				endif;
			endif
			?>
		<?php if ( $post->tuition_estimates ) : ?>
			<div class="tuition-info">
			<h2>Tuition and Fees</h2>
				<ul class="nav nav-tabs" id="tuition-tabs">
					<li class="active"><a href="#in-state" data-toggle="tab">In State Tuition</a></li>
					<li><a href="#out-of-state" data-toggle="tab">Out of State Tuition</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="in-state">
						<dl class="tuition-info-dl">
							<dt>National Average</dt>
							<dd>$<?php echo number_format( $post->tuition_estimates['in_state_national_rate'], 2 ); ?></dd>
							<dt><span style="color: #c90;">UCF</span> Tuition</dt>
							<dd>$<?php echo number_format( $post->tuition_estimates['in_state_rate'], 2 ); ?></dd>
							<dt>Less than national average</dt>
							<dd>$<?php 
								echo number_format(
									($post->tuition_estimates['in_state_national_rate'] - $post->tuition_estimates['in_state_rate'] ),
									2
								);
								?>
							</dd>
							<dt>National Average Program</dt>
							<dd>$<?php echo number_format( $post->tuition_estimates['in_state_program_national_rate'], 2 ); ?></dd>
							<dt><span style="color: #c90;">UCF</span> Program Tuition</dt>
							<dd>$<?php echo number_format( $post->tuition_estimates['in_state_program_rate'], 2 ); ?></dd>
							<dt>Less than national average</dt>
							<dd>$<?php 
								echo number_format(
									( $post->tuition_estimates['in_state_program_national_rate'] - $post->tuition_estimates['in_state_program_rate'] ),
									2
								);
								?>
							</dd>
						</dl>
					</div>
					<div class="tab-pane" id="out-of-state">
						<dl class="tuition-info-dl">
							<dt>National Average</dt>
							<dd>$<?php echo number_format( $post->tuition_estimates['out_of_state_national_rate'], 2 ); ?></dd>
							<dt><span style="color: #c90;">UCF</span> Tuition</dt>
							<dd>$<?php echo number_format( $post->tuition_estimates['out_of_state_rate'], 2 ); ?></dd>
							<dt>Less than national average</dt>
							<dd>$<?php 
								echo number_format(
									($post->tuition_estimates['out_of_state_national_rate'] - $post->tuition_estimates['out_of_state_rate'] ),
									2
								);
								?>
							</dd>
							<dt>National Average Program</dt>
							<dd>$<?php echo number_format( $post->tuition_estimates['out_of_state_program_national_rate'], 2 ); ?></dd>
							<dt><span style="color: #c90;">UCF</span> Program Tuition</dt>
							<dd>$<?php echo number_format( $post->tuition_estimates['out_of_state_program_rate'], 2 ); ?></dd>
							<dt>Less than national average</dt>
							<dd>$<?php 
								echo number_format(
									( $post->tuition_estimates['out_of_state_program_national_rate'] - $post->tuition_estimates['out_of_state_program_rate'] ),
									2
								);
								?>
							</dd>
						</dl>
					</div>
				</div>
				<!--<p class="disclaimer">*All tuition figures given are estimates based on the current tuition and fees mulitplied by the number of credit hours required for the degree. For more information please see the <a href="http://tuitionfees.smca.ucf.edu">Tuition and Fees</a> page.</p>-->
			</div>
		<?php endif; ?>
		</div>
	</div>
	<input type="hidden" id="program_type" value="<?php echo $post->tax_program_type->slug; ?>" />
	<input type="hidden" id="credit_hours" value="<?php echo $post->degree_hours; ?>" />
<?php get_footer();?>
