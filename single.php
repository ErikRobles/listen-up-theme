<?php get_header(); ?>
<?php while (have_posts()):
    the_post() ?>
    <div>
        <div class="container my-8 mx-auto ">
            <h1 class="text-small">
                <?php the_title() ?>
            </h1>
            <?php the_content() ?>
        </div>
    </div>
<?php endwhile; ?>
<?php get_footer() ?>