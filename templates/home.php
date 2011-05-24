<?php get_header();?>
	
	<div id="home">
		<?php $gallery = get_page_by_title("Homepage Images");?>
		<?php if($gallery):?>
		<div class="slideshow">
			<?php echo $gallery->post_content; ?>
		</div>
		<?php endif;?>
	
		<!-- Left col -->
		<div class="span-18">
			<?php $ribbon = get_option("admissions_banner");?>
			<?php if($ribbon):?><h2 class="ribbon"><?=$ribbon?></h2><?php endif;?>
			
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					
				<div id="post-<?php the_ID(); ?>">
					
					<div class="span-11">
						<?php the_content(); ?>
					</div>
				
					<div class="widgets span-7 last">
						<div class="pad-l">
						</div>
					</div>
				</div>
			<?php endwhile; endif; ?>
		</div>
		
		<div class="span-6 last">
			<div class="pad-l">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
	
<?php get_footer();?>