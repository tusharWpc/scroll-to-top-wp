<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Plugin Name: Scroll Top Of Page
 * Plugin URI: https://wordpress.org/plugins/scroll-top-of-page/
 * Description: Scroll Top Of Page WP plugin for enabling a Back to Top button on your WordPress website.
 * Version: 1.0.0
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Author: MD Nafish Fuad Tushar
 * Author URI: https://nftushar.code.blog/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: sstt
 */

function sstt_add_theme_page()
{
    add_menu_page("Scroll Top Of Page", "Scroll Top", "manage_options", "sstt-plugin-option", "sstt_create_page", "dashicons-arrow-up-alt", 101);
}
add_action("admin_menu", "sstt_add_theme_page");

// Including CSS
function sstt_enqueue_style()
{
    wp_enqueue_style("sstt-style", plugins_url("css/sstt-style.css", __FILE__));
}
add_action("wp_enqueue_scripts", "sstt_enqueue_style");

function sstt_add_theme_css()
{
    wp_enqueue_style("sstt-admin-style", plugins_url("css/sstt-admin-style.css", __FILE__), false, "1.0.0");
}
add_action("admin_enqueue_scripts", "sstt_add_theme_css");

// Including JavaScript
function sstt_enqueue_scripts()
{
    wp_enqueue_script("jquery");
    wp_enqueue_script("sstt-plugin-script", plugins_url("js/sstt-plugin.js", __FILE__), array(), "1.0.0", true);
}
add_action("wp_enqueue_scripts", "sstt_enqueue_scripts");

// jQuery Plugin Setting Activation
function sstt_scroll_script()
{
?>
    <script>
        jQuery(document).ready(function($) {
            var scrollUpIcon = $("#scrollUp");

            // Initial visibility based on checkbox state
            scrollUpIcon.toggle(<?php echo get_option("sstt-enabled") ? "true" : "false"; ?>);

            $.scrollUp();

            // Toggle visibility when checkbox is clicked
            $('[name="sstt-enabled"]').on('change', function() {
                scrollUpIcon.toggle(this.checked);
            });
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
        <h3 id="sstt-title"><?php echo esc_html__("Settings", "sstt"); ?></h3>
        <form method="post" action="options.php">
            <?php settings_fields("sstt_settings_group"); ?>
            <?php do_settings_sections("sstt-settings"); ?>

            <table class="sstt-table">
                <tbody>
                    <!-- Button Color -->
                    <tr class="sstt-tr">
                        <th class="sstt-th"><label for="sstt-primary-color"><?php echo esc_html__("Button Color:", "sstt"); ?></label></th>
                        <td>
                            <input type="color" name="sstt-primary-color" value="<?php echo esc_attr(get_option("sstt-primary-color")); ?>">
                        </td>
                    </tr>
                    <tr class="sstt-tr">
                        <th class="sstt-th">
                            <label for="sstt-margin">
                                <?php echo esc_html__("Margin:", "sstt"); ?> 
                            </label>
                        </th>
                        <td>
                            <input type="number" name="sstt-margin" value="<?php echo esc_attr(get_option("sstt-margin")); ?>" placeholder="px">
                        </td>
                    </tr>

                    <!-- Rounded Corner -->
                    <tr class="sstt-tr">
                        <th class="sstt-th"><label for="sstt-rounded-corner"><?php echo esc_html__("Rounded Corner:", "sstt"); ?></label></th>
                        <td>
                            <input type="number" name="sstt-rounded-corner" value="<?php echo esc_attr(get_option("sstt-rounded-corner")); ?>" placeholder="px">
                        </td>
                    </tr>

                    <!-- Alignment -->
                    <tr class="sstt-tr">
                        <th class="sstt-th"><label for="sstt-alignment"><?php echo esc_html__("Alignment:", "sstt"); ?></label></th>
                        <td>
                            <select name="sstt-alignment">
                                <option value="left" <?php selected(get_option("sstt-alignment"), "left"); ?>><?php echo esc_html__("Left", "sstt"); ?></option>
                                <option value="right" <?php selected(get_option("sstt-alignment"), "right"); ?>><?php echo esc_html__("Right", "sstt"); ?></option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>
<?php
}

// ... (rest of the code remains unchanged)

function sstt_register_settings()
{
    register_setting("sstt_settings_group", "sstt-primary-color");
    register_setting("sstt_settings_group", "sstt-margin");
    register_setting("sstt_settings_group", "sstt-rounded-corner");
    register_setting("sstt_settings_group", "sstt-alignment", array(
        "default" => "right", // Default alignment is right
    ));
    // Continue with the remaining settings in the same format
}

function sanitize_scroll_offset($input)
{
    return absint($input); // Ensure the scroll offset is a non-negative integer
}

function sanitize_checkbox($input)
{
    return isset($input) ? 1 : 0;
}

add_action("admin_init", "sstt_register_settings");

// Theme CSS Customization
function sstt_scroll_control()
{
?>
    <style>
        #scrollUp {
            background-color: <?php echo esc_attr(get_option("sstt-primary-color", "#ff7f50")); ?>;
            margin: <?php echo esc_attr(get_option("sstt-margin")); ?>px;
            border-radius: <?php echo esc_attr(get_option("sstt-rounded-corner")); ?>px;
            position: fixed;
            <?php $alignment = get_option("sstt-alignment", "right"); ?><?php echo $alignment ? esc_attr($alignment) . ": 0;" : ""; ?>
        }
    </style>
<?php
}
add_action("wp_head", "sstt_scroll_control");
?>
