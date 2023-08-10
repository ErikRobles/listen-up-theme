<?php get_header(); ?>

<main class="page max-w-[80rem] px-[5rem] m-auto flex flex-col justify-between md:flex-row gap-5 mb-0 md:mb-[4rem] mt-6">
    <div class="flex flex-col">
        <ul class="blog-entries">
            <?php while (have_posts()) : the_post(); ?>
                <li class="card gradient">
                    <?php the_post_thumbnail('mediumSize'); ?>
                    <div class="card-content">
                        <a href="<?php the_permalink(); ?>">
                            <h3 class="text-white font-bold"><?php the_title() ?></h3>
                        </a>
                        <p class="meta pointer text-white font-bold"><span>By: </span>
                            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                                <?php echo get_the_author_meta('display_name'); ?>
                            </a>
                        </p>
                        <p class="date-published">
                            <span class="text-white font-bold"><?php echo get_the_date(); ?></span>
                        </p>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</main>

<?php get_footer(); ?>