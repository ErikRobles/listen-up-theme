<footer class="py-6 site-footer">
    <div class="container mx-auto flex justify-center items-center gap-5">
        <?php
        $args = array(
            'theme_location' => 'main-menu',
            'container' => 'nav',
            'container_class' => 'main-menu',
        );
        wp_nav_menu($args);
        ?>
    </div>
</footer>

<?php wp_footer(); ?>

</body>

</html>