<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <title>Document</title>


</head>

<body>
    <header class="site-header">
        <div>
            <div class="navigation-bar">
                <div class="logo">
                    <a href="<?php echo home_url(); ?>">
                        <?php custom_theme_logo_size(); ?>
                    </a>
                </div><!-- logo -->
                <div>
                    <?php
                    $args = array(
                        'theme_location' => 'main-menu',
                        'container' => 'nav',
                        'container_class' => 'main-menu',
                    );
                    wp_nav_menu($args);
                    ?>
                </div>
            </div>

        </div>
    </header>