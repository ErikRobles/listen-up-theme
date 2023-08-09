<?php while (have_posts()) :
    the_post() ?>
    <div class="my-6 mx-auto page-content md:w-[60%]">
        <h1 class="text-center" style="color: <?php echo get_theme_mod('h1_color', '#000000'); ?>;">
            <?php the_title() ?>
        </h1>
        <div class="flex justify-center">

            <?php
            if (has_post_thumbnail()) :
                the_post_thumbnail('blog', array('class' => 'featured_image'));
            endif;
            ?>
        </div>
        <?php
        // Get the custom paragraph color from the customizer setting
        $paragraph_color = get_theme_mod('p_color', '#000000');
        // Filter the content and apply the color to <p> tags
        add_filter('the_content', function ($content) use ($paragraph_color) {
            return preg_replace_callback('/<p(.*?)>(.*?)<\/p>/', function ($matches) use ($paragraph_color) {
                $attributes = $matches[1];
                $content = $matches[2];
                return '<p' . $attributes . ' style="color: ' . esc_attr($paragraph_color) . '">' . $content . '</p>';
            }, $content);
        });
        the_content()
        ?>

    </div>
<?php endwhile; ?>