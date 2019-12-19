<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

    <div class="wrap">

<?php if ( have_posts() ) : ?>
    <header class="page-header">
		<?php
		the_archive_title( '<h1 class="page-title">', '</h1>' );
		the_archive_description( '<div class="taxonomy-description">', '</div>' );
		?>
    </header><!-- .page-header -->
<?php endif; ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <div id="primary" class="content-area">
                <main id="main" class="site-main">
                    <h2>Archive page</h2>
                    <ul>
						<?php while ( have_posts() ) : the_post(); ?>
                            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                            <hr>
						<?php endwhile;
						?>
                    </ul>
                </main><!-- #main -->
            </div><!-- #primary -->
    </div><!-- .wrap -->

<?php
get_sidebar();
get_footer();
