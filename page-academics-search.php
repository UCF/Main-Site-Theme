<?php

// Are any GET params set? If so, build a query for the search service
$query_string	  = $_SERVER['QUERY_STRING'];
$get_params_exist = ($query_string !== '') ? true : false;

if ($get_params_exist == true) {
	// Assign GET params to variables, as well as other variables for the search/browse interface
	$view 			= NULL;
	if (isset($_POST['submit'])) { 
		$view = 'search'; 
	}
	if ($get_params_exist == true && !isset($_POST['submit'])) { 
		$view = 'browse'; 
	}
	$search_query 	= $_GET['search_query'] ? urlencode($_GET['search_query']) : '';
	$program_type	= $_GET['program_type']; // undergrad/undergrad_grad/grad 
	$degree_type	= $_GET['degree_type'];  // major/minor/grad/cert
	$college		= $_GET['college'];
	$sortby			= $_GET['sortby'];
	$sort			= $_GET['sort'] ? $_GET['sort'] : 'ASC';
	$flip_sort		= ($sort == 'ASC') ? 'DESC' : 'ASC';
	
	// Build an array of query params based on GET params passed
	$query_array = array(
		'use'	=> 'programSearch',
	);	
	
	if ($search) 			{ $query_array['search']  = $search; }
	if ($college)			{ $query_array['college'] = $college; }
	
	if ($sortby)			{
		$query_array['order_by'] = $sortby.' '.$sort;
	} else 					{
		$query_array['order_by'] = 'score DESC';
	}
	
	if ($sortby != 'name') 	{
		$query_array['order_by'] .= ', name ASC';
	}	
	if ($search_query)		{ $query_array['search'] 	= $search_query; }
	if ($degree_type) 		{ $query_array['in'] 		= $degree_type; } 
	
	$query_array['graduate'] = 0;
	if ( ($program_type == 'undergrad_grad') || ($program_type == 'grad') ) {
		$query_array['graduate'] = 1;
	}	 
	if ($college && $college == 'College of Graduate Studies') {
		$query_array['graduate'] = 1;
	}
	
	
	// Grab results
	$results = query_search_service($query_array);
	
	//var_dump($query_array);
	//var_dump($results);
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
				
				<?php if ($error !== '') { print '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>'.$error.'</div>'; } ?>
			
				<div id="filters">
					<h3>Search:</h3>
					<div class="controls controls-row">
						<form id="course_search_form" action="<?=get_permalink()?>" class="form-search">
							<select name="program_type" class="span4">
								<option value="undergrad" <?php if ($program_type == 'undergrad') { ?>selected="selected"<?php } ?>>Undergraduate Programs Only</option>
								<option value="undergrad_grad" <?php if ($program_type == 'undergrad_grad') { ?>selected="selected"<?php } ?>>Undergraduate and Graduate Programs</option>
								<option value="grad" <?php if ($program_type == 'grad') { ?>selected="selected"<?php } ?>>Graduate Programs Only</option>
							</select>	
							<div class="input-append span3">
								<input type="text" class="search-query" name="search_query" value="<?=$search_query?>" />
								<button type="submit" class="btn"><i class="icon-search"></i> Search</button>
							</div>
						</form>
					</div>
				</div>
				
				<div id="browse">
					<h3>Browse: <?php if ($view == 'browse') { ?><span class="browse_header_alt"><?=$degree_type?></span><?php } ?></h3>
					<ul>
						<li><a href="<?=get_permalink()?>?program_type=undergrad&amp;degree_type=major&amp;sortby=name&amp;sort=ASC">Majors</a></li>
						<li><a href="<?=get_permalink()?>?program_type=undergrad&amp;degree_type=minor&amp;sortby=name&amp;sort=ASC">Minors</a></li>
						<li><a href="<?=get_permalink()?>?program_type=grad&amp;sortby=name&amp;sort=ASC">Graduate Programs</a></li>
						<li><a href="<?=get_permalink()?>?program_type=grad&amp;degree_type=certificate&amp;sortby=name&amp;sort=ASC">Certificates</a></li>
					</ul>
					
					<?php if ($view !== NULL) { ?>
					
						<?php
							// Create links per sort option
							if (strpos($query_string, 'sortby=').count < 1) {
								$query_string = $query_string.'&amp;sortby='.$sortby;
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
						?>
						
						<ul class="nav nav-tabs">
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
							// output data
							foreach ($results as $program) { 
								$website = '';
								if ($program->graduate) {
									$website = 'http://www.graduatecatalog.ucf.edu/programs/program.aspx'.$program->required_hours;
								}
								elseif ($program->website) {
									$website = $program->website;
								}
							?>
								<li class="program span10">
									<div class="row">
									<?php if ($website !== '') { ?>
										<a href="<?=$website?>">
									<?php } ?>
											<div class="span8">
												<h4 class="name"><?=trim($program->name)?></h4>
												<span class="college"><?=$program->college_name?></span>
												<span class="department"><?=$program->department_name?></span>
											</div>
											<div class="span2">
												<?php if ($program->required_hours) { 
													if ($program->graduate) { ?>
													<a href="http://www.graduatecatalog.ucf.edu/programs/program.aspx<?=$program->required_hours?>">
														<span class="credits label label-warning">Click for credit hours</span>
													</a>
													<?php } elseif ($program->required_hours > 100) { ?>
													<span class="credits label label-info"><?=$program->required_hours?> credit hours</span>
													<?php } else { ?>
													<span class="credits label label-success"><?=$program->required_hours?> credit hours</span>
													<?php }
												} ?>
											</div>
										</a>
									</div>
								</li>
							<?php
							}
							?>
							</ul>
							<?php	
						}
						elseif (!$results && $view !== NULL) { ?>
							<p>No results found.</p>
						<?php
						}
					?>
					
				<?php } // endif ?>
				
			</article>
		</div>
	</div>
<?php get_footer(); ?>