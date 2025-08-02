<?php
/**
 * The main template file
 *
 * @package SignalfireAlpha
 * @since 1.0.0
 */

get_header();
?>

<div class="container mx-auto px-4 py-8">
    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <?php if (have_posts()) : ?>
                
                <?php if (is_home() && !is_front_page()) : ?>
                    <header class="page-header mb-8">
                        <h1 class="page-title text-3xl font-bold text-gray-900"><?php single_post_title(); ?></h1>
                    </header>
                <?php endif; ?>

                <div class="posts-grid space-y-8">
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow'); ?>>
                            
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail">
                                    <a href="<?php the_permalink(); ?>" class="block">
                                        <?php the_post_thumbnail('large', ['class' => 'w-full h-48 object-cover']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="p-6">
                                <header class="entry-header mb-4">
                                    <?php
                                    if (is_singular()) :
                                        the_title('<h1 class="entry-title text-2xl font-bold text-gray-900 mb-2">', '</h1>');
                                    else :
                                        the_title('<h2 class="entry-title text-xl font-semibold text-gray-900 mb-2"><a href="' . esc_url(get_permalink()) . '" class="hover:text-blue-600 transition-colors">', '</a></h2>');
                                    endif;
                                    ?>
                                    
                                    <div class="entry-meta text-sm text-gray-500 flex items-center space-x-4">
                                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                            <?php echo esc_html(get_the_date()); ?>
                                        </time>
                                        <span>by <?php the_author(); ?></span>
                                        <?php if (has_category()) : ?>
                                            <span><?php the_category(', '); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </header>

                                <div class="entry-content text-gray-700">
                                    <?php
                                    if (is_singular()) :
                                        the_content();
                                    else :
                                        the_excerpt();
                                    endif;
                                    ?>
                                </div>

                                <?php if (!is_singular()) : ?>
                                    <footer class="entry-footer mt-4">
                                        <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium transition-colors">
                                            <?php esc_html_e('Read more', 'signalfire-wp-alpha'); ?>
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                            </svg>
                                        </a>
                                    </footer>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <?php
                // Pagination
                the_posts_pagination([
                    'mid_size'  => 2,
                    'prev_text' => __('&larr; Previous', 'signalfire-wp-alpha'),
                    'next_text' => __('Next &rarr;', 'signalfire-wp-alpha'),
                    'class'     => 'mt-8',
                ]);
                ?>

            <?php else : ?>
                <div class="no-results bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
                    <h1 class="text-2xl font-bold text-gray-900 mb-4"><?php esc_html_e('Nothing here', 'signalfire-wp-alpha'); ?></h1>
                    <p class="text-gray-600 mb-6"><?php esc_html_e('It looks like nothing was found at this location. Maybe try a search?', 'signalfire-wp-alpha'); ?></p>
                    <?php get_search_form(); ?>
                </div>
            <?php endif; ?>
        </div>

        <aside class="lg:col-span-1">
            <?php get_sidebar(); ?>
        </aside>
    </div>
</div>

<?php get_footer(); ?>