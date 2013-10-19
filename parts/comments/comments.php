<?php
// TODO: This needs SUBSTANTIAL cleanup.

if ( post_password_required() ) {
    echo '<p>'.__( 'This post is password protected. Enter the password to view comments.', 'nvLangScope' ).'</p>';
    return;
}

if ( have_comments() ) { ?>

    <h3><?php _e('Comments') ?></h3>
    <p>
    <?php
    printf(
        _n(
            'One Response to %2$s',     // Single comment text
            '%1$s Responses to %2$s',   // Multiple comment text
            get_comments_number()       // The number of comments to determine which string to use
        ),
        number_format_i18n( get_comments_number() ),    // %1$s
        '&#8220;'.get_the_title().'&#8221;'             // %2$s
    );
    ?>
    </p>


    <div class="nav-comments">
        <div class="alignleft"><?php previous_comments_link() ?></div>
        <div class="alignright"><?php next_comments_link() ?></div>
    </div>


    <ol class="commentlist">
        <?php wp_list_comments(); ?>
    </ol>


    <div class="nav-comments">
        <div class="alignleft"><?php previous_comments_link() ?></div>
        <div class="alignright"><?php next_comments_link() ?></div>
    </div>


<?php
}
else
{
    // this is displayed if there are no comments so far
    if ( comments_open() ) {
        //Do stuff if comments are open but there are no comments.
    }
    else {
        echo '<p>'.__( 'Comments are closed.', 'nvLangScope' ).'</p>';
    }
}


if ( comments_open() ) { ?>

    <div id="respond">

        <h3><?php comment_form_title( __( 'Leave a Reply', 'nvLangScope' ), __( 'Leave a Reply to %s', 'nvLangScope' ) ); ?></h3>

        <div id="cancel-comment-reply">
            <small><?php cancel_comment_reply_link() ?></small>
        </div>

        <?php
        if( get_option( 'comment_registration' ) && !is_user_logged_in() ) {

            printf( '<p>%s</p>',
                sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'nvLangScope' ),
                    wp_login_url( get_permalink() )
                )
            );

        }
        else {
            require 'comments-form.php';
        } // If registration required and not logged in ?>
    </div>

<?php } // if you delete this the sky will fall on your head