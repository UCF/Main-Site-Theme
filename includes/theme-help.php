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
					
					<h4 id="shortcodes">(post type)-list</h4>
					<p>Outputs a list of a given post type filtered by arbitrary taxonomies, for 
					example a tag or category.  A default output can be added for when no objects 
					matching the criteria are found.  Available attributes:</p>
					
					<table>
					<tr>
						<th scope="col">Post Type</th>
						<th scope="col">Shortcode Call</th>
						<th scope="col">Available Taxonomy Filters</th>
						<th scope="col">Additional Filters</th>
					</tr>
					
						<?php 
							$custom_post_types = installed_custom_post_types();
							
							foreach ($custom_post_types as $custom_post_type) {
						?>
					<tr>
						<td><?=$custom_post_type->singular_name?></td>
						<td><?=$custom_post_type->name?>-list</td>
								
						<td>
							<ul>
							<?php foreach ($custom_post_type->taxonomies as $tax) { 
								switch ($tax) {
									case 'post_tag':
										$tax = 'tags';
										break;
									case 'category':
										$tax = 'categories';
										break;
								}
								
							?>
								<li style="list-style: disc; margin-left: 15px;"><?=$tax?></li>
							</ul>
							<?php } ?>
						</td>
						<td>
							<ul>
							<?php
								// if more than 1 taxonomy is assigned to the post type, show 'join'
								// as being an available filter:
								if (count($custom_post_type->taxonomies) > 1) { 
								?>
									<li style="list-style: disc; margin-left: 15px;">join ('and', 'or')</li>
								<?php
								}
								?>
									<li style="list-style: disc; margin-left: 15px;">limit (number)</li>
							</ul>
						</td>
					</tr>
						<?php }	?>
					
						
				</table>
					
					<p>Example:</p>
<pre><code># Output a maximum of 5 Documents tagged 'foo' or 'bar', with a default output.
[document-list tags="foo bar" limit="5"]No Documents were found.[/document-list]

# Output all People categorized as 'foo'
[person-list categories="foo"]

# Output all People matching the terms in the custom taxonomy named 'org_groups'
[person-list org_groups="term list example"]

# Outputs all People found categorized as 'staff' and in the org_group 'small'.
[person-list limit=5 join="and" categories="staff" org_groups="small"]</code></pre>
				
				
				
				</li>
				
			</ul>
		</div>
	</div>
</div>