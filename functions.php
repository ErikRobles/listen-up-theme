<?php

function listenup_menus()
{
   register_nav_menus(array(
      'main-menu' => "Main Menu",
   ));
}
add_action('init', 'listenup_menus');

// Add Stylesheets and JS files
function listenup_scripts()
{
   wp_enqueue_script('jquery'); // Enqueue jQuery
   wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/custom-script.js', array('jquery'), '1.0.0', true); // Enqueue the custom script
   wp_enqueue_style('style', get_template_directory_uri() . "/css/style.min.css", array(), '3.3.1');

   // Enqueue Slick Nav
   wp_enqueue_script('slicknavjs', get_template_directory_uri() . '/js/jquery.slicknav.min.js', array('jquery'), '1.0.10', true);
   wp_enqueue_style('slicknavcss', get_template_directory_uri() . "/css/slicknav.min.css", array(), '1.0.10');
   wp_enqueue_style('custom-slicknav-style', get_template_directory_uri() . '/css/custom-slicknav.css', array('slicknavcss'), '1.0.0');


   wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap', array(), '1.0.0');
}

add_action('wp_enqueue_scripts', 'listenup_scripts');

function custom_theme_setup()
{
   // Add support for custom logo in customizer
   add_theme_support('custom-logo', array(
      'height'      => 100, // Adjust the height as needed
      'width'       => 300, // Adjust the width as needed
      'flex-height' => true,
      'flex-width'  => true,
   ));

   // Add custom setting for logo size in customizer
   add_action('customize_register', 'custom_theme_customize_register');
   // Add customizer settings and controls for the Navbar/Header and SlickNav
   add_action('customize_register', 'custom_theme_navbar_customize_register');
   add_action('customize_register', 'custom_theme_slicknav_customize_register');
}
add_action('after_setup_theme', 'custom_theme_setup');

function custom_theme_customize_register($wp_customize)
{
   // Add a custom setting for logo size
   $wp_customize->add_setting('custom_logo_size', array(
      'default'           => 100, // Default size
      'sanitize_callback' => 'absint', // Ensure the value is an integer
   ));

   // Add a custom control for the logo size slider
   $wp_customize->add_control('custom_logo_size', array(
      'type'        => 'range',
      'section'     => 'title_tagline', // Customize the section if needed
      'priority'    => 9,
      'label'       => __('Logo Size', 'listen-up'),
      'input_attrs' => array(
         'min'   => 50, // Minimum size
         'max'   => 300, // Maximum size
         'step'  => 1, // Step size
      ),
   ));

   // Add a custom setting for menu items font size
   $wp_customize->add_setting('menu_items_font_size', array(
      'default'           => 16, // Default font size
      'sanitize_callback' => 'absint', // Sanitize the value to an integer
   ));

   // Add a custom control for the menu items font size slider
   $wp_customize->add_control('menu_items_font_size', array(
      'type'        => 'range',
      'section'     => 'colors', // Add it to the "colors" section
      'priority'    => 10,
      'label'       => __('Menu Items Font Size', 'listen-up'),
      'input_attrs' => array(
         'min'   => 10, // Minimum font size
         'max'   => 30, // Maximum font size
         'step'  => 1, // Step size
      ),
   ));

   // Change Heading Color in Customizer
   $wp_customize->add_section('header_colors', array(
      'title' => __('Header Colors', 'listen-up'),
      'priority' => 30,
   ));

   // Add a setting for the H1 color
   $wp_customize->add_setting('h1_color', array(
      'default' => '#000000',
      'sanitize_callback' => 'sanitize_hex_color',
   ));

   // Add a control for the H1 color
   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'h1_color', array(
      'label' => __('H1 Color', 'listen-up'),
      'section' => 'header_colors',
   )));

   // Add a function for the P color via the Customizer
   $wp_customize->add_section('paragraph_colors', array(
      'title' => __('Paragraph Colors', 'listen-up'),
      'priority' => 30,
   ));
   // Add a setting for the p color
   $wp_customize->add_setting('p_color', array(
      'default' => '#000000',
      'sanitize_callback' => 'sanitize_hex_color',
   ));

   // Add a control for the p color
   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'p_color', array(
      'label' => __('Paragraph Color', 'listen-up'),
      'section' => 'paragraph_colors', // Make sure to use the correct section name
   )));


   // Add Customizer function for H2-H6 Colors
   // Add a setting for H2 color
   $wp_customize->add_setting('h2_color', array(
      'default' => '#000000',
      'sanitize_callback' => 'sanitize_hex_color',
   ));

   // Add a control for H2 color
   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'h2_color', array(
      'label' => __('H2 Color', 'listen-up'),
      'section' => 'header_colors', // Change this to 'header_colors'
   )));

   // Add a setting for H3 color
   $wp_customize->add_setting('h3_color', array(
      'default' => '#000000',
      'sanitize_callback' => 'sanitize_hex_color',
   ));

   // Add a control for H3 color
   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'h3_color', array(
      'label' => __('H3 Color', 'listen-up'),
      'section' => 'header_colors', // Change this to 'header_colors'
   )));
}

