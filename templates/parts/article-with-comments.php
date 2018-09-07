<?php
/**
 * PART: ARTICLE WITH COMMENTS
 *
 * This part can be used IN THE LOOP to output a single article with comments.
 */

use NV\Theme\Core\Theme;

?>
<article id="article-<?php the_ID() ?>" class="<?= implode(get_post_class(), ' ') ?>">

    <h1 class="article-head"><?php the_title() ?></h1>

    <?php the_post_thumbnail() ?>

    <div class="content">
        <?php the_content() ?>
        <?php wp_link_pages() ?>
    </div>

    <footer>
        <div id="comments">
            <?php Theme::comments() ?>
        </div>
    </footer>

</article>