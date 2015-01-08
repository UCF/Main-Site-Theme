
<?php
	$sort_by = "degree-name";

	if (isset($_GET['sort-by']) && $_GET['sort-by'] == "credit-hours") {
		$sort_by = "credit-hours";
	}

	// var_dump($_GET['program-type']);
?>

<!-- Search Result Header -->

<h2 class="degree-search-header">234 Results for: <?php echo urldecode($_GET['search-query']); ?></em></h2>

<div class="degree-search-sort">
	<strong class="degree-search-sort-label radio inline">Sort by:</strong>
	<label class="radio inline">
		<input type="radio" name="sort-by" class="sort-by" value="degree-name" <?php if ($sort_by == "degree-name") echo "checked";?>> Name
	</label>
	<label class="radio inline">
		<input type="radio" name="sort-by" class="sort-by" value="credit-hours" <?php if ($sort_by == "credit-hours") echo "checked";?>> Credit Hours
	</label>
</div>

<!-- Search Results -->

<ul class="degree-search-results">
	<li class="degree-search-result">
		<h3 class="degree-title">
			<a href="#">Accounting</a>
			<span class="degree-credits-count">&mdash; 140 credit hours</span>
		</h3>
		<span class="degree-college">College of Business Administration</span>
		<span class="degree-dept">
			<span class="degree-detail-label">Department:</span> Kenneth G. Dixon School of Accounting
		</span>
		<p class="degree-desc hidden-phone">
			The objective of the Accounting track in the Business Administration PhD program is to prepare
			students for academic careers in higher education and management careers within profit and
			nonprofit organizations. Success in the program is judged by the student’s understanding of
			the issues and methodologies essential to the advancement of knowledge.
		</p>
		<p class="degree-desc visible-phone">
			The objective of the Accounting track in the Business Administration PhD program is to prepare
			students for academic careers in higher education and management careers within profit and
			nonprofit organizations.&hellip;
		</p>
		<a class="degree-search-result-link" href="#">Read more about the Accounting degree.</a>
	</li>

	<li class="degree-search-result">
		<h3 class="degree-title">
			<a href="#">Finance</a>
			<span class="degree-credits-count">&mdash; 140 credit hours</span>
		</h3>
		<span class="degree-college">College of Business Administration</span>
		<span class="degree-dept">
			<span class="degree-detail-label">Department:</span> Finance
		</span>
		<p class="degree-desc hidden-phone">
			The objective of the Finance track in the Business Administration PhD program is to prepare
			students for academic careers in higher education and management careers within profit and
			nonprofit organizations. Success in the program is judged by the student’s understanding of
			the issues and methodologies essential to the advancement of knowledge.
		</p>
		<p class="degree-desc visible-phone">
			The objective of the Finance track in the Business Administration PhD program is to prepare
			students for academic careers in higher education and management careers within profit and
			nonprofit organizations.&hellip;
		</p>
		<a class="degree-search-result-link" href="#">Read more about the Finance degree.</a>
	</li>
</ul>
