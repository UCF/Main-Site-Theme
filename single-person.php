<?php disallow_direct_load('single.php');?>
<?php get_header(); the_post();?>	
	
	<div class="row page-content person-profile" id="<?=$post->post_name?>">
		<div id="page_title" class="span12">
			<h1 class="span9">Profile: <?php the_title();?></h1>
			<?php esi_include('output_weather_data','span3'); ?>
		</div>
		<div class="span2 details">
			<?
				$title = get_post_meta($post->ID, 'person_jobtitle', True);
				$image_url = get_featured_image_url($post->ID);
				$email = get_post_meta($post->ID, 'person_email', True);
				$phones = Person::get_phones($post);
			?>
			<img src="<?=$image_url ? $image_url : get_bloginfo('stylesheet_directory').'/static/img/no-photo.jpg'?>" />
			<? if(count($phones)) { ?>
			<ul class="phones unstyled">
				<? foreach($phones as $phone) { ?>
				<li><?=$phone?></li>
				<? } ?>
			</ul>
			<? } ?>
			<? if($email != '') { ?>
			<hr />
			<a class="email" href="mailto:<?=$email?>"><?=$email?></a>
			<? } ?>
		</div>
		<div class="span10">
			<article role="main">
				<h2><?=$post->post_title?><?=($title == '') ?: ' - '.$title ?></h2>
				<?=$content = str_replace(']]>', ']]>', apply_filters('the_content', $post->post_content))?>
			</article>
		</div>
	</div>
	
	
<?php get_footer();?>