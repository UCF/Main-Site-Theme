<?php $options = get_option(THEME_OPTIONS_NAME);?>
<div id="below-the-fold" class="span-24 last">
	<div class="span-14 append-1">
		<?php if($options['enable_news']): $count = $options['news_max_items'];?>
			<?php display_news('h2')?>
		<?php else:?>&nbsp;
			<?php debug("News feed is disabled.")?>
		<?php endif;?>
		<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Bottom Left')):?><?php endif;?>
	</div>
	<div class="span-9 last">
		<?php if($options['enable_events']): $count = $options['events_max_items'];?>
			<?php display_events('h2')?>
		<?php else:?>&nbsp;
			<?php debug("Events feed is disabled.")?>
		<?php endif;?>
		<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Bottom Right')):?><?php endif;?>
	</div>
</div>