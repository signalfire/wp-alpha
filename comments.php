<?php
/**
 * The template for displaying comments
 *
 * @package SignalfireAlpha
 * @since 1.0.0
 */

// If comments are closed and there are comments, let's leave a little note
if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
?>
    <p class="no-comments text-gray-600 text-sm italic"><?php esc_html_e('Comments are closed.', 'signalfire-wp-alpha'); ?></p>
<?php
endif;

if (have_comments()) :
?>
    <div id="comments" class="comments-area mt-8">
        <h2 class="comments-title text-2xl font-bold text-gray-900 mb-6">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(
                    /* translators: 1: title. */
                    esc_html__('One thought on &ldquo;%1$s&rdquo;', 'signalfire-wp-alpha'),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            } else {
                printf(
                    /* translators: 1: comment count number, 2: title. */
                    esc_html(_nx('%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'signalfire-wp-alpha')),
                    number_format_i18n($comment_count), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </h2>

        <ol class="comment-list space-y-6">
            <?php
            wp_list_comments([
                'style'      => 'ol',
                'short_ping' => true,
                'callback'   => 'signalfire_wp_alpha_comment_callback',
            ]);
            ?>
        </ol>

        <?php
        the_comments_navigation([
            'prev_text' => '<span class="nav-subtitle">' . esc_html__('Older comments', 'signalfire-wp-alpha') . '</span>',
            'next_text' => '<span class="nav-subtitle">' . esc_html__('Newer comments', 'signalfire-wp-alpha') . '</span>',
        ]);
        ?>

    </div>
<?php
endif;

// If comments are open or we have at least one comment, load up the comment template.
if (comments_open() || get_comments_number()) :
    comment_form([
        'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title text-xl font-semibold text-gray-900 mb-4">',
        'title_reply_after'  => '</h3>',
        'class_form'         => 'comment-form mt-8',
        'class_submit'       => 'btn btn-primary',
        'comment_field'      => '<div class="form-group mb-4"><label for="comment" class="form-label">' . esc_html__('Comment', 'signalfire-wp-alpha') . ' <span class="required text-red-500">*</span></label><textarea id="comment" name="comment" class="form-input" rows="6" required></textarea></div>',
        'fields'             => [
            'author' => '<div class="form-group mb-4"><label for="author" class="form-label">' . esc_html__('Name', 'signalfire-wp-alpha') . ' <span class="required text-red-500">*</span></label><input id="author" name="author" type="text" class="form-input" required /></div>',
            'email'  => '<div class="form-group mb-4"><label for="email" class="form-label">' . esc_html__('Email', 'signalfire-wp-alpha') . ' <span class="required text-red-500">*</span></label><input id="email" name="email" type="email" class="form-input" required /></div>',
            'url'    => '<div class="form-group mb-4"><label for="url" class="form-label">' . esc_html__('Website', 'signalfire-wp-alpha') . '</label><input id="url" name="url" type="url" class="form-input" /></div>',
        ],
    ]);
endif;