<?php
/*
Plugin Name: Sửa Admin cho đẹp bằng CSS
Description: Cho phép code css vào web cho đẹp
Version: 1.0
Author: Võ Trường Quang Tình
*/

// Add menu item in the admin menu
add_action('admin_menu', 'custom_admin_css_menu');
function custom_admin_css_menu() {
    add_options_page(
        'Custom Admin CSS', 
        'Custom Admin CSS', 
        'manage_options', 
        'custom-admin-css', 
        'custom_admin_css_options_page'
    );
}

// Display the options page
function custom_admin_css_options_page() {
    ?>
    <div class="wrap">
        <h1>Custom Admin CSS</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('custom_admin_css_options_group');
            do_settings_sections('custom-admin-css');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings
add_action('admin_init', 'custom_admin_css_settings');
function custom_admin_css_settings() {
    register_setting('custom_admin_css_options_group', 'custom_admin_css');

    add_settings_section(
        'custom_admin_css_section',
        'Custom CSS Settings',
        'custom_admin_css_section_callback',
        'custom-admin-css'
    );

    add_settings_field(
        'custom_admin_css_field',
        'Custom CSS',
        'custom_admin_css_field_callback',
        'custom-admin-css',
        'custom_admin_css_section'
    );
}

function custom_admin_css_section_callback() {
    echo 'Enter your custom CSS below:';
}

function custom_admin_css_field_callback() {
    $custom_css = get_option('custom_admin_css');
    echo '<textarea name="custom_admin_css" rows="10" cols="50" class="large-text code">' . esc_textarea($custom_css) . '</textarea>';
}

// Enqueue custom CSS in admin
add_action('admin_enqueue_scripts', 'enqueue_custom_admin_css');
function enqueue_custom_admin_css() {
    $custom_css = get_option('custom_admin_css');
    if (!empty($custom_css)) {
        wp_add_inline_style('admin-bar', $custom_css);
    }
}
?>