<?php
/*
*  Template Name: Page with Sidebar
*/
get_header(); ?>
<main class="page max-w-[80rem] px-[5rem] m-auto flex flex-col justify-between md:flex-row gap-5 mb-0 md:mb-[4rem] mt-6">
    <div class="mx-auto page-content md:w-[60%]">
        <?php get_template_part('/template-parts/page', 'loop') ?>
    </div>
    <?php get_sidebar(); ?>
</main>
<?php get_footer() ?>