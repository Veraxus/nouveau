<?php
/**
 * PRIMARY COMMENT TEMPLATE
 *
 * This file loads NOUVEAU's customizable comment system. This should be used including the following code in your page
 * or article templates:
 * 
 * comments_template( '/parts/comments/comments.php' );
 */

if ( post_password_required() ) {
    echo '<p>'.__( 'This post is password protected. Enter the password to view comments.', 'nvLangScope' ).'</p>';
    return;
}

if ( have_comments() ) { ?>

    <h3><?php _e('Comments', 'nvLangScope' ) ?></h3>
    <p>
    <?php
    printf(
        _n(
            'One Response to %2$s',     // Single comment text
            '%1$s Responses to %2$s',   // Multiple comment text
            get_comments_number(),      // The number of comments to determine which string to use
            'nvLangScope'
        ),
        number_format_i18n( get_comments_number() ),    // %1$s
        '&#8220;'.get_the_title().'&#8221;'             // %2$s
    );
    ?>
    </p>


    <?php include( NV_PARTS . '/comments/pagination.php' ); ?>

    <section class="comments-list">
        <?php wp_list_comments(array(
            'walker' => new \NV\Custom\WalkerComments()
        )); ?>
    </section>

    <?php include( NV_PARTS . '/comments/pagination.php' ); ?>


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
    include( NV_PARTS . '/comments/respond.php' );
}