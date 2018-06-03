<?php

//flush_rewrite_rules();

add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
function enqueue_parent_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

function add_social_scripts() {
    wp_register_script( 'vk-api', 'http://vk.com/js/api/openapi.js?154');
    wp_enqueue_script( 'vk-api' );
}

add_action( 'wp_enqueue_scripts', 'add_social_scripts' );

function add_vk_chat() {
    echo <<<HTML
<!-- VK Widget -->
<div id="vk_community_messages"></div>
<script type="text/javascript">
VK.Widgets.CommunityMessages("vk_community_messages", 160039823, {tooltipButtonText: "Есть вопрос?"});
</script>
HTML;
}

add_action( 'presscore_body_top', 'add_vk_chat' );

function add_fb_js() {
    echo <<<HTML
<!— Facebook Pixel Code —>
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '190245724962474');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=190245724962474&ev=PageView&noscript=1"
/></noscript>
<!— End Facebook Pixel Code —>
HTML;
}
// Add hook for front-end <head></head>
add_action('wp_head', 'add_fb_js');

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



