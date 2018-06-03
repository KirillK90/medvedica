<?php

// File Security Check.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	"weight" => -1,
	"name" => __("Testimonials Masonry & Grid", 'the7mk2'),
	"base" => "dt_testimonials_masonry",
	"icon" => "dt_vc_ico_testimonials_masonry",
	"class" => "dt_testimonials_masonry",
	"category" => __('by Dream-Theme', 'the7mk2'),
    "admin_enqueue_css" => array(get_template_directory_uri().'/fonts/icomoon-arrows-the7/style.css'),
	"params" => array(
		// General group.
		array(
			'heading' => __('Show', 'the7mk2'),
			'param_name' => 'post_type',
			'type' => 'dropdown',
			'std' => 'category',
			'value' => array(
				'All posts' => 'posts',
				'Posts from categories' => 'category',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'type' => 'autocomplete',
			'heading' => __( 'Choose posts', 'the7mk2' ),
			'param_name' => 'posts',
			'settings' => array(
				'multiple' => true,
				'min_length' => 0,
			),
			'save_always' => true,
			'description' => __( 'Field accept post ID, title. Leave empty to show all posts.', 'the7mk2' ),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'post_type',
				'value' => 'posts',
			),
		),
		array(
			'type' => 'autocomplete',
			'heading' => __( 'Choose post categories', 'the7mk2' ),
			'param_name' => 'category',
			'settings' => array(
				'multiple' => true,
				'min_length' => 0,
			),
			'save_always' => true,
			'description' => __( 'Field accept category ID, title, slug. Leave empty to show all posts.', 'the7mk2' ),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'post_type',
				'value' => 'category',
			),
		),

		array(
			'heading' => __('Order', 'the7mk2'),
			'param_name' => 'order',
			'type' => 'dropdown',
			'std' => 'desc',
			'value' => array(
				'Ascending' => 'asc',
				'Descending' => 'desc',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading' => __('Order by', 'the7mk2'),
			'param_name' => 'orderby',
			'type' => 'dropdown',
			'value' => array(
				'Date'          => 'date',
				'Name'          => 'title',
				'Author'        => 'author',
				'Slug'          => 'name',
				'Date modified' => 'modified',
				'ID'            => 'id',
				'Random'        => 'rand',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		// - Layout Settings.
		array(
			'heading' => __( 'Layout Settings', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			"heading" => __("Mode", 'dt-the7-core'),
			"param_name" => "type",
			"type" => "dropdown",
			"value" => array(
				"Grid" => "grid",
				"Masonry" => "masonry",
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			"heading" => __("Loading effect", 'the7mk2'),
			"param_name" => "loading_effect",
			"type" => "dropdown",
			"value" => array(
				'None' => 'none',
				'Fade in' => 'fade_in',
				'Move up' => 'move_up',
				'Scale up' => 'scale_up',
				'Fall perspective' => 'fall_perspective',
				'Fly' => 'fly',
				'Flip' => 'flip',
				'Helix' => 'helix',
				'Scale' => 'scale'
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			'heading' => __('Layout', 'the7mk2'),
			'param_name' => 'content_layout',
			'type' => 'dt_radio_image',
			'value' => 'layout_4',
			'options' => array(
				'layout_1'       => array(
					'title' => _x( 'Layout 1', 'the7mk2' ),
					'src' => '/inc/shortcodes/images/l01.gif',
				),
				'layout_2'        => array(
					'title' => _x( 'Layout 2', 'the7mk2' ),
					'src' => '/inc/shortcodes/images/l02.gif',
				),
				'layout_3'         => array(
					'title' => _x( 'Layout 3', 'the7mk2' ),
					'src' => '/inc/shortcodes/images/l03.gif',
				),
				'layout_4'          => array(
					'title' => _x( 'Layout 4', 'the7mk2' ),
					'src' => '/inc/shortcodes/images/l04.gif',
				),
				'layout_5'     => array(
					'title' => _x( 'Layout 5', 'the7mk2' ),
					'src' => '/inc/shortcodes/images/l05.gif',
				),
				'layout_6'       => array(
					'title' => _x( 'Layout 6', 'the7mk2' ),
					'src' => '/inc/shortcodes/images/l06.gif',
				),
			),
		),

	  	// Post group.
		array(
			'heading' => __('Content alignment', 'the7mk2'),
			'param_name' => 'content_alignment',
			'type' => 'dropdown',
			'std' => 'left',
			'value' => array(
				'Left' => 'left',
				'Center' => 'center',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		// - Content Area.
		array(
			'heading' => __( 'Content Area', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			'heading' => __('Show background', 'the7mk2'),
			'param_name' => 'content_bg',
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
		),
		array(
			'heading'		=> __('Color', 'the7mk2'),
			'param_name'	=> 'custom_content_bg_color',
			'type'			=> 'colorpicker',
			'value'			=> '',
			'dependency'	=> array(
				'element'	=> 'content_bg',
				'value'		=> 'y',
			),
			'description'   => __( 'Leave empty to use default content boxes color & decoration.', 'the7mk2' ),
		),
		array(
			'heading' => __('Content area paddings', 'the7mk2'),
			'param_name' => 'post_content_paddings',
			'type' => 'dt_spacing',

			'value' => '30px 30px 20px 30px',
			'units' => 'px',
		),
		// - Image Settings.

		array(
			'heading' => __( 'Image Settings', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			'heading' => __('Show image', 'the7mk2'),
			'param_name' => 'show_avatar',
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
		),
		array(
			'heading' => __('Image sizing', 'the7mk2'),
			'param_name' => 'image_sizing',
			'type' => 'dropdown',
			'std' => 'resize',
			'value' => array(
				'Preserve images proportions' => 'proportional',
				'Resize images' => 'resize',
			),
			'dependency'	=> array(
				'element'	=> 'show_avatar',
				'value'		=> 'y',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'headings' => array( __('Width', 'the7mk2'), __('Height', 'the7mk2') ),
			'param_name' => 'resized_image_dimensions',
			'type' => 'dt_dimensions',
			'value' => '1x1',
			'dependency' => array(
				'element' => 'image_sizing',
				'value' => 'resize',
			),

			'description' => __('Set image proportions, for example: 4x3, 3x2.', 'the7mk2'),
		),
		array(
			'heading' => __('Maximum width', 'the7mk2'),
			'param_name' => 'img_max_width',
			'type' => 'dt_number',
			'value' => '80',
			'units' => 'px',

			'dependency'	=> array(
				'element'	=> 'show_avatar',
				'value'		=> 'y',
			),
			'description' => __('Leave empty to use default width.', 'the7mk2'),
		),
		array(
			'heading' => __('Image paddings', 'the7mk2'),
			'param_name' => 'image_paddings',
			'type' => 'dt_spacing',
			'value' => '0px 20px 20px 0px',
			'units' => 'px, %',

			'dependency'	=> array(
				'element'	=> 'show_avatar',
				'value'		=> 'y',
			),
		),
		array(
			'heading' => __('Image border radius', 'the7mk2'),
			'param_name' => 'img_border_radius',
			'type' => 'dt_number',
			'value' => '60',
			'units' => 'px',

			'dependency'	=> array(
				'element'	=> 'show_avatar',
				'value'		=> 'y',
			),
		),

		// - Columns & Responsiveness.
		array(
			'heading' => __( 'Columns & Responsiveness', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			'heading' => __('Responsiveness mode', 'the7mk2'),
			'param_name' => 'responsiveness',
			'type' => 'dropdown',
			'value' => array(
				'Browser width based' => 'browser_width_based',
				'Post width based' => 'post_width_based',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		// -- Browser width based.
	    array(
			'heading' => __('Number of columns', 'the7mk2'),
			'param_name' => 'bwb_columns',
			'type' => 'dt_responsive_columns',
			'value' => 'desktop:3|h_tablet:3|v_tablet:2|phone:1',
			'dependency'	=> array(
				'element'	=> 'responsiveness',
				'value'		=> 'browser_width_based',
			),
		),
	    // -- Post width based.
		array(
			'heading' => __('Column minimum width', 'the7mk2'),
			'param_name' => 'pwb_column_min_width',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'dependency'	=> array(
				'element'	=> 'responsiveness',
				'value'		=> 'post_width_based',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading' => __('Desired columns number', 'the7mk2'),
			'param_name' => 'pwb_columns',
			'type' => 'dt_number',
			'value' => '',
			'units' => '',
			'max' => 12,
			"description" => __("Affects only masonry layout", "the7mk2"),
			"dependency" => array("element" => "responsiveness", "value" => 'post_width_based' ),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
	  	array(
			"heading" => __("Gap between columns ", 'the7mk2'),
			"param_name" => "gap_between_posts",
			"type" => "dt_number",
			"value" => "15",
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
			"description" => __("Please note that this setting affects post paddings. So, for example: a value 10px will give you 20px gaps between posts)", "the7mk2"),
		),
		array(
			'heading' => __( 'Pagination colors', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
		),
		array(
			'heading' => __('Font color', 'the7mk2'),
			'param_name' => 'navigation_font_color',
			'type' => 'colorpicker',
			'value' => '',
			'description' => __( 'Leave empty to use headers color.', 'the7mk2' ),
		),
		array(
			'heading' => __('Accent color', 'the7mk2'),
			'param_name' => 'navigation_accent_color',
			'type' => 'colorpicker',
			'value' => '',
			'description' => __( 'Leave empty to use accent color.', 'the7mk2' ),
		),

		// - Pagination.
		array(
			'heading' => __( 'Pagination', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			'heading' => __('Pagination mode', 'the7mk2'),
			'param_name' => 'loading_mode',
			'type' => 'dropdown',
			'std' => 'disabled',
			'value' => array(
				'Disabled' => 'disabled',
				'Standard' => 'standard',
				'JavaScript pages' => 'js_pagination',
				'"Load more" button' => 'js_more',
				'Infinite scroll' => 'js_lazy_loading',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		// -- Disabled.
		array(
			'heading' => __('Total number of posts', 'the7mk2'),
			'param_name' => 'dis_posts_total',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'disabled',
			),
			'description' => __('Leave empty to display all posts.', 'the7mk2'),
		),
		// -- Standard.
		array(
			'heading' => __('Number of posts to display on one page', 'the7mk2'),
			'param_name' => 'st_posts_per_page',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'standard',
			),
			'description' => __('Leave empty to use number from wp settings.', 'the7mk2'),
		),
		array(
			'heading' => __('Show all pages in paginator', 'the7mk2'),
			'param_name' => 'st_show_all_pages',
			'type' => 'dt_switch',
			'value' => 'n',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'standard',
			),
		),
		array(
			'heading' => __('Gap before pagination', 'the7mk2'),
			'param_name' => 'st_gap_before_pagination',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'standard',
			),
			'description' => __('Leave empty to use default gap', 'the7mk2'),
		),
		// -- JavaScript pages.
		array(
			'heading' => __('Total number of posts', 'the7mk2'),
			'param_name' => 'jsp_posts_total',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_pagination',
			),
			'description' => __('Leave empty to display all posts.', 'the7mk2'),
		),
		array(
			'heading' => __('Number of posts to display on one page', 'the7mk2'),
			'param_name' => 'jsp_posts_per_page',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_pagination',
			),
			'description' => __('Leave empty to use number from wp settings.', 'the7mk2'),
		),
		array(
			'heading' => __('Show all pages in paginator', 'the7mk2'),
			'param_name' => 'jsp_show_all_pages',
			'type' => 'dt_switch',
			'value' => 'n',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_pagination',
			),
		),
		array(
			'heading' => __('Gap before pagination', 'the7mk2'),
			'param_name' => 'jsp_gap_before_pagination',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_pagination',
			),
			'description' => __('Leave empty to use default gap', 'the7mk2'),
		),
		// -- js Load more.
		array(
			'heading' => __('Total number of posts', 'the7mk2'),
			'param_name' => 'jsm_posts_total',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_more',
			),
			'description' => __('Leave empty to display all posts.', 'the7mk2'),
		),
		array(
			'heading' => __('Number of posts to display on one page', 'the7mk2'),
			'param_name' => 'jsm_posts_per_page',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_more',
			),
			'description' => __('Leave empty to use number from wp settings.', 'the7mk2'),
		),
		array(
			'heading' => __('Gap before pagination', 'the7mk2'),
			'param_name' => 'jsm_gap_before_pagination',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_more',
			),
			'description' => __('Leave empty to use default gap', 'the7mk2'),
		),
		// -- js Infinite scroll.
		array(
			'heading' => __('Total number of posts', 'the7mk2'),
			'param_name' => 'jsl_posts_total',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_lazy_loading',
			),
			'description' => __('Leave empty to display all posts.', 'the7mk2'),
		),
		array(
			'heading' => __('Number of posts to display on one page', 'the7mk2'),
			'param_name' => 'jsl_posts_per_page',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_lazy_loading',
			),
			'description' => __('Leave empty to use number from wp settings.', 'the7mk2'),
		),
		array(
			'heading' => __( 'Extra Class', 'the7mk2' ),
			'param_name' => 'dt_title_general',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			"type" => "textfield",
			"heading" => __("Extra class name (optional)","the7mk2"),
			"param_name" => "el_class",
			"value" => "",
			"description" => __("Style particular elements differently - add a class name and refer to it in custom CSS.", "the7mk2"),
	  	),

		// - Testimonial Author Name.

		array(
			'heading' => __( 'Testimonial Author Name', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
			'group' => __( 'Testimonial', 'the7mk2' ),
		),
		array(
			'heading' => __('Show author name', 'the7mk2'),
			'param_name' => 'testimonial_name',
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'group' => __( 'Testimonial', 'the7mk2' ),
		),
		array(
			'heading' => __( 'Font style', 'the7mk2' ),
			'param_name' => 'post_title_font_style',
			'type' => 'dt_font_style',
			'value' => ':bold:',
			'group' => __( 'Testimonial', 'the7mk2' ),
			'dependency' => array(
				'element' => 'testimonial_name',
				'value' => 'y',
			),
		),
		array(
			'heading' => __('Font size', 'the7mk2'),
			'param_name' => 'post_title_font_size',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description' => __( 'Leave empty to use H4 font size.', 'the7mk2' ),
			'group' => __( 'Testimonial', 'the7mk2' ),
			'dependency' => array(
				'element' => 'testimonial_name',
				'value' => 'y',
			),
		),
		array(
			'heading' => __('Line height', 'the7mk2'),
			'param_name' => 'post_title_line_height',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description' => __( 'Leave empty to use H4 line height.', 'the7mk2' ),
			'group' => __( 'Testimonial', 'the7mk2' ),
			'dependency' => array(
				'element' => 'testimonial_name',
				'value' => 'y',
			),
		),
		array(
			'heading'		=> __('Font color', 'the7mk2'),
			'param_name'	=> 'custom_title_color',
			'type'			=> 'colorpicker',
			'value'			=> '',
			'description' => __( 'Leave empty to use headers color.', 'the7mk2' ),
			'group' => __( 'Testimonial', 'the7mk2' ),
			'dependency' => array(
				'element' => 'testimonial_name',
				'value' => 'y',
			),
		),
		array(
			'heading' => __('Gap below name', 'the7mk2'),
			'param_name' => 'post_title_bottom_margin',
			'type' => 'dt_number',
			'value' => '0',
			'units' => 'px',
			'group' => __( 'Testimonial', 'the7mk2' ),
			'dependency' => array(
				'element' => 'testimonial_name',
				'value' => 'y',
			),
		),
		// - Meta Information.
		array(
			'heading' => __( 'Testimonial Author Position', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
			'group' => __( 'Testimonial', 'the7mk2' ),
		),
		array(
			'heading' => __('Show position', 'the7mk2'),
			'param_name' => 'testimonial_position',
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'group' => __( 'Testimonial', 'the7mk2' ),
		),

		array(
			'heading' => __( 'Font style', 'the7mk2' ),
			'param_name' => 'testimonial_position_font_style',
			'type' => 'dt_font_style',
			'value' => 'normal:bold:none',
			'group' => __( 'Testimonial', 'the7mk2' ),
			'dependency' => array(
				'element' => 'testimonial_position',
				'value' => 'y',
			),
		),
		array(
			'heading' => __('Font size', 'the7mk2'),
			'param_name' => 'testimonial_position_font_size',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description' => __( 'Leave empty to use medium font size.', 'the7mk2' ),
			'group' => __( 'Testimonial', 'the7mk2' ),
			'dependency' => array(
				'element' => 'testimonial_position',
				'value' => 'y',
			),
		),
		array(
			'heading' => __('Line height', 'the7mk2'),
			'param_name' => 'testimonial_position_line_height',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description' => __( 'Leave empty to use medium line height.', 'the7mk2' ),
			'group' => __( 'Testimonial', 'the7mk2' ),
			'dependency' => array(
				'element' => 'testimonial_position',
				'value' => 'y',
			),
		),
		array(
			'heading'		=> __('Font color', 'the7mk2'),
			'param_name'	=> 'testimonial_position_color',
			'type'			=> 'colorpicker',
			'value'			=> '',
			'description' => __( 'Leave empty to use accent text color.', 'the7mk2' ),
			'group' => __( 'Testimonial', 'the7mk2' ),
			'dependency' => array(
				'element' => 'testimonial_position',
				'value' => 'y',
			),
		),
		array(
			'heading' => __('Gap below position', 'the7mk2'),
			'param_name' => 'testimonial_position_bottom_margin',
			'type' => 'dt_number',
			'value' => '20px',
			'units' => 'px',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group' => __( 'Testimonial', 'the7mk2' ),
			'dependency' => array(
				'element' => 'testimonial_position',
				'value' => 'y',
			),
		),


		// - Text.
		array(
			'heading' => __( 'Testimonial', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
			'group' => __( 'Testimonial', 'the7mk2' ),
		),
		array(
			'heading' => __('Testimonial content or excerpt', 'the7mk2'),
			'param_name' => 'post_content',
			'type' => 'dropdown',
			'std' => 'show_excerpt',
			'value' => array(
				'Excerpt' => 'show_excerpt',
				'Content' => 'show_content',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group' => __( 'Testimonial', 'the7mk2' ),
		),
		array(
			'heading' => __('Maximum number of words', 'the7mk2'),
			'param_name' => 'excerpt_words_limit',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'description' => __( 'Leave empty to show full text.', 'the7mk2' ),
			'group' => __( 'Testimonial', 'the7mk2' ),
			'dependency' => array(
				'element' => 'post_content',
				'value' => 'show_excerpt',
			),
		),
		array(
			'heading' => __( 'Font style', 'the7mk2' ),
			'param_name' => 'content_font_style',
			'type' => 'dt_font_style',
			'value' => '',
			'group' => __( 'Testimonial', 'the7mk2' ),
		),
		array(
			'heading' => __('Font size', 'the7mk2'),
			'param_name' => 'content_font_size',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description' => __( 'Leave empty to use large font size.', 'the7mk2' ),
			'group' => __( 'Testimonial', 'the7mk2' ),
		),
		array(
			'heading' => __('Line height', 'the7mk2'),
			'param_name' => 'content_line_height',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description' => __( 'Leave empty to use medium line height.', 'the7mk2' ),
			'group' => __( 'Testimonial', 'the7mk2' ),
		),
		array(
			'heading'		=> __('Font color', 'the7mk2'),
			'param_name'	=> 'custom_content_color',
			'type'			=> 'colorpicker',
			'value'			=> '',
			'description' => __( 'Leave empty to use primary text color.', 'the7mk2' ),
			'group' => __( 'Testimonial', 'the7mk2' ),
		),
		array(
			'heading' => __('Gap below testimonial', 'the7mk2'),
			'param_name' => 'content_bottom_margin',
			'type' => 'dt_number',
			'value' => '0',
			'units' => 'px',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group' => __( 'Testimonial', 'the7mk2' ),
		),
		array(
			'type' => 'css_editor',
			'heading' => __( 'CSS box', 'the7mk2' ),
			'param_name' => 'css_dt_testimonials_masonry',
			'group' => __( 'Design Options', 'the7mk2' )
		),
	),
);