function customize_heading_colors_in_content($content)
{
   $h2_color = get_theme_mod('h2_color', '#000000');
   $h3_color = get_theme_mod('h3_color', '#000000');

   // Modify H2 headings
   $content = preg_replace('/<h2(.*?)>(.*?)<\/h2>/i', '<h2$1 style="color: ' . esc_attr($h2_color) . '">$2</h2>', $content);

   // Modify H3 headings
   $content = preg_replace('/<h3(.*?)>(.*?)<\/h3>/i', '<h3$1 style="color: ' . esc_attr($h3_color) . '">$2</h3>', $content);


   return $content;
}
add_filter('the_content', 'customize_heading_colors_in_content');


function custom_theme_logo_size()
{
   $logo_size = get_theme_mod('custom_logo_size', 100); // Get the customizer setting value
   $logo_id   = get_theme_mod('custom_logo'); // Get the custom logo ID

   // Output the logo with the inline styles
   if ($logo_id) {
      $image = wp_get_attachment_image_src($logo_id, 'full');
      $logo_style = sprintf('style="max-height: %dpx; width: auto;"', $logo_size);
      echo '<img src="' . esc_url($image[0]) . '" alt="' . get_bloginfo('name') . '" ' . $logo_style . '>';
   } else {
      echo '<h1 class="site-title">';
      echo '<a href="' . esc_url(home_url('/')) . '" rel="home">' . get_bloginfo('name') . '</a>';
      echo '</h1>';
   }
}

