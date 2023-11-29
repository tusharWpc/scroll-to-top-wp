<?php

/**
 * Plugin Name: Simple Scroll To Top WP
 * Plugin URI: https://wordpress.org/plugins/simple-scroll-to-top-wp/
 * Description: Simple Scroll to Top plugin will help you to enable Back to Top button on your WordPress website.
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

function sstt_add_theme_css(){
  wp_enqueue_style( 'sstt-admin-style', plugins_url( 'css/sstt-admin-style.css', __FILE__ ), false, "1.0.0");

}
add_action('admin_enqueue_scripts', 'sstt_add_theme_css');

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

        <table>
            <tbody>

                <tr>
                    <th><label for="sstt-primary-color"><?php echo esc_html("Button Color:"); ?></label></th>
                    <td><input type="color" name="sstt-primary-color" value="<?php echo esc_attr(get_option("sstt-primary-color")); ?>"></td>
                </tr>
                <tr>
                    <th><label for="sstt-rounded-corner"><?php echo esc_html("Rounded Corner:"); ?></label></th>
                    <td><input type="number" name="sstt-rounded-corner" value="<?php echo esc_attr(get_option("sstt-rounded-corner")); ?>"></td>
                </tr>
                <tr>
                    <th><label for="sstt-alignment"><?php echo esc_html("Alignment:"); ?></label></th>
                    <td>
                        <select name="sstt-alignment">
                            <option value="left" <?php selected(get_option('sstt-alignment'), 'left'); ?>>Left</option>
                            <option value="right" <?php selected(get_option('sstt-alignment'), 'right'); ?>>Right</option>
                        </select>
                    </td>
                </tr>

                <!-- New Display Settings -->
                <tr>
                    <th><label for="sstt-enabled">Enabled</label></th>
                    <td><input type="checkbox" name="sstt-enabled" <?php checked(get_option('sstt-enabled'), 1); ?>></td>
                </tr>
                <tr>
                    <th><label for="sstt-javascript-async">Javascript Async</label></th>
                    <td><input type="checkbox" name="sstt-javascript-async" <?php checked(get_option('sstt-javascript-async')); ?>></td>
                </tr>
                <tr>
                    <th><label for="sstt-scroll-offset">Scroll Offset:</label></th>
                    <td><input type="number" name="sstt-scroll-offset" value="<?php echo esc_attr(get_option("sstt-scroll-offset", 100)); ?>" placeholder="px"></td>
                </tr>
                <tr>
                    <th><label for="sstt-button-size-width">Button Size Width:</label></th>
                    <td><input type="number" name="sstt-button-size-width" value="<?php echo esc_attr(get_option("sstt-button-size-width", 0)); ?>" placeholder="px"></td>
                </tr>
                <tr>
                    <th><label for="sstt-button-size-height">Button Size Height:</label></th>
                    <td><input type="number" name="sstt-button-size-height" value="<?php echo esc_attr(get_option("sstt-button-size-height", 0)); ?>" placeholder="px"></td>
                </tr>
                <!-- Add the rest of the display settings similarly -->
            </tbody>
        </table>

        <!-- Location Settings -->
        <h3>Location Settings:</h3>
        <table>
            <tbody>
                <tr>
                    <th><label for="sstt-location">Location:</label></th>
                    <td>
                        <select name="sstt-location">
                            <option value="bottom-right" <?php selected(get_option('sstt-location'), 'bottom-right'); ?>>Bottom Right</option>
                            <option value="bottom-left" <?php selected(get_option('sstt-location'), 'bottom-left'); ?>>Bottom Left</option>
                            <option value="top-right" <?php selected(get_option('sstt-location'), 'top-right'); ?>>Top Right</option>
                            <option value="top-left" <?php selected(get_option('sstt-location'), 'top-left'); ?>>Top Left</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="sstt-margin-x">Margin X:</label></th>
                    <td><input type="number" name="sstt-margin-x" value="<?php echo esc_attr(get_option("sstt-margin-x", 20)); ?>" placeholder="px"></td>
                </tr>
                <tr>
                    <th><label for="sstt-margin-y">Margin Y:</label></th>
                    <td><input type="number" name="sstt-margin-y" value="<?php echo esc_attr(get_option("sstt-margin-y", 20)); ?>" placeholder="px"></td>
                </tr>
            </tbody>
        </table>

        <!-- Filter Settings -->
        <h3>Filter Settings:</h3>
        <table>
            <tbody>
                <tr>
                    <th><label for="sstt-display-on-pages">Display on Pages:</label></th>
                    <td><input type="text" name="sstt-display-on-pages" value="<?php echo esc_attr(get_option("sstt-display-on-pages")); ?>" placeholder="Page IDs (comma-separated)"></td>
                </tr>
            </tbody>
        </table>

        <?php submit_button(); ?>
    </form>
</div>

<?php
}

function sstt_register_settings()
{
  register_setting('sstt_settings_group', 'sstt-primary-color');
  register_setting('sstt_settings_group', 'sstt-rounded-corner');
  register_setting('sstt_settings_group', 'sstt-alignment', array(
    'default' => 'right', // Default alignment is right
  ));

  // New Display Settings
  register_setting('sstt_settings_group', 'sstt-enabled');
  register_setting('sstt_settings_group', 'sstt-javascript-async');
  register_setting('sstt_settings_group', 'sstt-scroll-offset');
  register_setting('sstt_settings_group', 'sstt-button-size-width');
  register_setting('sstt_settings_group', 'sstt-button-size-height');
  register_setting('sstt_settings_group', 'sstt-button-opacity');
  register_setting('sstt_settings_group', 'sstt-button-fade-duration');
  register_setting('sstt_settings_group', 'sstt-scroll-duration');
  register_setting('sstt_settings_group', 'sstt-auto-hide');
  register_setting('sstt_settings_group', 'sstt-auto-hide-after');
  register_setting('sstt_settings_group', 'sstt-hide-small-devices');
  register_setting('sstt_settings_group', 'sstt-small-device-max-width');
  register_setting('sstt_settings_group', 'sstt-hide-small-window');
  register_setting('sstt_settings_group', 'sstt-small-window-max-width');
  register_setting('sstt_settings_group', 'sstt-hide-wp-admin');
  register_setting('sstt_settings_group', 'sstt-hide-iframes');

  // Location Settings
  register_setting('sstt_settings_group', 'sstt-location');
  register_setting('sstt_settings_group', 'sstt-margin-x');
  register_setting('sstt_settings_group', 'sstt-margin-y');

  // Filter Settings
  register_setting('sstt_settings_group', 'sstt-display-on-pages');


  // newLe
  register_setting('sstt_settings_group', 'sstt-enabled', 'sanitize_checkbox');
  register_setting('sstt_settings_group', 'sstt-javascript-async', 'sanitize_checkbox');
  register_setting('sstt_settings_group', 'sstt-auto-hide', 'sanitize_checkbox');
  register_setting('sstt_settings_group', 'sstt-hide-small-devices', 'sanitize_checkbox');
  register_setting('sstt_settings_group', 'sstt-hide-small-window', 'sanitize_checkbox');
  register_setting('sstt_settings_group', 'sstt-hide-wp-admin', 'sanitize_checkbox');
  register_setting('sstt_settings_group', 'sstt-hide-iframes', 'sanitize_checkbox');
}

function sanitize_checkbox($input)
{
  return isset($input) ? 1 : 0;
}

add_action('admin_init', 'sstt_register_settings');

// Theme CSS Customization
function sstt_scroll_control()
{
?>
  <style>
    #scrollUp {
      background-color: <?php echo esc_attr(get_option("sstt-primary-color", "#000000")); ?>;
      border-radius: <?php echo esc_attr(get_option("sstt-rounded-corner", "5")); ?>px;
      position: fixed;
      <?php $alignment = esc_attr(get_option("sstt-alignment", "right")); ?><?php echo $alignment ? $alignment . ": 0;" : ""; ?>
    }

    /* Add more dynamic styles based on your settings */
  </style>
<?php
}
add_action("wp_head", "sstt_scroll_control");
