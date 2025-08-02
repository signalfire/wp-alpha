<?php
/**
 * The template for displaying all pages
 *
 * @package SignalfireAlpha
 * @since 1.0.0
 */

get_header();
?>

<div class="container mx-auto px-4 py-8">
    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden'); ?>>
                    
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <?php the_post_thumbnail('large', ['class' => 'w-full h-64 object-cover']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="p-8">
                        <header class="entry-header mb-6">
                            <?php the_title('<h1 class="entry-title text-3xl font-bold text-gray-900">', '</h1>'); ?>
                        </header>

                        <div class="entry-content prose prose-lg max-w-none text-gray-700">
                            <?php the_content(); ?>
                        </div>

                        <footer class="entry-footer mt-8">
                            <?php
                            wp_link_pages([
                                'before' => '<div class="page-links">' . esc_html__('Pages:', 'signalfire-wp-alpha'),
                                'after'  => '</div>',
                            ]);
                            ?>
                        </footer>
                    </div>
                </article>

                <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    echo '<div class="comments-section mt-8">';
                    comments_template();
                    echo '</div>';
                endif;
                ?>

            <?php endwhile; ?>
        </div>

        <aside class="lg:col-span-1">
            <?php get_sidebar(); ?>
        </aside>
    </div>
</div>

<?php get_footer(); ?>