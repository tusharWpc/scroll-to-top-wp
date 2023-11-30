<?php
/**
 * Plugin Name: Scroll to Top WP
 * Plugin URI: https://wordpress.org/plugins/scroll-to-top-wp/
 * Description: Simple Scroll to Top wp plugin for enabling a Back to Top button on your WordPress website.
 * Version: 1.0.0
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Author: MD Nafish Fuad Tushar
 * Author URI: https://nftushar.code.blog/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: stw
 */

function stw_add_theme_page()
{
    add_menu_page('Scroll To Top', 'Scroll To Top', 'manage_options', 'stw-plugin-option', 'stw_create_page', 'dashicons-arrow-up-alt', 101);
}
add_action('admin_menu', 'stw_add_theme_page');

// Including CSS
function stw_enqueue_style()
{
    wp_enqueue_style('stw-style', plugins_url('css/stw-style.css', __FILE__));
}
add_action("wp_enqueue_scripts", "stw_enqueue_style");

function stw_add_theme_css()
{
    wp_enqueue_style('stw-admin-style', plugins_url('css/stw-admin-style.css', __FILE__), false, "1.0.0");
}
add_action('admin_enqueue_scripts', 'stw_add_theme_css');

// Including JavaScript
function stw_enqueue_scripts()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('stw-plugin-script', plugins_url('js/stw-plugin.js', __FILE__), array(), '1.0.0', true);
}
add_action("wp_enqueue_scripts", "stw_enqueue_scripts");

// jQuery Plugin Setting Activation
function stw_scroll_script()
{
    ?>
    <script>
        jQuery(document).ready(function($) {
            var scrollUpIcon = $('#scrollUp');

            // Initial visibility based on checkbox state
            scrollUpIcon.toggle(<?php echo get_option('stw-enabled') ? 'true' : 'false'; ?>);

            $.scrollUp();

            // Toggle visibility when checkbox is clicked
            $('[name="stw-enabled"]').on('change', function() {
                scrollUpIcon.toggle(this.checked);
            });
        });
    </script>
    <?php
}
add_action("wp_footer", "stw_scroll_script");

/**
 * Plugin Callback
 */
function stw_create_page()
{
    ?>
    <div class="stw-customize-form">
        <h3 id="stw-title"><?php echo esc_html__('Settings', 'stw'); ?></h3>
        <form method="post" action="options.php">
            <?php settings_fields('stw_settings_group'); ?>
            <?php do_settings_sections('stw-settings'); ?>

            <table class="stw-table">
                <tbody>
                    <!-- Button Color -->
                    <tr class="stw-tr">
                        <th class="stw-th"><label for="stw-primary-color"><?php echo esc_html__("Button Color:", 'stw'); ?></label></th>
                        <td>
                            <input type="color" name="stw-primary-color" value="<?php echo esc_attr(get_option("stw-primary-color")); ?>">
                        </td>
                    </tr>
                    <tr class="stw-tr">
                        <th class="stw-th"><label for="stw-margin"><?php echo esc_html__("Margin:", 'stw'); ?></label></th>
                        <td>
                            <input type="number" name="stw-margin" value="<?php echo esc_attr(get_option("stw-margin")); ?>"  placeholder="px">
                        </td>
                    </tr>
                    <!-- Rounded Corner -->
                    <tr class="stw-tr">
                        <th class="stw-th"><label for="stw-rounded-corner"><?php echo esc_html__("Rounded Corner:", 'stw'); ?></label></th>
                        <td>
                            <input type="number" name="stw-rounded-corner" value="<?php echo esc_attr(get_option("stw-rounded-corner", 1)); ?>" placeholder="px">
                        </td>
                    </tr>

                    <!-- Alignment -->
                    <tr class="stw-tr">
                        <th class="stw-th"><label for="stw-alignment"><?php echo esc_html__("Alignment:", 'stw'); ?></label></th>
                        <td>
                            <select name="stw-alignment">
                                <option value="left" <?php selected(get_option('stw-alignment'), 'left'); ?>><?php echo esc_html__('Left', 'stw'); ?></option>
                                <option value="right" <?php selected(get_option('stw-alignment'), 'right'); ?>><?php echo esc_html__('Right', 'stw'); ?></option>
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

function stw_register_settings()
{
    register_setting('stw_settings_group', 'stw-primary-color');
    register_setting('stw_settings_group', 'stw-margin');
    register_setting('stw_settings_group', 'stw-rounded-corner');
    register_setting('stw_settings_group', 'stw-alignment', array(
        'default' => 'right', // Default alignment is right
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

add_action('admin_init', 'stw_register_settings');

// Theme CSS Customization
function stw_scroll_control()
{
    ?>
    <style>
        #scrollUp {
            background-color: <?php echo esc_attr(get_option("stw-primary-color", "#000000")); ?>;
            margin: <?php echo esc_attr(get_option("stw-margin", "5")); ?>px;
            border-radius: <?php echo esc_attr(get_option("stw-rounded-corner", "1")); ?>px;
            position: fixed;
            <?php $alignment = get_option("stw-alignment", "right"); ?><?php echo $alignment ? esc_attr($alignment) . ": 0;" : ""; ?>
        }
    </style>
    <?php
}
add_action("wp_head", "stw_scroll_control");
?>
