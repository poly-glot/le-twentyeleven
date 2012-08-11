<?php
/**
 * Twenty Eleven (LE) functions and definitions
 */

$template_dir = get_template_directory();

// If user has not installed layout engine framework, then try to load it form source.
require( $template_dir . '/extensions/compatibility.php' );

// Create theme settings based on LessCSS and hooks
require( $template_dir . '/extensions/lesscss_options.php' );

// Create default layout, custom blocks and custom block items
require( $template_dir . '/extensions/layout.php' );

//Custom drag and drop objects based on twenty eleven theme using LE API
require( $template_dir . '/extensions/block_items/random_header.php' );
require( $template_dir . '/extensions/block_items/primary_menu.php' );
require( $template_dir . '/extensions/block_items/theme_logo.php' );

//Implement hard coded layout through plugin api.
require( $template_dir . '/extensions/hard_coded_filters.php' );

// Twenty Eleven functionality
require( $template_dir . '/extensions/twenty_eleven.php' );

?>