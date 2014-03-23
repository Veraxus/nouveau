<?php
/**
 * SINGLE COMMENT PART
 *
 * This is used by the NV comment walker to output a single comment.
 */
$classes = array('comment');
if ( $args['has_children'] ) {
    $classes[] = 'parent';
}
?>
<article id="comment-<?php comment_ID(); ?>" <?php comment_class( $classes ); ?>>
    <footer class="comment-meta">
        
        <div class="comment-author">
            <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
            <?php printf( __( '%s <span class="says">says:</span>', 'nvLangScope' ), sprintf( '<b class="fn">%s</b>', get_comment_author_link() ) ); ?>
        </div>

        <div class="comment-metadata">
            <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                <time datetime="<?php comment_time( 'c' ); ?>">
                    <?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'nvLangScope' ), get_comment_date(), get_comment_time() ); ?>
                </time>
            </a>
            <?php edit_comment_link( __( 'Edit', 'nvLangScope' ), '<span class="edit-link">', '</span>' ); ?>
        </div>

        <?php if ( '0' == $comment->comment_approved ) : ?>
            <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'nvLangScope' ); ?></p>
        <?php endif; ?>

    </footer>

    <div class="comment-content">
        <?php comment_text(); ?>
    </div>

    <div class="reply">
        <?php comment_reply_link( array_merge( $args, array( 'add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
    </div>
</article>