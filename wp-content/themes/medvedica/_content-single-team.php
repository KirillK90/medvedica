<?php
/**
 * Team single post template
 * 
 * @package vogue
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

global $post;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php

	do_action( 'presscore_before_post_content' );
    // Post content.
    echo '<div class="entry-content">';

    echo do_shortcode('[psy-spec-meta]');

	the_content();

    echo '</div>';

	do_action( 'presscore_after_post_content' );

	?>
<div class="clearfix"></div>
</article><!-- #post-<?php the_ID(); ?> -->