<?php

// File Security Check.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Back compatibility for the7 older 6.3.1
if ( ! has_filter( 'the7_shortcodeaware_excerpt', 'the7_shortcodeaware_excerpt_filter' ) && function_exists( 'vc_manager' ) ) {
	add_filter( 'the7_shortcodeaware_excerpt', array( vc_manager()->vc(), 'excerptFilter' ), 20 );
}