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
    <div class="custom-scroll-form">
        <h3 class="form-title"><?php echo esc_html('Scroll To Top Page Customize'); ?></h3>

        <form method="post" action="options.php">
        <?php settings_fields('custom-scroll-settings'); ?>
            <?php do_settings_sections('sstt-plugin-option'); ?>

            <table class="form-table">
                <tbody>

                    <tr class="form-row">
                        <th><label for="custom-primary-color"><?php echo esc_html("Button Color:"); ?></label></th>
                        <td><input type="color" name="custom-primary-color" value="<?php echo esc_attr(get_option("custom-primary-color")); ?>"></td>
                    </tr>
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-rounded-corner"><?php echo esc_html("Rounded Corner:"); ?></label></th>
                        <td><input class="number-input" type="number" name="custom-rounded-corner" value="<?php echo esc_attr(get_option("custom-rounded-corner")); ?>"></td>
                    </tr>
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-alignment"><?php echo esc_html("Alignment:"); ?></label></th>
                        <td>
                            <select name="custom-alignment">
                                <option value="left" <?php selected(get_option('custom-alignment'), 'left'); ?>>Left</option>
                                <option value="right" <?php selected(get_option('custom-alignment'), 'right'); ?>>Right</option>
                            </select>
                        </td>
                    </tr>

                    <!-- New Display Settings -->
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-enabled">Enabled</label></th>
                        <td><input type="checkbox" name="custom-enabled" <?php checked(get_option('custom-enabled'), 1); ?>></td>
                    </tr>
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-javascript-async">Javascript Async</label></th>
                        <td><input type="checkbox" name="custom-javascript-async" <?php checked(get_option('custom-javascript-async')); ?>></td>
                    </tr>
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-scroll-offset">Scroll Offset:</label></th>
                        <td><input class="number-input" type="number" name="custom-scroll-offset" value="<?php echo esc_attr(get_option("custom-scroll-offset", 100)); ?>" placeholder="px"></td>
                    </tr>
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-button-size-width">Button Size Width:</label></th>
                        <td><input class="number-input" type="number" name="custom-button-size-width" value="<?php echo esc_attr(get_option("custom-button-size-width", 0)); ?>" placeholder="px"></td>
                    </tr>
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-button-size-height">Button Size Height:</label></th>
                        <td><input class="number-input" type="number" name="custom-button-size-height" value="<?php echo esc_attr(get_option("custom-button-size-height", 0)); ?>" placeholder="px"></td>
                    </tr>
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-button-opacity">Button Opacity:</label></th>
                        <td><input class="number-input" type="number" name="custom-button-opacity" value="<?php echo esc_attr(get_option("custom-button-opacity", 80)); ?>" placeholder="%"></td>
                    </tr>
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-button-fade-duration">Button Fade Duration:</label></th>
                        <td><input class="number-input" type="number" name="custom-button-fade-duration" value="<?php echo esc_attr(get_option("custom-button-fade-duration", 0)); ?>" placeholder="ms"></td>
                    </tr>
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-scroll-duration">Scroll Duration:</label></th>
                        <td><input class="number-input" type="number" name="custom-scroll-duration" value="<?php echo esc_attr(get_option("custom-scroll-duration", 400)); ?>" placeholder="ms"></td>
                    </tr>
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-auto-hide">Auto Hide:</label></th>
                        <td><input type="checkbox" name="custom-auto-hide" <?php checked(get_option('custom-auto-hide'), 1); ?>></td>
                    </tr>
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-auto-hide-after">Auto Hide After:</label></th>
                        <td><input class="number-input" type="number" name="custom-auto-hide-after" value="<?php echo esc_attr(get_option("custom-auto-hide-after", 2)); ?>" placeholder="sec"></td>
                    </tr>
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-hide-small-devices">Hide on Small Devices:</label></th>
                        <td><input type="checkbox" name="custom-hide-small-devices" <?php checked(get_option('custom-hide-small-devices'), 1); ?>></td>
                    </tr>
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-small-device-max-width">Small Device Max Width:</label></th>
                        <td><input class="number-input" type="number" name="custom-small-device-max-width" value="<?php echo esc_attr(get_option("custom-small-device-max-width", 640)); ?>" placeholder="px"></td>
                    </tr>
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-hide-small-window">Hide on Small Window:</label></th>
                        <td><input type="checkbox" name="custom-hide-small-window" <?php checked(get_option('custom-hide-small-window'), 1); ?>></td>
                    </tr>
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-small-window-max-width">Small Window Max Width:</label></th>
                        <td><input class="number-input" type="number" name="custom-small-window-max-width" value="<?php echo esc_attr(get_option("custom-small-window-max-width", 640)); ?>" placeholder="px"></td>
                    </tr>
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-hide-wp-admin">Hide on WP-ADMIN:</label></th>
                        <td><input type="checkbox" name="custom-hide-wp-admin" <?php checked(get_option('custom-hide-wp-admin'), 1); ?>></td>
                    </tr>
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-hide-iframes">Hide on iframes:</label></th>
                        <td><input type="checkbox" name="custom-hide-iframes" <?php checked(get_option('custom-hide-iframes'), 1); ?>></td>
                    </tr>

                    <!-- Button Style -->
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-button-style">Button Style:</label></th>
                        <td>
                            <select name="custom-button-style">
                            <option value="image" <?php selected(get_option('custom-button-style'), 'image'); ?>>Image Button</option> 
                                <option value="text" <?php selected(get_option('custom-button-style'), 'text'); ?>>Text Button</option>
                                <option value="font-awesome" <?php selected(get_option('custom-button-style'), 'font-awesome'); ?>>Font Awesome Button</option>
                            </select>
                        </td>
                    </tr>

                    <!-- Button Action -->
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-button-action">Button Action:</label></th>
                        <td>
                            <select name="custom-button-action">
                                <option value="scroll-top" <?php selected(get_option('custom-button-action'), 'scroll-top'); ?>>Scroll to Top</option>
                                <option value="scroll-element" <?php selected(get_option('custom-button-action'), 'scroll-element'); ?>>Scroll to Element</option>
                                <option value="link-page" <?php selected(get_option('custom-button-action'), 'link-page'); ?>>Link to Page</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Location Settings -->
            <h3>Location Settings:</h3>
            <table class="location-table">
                <tbody>
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-location">Location:</label></th>
                        <td>
                            <select name="custom-location">
                                <option value="bottom-right" <?php selected(get_option('custom-location'), 'bottom-right'); ?>>Bottom Right</option>
                                <option value="bottom-left" <?php selected(get_option('custom-location'), 'bottom-left'); ?>>Bottom Left</option>
                                <option value="top-right" <?php selected(get_option('custom-location'), 'top-right'); ?>>Top Right</option>
                                <option value="top-left" <?php selected(get_option('custom-location'), 'top-left'); ?>>Top Left</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-margin-x">Margin X:</label></th>
                        <td><input class="number-input" type="number" name="custom-margin-x" value="<?php echo esc_attr(get_option("custom-margin-x", 20)); ?>" placeholder="px"></td>
                    </tr>
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-margin-y">Margin Y:</label></th>
                        <td><input class="number-input" type="number" name="custom-margin-y" value="<?php echo esc_attr(get_option("custom-margin-y", 20)); ?>" placeholder="px"></td>
                    </tr>
                </tbody>
            </table>

            <!-- Filter Settings -->
            <h3>Filter Settings:</h3>
            <table class="filter-table">
                <tbody>
                    <tr class="form-row">
                        <th class="form-th"><label for="custom-display-on-pages">Display on Pages:</label></th>
                        <td><input id="text-input-pageid" class="text-input " type="text" name="custom-display-on-pages" value="<?php echo esc_attr(get_option("custom-display-on-pages")); ?>" placeholder="Page IDs (comma-separated)"></td>
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
    register_setting('custom-scroll-settings', 'custom-primary-color');
    register_setting('custom-scroll-settings', 'custom-rounded-corner');
    register_setting('custom-scroll-settings', 'custom-alignment', array(
        'default' => 'right', // Default alignment is right
    ));

    // New Display Settings
    register_setting('custom-scroll-settings', 'custom-enabled');
    register_setting('custom-scroll-settings', 'custom-javascript-async');
    register_setting('custom-scroll-settings', 'custom-scroll-offset');
    register_setting('custom-scroll-settings', 'custom-button-size-width');
    register_setting('custom-scroll-settings', 'custom-button-size-height');
    register_setting('custom-scroll-settings', 'custom-button-opacity');
    register_setting('custom-scroll-settings', 'custom-button-fade-duration');
    register_setting('custom-scroll-settings', 'custom-scroll-duration');
    register_setting('custom-scroll-settings', 'custom-auto-hide');
    register_setting('custom-scroll-settings', 'custom-auto-hide-after');
    register_setting('custom-scroll-settings', 'custom-hide-small-devices');
    register_setting('custom-scroll-settings', 'custom-small-device-max-width');
    register_setting('custom-scroll-settings', 'custom-hide-small-window');
    register_setting('custom-scroll-settings', 'custom-small-window-max-width');
    register_setting('custom-scroll-settings', 'custom-hide-wp-admin');
    register_setting('custom-scroll-settings', 'custom-hide-iframes');

    // Button Style and Action
   register_setting('custom-scroll-settings', 'custom-button-style');
   register_setting('custom-scroll-settings', 'custom-button-action');


    // Location Settings
    register_setting('custom-scroll-settings', 'sstt-location');
    register_setting('custom-scroll-settings', 'sstt-margin-x');
    register_setting('custom-scroll-settings', 'sstt-margin-y');

    // Filter Settings
    register_setting('custom-scroll-settings', 'sstt-display-on-pages');
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
