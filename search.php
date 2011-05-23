<?php get_header();?>
	<div class="page-content" id="search-results">
		<div id="left" class="span-6 append-1">
			<h2>Search Results for: <?=esc_html(stripslashes($_GET['s']))?></h2>
			
			<div id="widgets">
				<ul>
				<?php if (get_post_meta($post->ID, '1st-subsidiary-aside', True)):?>
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('1st-subsidiary-aside') ) : ?>
				<?php endif; ?>
				<?php else:?>
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('secondary-aside') ) : ?>
				<?php endif; ?>
				<?php endif;?>
				</ul>
			</div>
		</div>
		<div id="right" class="span-17 last">
			<?php
				if (have_posts()) {
					// action hook creating the search loop
					thematic_searchloop();
				} else {
					thematic_abovepost();?>
					<div id="post-0" class="post noresults">
						<h3><?php _e('Nothing Found', 'thematic') ?></h3>
						<p><?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'thematic') ?></p>
						
						<form id="noresults-searchform" method="get" action="<?php bloginfo('url') ?>/">
							<div>
								<input id="noresults-s" name="s" type="text" value="<?php echo esc_html(stripslashes($_GET['s'])) ?>" size="40" />
								<input id="noresults-searchsubmit" name="searchsubmit" type="submit" value="<?php _e('Find', 'thematic') ?>" />
							</div>
						</form>
					</div><!-- #post -->
				<?php thematic_belowpost();
				}?>
		</div><!-- #container -->
<?php get_footer();?>