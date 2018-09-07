<?php
/**
 * RESPONSE FORM
 *
 * This displays the comment response form. This should not be loaded directly, but included by respond.php
 */
?>
<form action="<?= get_option( 'siteurl' ) ?>/wp-comments-post.php" method="post" id="commentform">

    <?php if( is_user_logged_in() ) { ?>

        <p><?php printf( __( 'Logged in as <a href="%1$s">%2$s</a>.' ), get_edit_user_link(), $user_identity ) ?></p>

    <?php } else { ?>

        <p><input type="text" name="author" id="author" value="<?= esc_attr( $comment_author ) ?>"
                  size="22" tabindex="1" <?= ( $req ) ? "aria-required='true'" : '' ?> />
            <label for="author">
                <small><?= __( 'Name', 'nv_lang_scope' ) ?> <?= ( $req ) ? __( '(required)' ) : '' ?></small>
            </label></p>

        <p><input type="text" name="email" id="email"
                  value="<?= esc_attr( $comment_author_email ) ?>" size="22"
                  tabindex="2" <?= ( $req ) ? "aria-required='true'" : '' ?> />
            <label for="email">
                <small><?= __( 'Mail (will not be published)', 'nv_lang_scope' ) ?> <?= ( $req ) ? __( '(required)', 'nv_lang_scope' ) : '' ?></small>
            </label></p>

        <p><input type="text" name="url" id="url" value="<?= esc_attr( $comment_author_url ) ?>"
                  size="22" tabindex="3"/>
            <label for="url">
                <small><?= __( 'Website', 'nv_lang_scope' ) ?></small>
            </label></p>

    <?php } ?>

    <p><textarea title="Leave your comment" name="comment" id="comment" cols="58" rows="10" tabindex="4"></textarea></p>

    <p><small><?= sprintf(__( 'You can use these tags: <code>%s</code>', 'nv_lang_scope' ), allowed_tags()) ?></small></p>

    <p><input name="submit" type="submit" id="submit" tabindex="5" class="button" value="<?= esc_attr(__( 'Submit Comment', 'nv_lang_scope' )) ?>"/>
        <?= get_comment_id_fields(0) ?>
    </p>

    <?php do_action( 'comment_form', $post->ID ) ?>

</form>