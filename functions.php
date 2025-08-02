<?php
/**
 * Signalfire Alpha Theme Functions
 *
 * @package SignalfireAlpha
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup
 */
function signalfire_wp_alpha_setup() {
    // Make theme available for translation
    load_theme_textdomain('signalfire-wp-alpha', get_template_directory() . '/languages');

    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ]);
    add_theme_support('custom-logo');
    add_theme_support('customize-selective-refresh-widgets');

    // Register navigation menu
    register_nav_menus([
        'primary' => __('Primary Menu', 'signalfire-wp-alpha'),
    ]);
}
add_action('after_setup_theme', 'signalfire_wp_alpha_setup');

/**
 * Enqueue scripts and styles
 */
function signalfire_wp_alpha_enqueue_assets() {
    $theme_version = wp_get_theme()->get('Version');
    
    // Check if Vite dev server is running
    $vite_dev_server = wp_remote_get('http://localhost:5173/theme-src/main.js', [
        'timeout' => 1,
        'sslverify' => false
    ]);
    $is_vite_dev = !is_wp_error($vite_dev_server) && wp_remote_retrieve_response_code($vite_dev_server) === 200;
    
    if ($is_vite_dev && defined('WP_DEBUG') && WP_DEBUG) {
        // Development mode - load from Vite dev server with HMR
        wp_enqueue_script(
            'vite-client',
            'http://localhost:5173/@vite/client',
            [],
            null,
            false
        );
        wp_script_add_data('vite-client', 'type', 'module');
        
        wp_enqueue_script(
            'signalfire-wp-alpha-main',
            'http://localhost:5173/theme-src/main.js',
            [],
            null,
            false
        );
        wp_script_add_data('signalfire-wp-alpha-main', 'type', 'module');
        
        // Add HMR support script
        wp_add_inline_script('vite-client', "
            if (import.meta.hot) {
                import.meta.hot.accept();
            }
            console.log('🔥 Vite HMR enabled');
        ");
        
    } else {
        // Production mode - load built assets
        $manifest_path = get_template_directory() . '/dist/.vite/manifest.json';
        
        if (file_exists($manifest_path)) {
            $manifest = json_decode(file_get_contents($manifest_path), true);
            $manifest_version = filemtime($manifest_path);
            
            if (isset($manifest['theme-src/main.js'])) {
                // Enqueue JavaScript
                wp_enqueue_script(
                    'signalfire-wp-alpha-main',
                    get_template_directory_uri() . '/dist/' . $manifest['theme-src/main.js']['file'],
                    [],
                    $manifest_version,
                    true
                );
                
                // Enqueue CSS if it exists
                if (isset($manifest['theme-src/main.js']['css'])) {
                    foreach ($manifest['theme-src/main.js']['css'] as $css_file) {
                        wp_enqueue_style(
                            'signalfire-wp-alpha-styles',
                            get_template_directory_uri() . '/dist/' . $css_file,
                            [],
                            $manifest_version
                        );
                    }
                }
            }
        }
        
        // Fallback auto-reload for production builds during development
        if (defined('WP_DEBUG') && WP_DEBUG) {
            wp_add_inline_script('signalfire-wp-alpha-main', "
                (function() {
                    function checkForUpdates() {
                        fetch('" . get_template_directory_uri() . "/dist/.vite/manifest.json?t=' + Date.now())
                            .then(response => response.json())
                            .then(data => {
                                const manifestPath = data['theme-src/main.js'];
                                if (manifestPath && manifestPath.css && manifestPath.css[0]) {
                                    const currentHash = manifestPath.css[0];
                                    const lastHash = window.lastCssHash || '';
                                    
                                    if (lastHash && currentHash !== lastHash) {
                                        console.log('🔄 Assets updated, reloading...');
                                        window.location.reload();
                                    }
                                    window.lastCssHash = currentHash;
                                }
                            })
                            .catch(() => {});
                    }
                    
                    setInterval(checkForUpdates, 2000);
                    console.log('🔄 Fallback reload enabled');
                    checkForUpdates();
                })();
            ", 'after');
        }
    }
}
add_action('wp_enqueue_scripts', 'signalfire_wp_alpha_enqueue_assets');

/**
 * Register widget areas
 */
function signalfire_wp_alpha_widgets_init() {
    register_sidebar([
        'name'          => __('Sidebar', 'signalfire-wp-alpha'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here.', 'signalfire-wp-alpha'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ]);
}
add_action('widgets_init', 'signalfire_wp_alpha_widgets_init');

/**
 * Customize excerpt length
 */
function signalfire_wp_alpha_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'signalfire_wp_alpha_excerpt_length');

/**
 * Add async/defer attributes to enqueued scripts
 */
function signalfire_wp_alpha_script_attributes($tag, $handle, $src) {
    if ('vite-client' === $handle || 'signalfire-wp-alpha-main' === $handle) {
        return str_replace('<script', '<script type="module"', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'signalfire_wp_alpha_script_attributes', 10, 3);

/**
 * Fallback menu when no menu is assigned
 */
function signalfire_wp_alpha_fallback_menu() {
    echo '<ul id="primary-menu" class="hidden md:flex space-x-6 items-center">';
    echo '<li><a href="' . esc_url(home_url('/')) . '" class="text-gray-700 hover:text-blue-600 transition-colors py-2 px-3 rounded hover:bg-gray-50 block md:inline-block">Home</a></li>';
    
    // Get pages
    $pages = get_pages(['sort_column' => 'menu_order', 'number' => 5]);
    foreach ($pages as $page) {
        echo '<li><a href="' . esc_url(get_permalink($page->ID)) . '" class="text-gray-700 hover:text-blue-600 transition-colors py-2 px-3 rounded hover:bg-gray-50 block md:inline-block">' . esc_html($page->post_title) . '</a></li>';
    }
    
    echo '</ul>';
}

/**
 * Custom comment callback function
 */
function signalfire_wp_alpha_comment_callback($comment, $args, $depth) {
    if ('div' === $args['style']) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <<?php echo $tag; ?> <?php comment_class('comment bg-gray-50 rounded-lg p-4 mb-4'); ?> id="comment-<?php comment_ID(); ?>">
        
        <div class="comment-author vcard flex items-start space-x-3">
            <?php if ($args['avatar_size'] != 0) : ?>
                <div class="comment-avatar flex-shrink-0">
                    <?php echo get_avatar($comment, 48, '', '', ['class' => 'rounded-full']); ?>
                </div>
            <?php endif; ?>
            
            <div class="comment-content flex-1">
                <div class="comment-meta commentmetadata text-sm text-gray-600 mb-2">
                    <cite class="fn font-medium text-gray-900"><?php echo get_comment_author_link(); ?></cite>
                    <span class="mx-2">•</span>
                    <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>" class="text-gray-500 hover:text-blue-600">
                        <?php printf(esc_html__('%1$s at %2$s', 'signalfire-wp-alpha'), get_comment_date(), get_comment_time()); ?>
                    </a>
                    <?php edit_comment_link(esc_html__('(Edit)', 'signalfire-wp-alpha'), ' ', ''); ?>
                </div>

                <?php if ($comment->comment_approved == '0') : ?>
                    <em class="comment-awaiting-moderation text-yellow-600 text-sm"><?php esc_html_e('Your comment is awaiting moderation.', 'signalfire-wp-alpha'); ?></em>
                    <br />
                <?php endif; ?>

                <div id="div-comment-<?php comment_ID(); ?>" class="comment-text text-gray-700">
                    <?php comment_text(); ?>
                </div>

                <div class="reply mt-3">
                    <?php 
                    comment_reply_link(array_merge($args, [
                        'add_below' => $add_below,
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                        'class'     => 'text-blue-600 hover:text-blue-700 text-sm font-medium'
                    ])); 
                    ?>
                </div>
            </div>
        </div>
    <?php
}