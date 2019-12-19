<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header();

?>

	<div class="wrap">
		<?php if ( is_home() && ! is_front_page() ) : ?>
			<header class="page-header">
				<h1 class="page-title"><?php single_post_title(); ?></h1>
			</header>
		<?php else : ?>
			<header class="page-header">
				<h2 class="page-title"><?php _e( 'Posts', 'twentyseventeen' ); ?></h2>
			</header>
		<?php endif; ?>

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
<h1>GLAVNA STRANA</h1>
				<?php

				if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php echo '<h2><a href="';
						the_permalink();
						echo '">';
						the_title();
						echo '</a></h2>';
						?>
						<hr>
                        subtitles:
						<?php
						if ( get_field( 'subtitle' ) ) {
							?>
                            <h3><?php the_field( 'subtitle' ); ?></h3><?php
						}
						?>
						<?php
						$images = get_field('gallery');
						if( $images ): ?>

							<?php foreach( $images as $image ): ?>

								<a href="<?php echo esc_url($image['url']); ?>">
									<img src="<?php echo esc_url($image['sizes']['medium']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
								</a>
								<p><?php echo esc_html($image['caption']); ?></p>

							<?php endforeach; ?>

						<?php endif; ?>
						Repeater:
						<br>
						<div class="testimonials">
							<?php if( have_rows('slides') ): ?>
								<ul>
									<?php while( have_rows('slides') ): the_row();
										$text = get_sub_field('text');
										?>
										<li>
											<?php echo $text; ?>
										</li>
									<?php endwhile; ?>
								</ul>
							<?php endif; ?>
						</div>
						locations - taxonomies:
						<br>
						<?php
						$terms = get_the_terms( $post->ID, 'locations' );
						if ( $terms && ! is_wp_error( $terms ) ) {
							foreach ( $terms as $term ) {
								$link = get_term_link( $term );
								echo '<a href="' . esc_url( $link ) . '">' . esc_attr( $term->name ) . '</a>, ';


							}
						} else {
							echo 'No taxonomy';
						}
						?>
						<br>
						types - taxonomies:
						<br>
						<?php
						$terms = get_the_terms( $post->ID, 'types' );
						if ( $terms && ! is_wp_error( $terms ) ) {
							foreach ( $terms as $term ) {
								$link = get_term_link( $term );
								echo '<a href="' . esc_url( $link ) . '">' . esc_attr( $term->name ) . '</a>, ';
							}
						} else {
							echo 'No taxonomy';
						}
						?>
						<div class="entry-content">
							<?php the_content(); ?>
						</div>
						<?php wp_reset_postdata(); ?>
					<?php endwhile; ?>
				<?php endif; ?>
			</main><!-- #main -->
		</div><!-- #primary -->

	</div><!-- .wrap -->


<?php

get_sidebar();
get_footer();