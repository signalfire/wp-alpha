<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site min-h-screen flex flex-col">
    <header id="masthead" class="site-header bg-white shadow-sm border-b border-gray-200">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="site-branding">
                    <?php if (has_custom_logo()) : ?>
                        <div class="site-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <h1 class="site-title text-2xl font-bold text-gray-900">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-blue-600 transition-colors">
                                <?php bloginfo('name'); ?>
                            </a>
                        </h1>
                        <?php
                        $description = esc_html(get_bloginfo('description', 'display'));
                        if ($description || is_customize_preview()) :
                        ?>
                            <p class="site-description text-gray-600 text-sm mt-1"><?php echo $description; ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <nav id="site-navigation" class="main-navigation relative" aria-label="<?php esc_attr_e('Primary menu', 'signalfire-wp-alpha'); ?>">
                    <button class="menu-toggle md:hidden bg-gray-100 hover:bg-gray-200 p-2 rounded transition-colors" 
                            aria-controls="primary-menu" 
                            aria-expanded="false"
                            aria-label="<?php esc_attr_e('Toggle menu', 'signalfire-wp-alpha'); ?>">
                        <span class="sr-only"><?php esc_html_e('Menu', 'signalfire-wp-alpha'); ?></span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'hidden md:flex space-x-6 items-center',
                        'link_class'     => 'text-gray-700 hover:text-blue-600 transition-colors py-2 px-3 rounded hover:bg-gray-50 block md:inline-block',
                        'fallback_cb'    => 'signalfire_alpha_fallback_menu',
                        'container'      => false,
                    ]);
                    ?>
                </nav>
            </div>
        </div>
    </header>

    <main id="primary" class="site-main flex-1"><?php // Closed in footer.php ?>