// Navbar/Header Customizer Settings
function custom_theme_navbar_customize_register($wp_customize)
{
   // Add a custom setting for the Navbar/Header background color
   $wp_customize->add_setting('navbar_bg_color', array(
      'default'           => '#222', // Default background color
      'sanitize_callback' => 'sanitize_hex_color', // Sanitize the color value
   ));

   // Add a custom control for the Navbar/Header background color
   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'navbar_bg_color', array(
      'label'      => __('Navbar/Header Background Color', 'listen-up'),
      'section'    => 'colors',
      'settings'   => 'navbar_bg_color',
   )));

   // Add a custom setting for the Navbar/Header font color
   $wp_customize->add_setting('navbar_font_color', array(
      'default'           => '#ffffff', // Default font color
      'sanitize_callback' => 'sanitize_hex_color', // Sanitize the color value
   ));

   // Add a custom control for the Navbar/Header font color
   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'navbar_font_color', array(
      'label'      => __('Navbar/Header Font Color', 'listen-up'),
      'section'    => 'colors',
      'settings'   => 'navbar_font_color',
   )));

   // Add a custom setting for the Navbar/Header hover color (text color on hover)
   $wp_customize->add_setting('navbar_hover_color', array(
      'default'           => '#ff0000', // Default hover color
      'sanitize_callback' => 'sanitize_hex_color', // Sanitize the color value
   ));

   // Add a custom control for the Navbar/Header hover color (text color on hover)
   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'navbar_hover_color', array(
      'label'      => __('Navbar/Header Hover Text Color', 'listen-up'),
      'section'    => 'colors',
      'settings'   => 'navbar_hover_color',
   )));

   // Add a custom setting for the Navbar/Header hover background color
   $wp_customize->add_setting('navbar_hover_bg_color', array(
      'default'           => '#ff0000', // Default hover background color
      'sanitize_callback' => 'sanitize_hex_color', // Sanitize the color value
   ));

   // Add a custom control for the Navbar/Header hover background color
   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'navbar_hover_bg_color', array(
      'label'      => __('Navbar/Header Hover Background Color', 'your-theme-textdomain'),
      'section'    => 'colors',
      'settings'   => 'navbar_hover_bg_color',
   )));

   // Add other customizer settings and controls for the Navbar/Header here
   // ...
}
function custom_theme_footer_customize_register($wp_customize) {
   // Add a custom section for Footer settings
   $wp_customize->add_section('footer_settings', array(
      'title' => __('Footer Settings', 'your-theme-textdomain'),
      'priority' => 120,
   ));

   // Footer background color
   $wp_customize->add_setting('footer_bg_color', array(
      'default' => '#000000',
      'sanitize_callback' => 'sanitize_hex_color',
   ));
   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_bg_color', array(
      'label' => __('Footer Background Color', 'your-theme-textdomain'),
      'section' => 'footer_settings',
      'settings' => 'footer_bg_color',
   )));

   // Footer text color
   $wp_customize->add_setting('footer_text_color', array(
      'default' => '#ffffff',
      'sanitize_callback' => 'sanitize_hex_color',
   ));
   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_text_color', array(
      'label' => __('Footer Text Color', 'your-theme-textdomain'),
      'section' => 'footer_settings',
      'settings' => 'footer_text_color',
   )));

   // Footer text hover color
   $wp_customize->add_setting('footer_text_hover_color', array(
      'default' => '#aaaaaa',
      'sanitize_callback' => 'sanitize_hex_color',
   ));
   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_text_hover_color', array(
      'label' => __('Footer Text Hover Color', 'your-theme-textdomain'),
      'section' => 'footer_settings',
      'settings' => 'footer_text_hover_color',
   )));

   // Footer menu hover background color
   $wp_customize->add_setting('footer_menu_hover_bg_color', array(
      'default'           => 'rgba(0, 0, 0, 0)', // Full transparency
      'sanitize_callback' => 'sanitize_hex_color',
   ));
   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_menu_hover_bg_color', array(
      'label' => __('Footer Menu Hover Background Color', 'listen-up'),
      'section' => 'footer_settings',
      'settings' => 'footer_menu_hover_bg_color',
   )));
}
add_action('customize_register', 'custom_theme_footer_customize_register');

function custom_theme_footer_styles() {
   echo '<style type="text/css">';
   
   // Footer background color
   echo '.site-footer { background-color: ' . get_theme_mod('footer_bg_color', '#000000') . '; }';
   
   // Footer text color
   echo '.site-footer, .site-footer a { color: ' . get_theme_mod('footer_text_color', '#ffffff') . '; }';
   
   // Footer text hover color
   echo '.site-footer a:hover { color: ' . get_theme_mod('footer_text_hover_color', '#ff0000') . '; }';
   
   // Footer menu item hover background color
   echo '.site-footer .main-menu li:hover { background-color: ' . get_theme_mod('footer_menu_hover_bg_color', '#ff0000') . '; }';

   echo '</style>';
}
add_action('wp_head', 'custom_theme_footer_styles');



