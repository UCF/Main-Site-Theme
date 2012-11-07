<?php global $shortcode_tags; ?>
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
					
					<?php if (isset($shortcode_tags['slideshow'])) { ?>
						
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

					<?php } ?>
					
					
					
					<h4>(post type)-list</h4>
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
								if (isset($shortcode_tags[$custom_post_type->name.'-list'])) { 
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
						<?php }
						}	?>
					
						
				</table>
					
					<p>Examples:</p>
<pre><code># Output a maximum of 5 Documents tagged 'foo' or 'bar', with a default output.
[document-list tags="foo bar" limit=5]No Documents were found.[/document-list]

# Output all People categorized as 'foo'
[person-list categories="foo"]

# Output all People matching the terms in the custom taxonomy named 'org_groups'
[person-list org_groups="term list example"]

# Outputs all People found categorized as 'staff' and in the org_group 'small'.
[person-list limit=5 join="and" categories="staff" org_groups="small"]</code></pre>
				
				
				<?php 
				if (isset($shortcode_tags['person-picture-list'])) { ?>
				
				<h4>person-picture-list</h4>
				<p>Outputs a list of People with thumbnails, person names, and job titles.  If a person's description is available, a link to the person's profile will be outputted.  If a thumbnail for the person does not exist, a default 'No Photo Available' thumbnail will display.  An optional <strong>row_size</strong> parameter is available to customize the number of rows that will display, in addition to the other filter parameters available to the <strong>person-list</strong> shortcode.</p>
				
				<p>Example:</p>
<pre><code># Output all People (default to 5 columns.)
[person-picture-list]

# Output all People in 4 columns.
[person-picture-list row_size=4]

# Output People in org_group 'staff' in 6 columns.
[person-picture-list org_groups="staff" row_size=6]
</code></pre>

				<?php } ?>
				
				
				<?php if (isset($shortcode_tags['post-type-search'])) { ?>
				<h4>post-type-search</h4>
				<p>Returns a list of posts of a given post type that are searchable through a generated search field.  Posts are searchable by post title and any associated tags.  Available attributes:</p>
					
					<table>
						<tr>
							<th>Name</th>
							<th>Description</th>
							<th>Default Value</th>
							<th>Available Values</th>
						</tr>
						<tr>
							<td>post_type_name</td>
							<td>The post type to retrieve posts for</td>
							<td>post</td>
							<td>
								<ul>
								<?php 
									foreach ($custom_post_types as $custom_post_type) {
										print '<li style="list-style: disc; margin-left: 15px;">'.$custom_post_type->name.'</li>';
									}
								?>
								</ul>
							</td>
						</tr>
						<tr>
							<td>taxonomy</td>
							<td>A taxonomy by which posts can be organized</td>
							<td>category</td>
							<td>Depends on the post type chosen and its available taxonomies</td>
						</tr>
						<tr>
							<td>show_empty_sections</td>
							<td>Determines whether or not empty taxonomy terms will be displayed within the results.</td>
							<td>false</td>
							<td>true, false</td>
						</tr>
						<tr>
							<td>non_alpha_section_name</td>
							<td>Changes the name of the section in which non-alphabetical post results are stored in the alphabetical sort (posts that start with 0-9, etc.)</td>
							<td>Other</td>
							<td></td>
						</tr>
						<tr>
							<td>column_width</td>
							<td>Determines the width of the columns of results.  Intended for use with Bootstrap scaffolding (<a href="http://twitter.github.com/bootstrap/scaffolding.html">see here</a>), but will accept any CSS class name.</td>
							<td>span4</td>
							<td></td>
						</tr>
						<tr>
							<td>column_count</td>
							<td>The number of columns that will be created with the set column_width.</td>
							<td>3</td>
							<td></td>
						</tr>
						<tr>
							<td>order_by</td>
							<td>How to order results by term.  Note that this does not affect alphabetical results.  See <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters">WP Query Orderby params</a> in the Wordpress Codex for more information.</td>
							<td>post_title</td>
							<td>
								<ul>
									<li style="list-style: disc; margin-left: 15px;">none</li>
									<li style="list-style: disc; margin-left: 15px;">ID</li>
									<li style="list-style: disc; margin-left: 15px;">author</li>
									<li style="list-style: disc; margin-left: 15px;">title</li>
									<li style="list-style: disc; margin-left: 15px;">name</li>
									<li style="list-style: disc; margin-left: 15px;">date</li>
									<li style="list-style: disc; margin-left: 15px;">modified</li>
									<li style="list-style: disc; margin-left: 15px;">parent</li>
									<li style="list-style: disc; margin-left: 15px;">rand</li>
									<li style="list-style: disc; margin-left: 15px;">menu_order</li>
								</ul>
							</td>
						</tr>
						<tr>
							<td>order</td>
							<td>Determine if posts are ordered from ascending to descending, or vice-versa.</td>
							<td>ASC</td>
							<td>ASC (ascending), DESC (descending)</td>
						</tr>
							<td>show_sorting</td>
							<td>Whether or not to display the toggle buttons that sort posts by taxonomy and alphabetically.</td>
							<td>true</td>
							<td>true, false</td>
						<tr>
						</tr>
						<tr>
							<td>default_sorting</td>
							<td>How posts will be sorted by default.  Choose between by taxonomy term or alphabetically.</td>
							<td>term</td>
							<td>
								<ul>
									<li style="list-style: disc; margin-left: 15px;">term</li>
									<li style="list-style: disc; margin-left: 15px;">alpha</li>
								</ul>
							</td>
						</tr>
						<tr>
							<td>default_search_text</td>
							<td>Sets the post search field placeholder text.  Note that placeholders are not supported by older browsers (IE 8 and below.)</td>
							<td>Find a (post type name)</td>
							<td></td>
						</tr>
					</table>
					
					<p>Examples:</p>
<pre style="white-space: pre-line;"><code># Generate a Post search, organized by category, with empty sections visible.  Generates one column of results with CSS class .span3.
[post-type-search column_width="span3" column_count="1" show_empty_sections=true default_search_text="Find Something"]

# Generate a Person search, organized by Organizational Groups (that have People assigned to them.)
[post-type-search post_type_name="person" taxonomy="org_groups"]
</code></pre>
				<?php } ?>	
				
				</li>
				
			</ul>
		</div>
	</div>
</div>