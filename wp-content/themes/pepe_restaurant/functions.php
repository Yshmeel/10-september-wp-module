<?php

function init_pepe_template() {
    register_nav_menus( array(
        'main-menu' => 'Main Menu'
    ) );
    add_theme_support('custom-logo');
}

add_action('after_setup_theme', 'init_pepe_template');

add_action( 'wp_enqueue_scripts', 'pepe_restaurant_enqueue' );
function pepe_restaurant_enqueue() {
    wp_enqueue_style( 'pepe-style', get_stylesheet_uri() );
    wp_enqueue_script( 'jquery' );
}
