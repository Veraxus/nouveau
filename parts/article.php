<?php
/**
 * ARTICLE PART (NO COMMENTS)
 *
 * This part can be used IN THE LOOP to output a single article (sans comments).
 */
?>
<article id="article-<?php the_ID() ?>" class="<?php echo implode(get_post_class(),' ') ?>">

    <h1><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>

    <?php the_post_thumbnail() ?>

    <div>
        <?php the_content() ?>
    </div>

</article>