<?php
/**
 * The sidebar containing the main widget area
 *
 * @package SignalfireAlpha
 * @since 1.0.0
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside id="secondary" class="widget-area space-y-6">
    <?php dynamic_sidebar('sidebar-1'); ?>
</aside><!-- #secondary -->