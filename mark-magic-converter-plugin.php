<?php
/*
Plugin Name: Mark Magic Converter Plugin
Plugin URI: https://github.com/gmuthuri/mark-magic-converter
Description: A WordPress plugin for file conversion based on the Mark Magic Converter app.
Version: 1.0
Author: gmuthuri
Author URI: https://github.com/gmuthuri
License: GPL2
*/

// Add an admin menu
function mmc_admin_menu() {
    add_menu_page(
        'Mark Magic Converter',
        'Mark Magic Converter',
        'manage_options',
        'mmc-plugin',
        'mmc_render_admin_page',
        'dashicons-media-code',
        20
    );
}
add_action('admin_menu', 'mmc_admin_menu');

// Render the admin page
function mmc_render_admin_page() {
    if (isset($_POST['mmc-submit'])) {
        mmc_handle_file_upload();
    }

    ?>
    <div class="wrap">
        <h1>Mark Magic Converter</h1>
        <form method="post" enctype="multipart/form-data">
            <label for="mmc-file">Upload File:</label>
            <input type="file" name="mmc-file" id="mmc-file" required />
            <?php submit_button('Convert File', 'primary', 'mmc-submit'); ?>
        </form>
    </div>
    <?php
}

// Handle file upload and conversion
function mmc_handle_file_upload() {
    if (!empty($_FILES['mmc-file']['name'])) {
        $uploaded_file = $_FILES['mmc-file'];
        $upload_dir = wp_upload_dir();
        $target_file = $upload_dir['path'] . '/' . basename($uploaded_file['name']);

        if (move_uploaded_file($uploaded_file['tmp_name'], $target_file)) {
            $converted_file = mmc_convert_file($target_file);
            if ($converted_file) {
                echo '<p>File converted successfully. <a href="' . esc_url($converted_file) . '" download>Download Converted File</a></p>';
            } else {
                echo '<p>File conversion failed.</p>';
            }
        } else {
            echo '<p>File upload failed. Please try again.</p>';
        }
    } else {
        echo '<p>No file uploaded. Please select a file.</p>';
    }
}

// Placeholder for file conversion logic
function mmc_convert_file($file_path) {
    $converted_file_path = $file_path . '-converted.txt'; // Example: Create a new file with "-converted" suffix

    // Example conversion: Copy file content to a new file with modifications
    $original_content = file_get_contents($file_path);
    $converted_content = strtoupper($original_content); // Example: Convert text to uppercase

    if (file_put_contents($converted_file_path, $converted_content)) {
        return $converted_file_path;
    }

    return false;
}
