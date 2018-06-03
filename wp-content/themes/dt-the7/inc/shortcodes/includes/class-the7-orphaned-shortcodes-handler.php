<?php
class The7_Orphaned_Shortcodes_Handler {
	protected static $id = 1;

	const CACHE_OPTION_ID = 'the7_orphaned_shortcodes_inline_css';

	public static function set_unique_shortcode_id( DT_Shortcode_With_Inline_Css $shortcode_obj ) {
		$shortcode_obj->allow_to_print_inline_css();
		$shortcode_obj->set_unique_class( self::get_unique_id( $shortcode_obj->get_tag() ) );
	}

	public static function get_unique_id( $tag ) {
		$str = 'orphaned-shortcode-';

		return $str . md5( $tag . self::$id );
	}

	public static function get_inline_css( $_, DT_Shortcode_With_Inline_Css $shortcode_obj ) {
		$shortcode_obj->allow_to_print_inline_css();
		$css_list = (array) get_option( self::CACHE_OPTION_ID, array() );
		$unique_id = self::get_unique_id( $shortcode_obj->get_tag() );

		if ( array_key_exists( $unique_id,  $css_list ) ) {
			return $css_list[ $unique_id ];
		}

		$css = $css_list[ $unique_id ] = self::generate_inline_css( $shortcode_obj );
		update_option( self::CACHE_OPTION_ID, $css_list );

		return $css;
	}

	public static function generate_inline_css( DT_Shortcode_With_Inline_Css $shortcode_obj ) {
		if ( ! class_exists( 'lessc', false ) ) {
			include PRESSCORE_DIR . '/vendor/lessphp/lessc.inc.php';
		}

		return $shortcode_obj->generate_inline_css( '', $shortcode_obj->get_atts() );
	}

	public static function increment_inner_id() {
		++self::$id;
	}

	public static function clear_cache() {
		delete_option( self::CACHE_OPTION_ID );
	}

	public static function add_cache_invalidation_hooks() {
		add_action( 'optionsframework_after_validate', array( __CLASS__, 'clear_cache' ) );
		add_action( 'optionsframework_after_options_reset', array( __CLASS__, 'clear_cache' ) );
	}

	public static function add_hooks() {
		add_action( 'the7_shortcodes_reset', array( __CLASS__, 'set_unique_shortcode_id' ) );
		add_filter( 'the7_shortcodes_get_inline_css', array( __CLASS__, 'get_inline_css' ), 10, 2 );
		add_action( 'the7_after_shortcode_output', array( __CLASS__, 'increment_inner_id' ) );
	}

	public static function remove_hooks() {
		remove_action( 'the7_shortcodes_reset', array( __CLASS__, 'set_unique_shortcode_id' ) );
		remove_filter( 'the7_shortcodes_get_inline_css', array( __CLASS__, 'get_inline_css' ) );
		remove_action( 'the7_after_shortcode_output', array( __CLASS__, 'increment_inner_id' ) );
	}
}
