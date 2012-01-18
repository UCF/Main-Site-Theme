<div id="theme-help" class="i-am-a-fancy-admin">
	<div class="container">
		<h2>Help</h2>
		
		<?php if ($updated):?>
		<div class="updated fade"><p><strong><?=__( 'Options saved' ); ?></strong></p></div>
		<?php endif; ?>
		
		<div class="sections">
			<ul>
				<li class="section"><a href="#posting">Posting</a></li>
				<li class="section"><a href="#shortcodes">Shortcodes</a></li>
			</ul>
		</div>
		<div class="fields">
			<ul>
				
				<li class="section" id="posting">
					<h3>Posting</h3>
					<p>Posting is fun, do it.</p>
				</li>
				
				<li class="section" id="shortcodes">
					<h3>Shortcodes</h3>
					
					<h4>slideshow</h4>
					<p>Create a javascript slideshow of each top level element in the shortcode.  All attributes are optional, but may default to less than ideal values.  Available attributes:</p>
					<table>
						<tr>
							<th scope="col">Name</th>
							<th scope="col">Description</th>
							<th scope="col">Default Value</th>
						</tr>
						<tr>
							<td>height</td>
							<td>CSS height of the outputted slideshow</td>
							<td>100px</td>
						</tr>
						<tr>
							<td>width</td>
							<td>CSS width of the outputted slideshow</th>
							<td>100%</td>
						</tr>
						<tr>
							<td>transition</td>
							<td>Length of transition in milliseconds</td>
							<td>1000</td>
						</tr>
						<tr>
							<td>cycle</td>
							<td>Length of each cycle in milliseconds</td>
							<td>5000</td>
						</tr>
						<tr>
							<td>animation</td>
							<td>The animation type, one of: 'slide' or 'fade'</td>
							<td>slide</td>
						</tr>
					</table>
					<p>Example:
<pre><code>[slideshow height="500px" transition="500" cycle="2000"]
&lt;img src="http://some.image.com" .../&gt;
&lt;div class="robots"&gt;Robots are coming!&lt;/div&gt;
&lt;p&gt;I'm a slide!&lt;/p&gt;
[/slideshow]</code></pre>
					
					<h4>document-list</h4>
					<p>Outputs a list of {$plural} filtered by arbitrary taxonomies, for example a tag
					or category.  A default output for when no objects matching the criteria are
					found.</p>
					<p>Example:</p>
<pre><code># Output a maximum of 5 items tagged foo or bar, with a default output.
[{$scode} tags="foo bar" limit="5"]No {$plural} were found.[/{$scode}]

# Output all objects categorized as foo
[{$scode} categories="foo"]

# Output all objects matching the terms in the custom taxonomy named foo
[{$scode} foo="term list example"]

# Outputs all objects found categorized as staff and tagged as small.
[{$scode} limit="5" join="and" categories="staff" tags="small"]</code></pre>
				</li>
				
			</ul>
		</div>
	</div>
</div>