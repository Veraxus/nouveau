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


    <?php include 'comments-nav.php'; ?>

    <ol class="commentlist">
        <?php wp_list_comments( array( 'walker' => new \NV\Custom\WalkerComments ) ); ?>
    </ol>

    <?php include 'comments-nav.php'; ?>


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


if ( comments_open() ) {
    require('comments-respond.php');
}