<?php
	$options = get_option(THEME_OPTIONS_NAME);
	$domain  = $options['search_domain'];
	$limit   = (int)$options['search_per_page'];
	$start   = (is_numeric($_GET['start'])) ? (int)$_GET['start'] : 0;
	$results = get_search_results($_GET['s'], $start, $limit, $domain);
?>
<?php get_header();?>
	<div class="page-content" id="search-results">
		<div class="results span-16 append-2">
			<h2>Search results</h2>
			<?php get_search_form()?>
			
			<?php if(count($results['items'])):?>
				
			<ul class="result-list">
				<?php foreach($results['items'] as $result):?>
				<li class="item">
					<h3>
						<a class="sans ignore-external title <?=mimetype_to_application(($result['mime']) ? $result['mime'] : 'text/html')?>" href="<?=$result['url']?>">
							<?=$result['title']?>
						</a>
					</h3>
					<a href="<?=$result['url']?>" class="ignore-external url sans"><?=$result['url']?></a>
					<div class="snippet sans">
						<?=str_replace('<br>', '', $result['snippet'])?>
					</div>
				</li>
				<?php endforeach;?>
			</ul>
			
			<?php if($start + $limit < $results['number']):?>
			<a class="button more" href="./?s=<?=$_GET['s']?>&amp;start=<?=$start + $limit?>">More Results</a>
			<?php endif;?>
			
			<?php else:?>
				
			<p>No results found for "<?=htmlentities($_GET['s'])?>".</p>
			
			<?php endif;?>
		</div>
		
		
		<div id="sidebar" class="span-6 last">
			<?php
				// Remove search widget if included, redundant on this page
				ob_start(); get_search_form(); $search  = ob_get_clean();
				ob_start(); get_sidebar()    ; $sidebar = ob_get_clean();
				$sidebar = str_replace($search, '', $sidebar);
			?>
			<?=$sidebar?>
		</div>
		
		<div id="below-the-fold" class="clear">
			<?php get_template_part('templates/below-the-fold'); ?>
		</div>
	</div>
<?php get_footer();?>