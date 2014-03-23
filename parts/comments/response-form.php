<?php
/**
 * RESPONSE FORM
 *
 * This displays the comment response form. This should not be loaded directly, but included by respond.php
 */
?>
<form action="<?php echo get_option( 'siteurl' ); ?>/wp-comments-post.php" method="post" id="commentform">

    <?php if( is_user_logged_in() ) { ?>

        <p><?php printf( __( 'Logged in as <a href="%1$s">%2$s</a>.' ), get_edit_user_link(), $user_identity ); ?></p>

    <?php } else { ?>

        <p><input type="text" name="author" id="author" value="<?php echo esc_attr( $comment_author ); ?>"
                  size="22" tabindex="1" <?php if( $req ) {
                echo "aria-required='true'";
            } ?> />
            <label for="author">
                <small><?php _e( 'Name', 'nvLangScope' ); ?> <?php if( $req ) {
                        _e( '(required)' );
                    } ?></small>
            </label></p>

        <p><input type="text" name="email" id="email"
                  value="<?php echo esc_attr( $comment_author_email ); ?>" size="22"
                  tabindex="2" <?php if( $req ) {
                echo "aria-required='true'";
            } ?> />
            <label for="email">
                <small><?php _e( 'Mail (will not be published)', 'nvLangScope' ); ?> <?php if( $req ) {
                        _e( '(required)', 'nvLangScope' );
                    } ?></small>
            </label></p>

        <p><input type="text" name="url" id="url" value="<?php echo esc_attr( $comment_author_url ); ?>"
                  size="22" tabindex="3"/>
            <label for="url">
                <small><?php _e( 'Website', 'nvLangScope' ); ?></small>
            </label></p>

    <?php } ?>

    <p><textarea name="comment" id="comment" cols="58" rows="10" tabindex="4"></textarea></p>

    <p><small><?php printf(__( 'You can use these tags: <code>%s</code>', 'nvLangScope' ), allowed_tags()); ?></small></p>

    <p><input name="submit" type="submit" id="submit" tabindex="5" class="button" value="<?php esc_attr_e( 'Submit Comment', 'nvLangScope' ); ?>"/>
        <?php comment_id_fields(); ?>
    </p>

    <?php do_action( 'comment_form', $post->ID ); ?>

</form>