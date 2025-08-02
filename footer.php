    </main><!-- #primary -->

    <footer id="colophon" class="site-footer bg-gray-900 text-white mt-auto">
        <div class="container mx-auto px-4 py-8">
            <div class="grid md:grid-cols-2 gap-8">
                <div class="footer-info">
                    <h3 class="text-lg font-semibold mb-4"><?php bloginfo('name'); ?></h3>
                    <p class="text-gray-300 text-sm">
                        <?php
                        $description = get_bloginfo('description', 'display');
                        echo $description ? $description : __('A modern WordPress theme built with Tailwind CSS and Vite.', 'signalfire-wp-alpha');
                        ?>
                    </p>
                </div>
                
                <?php if (is_active_sidebar('sidebar-1')) : ?>
                    <div class="footer-widgets">
                        <?php dynamic_sidebar('sidebar-1'); ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-6">
                <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
                    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('All rights reserved.', 'signalfire-wp-alpha'); ?></p>
                    <p>
                        <?php esc_html_e('Powered by', 'signalfire-wp-alpha'); ?> 
                        <a href="https://wordpress.org" class="hover:text-white transition-colors">WordPress</a>
                    </p>
                </div>
            </div>
        </div>
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>