<?php

/*
 Template Name: Single Real Estates
 */

acf_form_head();

get_header();

?>
    <div class="wrap">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">

                <br>

                <button onclick="window.history.back()">Go Back</button>
                <h1>Single page</h1>
                <h2><?php the_title(); ?></h2>

                subtitles:
				<?php
				if ( get_field( 'subtitle' ) ) {
					?>
                    <h3><?php the_field( 'subtitle' ); ?></h3><?php
				}
				?>
				<?php
				$images = get_field( 'gallery' );
				if ( $images ): ?>

					<?php foreach ( $images as $image ): ?>

                        <a href="<?php echo esc_url( $image['url'] ); ?>">
                            <img src="<?php echo esc_url( $image['sizes']['medium'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>"/>
                        </a>
                        <p><?php echo esc_html( $image['caption'] ); ?></p>

					<?php endforeach; ?>

				<?php endif; ?>
                Repeater:
                <br>
                <div class="testimonials">
					<?php if ( have_rows( 'slides' ) ): ?>
                        <ul>
							<?php while ( have_rows( 'slides' ) ): the_row();
								$text = get_sub_field( 'text' );
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
				$terms            = get_the_terms( $post->ID, 'locations' );
				$current_location = 0;
				if ( $terms && ! is_wp_error( $terms ) ) {
					foreach ( $terms as $term ) {
						$current_location = $term->term_id;
						$link             = get_term_link( $term );
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
                <hr>
				<?php
				$post_id = acf_maybe_get_POST( 'post_id' );
				$post    = get_post( $post_id );
				$author  = (int) $post->post_author;
				//if ( ( current_user_can( 'update_core' ) ) || ( get_current_user_id() === $author ) ) {
					if ( is_user_logged_in() ) {
					?>
                    <h4>Edit Real Estate:</h4>
                    <form id="edit_real_estate" class="js-form-edit-real-estate" data-id="<?php echo get_the_ID(); ?>">
                        <fieldset>
                            <p><label for="post_title">Title</label>
                                <input type="text" id="post_title" name="post_title" value="<?php echo $post->post_title; ?>"/></p>
                            <p><label for="subtitle">Subtitle</label>
                                <input type="text" id="subtitle" name="subtitle" value="<?php echo get_field( 'subtitle' ); ?>"/></p>
							<?php

							$locationsTex = get_terms( [
								'taxonomy'   => 'locations',
								'hide_empty' => false
							] );

							$select = "<select name='location' class='js-location-select'>";
							$select .= "<option value='-1'>Select locations</option>";

							foreach ( $locationsTex as $location ) {
								$select .= "<option value='" . $location->term_id . "' " . ( $current_location === $location->term_id ? 'selected' : '' ) . ">" . $location->name . "</option>";
							}

							$select .= "</select>";

							echo $select;
							?>
							<?php
							acf_form( [
								'post_id' => $post->ID,
								'fields'  => [ 'gallery', 'slides' ],
								'form'    => false
							] );
							?>
                        </fieldset>
                        <br>
                        <!--	<input type="hidden" name="submit" id="submit" value="true"/>-->
                        <input type="hidden" id="post_id" name="post_id" value="<?php echo $post->ID ?>">
                        <!--    <input type="hidden" name="ajax-nonce" id="ajax-nonce" value="' --><?php //echo wp_create_nonce( 'email-nonce' ); ?><!--'" />-->
                        <button type="submit" class="btn btn-primary js-submit-button">Submit</button>

                    </form>
					<?php
				}
				?>
                <br>
            </main><!-- #main -->
        </div><!-- #primary -->
    </div><!-- #wrapp -->

<?php
get_sidebar();
get_footer();