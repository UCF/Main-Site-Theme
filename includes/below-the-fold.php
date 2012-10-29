<?php $options = get_option(THEME_OPTIONS_NAME);?>
<div class="row">
	<div id="below-the-fold" class="row-border-bottom-top">
		<div class="span4">
			<?php if($options['enable_flickr']):?>
				<?php display_flickr('h2')?>
				<div class="end"><!-- --></div>
			<?php else:?>&nbsp;
				<?php debug("Flickr images are disabled.")?>
			<?php endif;?>
			<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Bottom Left')):?><?php endif;?>
		</div>
		<div class="span4">
			<?php if($options['enable_news']):?>
				<?php display_news('h2')?>
			<?php else:?>&nbsp;
				<?php debug("News feed is disabled.")?>
			<?php endif;?>
			<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Bottom Center')):?><?php endif;?>
		</div>
		<div class="span4">
			<?php if($options['enable_events']):?>
				<?php display_events('h2')?>
			<?php else:?>&nbsp;
				<?php debug("Events feed is disabled.")?>
			<?php endif;?>
			<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Bottom Right')):?><?php endif;?>
		</div>
	</div>
</div>