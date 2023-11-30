<?php
/**
 * Plugin Name: Scroll Top WP
 * Plugin URI: https://wordpress.org/plugins/scroll-top-wp/
 * Description: Simple Scroll to Top plugin will help you to enable Back to Top button on your WordPress website.
 * Version: 1.0.0
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Author: MD Nafish Fuad Tushar
 * Author URI: https://nftushar.code.blog/
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

function sstt_add_theme_css()
{
    wp_enqueue_style('sstt-admin-style', plugins_url('css/sstt-admin-style.css', __FILE__), false, "1.0.0");
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
        <h3 id="sstt-title"><?php echo esc_html('Scroll To Top Page Customize'); ?></h3>
        <form method="post" action="options.php">
            <?php settings_fields('sstt_settings_group'); ?>
            <?php do_settings_sections('sstt-settings'); ?>

            <table class="sstt-table">
                <tbody>
                    <!-- Button Color -->
                    <tr class="sstt-tr">
                        <th class="sstt-th"><label for="sstt-primary-color"><?php echo esc_html("Button Color:"); ?></label></th>
                        <td>
                            <input type="color" name="sstt-primary-color" value="<?php echo esc_attr(get_option("sstt-primary-color")); ?>">
                        </td>
                    </tr>
                    <!-- Rounded Corner -->
                    <tr class="sstt-tr">
                        <th class="sstt-th"><label for="sstt-rounded-corner"><?php echo esc_html("Rounded Corner:"); ?></label></th>
                        <td>
                            <input type="number" name="sstt-rounded-corner" value="<?php echo esc_attr(get_option("sstt-rounded-corner", 1)); ?>" placeholder="px">
                        </td>
                    </tr>

                    <!-- Alignment -->
                    <tr class="sstt-tr">
                        <th class="sstt-th"><label for="sstt-alignment"><?php echo esc_html("Alignment:"); ?></label></th>
                        <td>
                            <select name="sstt-alignment">
                                <option value="left" <?php selected(get_option('sstt-alignment'), 'left'); ?>>Left</option>
                                <option value="right" <?php selected(get_option('sstt-alignment'), 'right'); ?>>Right</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Display Settings -->
            <h3 id="sstt-title"><?php echo esc_html('Display Settings:'); ?></h3>
            <table>
                <tbody>
                    <tr class="sstt-tr">
                        <th class="sstt-th"><label for="sstt-enabled">Enabled</label></th>
                        <td>
                            <input type="checkbox" name="sstt-enabled" <?php checked(get_option('sstt-enabled'), 1); ?>>
                        </td>
                    </tr>
                    <tr class="sstt-tr">
                        <th class="sstt-th"><label for="sstt-javascript-async">Javascript Async</label></th>
                        <td>
                            <input type="checkbox" name="sstt-javascript-async" <?php checked(get_option('sstt-javascript-async')); ?>>
                        </td>
                    </tr>
                    <tr class="sstt-tr">
                        <th class="sstt-th"><label for="sstt-scroll-offset">Scroll Offset:</label></th>
                        <td>
                            <input type="number" name="sstt-scroll-offset" value="<?php echo esc_attr(get_option("sstt-scroll-offset", 100)); ?>" placeholder="px">
                        </td>
                    </tr>
                    <!-- Continue with the remaining settings in the same format -->
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
    register_setting('sstt_settings_group', 'sstt-primary-color');
    register_setting('sstt_settings_group', 'sstt-rounded-corner');
    register_setting('sstt_settings_group', 'sstt-alignment', array(
        'default' => 'right', // Default alignment is right
    ));

    // New Display Settings
    register_setting('sstt_settings_group', 'sstt-enabled', 'sanitize_checkbox');
    register_setting('sstt_settings_group', 'sstt-javascript-async', 'sanitize_checkbox');
    register_setting('sstt_settings_group', 'sstt-scroll-offset', 'sanitize_scroll_offset');

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

add_action('admin_init', 'sstt_register_settings');

// Theme CSS Customization
function sstt_scroll_control()
{
?>
    <style>
        #scrollUp {
            background-color: <?php echo get_option("sstt-primary-color", "#000000"); ?>;
            border-radius: <?php echo get_option("sstt-rounded-corner", "1"); ?>px;
            position: fixed;
            <?php $alignment = get_option("sstt-alignment", "right"); ?><?php echo $alignment ? $alignment . ": 0;" : ""; ?>
        }
    </style>
<?php
}
add_action("wp_head", "sstt_scroll_control");