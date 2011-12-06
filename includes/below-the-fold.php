<?php $options = get_option(THEME_OPTIONS_NAME);?>
<div id="below-the-fold" class="span-24 last">
	<div class="span-14 append-1">
		<?php if($options['enable_news']): $count = $options['news_max_items'];?>
			<?php $news = get_news(0, ($count) ? $count : 2);?>
			<?php if(count($news)):?>
				<h2><?=$news[0]->get_feed()->get_title()?></h2>
				<ul class="news">
					<?php foreach($news as $item): $image = get_article_image($item);?>
					<li class="item">
						<h3 class="title"><a href="<?=$item->get_link()?>" class="ignore-external title"><?=$item->get_title()?></a></h3>
						<p>
							<a class="image ignore-external" href="<?=$item->get_link()?>">
								<?php if($image):?>
								<img src="<?=$image?>" alt="Feed image for <?=$item->get_title()?>" />
								<?php endif;?>
							</a>
							<a class="description ignore-external"  href="<?=$item->get_link()?>">
								<?= $item->get_description();?>
							</a>
						</p>
						<div class="end"><!-- --></div>
					</li>
					<?php endforeach;?>
				</ul>
			<?php else:?>
				<p>Unable to fetch news.</p>
			<?php endif;?>
		<?php else:?>&nbsp;
			<?php debug("News feed is disabled.")?>
		<?php endif;?>
		<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Bottom Left')):?><?php endif;?>
	</div>
	<div class="span-9 last">
		<?php if($options['enable_events']): $count = $options['events_max_items'];?>
			<?php $events = get_events(0, ($count) ? $count : 3);?>
			<?php if(count($events)):?>
				<h2><?=$events[0]->get_feed()->get_title()?></h2>
				<table class="events">
					<?php foreach($events as $item):?>
					<tr class="item">
						<td class="date">
							<?php
								$month = $item->get_date("M");
								$day   = $item->get_date("j");
							?>
							<div class="month"><?=$month?></div>
							<div class="day"><?=$day?></div>
						</td>
						<td class="title">
							<a href="<?=$item->get_link()?>" class="wrap ignore-external"><?=$item->get_title()?></a>
						</td>
					</tr>
					<?php endforeach;?>
				</table>
			<?php else:?>
				<p>Unable to fetch events</p>
			<?php endif;?>
		<?php else:?>&nbsp;
			<?php debug("Events feed is disabled.")?>
		<?php endif;?>
		<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Bottom Right')):?><?php endif;?>
	</div>
</div>