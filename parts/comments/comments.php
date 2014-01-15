<?php
/**
 * Template Part: Comments Listing
 *
 * This template part can be loaded in primary templates to enable comments in that template. To do so, use the
 * following in your template:
 *
 * <?php comments_template( '/parts/comments/comments.php' ); ?>
 */

// If the parent post is password protected, exit without doing anything
if ( post_password_required() ) {
    return;
}


// But if we have comments...
if ( have_comments() ) { ?>

    <h3><?php _e('Comments','nvLangScope') ?></h3>
    <h5>
        <?php
        printf(
            _n(
                'One Response to %2$s',                 // Text if single comments
                'There are %1$s Responses to %2$s',     // Text if multiple comments
                get_comments_number(),                  // The number of comments (determines which string to use)
                'nvLangScope'
            ),
            number_format_i18n( get_comments_number() ),    // %1$s
            '&#8220;'.get_the_title().'&#8221;'             // %2$s
        );
        ?>
    </h5>

    <div class="nav-comments">
        <div class="alignleft"><?php previous_comments_link() ?></div>
        <div class="alignright"><?php next_comments_link() ?></div>
    </div>

    <ol class="comment-list">
        <?php wp_list_comments( array( 'walker' => new \NV\Custom\WalkerComments ) ); ?>
    </ol>

    <div class="nav-comments">
        <div class="alignleft"><?php previous_comments_link() ?></div>
        <div class="alignright"><?php next_comments_link() ?></div>
    </div>

    <?php
}

// If comments are closed...
if ( ! comments_open() ) {
    echo '<p>'.__( 'Comments are closed.', 'nvLangScope' ).'</p>';
}


// Comments are NOT closed, show response form...
else {
    require('comments-respond.php');
}