<?php

// Are any GET params set? If so, build a query for the search service
$query_string	  = $_SERVER['QUERY_STRING'];
$get_params_exist = ($query_string !== '') ? true : false;

if ($get_params_exist == true) {
	
	// Assign GET params to variables, as well as other variables for the search/browse interface
	$view 			= NULL;
	$is_search		= $_GET['is_search'];
	if ($is_search == true) { 
		$view = 'search'; 
	}
	if ($get_params_exist == true && !$_GET['is_search']) { 
		$view = 'browse';
	}
	$search_query 	= $_GET['search_query'] ? urlencode($_GET['search_query']) : '';
	$program_type	= $_GET['program_type']; // undergrad/undergrad_grad/grad 
	$degree_type	= $_GET['degree_type'];  // major/minor/grad/cert
	$college		= $_GET['college'];
	$sortby			= $_GET['sortby'] ? $_GET['sortby'] : 'name';
	$sort			= $_GET['sort'] ? $_GET['sort'] : 'ASC';
	$flip_sort		= ($sort == 'ASC') ? 'DESC' : 'ASC';
	
	// Build an array of query params based on GET params passed
	$query_array = array(
		'use'	=> 'programSearch',
	);	
	
	if ($college)			{ $query_array['college'] = $college; }
	
	$query_array['order_by'] = $sortby.' '.$sort;
	
	if ($sortby != 'name') 	{
		$query_array['order_by'] .= ', name ASC';
	}	
	if ($search_query)		{ $query_array['search'] 	= $search_query; }
	if ($degree_type && $degree_type !== 'grad') { $query_array['in'] = $degree_type; }
	
	$query_array['graduate'] = 0;
	if ($program_type == 'grad') {
		$query_array['graduate'] = 1;
	}	 
	if ($college && $college == 'College of Graduate Studies') {
		$query_array['graduate'] = 1;
	}
	
	// Grab results
	if ($is_search && $search_query == '') {
		$error = '<strong>Error:</strong> Please enter a search term.';
	}
	elseif ($program_type == 'undergrad_grad') {
		// Undergrad + Grad searches must query twice to get both 'graduate' value results
		$undergrad_results = query_search_service($query_array);
		$query_array['graduate'] = 1;
		$grad_results = query_search_service($query_array);
		$results = array_merge((array) $undergrad_results, (array) $grad_results);
	}
	else {
		$results = query_search_service($query_array);
	}
	
	// Sort results by degree type
	$majors = array_filter($results, create_function('$p', '
		return $p->type === "major" && $p->graduate === "0";
	'));
	$minors = array_filter($results, create_function('$p', '
		return $p->type === "minor";
	'));
	$grad_programs = array_filter($results, create_function('$p', '
		return $p->type === "major" && $p->graduate === "1";
	'));
	$certificates = array_filter($results, create_function('$p', '
		return $p->type === "certificate";
	'));
	$articulated = array_filter($results, create_function('$p', '
		return $p->type === "articulated";
	'));
	$accelerated = array_filter($results, create_function('$p', '
		return $p->type === "accelerated";
	'));
	
	$results_sorted = array(
		'Undergraduate Degrees' => $majors,
		'Graduate Degrees'		=> $grad_programs,
		'Minors'       			=> $minors,
		'Certificates' 			=> $certificates,
		'Articulated'  			=> $articulated,
		'Accelerated'  			=> $accelerated,
	);
	
	
	// Format degree type names from $_GET for use in body content
	switch ($degree_type) {
		case 'grad':
			$degree_type_param = 'Graduate Programs';
			break;
		case 'major':
			$degree_type_param = 'Majors';
			break;
		case 'minor':
			$degree_type_param = 'Minors';
			break;
		case 'certificate':
			$degree_type_param = 'Certificates';
			break;
		default:
			break;
	}
	
	// Add selected state to program type dropdown
	$undergrad_sel = $undergrad_grad_sel = $grad_sel = '';
	$selected_val = 'selected="selected"';
	switch ($program_type) {
		case 'undergrad':
			$undergrad_sel = $selected_val;
			break;
		case 'undergrad_grad':
			$undergrad_grad_sel = $selected_val;
			break;
		case 'grad':
			$grad_sel = $selected_val;
			break;
		default:
			break;
	}
	
	// Add active state class to degree type navigation links
	$majors_classes = $minors_classes = $grad_classes = $cert_classes = '';
	$active_val = 'active';
	switch ($degree_type) {
		case 'major':
			$majors_classes = $active_val;
			break;
		case 'minor':
			$minors_classes = $active_val;
			break;
		case 'grad':
			$grad_classes = $active_val;
			break;
		case 'certificate':
			$cert_classes = $active_val;
			break;
		default:
			break;					
	}
	
	// Create links per sort option (Name/College/Hours)
	if (strpos($query_string, 'sortby=').count < 1) {
		$query_string = $query_string.'&amp;sortby='.$sortby;
	}
	if (strpos($query_string, 'sort=').count < 1) {
		$query_string = $query_string.'&amp;sort='.$sort;
	}
	if (strpos($query_string, 'degree_type=').count < 1) {
		$query_string = $query_string.'&amp;degree_type='.$degree_type;
	}
								
	$flip_url 				= get_permalink().'?'.str_replace('sort='.$sort, 'sort='.$flip_sort, $query_string);
		
	$sort_name_url 			= ($sortby == 'name') ? $flip_url : get_permalink().'?'.str_replace('sortby='.$sortby, 'sortby=name', $query_string);
	$sort_college_url 		= ($sortby == 'college_name') ? $flip_url : get_permalink().'?'.str_replace('sortby='.$sortby, 'sortby=college_name', $query_string);
	$sort_hours_url 		= ($sortby == 'required_hours') ? $flip_url : get_permalink().'?'.str_replace('sortby='.$sortby, 'sortby=required_hours', $query_string);
								
	$sort_name_classes		= '';
	if ($flip_sort == 'ASC' && $sortby == 'name') 			{ $sort_name_classes .= 'dropup '; }
	if ($sortby == 'name') 									{ $sort_name_classes .= 'active'; }
	
	$sort_college_classes 	= '';
	if ($flip_sort == 'ASC' && $sortby == 'college_name') 	{ $sort_college_classes .= 'dropup '; }
	if ($sortby == 'college_name') 							{ $sort_college_classes .= 'active'; }
	
	$sort_hours_classes		= '';
	if ($flip_sort == 'ASC' && $sortby == 'required_hours') { $sort_hours_classes .= 'dropup '; }
	if ($sortby == 'required_hours') 						{ $sort_hours_classes .= 'active'; }
	
}
?>


<?php get_header(); the_post();?>
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="span12" id="page_title">
			<h1 class="span9"><?php the_title();?></h1>
			<?php esi_include('output_weather_data(\'span3\');'); ?>
		</div>
		
		<div id="sidebar_left" class="span2" role="navigation">
			<?=get_sidebar('left');?>
		</div>
		
		<div class="span10" id="contentcol">
			<article role="main">
				<p><a href="<?=get_site_url()?>/academics/">&laquo; Back to Academics</a></p>
				
				<?php the_content(); ?>
			
				<div id="filters">
					<h3>Search:</h3>
					<div class="controls controls-row">
						<form id="course_search_form" action="<?=get_permalink()?>" class="form-search">
							<select name="program_type" class="span4">
								<option value="undergrad" <?=$undergrad_sel?>>Undergraduate Programs Only</option>
								<option value="undergrad_grad" <?=$undergrad_grad_sel?>>Undergraduate and Graduate Programs</option>
								<option value="grad" <?=$grad_sel?>>Graduate Programs Only</option>
							</select>
							<div class="input-append span3">
								<input type="text" class="search-query" name="search_query" value="<?=$search_query?>" />
								<input type="hidden" name="is_search" value="true" />
								<button type="submit" class="btn"><i class="icon-search"></i> Search</button>
							</div>
						</form>
					</div>
				</div>
				
				<div id="browse">
					<div class="row">
						<h3 id="degree-type-header" class="span4">Browse: <?php if ($view == 'browse') { ?><span class="browse-header-alt"><?=$degree_type_param?></span><?php } ?></h3>
						<div class="span6">
							<ul class="nav nav-pills" role="navigation" id="degree-type-list">
								<li class="<?=$majors_classes?>"><a href="<?=get_permalink()?>?program_type=undergrad&amp;degree_type=major&amp;sortby=name&amp;sort=ASC">Majors</a></li>
								<li class="<?=$minors_classes?>"><a href="<?=get_permalink()?>?program_type=undergrad&amp;degree_type=minor&amp;sortby=name&amp;sort=ASC">Minors</a></li>
								<li class="<?=$grad_classes?>"><a href="<?=get_permalink()?>?program_type=grad&amp;degree_type=grad&amp;sortby=name&amp;sort=ASC">Graduate Programs</a></li>
								<li class="<?=$cert_classes?>"><a href="<?=get_permalink()?>?program_type=grad&amp;degree_type=certificate&amp;sortby=name&amp;sort=ASC">Certificates</a></li>
							</ul>
						</div>
					</div>
					
					<?php if ($view !== NULL) { ?>
											
						<ul class="nav nav-tabs" id="degree-type-sort">
							<li style="padding:9px 15px 0 0;"><strong>Sort by: </strong></li>
							<li class="dropdown <?=$sort_name_classes?>">
								<a href="<?=$sort_name_url?>">Name <b class="caret"></b></a>
							</li>
							<li class="dropdown <?=$sort_college_classes?>">
								<a href="<?=$sort_college_url?>">College <b class="caret"></b></a>
							</li>
							<li class="dropdown <?=$sort_hours_classes?>">
								<a href="<?=$sort_hours_url?>">Hours <b class="caret"></b></a>
							</li>
						</ul>
						
				</div>					
					
					<?php 
						if ($results) { ?>
							<ul class="row" id="results">
							<?php
							foreach ($results_sorted as $program_type => $programs) { 	
							
								if ($program_type && count($programs) > 0) { ?>
									<h3 class="span10 program-type"><?=$program_type?></h3>	
								<?php }
							
								foreach ($programs as $program) {									
							
									// Dept Website link						
									$dept_website = '';
									if ($program->graduate) {
										$dept_website = 'http://www.graduatecatalog.ucf.edu/programs/program.aspx'.$program->required_hours;
									}
									elseif ($program->website) {
										$dept_website = $program->website;
									}
									// Format degree type values
									switch ($program->type) {
										case 'major':
											$degree_type_val = 'Undergraduate Major';
											break;
										case 'minor':
											$degree_type_val = 'Undergraduate Minor';
											break;
										case 'accelerated':
											$degree_type_val = 'Accelerated Program';
											break;
										case 'articulated':
											$degree_type_val = 'Articulated Program';
											break;
										default:
											$degree_type_val = ucwords($program->type);
											break;										
									}
									if ($program->graduate && $program->type !== 'certificate') {
										$degree_type_val = 'Graduate Program';
									}
								?>
									<li class="program span10">
										<div class="row">
																			
											<div class="span7">
											<?php if ($dept_website !== '') { ?><a href="<?=$dept_website?>"><?php } ?>
												<h4 class="name"><?=trim($program->name)?></h4>
											<?php if ($dept_website !== '') { ?></a><?php } ?>
											
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
												
											<div class="credits_wrap">
												<span class="name-alt"><?=$degree_type_val?></span>
											
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
								} // endforeach
								
							}
							?>
							</ul>
							<?php	
						} // if ($results)
						elseif (!$results && $view !== NULL) { ?>
							<?php if ($error !== '') { 
								print '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>'.$error.'</div>'; 
							} ?>
							<p>No results found.</p>
					
					<?php 
						} // end elseif (!$results && $view !== NULL)
					} // endif ($view !== null) 
					?>
				
			</article>
		</div>
	</div>
<?php get_footer(); ?>