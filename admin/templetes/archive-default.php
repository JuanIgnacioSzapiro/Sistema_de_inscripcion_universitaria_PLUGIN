<?php
/**
 * Materias Archive
 */
get_header(); ?>

<h1>All Subjects</h1>

<?php while (have_posts()) : the_post(); ?>
    <article>
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <pre><?php echo get_post_meta(get_the_ID()); ?></pre>
    </article>
<?php endwhile;

get_footer();