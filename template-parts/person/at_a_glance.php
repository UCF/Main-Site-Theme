<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'person' ) :
	$colleges = array(); // TODO
	$departments = array(); // TODO
?>
<section id="at-a-glance" aria-label="Details and Contact Information">
	<div class="jumbotron jumbotron-fluid bg-faded mb-0">
		<div class="container">
			<div class="row">
				<div class="col-md-8 offset-md-4">
					<dl>
						<?php if ( $colleges ) : ?>
						<dt class="h6 text-uppercase text-default">College(s)</dt>
						<dd class="h5 mb-4">
							<?php
							foreach ( $colleges as $college ) :
								$college_url = get_term_link( $college->term_id );
								if ( $college_url ) :
							?>
								<a href="<?php echo $college_url; ?>" class="d-block">
									<?php echo $college->name; ?>
								</a>
							<?php else : ?>
								<span class="d-block">
									<?php echo $college->name; ?>
								</span>
							<?php
								endif;
							endforeach;
							?>
						</dd>
						<?php endif; ?>

						<?php if ( $departments ) : ?>
						<dt class="h6 text-uppercase text-default">Department(s)</dt>
						<dd class="h5">
							<?php
							foreach ( $departments as $department ) :
								$department_url = get_term_meta( $department->term_id, 'departments_url', true );
								if ( $department_url ) :
							?>
								<a href="<?php echo $department_url; ?>" class="d-block">
									<?php echo $department->name; ?>
								</a>
							<?php else : ?>
								<span class="d-block">
									<?php echo $department->name; ?>
								</span>
							<?php
								endif;
							endforeach;
							?>
						</dd>
						<?php endif; ?>

						<dt class="h6 text-uppercase text-default">Contact</dt>
						<dd>
							<dl>
								<dt>Location</dt>
								<dd>TODO</dd>
								<dt>Phone</dt>
								<dd>TODO</dd>
								<dt>Email</dt>
								<dd>TODO</dd>
							</dl>
						</dd>
					</dl>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