// SlickNav Customizer Settings
function custom_theme_slicknav_customize_register($wp_customize)
{
   // Add customizer settings and controls for the SlickNav here
   // ...

   // Add a custom setting for the SlickNav background color
   $wp_customize->add_setting('slicknav_bg_color', array(
      'default'           => '#222', // Default background color
      'sanitize_callback' => 'sanitize_hex_color', // Sanitize the color value
   ));

   // Add a custom control for the SlickNav background color
   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slicknav_bg_color', array(
      'label'      => __('SlickNav Background Color', 'listen-up'),
      'section'    => 'colors',
      'settings'   => 'slicknav_bg_color',
   )));

   // Add a custom setting for the SlickNav font color
   $wp_customize->add_setting('slicknav_font_color', array(
      'default'           => '#ffffff', // Default font color
      'sanitize_callback' => 'sanitize_hex_color', // Sanitize the color value
   ));

   // Add a custom control for the SlickNav font color
   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slicknav_font_color', array(
      'label'      => __('SlickNav Font Color', 'your-theme-textdomain'),
      'section'    => 'colors',
      'settings'   => 'slicknav_font_color',
   )));

   // Add a custom setting for the SlickNav hover color (text color on hover)
   $wp_customize->add_setting('slicknav_hover_color', array(
      'default'           => '#ff0000', // Default hover color
      'sanitize_callback' => 'sanitize_hex_color', // Sanitize the color value
   ));

   // Add a custom control for the SlickNav hover color (text color on hover)
   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slicknav_hover_color', array(
      'label'      => __('SlickNav Hover Text Color', 'your-theme-textdomain'),
      'section'    => 'colors',
      'settings'   => 'slicknav_hover_color',
   )));

   // Add a custom setting for the SlickNav hover background color
   $wp_customize->add_setting('slicknav_hover_bg_color', array(
      'default'           => '#ff0000', // Default hover background color
      'sanitize_callback' => 'sanitize_hex_color', // Sanitize the color value
   ));

   // Add a custom control for the SlickNav hover background color
   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slicknav_hover_bg_color', array(
      'label'      => __('SlickNav Hover Background Color', 'your-theme-textdomain'),
      'section'    => 'colors',
      'settings'   => 'slicknav_hover_bg_color',
   )));

   // Add other customizer settings and controls for the SlickNav here
   // ...
}

function custom_theme_customizer_css()
{
?>
   <style type="text/css">
      /* Navbar/Header styles */
      .site-header {
         background-color: <?php echo get_theme_mod('navbar_bg_color', '#222'); ?>;
         color: <?php echo get_theme_mod('navbar_font_color', '#ffffff'); ?>;
      }

      .site-header a {
         color: <?php echo get_theme_mod('navbar_font_color', '#ffffff'); ?>;
      }

      .site-header a:hover {
         color: <?php echo get_theme_mod('navbar_hover_color', '#ff0000'); ?>;
         background-color: <?php echo get_theme_mod('navbar_hover_bg_color', '#ff0000'); ?>;
      }

      /* SlickNav styles */
      /* SlickNav styles */
      .slicknav_nav {
         background-color: <?php echo get_theme_mod('slicknav_bg_color', '#222'); ?>;
         color: <?php echo get_theme_mod('slicknav_font_color', '#ffffff'); ?>;
      }

      .slicknav_nav a {
         color: <?php echo get_theme_mod('slicknav_font_color', '#ffffff'); ?>;
      }

      .slicknav_nav a:hover {
         color: <?php echo get_theme_mod('slicknav_hover_color', '#ff0000'); ?>;
         background-color: <?php echo get_theme_mod('slicknav_hover_bg_color', '#ff0000'); ?>;
      }

      /* Additional styles for .slicknav_menu */
      .slicknav_menu {
         background-color: <?php echo get_theme_mod('slicknav_bg_color', '#222'); ?>;
      }
   </style>
<?php
}
add_action('wp_head', 'custom_theme_customizer_css');

function custom_header_menu_items_style()
{
   $menu_items_font_size = get_theme_mod('menu_items_font_size', 16);

   // Output the menu items font size style
   echo '<style type="text/css">';
   echo '.navigation-bar .main-menu li a { font-size: ' . $menu_items_font_size . 'px; }';
   echo '</style>';
}
add_action('wp_head', 'custom_header_menu_items_style');

function custom_slicknav_menu_items_style()
{
   $menu_items_font_size = get_theme_mod('menu_items_font_size', 16);

   // Output the SlickNav menu items font size style
   echo '<style type="text/css">';
   echo '.slicknav_nav a { font-size: ' . $menu_items_font_size . 'px; }';
   echo '</style>';
}
add_action('wp_head', 'custom_slicknav_menu_items_style');


function listenup_setup()
{

   // Register new image sizes

   add_image_size('square', 350, 350, true);
   add_image_size('portrait', 350, 724, true);
   add_image_size('box', 400, 375, true);
   add_image_size('mediumSize', 700, 400, true);
   add_image_size('blog', 966, 644, true);

   // Enable featured Image
   add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', 'listenup_setup');

function custom_enqueue_customizer_reset_script() {
   wp_enqueue_script('customizer-reset', get_template_directory_uri() . '/js/customizer-reset.js', array('customize-controls'), null, true);
}
add_action('customize_controls_enqueue_scripts', 'custom_enqueue_customizer_reset_script');

