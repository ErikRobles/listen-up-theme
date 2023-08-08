<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php get_header(); ?>
<?php while (have_posts()):
    the_post() ?>
    <div class="">
        <div class=" my-8 mx-auto ">
            <h1 class="text-3xl">
                <?php the_title() ?>
            </h1>
            <?php the_content() ?>
        </div>
    </div>
<?php endwhile; ?>
<?php get_footer() ?>