<?php
/**
 * Template Name: Media Feature
 **/
?>
<?php get_header(); the_post(); ?>

</div> <!-- close .container -->


<style>
/* Media header page template */
#header-nav-wrap {
	z-index: 2;
}

@media (max-width: 480px) {
	#header-nav-wrap {
		left: 20px; /* gutter width */
		position: absolute;
		right: 20px;
	}
}

.page-media {
	position: relative;
	top: -70px;
	z-index: 1;
}

@media (max-width: 767px) {
	.page-media {
		margin-left: -20px;
		margin-right: -20px;
		top: -96px;
	}
}

@media (max-width: 480px) {
	.page-media {
		top: -72px;
	}
}

.page-media-header {
	box-sizing: border-box;
	height: 550px;
	overflow: hidden;
	position: relative;
	z-index: -1;
}

/* CSS-only full-width bg video. IE9+ */
.page-media-header video {
	height: auto;
	min-width: 100%;
	min-height: 100%;
	left: 50%;
	overflow: hidden;
	position: absolute;
	top: 50%;
	-webkit-transform: translateX(-50%) translateY(-50%);
	-ms-transform: translateX(-50%) translateY(-50%);
	transform: translateX(-50%) translateY(-50%);
	width: auto;
	z-index: -1000;
}

@media (max-width: 767px) {
	.page-media-header video {
		display: none;
	}
}

.page-media-container {
	padding-top: 70px;
	position: absolute;
	z-index: 2;
}

@media (max-width: 767px) {
	.page-media-container {
		padding-top: 90px;
	}
}

@media (max-width: 480px) {
	.page-media-container {
		padding-top: 134px;
	}
}

</style>
<style>
/* Page-specific */
#header-menu li a {
	color: #fff;
}

#header-menu li.last a {
	color: #000;
}

.page-media-header {
	background: url('http://www.ucf.edu/impact/files/2015/09/impact-video-still.jpg') center center no-repeat;
	background-size: cover;
}

</style>


<div class="container-fullwidth page-media" id="<?php echo $post->post_name; ?>">
	<div class="page-media-header">

		<div id="header-video-placeholder" data-mp4="http://www.ucf.edu/impact/files/2015/12/impact-video-mp4.mp4"></div>

		<div class="page-media-container">
			<div class="container">
				<div class="row">
					<div class="span12">
						Custom content on top of video/image goes here...
					</div>
				</div>
			</div>
		</div>

	</div>
	<div class="page-content">
		<article role="main">
			<?php the_content(); ?>
		</article>
	</div>

	<script>
		var $videoPlaceholder = $('#header-video-placeholder');

		// Generate a video tag for the header background
		function createHeaderVideo() {
			var mp4 = $videoPlaceholder.attr('data-mp4'),
				webm = $videoPlaceholder.attr('data-webm'),
				ogg = $videoPlaceholder.attr('data-ogg'),
				$video = $('<video autoplay preload muted class="fade"></video>');

			// Stop now/display nothing if no video sources are provided
			if (!mp4 && !webm && !ogg) {
				return;
			}

			if (mp4) {
				$video.append('<source src="'+ mp4 +'" type="video/mp4">');
			}
			if (webm) {
				$video.append('<source src="'+ webm +'" type="video/webm">');
			}
			if (ogg) {
				$video.append('<source src="'+ ogg +'" type="video/ogg">');
			}

			$videoPlaceholder.replaceWith($video);

			// Fade in video when it's ready to play
			$video.on('play', function() {
				$video.addClass('in');
			});
		}

		// Test if video auto plays
		function autoPlayOrBust() {

			var mp4 = 'data:video/mp4;base64,AAAAFGZ0eXBNU05WAAACAE1TTlYAAAOUbW9vdgAAAGxtdmhkAAAAAM9ghv7PYIb+AAACWAAACu8AAQAAAQAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgAAAnh0cmFrAAAAXHRraGQAAAAHz2CG/s9ghv4AAAABAAAAAAAACu8AAAAAAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAABAAAAAAFAAAAA4AAAAAAHgbWRpYQAAACBtZGhkAAAAAM9ghv7PYIb+AAALuAAANq8AAAAAAAAAIWhkbHIAAAAAbWhscnZpZGVBVlMgAAAAAAABAB4AAAABl21pbmYAAAAUdm1oZAAAAAAAAAAAAAAAAAAAACRkaW5mAAAAHGRyZWYAAAAAAAAAAQAAAAx1cmwgAAAAAQAAAVdzdGJsAAAAp3N0c2QAAAAAAAAAAQAAAJdhdmMxAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAAAAFAAOABIAAAASAAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAGP//AAAAEmNvbHJuY2xjAAEAAQABAAAAL2F2Y0MBTUAz/+EAGGdNQDOadCk/LgIgAAADACAAAAMA0eMGVAEABGjuPIAAAAAYc3R0cwAAAAAAAAABAAAADgAAA+gAAAAUc3RzcwAAAAAAAAABAAAAAQAAABxzdHNjAAAAAAAAAAEAAAABAAAADgAAAAEAAABMc3RzegAAAAAAAAAAAAAADgAAAE8AAAAOAAAADQAAAA0AAAANAAAADQAAAA0AAAANAAAADQAAAA0AAAANAAAADQAAAA4AAAAOAAAAFHN0Y28AAAAAAAAAAQAAA7AAAAA0dXVpZFVTTVQh0k/Ou4hpXPrJx0AAAAAcTVREVAABABIAAAAKVcQAAAAAAAEAAAAAAAAAqHV1aWRVU01UIdJPzruIaVz6ycdAAAAAkE1URFQABAAMAAAAC1XEAAACHAAeAAAABBXHAAEAQQBWAFMAIABNAGUAZABpAGEAAAAqAAAAASoOAAEAZABlAHQAZQBjAHQAXwBhAHUAdABvAHAAbABhAHkAAAAyAAAAA1XEAAEAMgAwADAANQBtAGUALwAwADcALwAwADYAMAA2ACAAMwA6ADUAOgAwAAABA21kYXQAAAAYZ01AM5p0KT8uAiAAAAMAIAAAAwDR4wZUAAAABGjuPIAAAAAnZYiAIAAR//eBLT+oL1eA2Nlb/edvwWZflzEVLlhlXtJvSAEGRA3ZAAAACkGaAQCyJ/8AFBAAAAAJQZoCATP/AOmBAAAACUGaAwGz/wDpgAAAAAlBmgQCM/8A6YEAAAAJQZoFArP/AOmBAAAACUGaBgMz/wDpgQAAAAlBmgcDs/8A6YEAAAAJQZoIBDP/AOmAAAAACUGaCQSz/wDpgAAAAAlBmgoFM/8A6YEAAAAJQZoLBbP/AOmAAAAACkGaDAYyJ/8AFBAAAAAKQZoNBrIv/4cMeQ==',
				body = document.getElementsByTagName('body')[0];

			var v = document.createElement('video');
			v.src = mp4;
			v.autoplay = true;
			v.volume = 0;
			v.style.visibility = 'hidden';

			body.appendChild(v);

			// video.play() seems to be required for it to work,
			// despite the video having an autoplay attribute.
			v.play();

			// triggered if autoplay fails
			var removeVideoTimeout = setTimeout(function () {
				$(v).remove();
			}, 50);

			// triggered if autoplay works
			v.addEventListener('play', function () {
				clearTimeout(removeVideoTimeout);
				$(v).remove();
				createHeaderVideo();
			}, false);
		}

		autoPlayOrBust();
	</script>
</div>
<div class="container">
	<?php get_footer();?>
