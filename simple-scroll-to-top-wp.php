<?php

/**
 * Plugin Name: Simple Scroll To Top WP
 * Plugin URI: https://wordpress.org/plugins/simple-scroll-to-top-wp/
 * Description: Simple Scroll to top plugin will help you to enable Back to Top button on your WordPress website.
 * Version: 1.0.0
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Author: MD Nafish Fuad Tushar
 * Author URI: https://nftushar.com/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI: https://github.com/nftushar
 * Text Domain: sstt
 */

function sstt_add_theme_page()
{
  add_menu_page('Scroll To Top', 'Scroll To Top', 'manage_options', 'sstt-plugin-option', 'sstt_create_page', 'dashicons-arrow-up-alt', 101);
}
add_action('admin_menu', 'sstt_add_theme_page');


// Including CSS
function sstt_enqueue_style()
{
  wp_enqueue_style('sstt-style', plugins_url('css/sstt-style.css', __FILE__));
}
add_action("wp_enqueue_scripts", "sstt_enqueue_style");

// Including JavaScript
function sstt_enqueue_scripts()
{
  wp_enqueue_script('jquery');
  wp_enqueue_script('sstt-plugin-script', plugins_url('js/sstt-plugin.js', __FILE__), array(), '1.0.0', true);
}
add_action("wp_enqueue_scripts", "sstt_enqueue_scripts");

// jQuery Plugin Setting Activation
function sstt_scroll_script()
{
?>
  <script>
    jQuery(document).ready(function() {
      jQuery.scrollUp();
    });
  </script>
<?php
}
add_action("wp_footer", "sstt_scroll_script");

/**
 * Plugin Callback
 */
function sstt_create_page()
{
?>

<div class="sstt-customize-form">
    <h3 id="title"><?php echo esc_html('Scroll To Top Page Customize'); ?></h3>

    <form method="post" action="options.php">
        <?php settings_fields('sstt_settings_group'); ?>
        <?php do_settings_sections('sstt-settings'); ?>

        <label for="sstt-primary-color"><?php echo esc_html("Button Color:"); ?></label>
        <input type="color" name="sstt-primary-color" value="<?php echo esc_attr(get_option("sstt-primary-color")); ?>">

        <label for="sstt-rounded-corner"><?php echo esc_html("Rounded Corner:"); ?></label>
        <input type="text" name="sstt-rounded-corner" value="<?php echo esc_attr(get_option("sstt-rounded-corner")); ?>">

        <?php submit_button(); ?>
    </form>
</div>



<?php }

function sstt_register_settings(){
  register_setting('sstt_settings_group', 'sstt-primary-color');
  register_setting('sstt_settings_group', 'sstt-rounded-corner');
}
add_action('admin_init', 'sstt_register_settings');

  
// Theme CSS Customization
function sstt_theme_color_cus()
{
?>
  <style>
    #scrollUp {
      background-color: <?php echo get_theme_mod("sstt_default_color", '#000000'); ?>;
      border-radius: <?php echo get_theme_mod("sstt_rounded_corner", '5px'); ?>;
    }
  </style>
<?php
}
add_action('wp_head', 'sstt_theme_color_cus');


?>