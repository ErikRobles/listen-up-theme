<?php 
/*
*  Template Name: Page with Sidebar
*/
get_header(); ?>
<main class="page max-w-[80rem] px-[5rem] m-auto flex flex-col justify-between md:flex-row gap-5">
    <div class="my-6 mx-auto page-content w-full md:w-[80%]">
        <?php get_template_part('/template-parts/page', 'loop') ?>
    </div>
    <?php get_sidebar(); ?>
</main>
<?php get_footer() ?>