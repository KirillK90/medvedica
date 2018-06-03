<?php
/**
 * Albums shortcodes VC bridge
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

vc_lean_map( 'dt_albums', null, dirname( __FILE__ ) . '/mod-albums-masonry-bridge.php' );
vc_lean_map( 'dt_photos_masonry', null, dirname( __FILE__ ) . '/mod-albums-photo-masonry-bridge.php' );
vc_lean_map( 'dt_albums_jgrid', null, dirname( __FILE__ ) . '/mod-albums-justified-grid-bridge.php' );
vc_lean_map( 'dt_photos_jgrid', null, dirname( __FILE__ ) . '/mod-albums-photo-justified-grid-bridge.php' );
vc_lean_map( 'dt_albums_scroller', null, dirname( __FILE__ ) . '/mod-albums-scroller-bridge.php' );
vc_lean_map( 'dt_small_photos', null, dirname( __FILE__ ) . '/mod-albums-photo-scroller-bridge.php' );
