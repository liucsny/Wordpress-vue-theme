<?php
// Remove all default WP template redirects/lookups
remove_action('template_redirect', 'redirect_canonical');

add_theme_support( 'post-thumbnails' );

// 测试
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'custom-background' );

register_rest_field( 'post', 'metadata', array(
    'get_callback' => function ( $data ) {
        return get_post_meta( $data['id'], '', '' );
    }, ));

// 注册post的metadata
register_rest_field( 'post', 'metadata', array(
'get_callback' => function ( $data ) {
    return get_post_meta( $data['id'], '', '' );
}, ));

// 注册page的metadata
register_rest_field( 'page', 'metadata', array(
'get_callback' => function ( $data ) {
    return get_post_meta( $data['id'], '', '' );
}, ));

function slug_get_post_meta_cb( $object, $field_name, $request ) {
    return get_post_meta( $object[ 'id' ], $field_name );
}
 
function slug_update_post_meta_cb( $value, $object, $field_name ) {
    return update_post_meta( $object[ 'id' ], $field_name, $value );
}

// Redirect all requests to index.php so the Vue app is loaded and 404s aren't thrown
function remove_redirects() {
    add_rewrite_rule('^/(.+)/?', 'index.php', 'top');
}
add_action('init', 'remove_redirects');

// Load scripts
function load_vue_scripts() {
    wp_enqueue_style('blankslate/app.css', get_template_directory_uri() . '/dist/styles/app.css', false, null);
    wp_enqueue_script('blankslate/manifest.js', get_template_directory_uri() . '/dist/scripts/manifest.js', null, null, true);
    wp_enqueue_script('blankslate/vendor.js', get_template_directory_uri() . '/dist/scripts/vendor.js', null, null, true);
    wp_enqueue_script('blankslate/app.js', get_template_directory_uri() . '/dist/scripts/app.js', null, null, true);
}
add_action('wp_enqueue_scripts', 'load_vue_scripts', 100);
