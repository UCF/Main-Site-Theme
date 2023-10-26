<?php
$post = isset( $post ) ? $post : get_queried_object();

$linkedin  = get_field( 'expert_linkedin_url', $post->ID );
$facebook  = get_field( 'expert_facebook_url', $post->ID );
$twitter   = get_field( 'expert_twitter_url', $post->ID );
$instagram = get_field( 'expert_instagram_url', $post->ID );
$other     = get_field( 'expert_other_url', $post->ID );

if ( $linkedin || $facebook || $twitter || $instagram || $other ) : ?>

<h3 class="h6">Social Media</h3>
<ul class="list-inline">
<?php if ( $linkedin ) : ?>
    <li class="list-inline-item">
        <a href="<?php echo $linkedin; ?>" target="_blank" rel="nofollow">
            <span class="fa fa-linkedin-square fa-lg text-secondary"></span><span class="sr-only"><?php the_title(); ?>'s Linkedin Profile
        </a>
    </li>
<?php endif; ?>
<?php if ( $facebook ) : ?>
    <li class="list-inline-item">
        <a href="<?php echo $facebook; ?>" target="_blank" rel="nofollow">
            <span class="fa fa-facebook-square fa-lg text-secondary"></span><span class="sr-only"><?php the_title(); ?>'s Facebook Profile
        </a>
    </li>
<?php endif; ?>
<?php if ( $twitter ) : ?>
    <li class="list-inline-item">
        <a href="<?php echo $twitter; ?>" target="_blank" rel="nofollow">
            <span class="fa fa-twitter-square fa-lg text-secondary"></span><span class="sr-only"><?php the_title(); ?>'s Twitter Profile
        </a>
    </li>
<?php endif; ?>
<?php if ( $instagram ) : ?>
    <li class="list-inline-item">
        <a href="<?php echo $instagram; ?>" target="_blank" rel="nofollow">
            <span class="fa fa-instagram fa-lg text-secondary"></span><span class="sr-only"><?php the_title(); ?>'s Instagram Profile
        </a>
    </li>
<?php endif; ?>
<?php if ( $other ) : ?>
    <li class="list-inline-item">
        <a href="<?php echo $other; ?>" target="_blank" rel="nofollow">
            <span class="fa fa-globe fa-lg text-secondary"></span><span class="sr-only"><?php the_title(); ?>'s Website
        </a>
    </li>
<?php endif; ?>
</ul>

<?php endif; ?>