<?php get_header(); the_post();?>
	<?php $degrees = get_degrees(); ?>
	<div class="row page-content" id="academics-search">
		<div class="span12" id="page_title">
			<h1 class="span9"><?php the_title();?></h1>
			<?php esi_include('output_weather_data','span3'); ?>
		</div>
		
		<div id="sidebar_left" class="span2" role="navigation">
			<?=get_sidebar('left');?>
		</div>
		
		<div class="span10" id="contentcol">
			<article role="main">
				<p class="screen-only"><a href="<?=get_site_url()?>/academics/">&laquo; Back to Academics</a></p>
				
				<?php the_content(); ?>
			
				


				<?=display_degrees($degrees);?>



		<!--			
				<?php //if ($view !== NULL) { ?>
				<div id="results">
					<div class="row">	
						<h3 id="results-header" class="span10">
							<?=$results_count?> Result<?php if ($results_count == 0 || $results_count > 1) { ?>s<?php } ?> For: <span class="results-header-alt">
							<?php if ($view == 'browse') { ?>
								All <?=$degree_type_param?>
							<?php 
							} else if ($search_query_pretty) { ?>
								<?=$search_query_pretty?>
							<?php 
							}
							else { ?>
								All Majors
							<?php
							} ?>
							</span>
						</h3>
						
						<div class="span10">						
							<ul class="nav nav-tabs" id="degree-type-sort">
								<li id="degree-type-sort-header">Sort by:</li>
								<li class="dropdown <?=$sort_name_classes?>">
									<a class="print-noexpand" href="<?=$sort_name_url?>">Name <b class="caret"></b></a>
								</li>
								<li class="dropdown <?=$sort_college_classes?>">
									<a class="print-noexpand" href="<?=$sort_college_url?>">College <b class="caret"></b></a>
								</li>
								<li class="dropdown <?=$sort_hours_classes?>">
									<a class="print-noexpand" href="<?=$sort_hours_url?>">Hours <b class="caret"></b></a>
								</li>
							</ul>
						</div>
					</div>	
				</div>					
					
					<?php 
					if ($results) { 
						foreach ($results_sorted as $program_type => $programs) { 
						
							if ($program_type && count($programs) > 0) { ?>
								<h3 class="program-type"><?=$program_type?></h3>	
							
								<ul class="row results-list">
								
									<?php
									// Format program types to not use plural tense
									$program_type = substr($program_type, 0, (strlen($program_type) - 1));
								
									foreach ($programs as $program) {									
								
										// Dept Website link						
										$dept_website = '';
										if ($program->graduate) {
											$dept_website = 'http://www.graduatecatalog.ucf.edu/programs/program.aspx'.$program->required_hours;
										}
										elseif ($program->website) {
											$dept_website = $program->website;
										}
									?>
										<li class="program span10">
											<div class="row">
																				
												<div class="span7">
												<?php
													$website = null;
													if ($program->graduate) {
														$website = 'http://www.graduatecatalog.ucf.edu/programs/program.aspx'.$program->required_hours;
													}
													else {
														// Update program type degree names.
														switch ($program->type) {
															case 'major':
																if ($program->graduate == 0) {
																	$program->type = 'Undergraduate Degree';
																}
																else {
																	$program->type = 'Graduate Degree';
																}
																break;
															case 'articulated':
																$program->type = ucwords($program->type).' Program';
																break;
															case 'accelerated':
																$program->type = ucwords($program->type).' Program';
																break;
															default:
																$program->type = ucwords($program->type);
																break;
														}
														$args = array(
															'post_type' => 'degree',
															'posts_per_page' => 1,
															'meta_query' => array(
																array(
																	'key' => 'degree_id',
																	'value' => $program->id,
																),
																array(
																	'key' => 'degree_type_id',
																	'value' => $program->type_id,
																),
															),
															'tax_query' => array(
																array(
																	'taxonomy' => 'program_types',
																	'field' => 'slug',
																	'terms' => sanitize_title($program->type),
																),
															),
														);
														$post = get_posts($args);
														if ($post) {
															$post = $post[0];
															$website = get_permalink($post->ID);
														}
													}
													

												?>
												<?php if ($website) { ?><a href="<?=$website?>"><?php } ?>
													<h4 class="name"><?=trim($program->name)?></h4>
												<?php if ($website) { ?></a><?php } ?>
												
												<?php if ($program->college_name) { ?>
													<span class="name_label">College</span>
													<span class="college"><?=$program->college_name?></span>
												<?php } ?>
												
												<?php if ($program->department_name) { ?>
													<span class="name_label">Department</span>
													<span class="department">
														<?php if ($dept_website !== '') { ?><a href="<?=$dept_website?>"><?php } ?>
														<?=$program->department_name?>
														<?php if ($dept_website !== '') { ?></a><?php } ?>
													</span>
												<?php } ?>
												
												</div>
													
												<div class="credits-wrap">
													<span class="program-type-alt"><?=$program_type?></span>
												
													<?php if ($program->required_hours) { 
														if ($program->graduate) { ?>
														<a href="http://www.graduatecatalog.ucf.edu/programs/program.aspx<?=$program->required_hours?>">
															<span class="credits label label-warning">Click for credit hours</span>
														</a>
														<?php } elseif ($program->required_hours >= 100) { ?>
														<span class="credits label label-info"><?=$program->required_hours?> credit hours</span>
														<?php } elseif ($program->required_hours > 1 && $program->required_hours < 100) { ?>
														<span class="credits label label-success"><?=$program->required_hours?> credit hours</span>
														
													<?php }
													} else { ?>
														<span class="credits label">Credit hours n/a</span>
													<?php } ?>
												</div>
												
											</div>
										</li>
									<?php
									}
									?>
									</ul>	
									<hr />
								<?php
								}
							}	
						} else { ?>
							<?php if ($error !== '') { 
								print '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>'.$error.'</div>'; 
							} ?>
							<p>No results found.</p>
					<?php 
						}
					//} ?>
		-->			
					<br/>
					<p class="more-details">
						For more details and the complete undergraduate catalog, visit: <a href="http://www.catalog.sdes.ucf.edu/">www.catalog.sdes.ucf.edu/</a>.
					</p>
					<p class="more-details">
						For graduate programs and courses, visit: <a href="http://www.graduatecatalog.ucf.edu/">www.graduatecatalog.ucf.edu/</a>.
					</p>
				
			</article>
		</div>
	</div>
<?php get_footer(); ?>