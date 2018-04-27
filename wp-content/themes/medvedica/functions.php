<?php

//flush_rewrite_rules();

add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
function enqueue_parent_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

function remove_admin_bar_links() {
    /** @var $wp_admin_bar WP_Admin_Bar */
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('revslider');
    $wp_admin_bar->remove_menu('options-framework-parent');
    $wp_admin_bar->remove_menu('revslider');
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('customize');
    $wp_admin_bar->remove_menu('comments');
}
//add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links', 999 );


function log_me($message) {
    echo '<pre>';
    if (is_array($message) || is_object($message)) {
        print_r($message);
    } else {
        var_dump($message);
    }
    echo '</pre>';
}
//
function tinymce_paste_as_text( $init ) {
    $init['paste_as_text'] = true;

    return $init;
}
add_filter('tiny_mce_before_init', 'tinymce_paste_as_text');

add_image_size('event-img', '500px', '500px');

function replace_excerpt($content)
{
    return str_replace('read more', 'Читать далее', $content );
}
add_filter('the_excerpt', 'replace_excerpt');





function manage_sidebar($index)
{
    presscore_config()->set( 'sidebar_position', 'disabled' );
    return false;
}
add_filter( 'presscore_config_base_init_tribe_events', 'manage_sidebar' );

function event_cat_slug($index)
{
    return 'topic';
}
add_filter( 'tribe_events_category_slug', 'event_cat_slug' );



