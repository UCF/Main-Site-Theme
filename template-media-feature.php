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

/* CSS-only full-width bg video. Object-fit is replaced via js if not supported */
.page-media-header video {
	height: 100%;
	object-fit: cover;
	position: absolute;
	width: 100%;
	z-index: 1;
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
	background: url('//placehold.it/1600x550') center center no-repeat;
	background-size: cover;
}

</style>


<div class="container-fullwidth page-media" id="<?php echo $post->post_name; ?>">
	<div class="page-media-header">

		<video autoplay preload muted>
			<source src="http://www.quirksmode.org/html5/videos/big_buck_bunny.mp4" type="video/mp4">
		</video>

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
		/*! modernizr 3.2.0 (Custom Build) | MIT *
		 * http://modernizr.com/download/?-setclasses !*/
		!function(n,e,s){function o(n,e){return typeof n===e}function a(){var n,e,s,a,i,l,r;for(var c in f)if(f.hasOwnProperty(c)){if(n=[],e=f[c],e.name&&(n.push(e.name.toLowerCase()),e.options&&e.options.aliases&&e.options.aliases.length))for(s=0;s<e.options.aliases.length;s++)n.push(e.options.aliases[s].toLowerCase());for(a=o(e.fn,"function")?e.fn():e.fn,i=0;i<n.length;i++)l=n[i],r=l.split("."),1===r.length?Modernizr[r[0]]=a:(!Modernizr[r[0]]||Modernizr[r[0]]instanceof Boolean||(Modernizr[r[0]]=new Boolean(Modernizr[r[0]])),Modernizr[r[0]][r[1]]=a),t.push((a?"":"no-")+r.join("-"))}}function i(n){var e=r.className,s=Modernizr._config.classPrefix||"";if(c&&(e=e.baseVal),Modernizr._config.enableJSClass){var o=new RegExp("(^|\\s)"+s+"no-js(\\s|$)");e=e.replace(o,"$1"+s+"js$2")}Modernizr._config.enableClasses&&(e+=" "+s+n.join(" "+s),c?r.className.baseVal=e:r.className=e)}var t=[],f=[],l={_version:"3.2.0",_config:{classPrefix:"",enableClasses:!0,enableJSClass:!0,usePrefixes:!0},_q:[],on:function(n,e){var s=this;setTimeout(function(){e(s[n])},0)},addTest:function(n,e,s){f.push({name:n,fn:e,options:s})},addAsyncTest:function(n){f.push({name:null,fn:n})}},Modernizr=function(){};Modernizr.prototype=l,Modernizr=new Modernizr;var r=e.documentElement,c="svg"===r.nodeName.toLowerCase();a(),i(t),delete l.addTest,delete l.addAsyncTest;for(var u=0;u<Modernizr._q.length;u++)Modernizr._q[u]();n.Modernizr=Modernizr}(window,document);
	</script>

	<script>
		var $video = $('.page-media-header video');

		function resizeVideo() {

		}

		if ($video.length() && !Modernizr.objectfit) {
			$(window).on('resize', resizeVideo);
			resizeVideo();
		}
	</script>

</div>
<div class="container">
	<?php get_footer();?>
