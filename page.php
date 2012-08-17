<?php get_header(); the_post();?>
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="span12">
			<h1><?php the_title();?></h1>
		</div>
		
		<?php 
		if (get_post_meta($post->ID, 'page_subheader', TRUE) !== '') {
			$subheader = get_post(get_post_meta($post->ID, 'page_subheader', TRUE));			
		?>
			<div class="span12" id="subheader">
				<?php
				$subimg = get_post_meta($subheader->ID, 'subheader_sub_image', TRUE);
				$imgatts = array(
					'class'	=> "subheader_subimg span2",
					'alt'   => $post->post_title,
					'title' => $post->post_title,
				);
				print wp_get_attachment_image($subimg, 'subpage-subimg', 0, $imgatts);
				?>
				<blockquote class="subhead_quote span8">
					<?=$subheader->post_content?>
					<p class="subhead_author"><?=get_post_meta($subheader->ID, 'subheader_student_name', TRUE)?></p>
					<p class="subhead_quotelink"><a href="<?=get_permalink(get_page_by_title( 'Submit a Quote About UCF', OBJECT, 'page' )->ID)?>">Submit a quote &raquo;</a></p>
				</blockquote>
				
				<?php
				$studentimg = get_post_meta($subheader->ID, 'subheader_student_image', TRUE);
				$imgatts = array(
					'class'	=> "subheader_studentimg",
					'alt'   => get_post_meta($subheader->ID, 'subheader_student_name', TRUE),
					'title' => get_post_meta($subheader->ID, 'subheader_student_name', TRUE),
				);
				print wp_get_attachment_image($studentimg, 'subpage-studentimg', 0, $imgatts);
				?>
			</div>
		<?php
		} ?>
		
		<div id="sidebar_left" class="span2">
			<?=get_sidebar('left');?>
		</div>
		
		<div class="span7" id="contentcol">
			<article>
				<?php the_content();?>
			</article>
		</div>
		
		<div id="sidebar_right" class="span3">		
			<?=get_sidebar('right');?>
		</div>
	</div>
<?php get_footer();?>