<?php
// Blog & News

if
(function_exists('vc_map'))
{
	vc_map( array(

			"name" => esc_html__("DC Blog And News", 'welderpro'),

			"base" => "blogs",

			"class" => "",

			"category" => 'Content',

			"icon" => "icon-st",

			"params" => array(

				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__('Number', 'welderpro'),
					"param_name" => "num",
					"description" => esc_html__('Enter Number of posts to Show.', 'welderpro')
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__('Text Limit', 'welderpro'),
					"param_name" => "text_limit",
					"description" => esc_html__('Enter text limit for posts to Show.', 'welderpro')
				),
				array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( 'Category', 'welderpro'),
					"param_name" => "cat",
					"value" => array_flip( (array)welderpro_get_categories( array( 'taxonomy' => 'category', 'hide_empty' => FALSE ), true ) ),
					"description" => esc_html__( 'Choose Category.', 'welderpro')
				),
				array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Order By", 'welderpro'),
					"param_name" => "sort",
					'value' => array_flip( array('select'=>esc_html__('Select Options', 'welderpro'), 'date'=>esc_html__('Date', 'welderpro'), 'title'=>esc_html__('Title', 'welderpro') , 'name'=>esc_html__('Name', 'welderpro') , 'author'=>esc_html__('Author', 'welderpro'), 'comment_count' =>esc_html__('Comment Count', 'welderpro'), 'random' =>esc_html__('Random', 'welderpro') ) ),
					"description" => esc_html__("En<em></em>ter the sorting order.", 'welderpro')
				),
				array(
					"type" => "dropdown",

					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Order", 'welderpro'),
					"param_name" => "order",
					'value' => array_flip(array('select'=>esc_html__('Select Options', 'welderpro'), 'ASC'=>esc_html__('Ascending', 'welderpro'), 'DESC'=>esc_html__('Descending', 'welderpro') ) ),
					"description" => esc_html__("Enter the sorting order.", 'welderpro')
				),
			)


		)

	);
}

//Custom Heading
if
(function_exists('vc_map'))
{



	vc_map( array(



			"name"      => esc_html__("DC Heading", 'welderpro'),



			"base"      => "heading",



			"class"     => "",



			"icon" => "icon-st",



			"category"  => 'Content',



			"params"    => array(



				array(



					"type"      => "textarea",



					"holder"    => "div",



					"class"     => "",



					"heading"   => esc_html__("Text", 'welderpro'),



					"param_name"=> "text",



					"value"     => "",



					"description" => esc_html__("Heading", 'welderpro')



				),

				array(



					"type" => "dropdown",



					"heading" => esc_html__('Element Tag', 'welderpro'),



					"param_name" => "tag",



					"value" => array(

						esc_html__('h1', 'welderpro') => 'h1',

						esc_html__('h2', 'welderpro') => 'h2',



						esc_html__('h3', 'welderpro') => 'h3',



						esc_html__('h4', 'welderpro') => 'h4',



						esc_html__('h5', 'welderpro') => 'h5',



						esc_html__('h6', 'welderpro') => 'h6',



						esc_html__('p', 'welderpro')  => 'p',



						esc_html__('div', 'welderpro') => 'div'

					),

					"description" => esc_html__("Section Element Tag", 'welderpro'),

				),

				array(

					"type" => "dropdown",

					"heading" => esc_html__('Text Align', 'welderpro'),

					"param_name" => "align",

					"value" => array(

						esc_html__('left', 'welderpro') => 'left',

						esc_html__('right', 'welderpro') => 'right',

						esc_html__('center', 'welderpro') => 'center',

						esc_html__('justify', 'welderpro') => 'justify',

					),



					"description" => esc_html__("Section Overlay", 'welderpro'),



				),

				array(



					"type"      => "textfield",



					"holder"    => "div",



					"class"     => "",



					"heading"   => esc_html__("Font Size", 'welderpro'),



					"param_name"=> "size",



					"value"     => "",



					"description" => esc_html__("Ex: 14px", 'welderpro')



				),

				array(
					"type"      => "colorpicker",
					"holder"    => "div",
					"class"     => "",
					"heading"   => esc_html__("Color", 'welderpro'),
					"param_name"=> "color",
					"value"     => "",
					"description" => esc_html__("", 'welderpro')
				),

				array(



					"type"      => "textfield",



					"holder"    => "div",



					"class"     => "",



					"heading"   => esc_html__("Margin Bottom", 'welderpro'),



					"param_name"=> "bot",



					"value"     => "",



					"description" => esc_html__("", 'welderpro')



				),

				array(



					"type"      => "textfield",



					"holder"    => "div",



					"class"     => "",



					"heading"   => esc_html__("Class Extra", 'welderpro'),



					"param_name"=> "class",



					"value"     => "",



					"description" => esc_html__("", 'welderpro')



				),
				
				array(



					"type"      => "textfield",



					"holder"    => "div",



					"class"     => "",



					"heading"   => esc_html__("Line Height", 'welderpro'),



					"param_name"=> "line_height",



					"value"     => "",



					"description" => esc_html__("", 'welderpro')



				),

			)));



}

//Special Heading
if
(function_exists('vc_map'))
{
vc_map( array(
"name"      => esc_html__("Special Heading", 'welderpro'),
"base"      => "sheading",
"class"     => "",
"icon" => "icon-st",
"category"  => 'Content',
"params"    => array(
					array(
					"type"      => "textfield",
					"holder"    => "div",
					"class"     => "",
					"heading"   => esc_html__("Text", 'welderpro'),
					"param_name"=> "subhead",
					"value"     => "",
					"description" => esc_html__("Sub Heading", 'welderpro')
					),
					array(
					"type"      => "textfield",
					"holder"    => "div",
					"class"     => "",
					"heading"   => esc_html__("Sub Head Font Size", 'welderpro'),
					"param_name"=> "subsize",
					"value"     => "",
					"description" => esc_html__("Ex: 14px", 'welderpro')
					),
					array(
					"type"      => "colorpicker",
					"holder"    => "div",
					"class"     => "",
					"heading"   => esc_html__("Color", 'welderpro'),
					"param_name"=> "subcolor",
					"value"     => "",
					"description" => esc_html__("Subhead Color", 'welderpro')
					),
					array(
					"type"      => "textfield",
					"holder"    => "div",
					"class"     => "",
					"heading"   => esc_html__("Text", 'welderpro'),
					"param_name"=> "mainhead",
					"value"     => "",
					"description" => esc_html__("Main Heading", 'welderpro')
					),
					array(
					"type"      => "textfield",
					"holder"    => "div",
					"class"     => "",
					"heading"   => esc_html__("Main Head Font Size", 'welderpro'),
					"param_name"=> "mainsize",
					"value"     => "",
					"description" => esc_html__("Ex: 14px", 'welderpro')
					),
					array(
					"type"      => "colorpicker",
					"holder"    => "div",
					"class"     => "",
					"heading"   => esc_html__("Main Color", 'welderpro'),
					"param_name"=> "maincolor",
					"value"     => "",
					"description" => esc_html__("Main head Color", 'welderpro')
					),
					array(
					"type"      => "textfield",
					"holder"    => "div",
					"class"     => "",
					"heading"   => esc_html__("Text", 'welderpro'),
					"param_name"=> "paragraph",
					"value"     => "",
					"description" => esc_html__("Paragraph Heading", 'welderpro')
					),
					array(
					"type"      => "textfield",
					"holder"    => "div",
					"class"     => "",
					"heading"   => esc_html__("Paragraph Font Size", 'welderpro'),
					"param_name"=> "parasize",
					"value"     => "",
					"description" => esc_html__("Ex: 14px", 'welderpro')
					),
					array(
					"type"      => "colorpicker",
					"holder"    => "div",
					"class"     => "",
					"heading"   => esc_html__("Color", 'welderpro'),
					"param_name"=> "paracolor",
					"value"     => "",
					"description" => esc_html__("Paragraph Color", 'welderpro')
					),
					array(
					"type"      => "textfield",
					"holder"    => "div",
					"class"     => "",
					"heading"   => esc_html__("Margin Bottom", 'welderpro'),
					"param_name"=> "mbottom",
					"value"     => "",
					"description" => esc_html__("Ex: 70px", 'welderpro')
					),

)));
}

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Counter
/*-----------------------------------------------------------------------------------*/
if
(function_exists('vc_map'))
{
	vc_map( array(
		"name"					=>esc_html__( "Counter", 'welderpro' ),
		"description"			=>esc_html__( "Counter", 'welderpro' ),
		"base"					=> "welderpro_counter",
		'category'				=> "Content",
		"icon"					=> "icon-wpb-welderpro-counter",
		"params"				=> array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=>esc_html__( "Number", 'welderpro' ),
				"param_name"	=> "number",
				"value"			=> "197",
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=>esc_html__( "Title", 'welderpro' ),
				"param_name"	=> "title",
				"value"			=> "",
			),
			array(
				"type"			=> "colorpicker",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=>esc_html__( "Color", 'welderpro' ),
				"param_name"	=> "color",
				"value"			=> "#666666",
			),
			array(
				"type"			=> "textarea_html",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=>esc_html__( "Content", 'welderpro' ),
				"param_name"	=> "content",
				"value"			=> "Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.",
				"group"	=>esc_html__( 'Content', 'welderpro' ),
			),
		)
	) );
}


/*-----------------------------------------------------------------------------------*/
/* Map to VC - Iconbox
/*-----------------------------------------------------------------------------------*/
if
(function_exists('vc_map'))
{
	vc_map( array(
		"name"					=> esc_html__( "Iconbox", 'welderpro' ),
		"description"			=> esc_html__( "Box with Icon and Content.", 'welderpro' ),
		"base"					=> "welderpro_iconbox",
		'category'				=> "Content",
		"icon" 					=> "icon-st",
		"params"				=> array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> esc_html__( "Icon", 'welderpro' ),
				"param_name"	=> "icon",
				"value"			=> "fa-phone",
				"description"	=> esc_html__( "Can be any Fontawesome Icon (fa-phone) or Simple Line Icon (sl-users)", 'welderpro' ),
			),
			array(
				"type"			=> "attach_image",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> esc_html__( "Image Alternative", 'welderpro' ),
				"param_name"	=> "iconimg",
				"value"			=> "",
				"description"	=> esc_html__( "Select an image instead of using a Font Icon", 'welderpro' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> esc_html__( "Style", 'welderpro' ),
				"param_name"	=> "style",
				"value"			=> array(
					'Icon next to Box style 1' => '1',
					'Icon next to Box style 2' => '2',
					'Icon next to Box style 3' => '4',
					'Icon above Box' => '3',
				),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> esc_html__( "Icon Color", 'welderpro' ),
				"param_name"	=> "iconcolor",
				"value"			=> array(
					'Accent Color' => 'accent',
					'Greyscale' => 'grey',
					'Custom Color' => 'custom',
				),
			),
			array(
				"type"			=> "colorpicker",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> esc_html__( "Color", 'welderpro' ),
				"param_name"	=> "customcolor",
				"value"			=> "",
				'dependency' => Array( 'element' => 'iconcolor', 'value' => Array('custom') ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> esc_html__( "Custom Class", 'welderpro' ),
				"param_name"	=> "class",
				"value"			=> "",
				"description"	=> esc_html__( "Use this field to add a custom class.", 'welderpro' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> esc_html__( "Title", 'welderpro' ),
				"param_name"	=> "title",
				"value"			=> "",
				"group"	=> esc_html__( 'Content', 'welderpro' ),
			),
			array(
				"type"			=> "colorpicker",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> esc_html__( "Title Color", 'welderpro' ),
				"param_name"	=> "titlecolor",
				"value"			=> "",
				"description"	=> "Pick Title Text Color.",
				"group"	=> esc_html__( 'Content', 'welderpro' ),
			),
			
			array(
				"type"			=> "textarea_html",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> esc_html__( "Content", 'welderpro' ),
				"param_name"	=> "content",
				"value"			=> "Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.",
				"group"	=> esc_html__( 'Content', 'welderpro' ),
			),
			array(
				"type"			=> "colorpicker",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> esc_html__( "Content Color", 'welderpro' ),
				"param_name"	=> "contentcolor",
				"value"			=> "",
				"description"	=> "Pick Content Text Color.",
				"group"	=> esc_html__( 'Content', 'welderpro' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> esc_html__( "Iconbox Title/Button URL (links the complete iconbox to this url)", 'welderpro' ),
				"param_name"	=> "url",
				"value"			=> "",
				"description"	=> "Enter URL or leave empty. ",
				"group"	=> esc_html__( 'Content', 'welderpro' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> esc_html__( "Iconbox Button Text ", 'welderpro' ),
				"param_name"	=> "buttontext",
				"value"			=> "",
				"description"	=> "Enter Button Text or leave empty.",
				"group"	=> esc_html__( 'Content', 'welderpro' ),
			),
			array(
				"type"			=> "colorpicker",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> esc_html__( "Button Text Color", 'welderpro' ),
				"param_name"	=> "buttontcolor",
				"value"			=> "",
				"description"	=> "Pick Button Text Color.",
				"group"	=> esc_html__( 'Content', 'welderpro' ),
			),
			array(
				"type"			=> "colorpicker",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> esc_html__( "Button Background Color", 'welderpro' ),
				"param_name"	=> "buttonbgcolor",
				"value"			=> "",
				"description"	=> "Pick Button Background Color.",
				"group"	=> esc_html__( 'Content', 'welderpro' ),
			),
		)
	) );
}




//Portfolio Filter
if(function_exists('vc_map')){
   vc_map( array(
   "name"      => __("DC Portfolio Filter", 'welderpro'),
   "base"      => "foliof",
   "class"     => "",
   "icon" => "icon-st",
   "category"  => 'Content',
   "params"    => array(
	   
	  array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> esc_html__( "Icon Color", 'welderpro' ),
				"param_name"	=> "style",
				"value"			=> array(
					'Style 1' => 'style1',
					'Style 2' => 'style2',
					'Style 3' => 'style3',
				),
			),

      array(
         "type"      => "textfield",
         "holder"    => "div",
         "class"     => "",
         "heading"   => __("Text Show All Portfolio", 'welderpro'),
         "param_name"=> "all",
         "value"     => "",
         "description" => __("Text Filter Show All Portfolio.", 'welderpro')
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Number portfolio per page", 'welderpro' ),
         "param_name" => "num",
         "value" => "10",
         "description" => __("Enter Number Portfolio.", 'welderpro' )
      ), 
      
    )));
}

// Buttons

if
(function_exists('vc_map'))
{


	vc_map( array(

			"name" => esc_html__("DC Buttons", 'welderpro'),

			"base" => "button",

			"class" => "",

			"category" => 'Content',

			"icon" => "icon-st",

			"params" => array(


				array(

					"type" => "textfield",

					"holder" => "div",

					"class" => "",

					"heading" => esc_html__("Icon", 'welderpro'),

					"param_name" => "icon",

					"value" => '',

					"description" => esc_html__("Ex: download. Find here: <a target='_blank' href='https://icomoon.io/#preview-free'>https://icomoon.io/#preview-free</a>", 'welderpro')

				),
				array(

					"type" => "textfield",

					"holder" => "div",

					"class" => "",

					"heading" => esc_html__("Button Text", 'welderpro'),

					"param_name" => "btntext",

					"value" => "",

					"description" => esc_html__("", 'welderpro')

				),
				array(

					"type" => "textfield",

					"holder" => "div",

					"class" => "",

					"heading" => esc_html__("Button Link", 'welderpro'),

					"param_name" => "btnlink",

					"value" => '',

					"description" => esc_html__("", 'welderpro')

				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__('Style Button', 'welderpro'),
					"param_name" => "style",
					"value" => array(
						esc_html__('Select Style', 'welderpro') => 'no',
						esc_html__('Small', 'welderpro') => 'small',
						esc_html__('Medium', 'welderpro') => 'medium',
						esc_html__('Large', 'welderpro') => 'large',
						esc_html__('Small/Background: transparent', 'welderpro') => 'stransparent',
						esc_html__('Medium/Background: transparent', 'welderpro') => 'mtransparent',
						esc_html__('Large/Background: transparent', 'welderpro') => 'ltransparent',
						esc_html__('Large/Border/Transparent', 'welderpro') => 'lbtransparent',
						esc_html__('Small/White', 'welderpro') => 'swhite',
						esc_html__('Medium/White', 'welderpro') => 'mwhite',
						esc_html__('Large/White', 'welderpro') => 'lwhite',
						esc_html__('Small/dark', 'welderpro') => 'sdark',
						esc_html__('Medium/dark', 'welderpro') => 'mdark',
						esc_html__('Large/dark', 'welderpro') => 'ldark',

					),
					"description" => esc_html__("", 'welderpro'),
				),

			)
		));

}
// Blocqouter Solid

if
(function_exists('vc_map'))
{
	vc_map( array(
			"name"      => esc_html__("DC Blockquote Solid", 'welderpro'),
			"base"      => "blocquote",
			"class"     => "",
			"icon" => "icon-st",
			"category"=>'Content',
			"params"=>array(
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Title", 'welderpro'),
					"param_name" => "title",
					"value" => "",
					"description" => esc_html__("Title display in Blockquote Table.", 'welderpro')
				),
				array(
					"type" => "textarea",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Text ", 'welderpro'),
					"param_name" => "text",
					"value" => "",
					"description" => esc_html__("Text display in blocquote", 'welderpro')
				),


			)


		)

	);
}

// Pricing Table (use)
if
(function_exists('vc_map'))
{
	vc_map( array(
			"name" => esc_html__("DC Pricing Table", 'welderpro'),
			"base" => "pricingtable",
			"class" => "",
			"category" => 'Content',
			"icon" => "icon-st",
			"params" => array(
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Title Pricing", 'welderpro'),
					"param_name" => "title",
					"value" => "",
					"description" => esc_html__("Title display in Pricing Table.", 'welderpro')
				),
				
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Add Class", 'welderpro'),
					"param_name" => "class",
					"value" => "",
					"description" => esc_html__("Add extra class.", 'welderpro')
				),

				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Price Pricing", 'welderpro'),
					"param_name" => "price",
					"value" => "",
					"description" => esc_html__("Price display in Pricing Table.", 'welderpro')
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Per Month", 'welderpro'),
					"param_name" => "month",
					"value" => "",
					"description" => esc_html__("Per Month display in Pricing Table.", 'welderpro')
				),
				array(
					"type" => "textarea_html",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Detail Pricing", 'welderpro'),
					"param_name" => "content",
					"value" => "",
					"description" => esc_html__("Content Pricing Table.", 'welderpro')
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Label Button", 'welderpro'),
					"param_name" => "buttontext",
					"value" => "",
					"description" => esc_html__("Text display in button.", 'welderpro')
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Link Button", 'welderpro'),
					"param_name" => "link",
					"value" => "",
					"description" => esc_html__("Link in button, Leave a blank do not show.", 'welderpro')
				),

			)));
}

//Newsletters
if
(function_exists('vc_map'))
{

	vc_map( array(

			"name"      => esc_html__("DC Newsletters", 'welderpro'),

			"base"      => "newsletter_welderpro",

			"class"     => "",

			"icon" => "icon-st",

			"category"  => 'Content',

			"params"    => array(

				array(

					"type"      => "textfield",

					"holder"    => "div",

					"class"     => "",

					"heading"   => esc_html__("Button Submit", 'welderpro'),

					"param_name"=> "btntext",

					"value"     => "",

					"description" => esc_html__("", 'welderpro')

				),

			)));

}


//Call To Action

if
(function_exists('vc_map'))
{

	vc_map( array(

			"name" => esc_html__("DC Call To Action Box", 'welderpro'),

			"base" => "ctabox",

			"class" => "",

			"icon" => "icon-st",

			"category" => 'Content',

			"params" => array(

				array(

					"type" => "textfield",

					"holder" => "div",

					"class" => "",

					"heading" => esc_html__("Title Box", 'welderpro'),

					"param_name" => "title",

					"value" => "",

					"description" => esc_html__("", 'welderpro')

				),
				array(

					"type" => "textfield",

					"holder" => "div",

					"class" => "",

					"heading" => esc_html__("Icon 1", 'welderpro'),

					"param_name" => "icon1",

					"value" => "",

					"description" => esc_html__("Find here: <a target='_blank' href='https://icomoon.io/#preview-free'>https://icomoon.io/#preview-free</a>", 'welderpro')

				),
				array(

					"type" => "textfield",

					"holder" => "div",

					"class" => "",

					"heading" => esc_html__("Label Button 1", 'welderpro'),

					"param_name" => "btn1",

					"value" => "",

					"description" => esc_html__("", 'welderpro')

				),
				array(

					"type" => "textfield",

					"holder" => "div",

					"class" => "",

					"heading" => esc_html__("Link Button 1", 'welderpro'),

					"param_name" => "link1",

					"value" => "",

					"description" => esc_html__("", 'welderpro')

				),
				array(

					"type" => "textfield",

					"holder" => "div",

					"class" => "",

					"heading" => esc_html__("Icon 2", 'welderpro'),

					"param_name" => "icon2",

					"value" => "",

					"description" => esc_html__("Find here: <a target='_blank' href='https://icomoon.io/#preview-free'>https://icomoon.io/#preview-free</a>", 'welderpro')

				),
				array(

					"type" => "textfield",

					"holder" => "div",

					"class" => "",

					"heading" => esc_html__("Label Button 2", 'welderpro'),

					"param_name" => "btn2",

					"value" => "",

					"description" => esc_html__("", 'welderpro')

				),
				array(

					"type" => "textfield",

					"holder" => "div",

					"class" => "",

					"heading" => esc_html__("Link Button 2", 'welderpro'),

					"param_name" => "link2",

					"value" => "",

					"description" => esc_html__("", 'welderpro')

				),

			)));

}

//Our Team

if
(function_exists('vc_map'))
{
	vc_map( array(
			"name" => esc_html__("DC Our Team", 'welderpro'),
			"base" => "team",
			"class" => "",
			"icon" => "icon-st",
			"category" => 'Content',
			"params" => array(
				array(
					"type" => "attach_image",
					"holder" => "div",
					"class" => "",
					"heading" => "Photo Member",
					"param_name" => "photo",
					"value" => "",
					"description" => esc_html__("", 'welderpro')
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Name", 'welderpro'),
					"param_name" => "name",
					"value" => "",
					"description" => esc_html__("Member's Name", 'welderpro')
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Job", 'welderpro'),
					"param_name" => "job",
					"value" => "",
					"description" => esc_html__("Member's job.", 'welderpro')
				),
				array(
					"type"      => "textfield",
					"holder"    => "div",
					"class"     => "",
					"heading"   => esc_html__("Icon 1", 'welderpro'),
					"param_name"=> "icon1",
					"value"     => "",
					"description" => esc_html__("EX: facebook, twitter,linkedin... Find here: <a target='_blank' href='https://icomoon.io/#preview-free'>https://icomoon.io/#preview-free</a>", 'welderpro')
				),
				array(
					"type"      => "textfield",
					"holder"    => "div",
					"class"     => "",
					"heading"   => "Url 1",
					"param_name"=> "url1",
					"value"     => "",
					"description" => esc_html__("Url.", 'welderpro')
				),
				array(
					"type"      => "textfield",
					"holder"    => "div",
					"class"     => "",
					"heading"   => esc_html__("Icon 2", 'welderpro'),
					"param_name"=> "icon2",
					"value"     => "",
					"description" => esc_html__("EX: facebook, twitter,linkedin... Find here: <a target='_blank' href='https://icomoon.io/#preview-free'>https://icomoon.io/#preview-free</a>", 'welderpro')
				),
				array(
					"type"      => "textfield",
					"holder"    => "div",
					"class"     => "",
					"heading"   => "Url 2",
					"param_name"=> "url2",
					"value"     => "",
					"description" => esc_html__("Url.", 'welderpro')
				),
				array(
					"type"      => "textfield",
					"holder"    => "div",
					"class"     => "",
					"heading"   => esc_html__("Icon 3", 'welderpro'),
					"param_name"=> "icon3",
					"value"     => "",
					"description" => esc_html__("EX: facebook, twitter,linkedin... Find here: <a target='_blank' href='https://icomoon.io/#preview-free'>https://icomoon.io/#preview-free</a>", 'welderpro')
				),
				array(
					"type"      => "textfield",
					"holder"    => "div",
					"class"     => "",
					"heading"   => "Url 3",
					"param_name"=> "url3",
					"value"     => "",
					"description" => esc_html__("Url.", 'welderpro')
				),
				array(
					"type"      => "textfield",
					"holder"    => "div",
					"class"     => "",
					"heading"   => esc_html__("Icon 4", 'welderpro'),
					"param_name"=> "icon4",
					"value"     => "",
					"description" => esc_html__("EX: facebook, twitter,linkedin... Find here: <a target='_blank' href='https://icomoon.io/#preview-free'>https://icomoon.io/#preview-free</a>", 'welderpro')
				),
				array(
					"type"      => "textfield",
					"holder"    => "div",
					"class"     => "",
					"heading"   => "Url 4",
					"param_name"=> "url4",
					"value"     => "",
					"description" => esc_html__("Url.", 'welderpro')
				),
								array(
					"type"      => "textfield",
					"holder"    => "div",
					"class"     => "",
					"heading"   => esc_html__("Icon 5", 'welderpro'),
					"param_name"=> "icon5",
					"value"     => "",
					"description" => esc_html__("EX: facebook, twitter,linkedin... Find here: <a target='_blank' href='https://icomoon.io/#preview-free'>https://icomoon.io/#preview-free</a>", 'welderpro')
				),
				array(
					"type"      => "textfield",
					"holder"    => "div",
					"class"     => "",
					"heading"   => "Url 5",
					"param_name"=> "url5",
					"value"     => "",
					"description" => esc_html__("Url.", 'welderpro')
				),
								array(
					"type"      => "textfield",
					"holder"    => "div",
					"class"     => "",
					"heading"   => esc_html__("Icon 6", 'welderpro'),
					"param_name"=> "icon6",
					"value"     => "",
					"description" => esc_html__("EX: facebook, twitter,linkedin... Find here: <a target='_blank' href='https://icomoon.io/#preview-free'>https://icomoon.io/#preview-free</a>", 'welderpro')
				),
				array(
					"type"      => "textfield",
					"holder"    => "div",
					"class"     => "",
					"heading"   => "Url 6",
					"param_name"=> "url6",
					"value"     => "",
					"description" => esc_html__("Url.", 'welderpro')
				),
			)));
}


//Facts

if
(function_exists('vc_map'))
{

	vc_map( array(

			"name" => esc_html__("DC Facts Box", 'welderpro'),

			"base" => "facts",

			"class" => "",

			"icon" => "icon-st",

			"category" => 'Content',

			"params" => array(

				array(

					"type" => "textfield",

					"holder" => "div",

					"class" => "",

					"heading" => esc_html__("Icon", 'welderpro'),

					"param_name" => "icon",

					"value" => "",

					"description" => esc_html__("Find here: <a target='_blank' href='https://icomoon.io/#preview-free'>https://icomoon.io/#preview-free</a>", 'welderpro')

				),
				array(

					"type" => "textfield",

					"holder" => "div",

					"class" => "",

					"heading" => esc_html__("Number", 'welderpro'),

					"param_name" => "number",

					"value" => "",

					"description" => esc_html__("", 'welderpro')

				),
				array(

					"type" => "textfield",

					"holder" => "div",

					"class" => "",

					"heading" => esc_html__("Title", 'welderpro'),

					"param_name" => "title",

					"value" => "",

					"description" => esc_html__("", 'welderpro')

				),
				array(
					"type"      => "colorpicker",
					"holder"    => "div",
					"class"     => "",
					"heading"   => esc_html__("Color Title", 'welderpro'),
					"param_name"=> "color",
					"value"     => "",
					"description" => esc_html__("", 'welderpro')
				),

				array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Do You Want Border-Right?", 'welderpro'),
					"param_name" => "border",
					"value" => array(

						esc_html__('Select', 'welderpro') => 'yesno',

						esc_html__('No', 'welderpro') => 'no',

						esc_html__('Yes', 'welderpro') => 'yes',

					),
					"description" => esc_html__("", 'welderpro')
				),

			)));

}


//Clients Logo

if
(function_exists('vc_map'))
{

	vc_map( array(

			"name"      => esc_html__("DC Clients Logo", 'welderpro'),

			"base"      => "logos",

			"class"     => "",

			"icon" => "icon-st",

			"category"  => 'Content',

			"params"    => array(

				array(

					"type" => "attach_images",

					"holder" => "div",

					"class" => "",

					"heading" => "Logo Client",

					"param_name" => "gallery",

					"value" => "",

					"description" => esc_html__("Note: Add link to <b>caption</b> image.", 'welderpro')

				),

			)));

}

//Slider(use)

if
(function_exists('vc_map'))
{

	vc_map( array(

			"name"      => esc_html__("DC Slider", 'welderpro'),

			"base"      => "slider",

			"class"     => "",

			"icon" => "icon-st",

			"category"  => 'Content',

			"params"    => array(

				array(

					"type" => "attach_images",

					"holder" => "div",

					"class" => "",

					"heading" => "Slider Images",

					"param_name" => "gallery",

					"value" => "",

					"description" => esc_html__("Note: Add link to <b>caption</b> image.", 'welderpro')

				),


			)));

}

//Contact Address

if
(function_exists('vc_map'))
{

	vc_map( array(

			"name" => esc_html__("DC Contact Address", 'welderpro'),

			"base" => "c-address",

			"class" => "",

			"category" => 'Content',

			"icon" => "icon-st",

			"params" => array(

				array(

					"type" => "attach_images",

					"holder" => "div",

					"class" => "",

					"heading" => "Upload Icon",

					"param_name" => "icon",

					"value" => "",

					"description" => esc_html__("Note: Upload Icon.", 'welderpro')

				),

				array(

					"type" => "textarea_html",

					"holder" => "div",

					"class" => "",

					"heading" => esc_html__("Content Box", 'welderpro'),

					"param_name" => "content",

					"value" => "",

					"description" => esc_html__("", 'welderpro')

				),
		)

		));

}

// Testimonials

if
(function_exists('vc_map'))
{



	vc_map( array(

			"name" => esc_html__("DC Testimonial", 'welderpro'),

			"base" => "testimonial",

			"class" => "",

			"category" => 'Content',

			"icon" => "icon-st",

			"params" => array(

				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Number Show", 'welderpro' ),
					"param_name" => "number",
					"value" => ''
				),
			)

		));

}

// Services

if
(function_exists('vc_map'))
{



	vc_map( array(

			"name" => esc_html__("DC Services", 'welderpro'),

			"base" => "services",

			"class" => "",

			"category" => 'Content',

			"icon" => "icon-st",

			"params" => array(

				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Number Show", 'welderpro' ),
					"param_name" => "number",
					"value" => ''
				),
			)

		));

}

//Social
if
(function_exists('vc_map'))
{


	vc_map( array(

			"name" => esc_html__("DC Social", 'welderpro'),

			"base" => "social",

			"class" => "",

			"category" => 'Content',

			"icon" => "icon-st",

			"params" => array(


				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Link twitter", 'welderpro' ),
					"param_name" => "link1",
					"value" => ''
				),

				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Link github", 'welderpro' ),
					"param_name" => "link2",
					"value" => ''
				),

				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Link dribbble", 'welderpro' ),
					"param_name" => "link3",
					"value" => ''
				),

				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Link linkedin", 'welderpro' ),
					"param_name" => "link4",
					"value" => ''
				),

				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Link behance", 'welderpro' ),
					"param_name" => "link5",
					"value" => ''
				),

				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Link facebook", 'welderpro' ),
					"param_name" => "link6",
					"value" => ''
				),

				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Link instagram", 'welderpro' ),
					"param_name" => "link7",
					"value" => ''
				),

				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Link youtube", 'welderpro' ),
					"param_name" => "link8",
					"value" => ''
				),

				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Link skype", 'welderpro' ),
					"param_name" => "link9",
					"value" => ''
				),

				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Link google", 'welderpro' ),
					"param_name" => "link10",
					"value" => ''
				),
			)

		));

}


/*-----------------------------------------------------------------------------------*/
/* Map to VC - Box - Imagebox Shortcode
/*-----------------------------------------------------------------------------------*/
function welderpro_imagebox_vc() {
	vc_map( array(
		"name"					=>esc_html__( "Imagebox", 'welderpro' ),
		"description"			=>esc_html__( "Box with Content and Button", 'welderpro' ),
		"base"					=> "welderpro_imagebox",
		'category'				=> "Content",
		"icon"					=> "icon-wpb-welderpro-imagebox",
		"params"				=> array(
			array(
				"type"			=> "attach_image",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=>esc_html__( "Image", 'welderpro' ),
				"param_name"	=> "img",
				"value"			=> "",
				"description"	=>esc_html__( "If you want to use an Image you can upload it here.", 'welderpro' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=>esc_html__( "Title", 'welderpro' ),
				"param_name"	=> "img_title",
				"value"			=> ""
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=>esc_html__( "Link Image to this URL", 'welderpro' ),
				"param_name"	=> "url",
				"value"			=> "",
				"description"	=>esc_html__( "Enter URL or leave empty", 'welderpro' )
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=>esc_html__( "Margin Bottom", 'welderpro' ),
				"param_name"	=> "margin_bot",
				"value"			=> "",
				"description"	=>esc_html__( "ex : 40px", 'welderpro' )
			),
			array(
				"type"			=> "textarea_html",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=>esc_html__( "Content", 'welderpro' ),
				"param_name"	=> "content",
				"value"			=> "Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.",
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=>esc_html__( "Style", 'welderpro' ),
				"param_name"	=> "style",
				"value"			=> array(
					'Boxed' => '1',
					'Simple' => '2',
					'Boxed Content Left' => '3',
					'Simple Content Left' => '4',
				),
			),
		)
	) );
}
add_action( 'vc_before_init', 'welderpro_imagebox_vc' );



/*-----------------------------------------------------------------------------------*/
/* Map to VC - Divider
/*-----------------------------------------------------------------------------------*/
function welderpro_divider_vc() {
	vc_map( array(
		"name"					=>esc_html__( "Divider", 'welderpro' ),
		"description"			=>esc_html__( "Divider & Separator", 'welderpro' ),
		"base"					=> "welderpro_divider",
		'category'				=> "Structure",
		"icon"					=> "icon-wpb-welderpro-divider",
		"params"				=> array(
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=>esc_html__( "Divider Style", 'welderpro' ),
				"param_name"	=> "style",
				"value"			=> array(
					'Thin Light Grey' => '1',
					'Dotted' => '2',
					'Line with Shadow' => '3',
					'Diagonal Lines' => '4',
					'Short Accent Color' => '5',
					'Short Dark Grey' => '6',
					'Dashed Line' => '7',
					'Centered Line with Icon' => '8',
					'Thin Light for dark Backgrounds' => '9',
				),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=>esc_html__( "Margin", 'welderpro' ),
				"param_name"	=> "margin",
				"value"			=> "60px 0 60px 0",
				"description"	=>esc_html__( "Set Divider Margin - topmargin rightmargin bottommargin leftmargin", 'welderpro' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=>esc_html__( "Icon", 'welderpro' ),
				"param_name"	=> "icon",
				"value"			=> "",
				"description"	=>esc_html__( "Can be any Fontawesome Icon (ie. fa-phone)", 'welderpro' ),
				'dependency' => Array( 'element' => 'style', 'value' => Array('8') ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'welderpro_divider_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - New Divider
/*-----------------------------------------------------------------------------------*/
function welderpro_newdivider_vc() {
	vc_map( array(
		"name" =>esc_html__( "New Divider", 'welderpro' ),
		"description" =>esc_html__( "Divider & Separator", 'welderpro' ),
		"base" => "welderpro_newdivider",
		"category" => 'Structure',
		"icon" => "icon-wpb-welderpro-divider",
		"params" => array(
			array(
				"type" => "dropdown",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Line Style",
				"param_name" => "style",
				"value" => array(
					"Solid" => "solid",
					"Dashed" => "dashed",
					"Dotted" => "dotted",
					"Transparent" => "transparent",
				),
				"description" => "",
			),
			array(
	            "type" => "colorpicker",
	            "admin_label" => false,
	            "class" => "",
	            "heading" => "Line Color",
	            "value" => "#999999",
	            "param_name" => "line_color",
	        ),
			array(
				"type" => "textfield",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Width",
				"param_name" => "width",
				"value" => "100%",
				"save_value" => true,
				"description" => "Width of the separator. Can be px or %. Default: 100%",
			),
			array(
				"type" => "textfield",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Thickness",
				"param_name" => "thickness",
				"value" => "1px",
				"save_value" => true,
				"description" => "Tickness of the separator. Default: 1px",
			),
			array(
				"type" => "textfield",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Top Margin",
				"param_name" => "topmargin",
				"value" => "",
				"save_value" => true,
				"description" => "Top Margin. For example: 20px",
			),
			array(
				"type" => "textfield",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Bottom Margin",
				"param_name" => "bottommargin",
				"value" => "",
				"save_value" => true,
				"description" => "Top Margin. For example: 20px",
			),
			array(
				"type" => "dropdown",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Align",
				"param_name" => "align",
				"value" => array(
					"Center" => "center",
					"Left" => "left",
					"Right" => "right",
				),
				"description" => "",
			),
		)
	) );
}
add_action( 'vc_before_init', 'welderpro_newdivider_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Headline
/*-----------------------------------------------------------------------------------*/
function welderpro_headline_vc() {
	vc_map( array(
		"name"					=>esc_html__( "Headline", 'welderpro' ),
		"description"			=>esc_html__( "Insert a Custom Headline", 'welderpro' ),
		"base"					=> "welderpro_headline",
		'category'				=> "Text",
		"icon"					=> "icon-wpb-welderpro-headline",
		"params"				=> array(
			array(
				"type"			=> "textarea",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=>esc_html__( "Content", 'welderpro' ),
				"param_name"	=> "content",
				"value"			=> "",
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=>esc_html__( "Headline Type", 'welderpro' ),
				"param_name"	=> "type",
				"value"			=> array(
					'h1' => 'h1',
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'h5' => 'h5',
					'h6' => 'h6',
					'Normal Text' => 'div',
				),
				"description"	=>esc_html__( "This is for SEO purposes and does not set the size (i.e. you can have an h1 that is small or an h6 that displays large)", 'welderpro' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=>esc_html__( "Custom Font", 'welderpro' ),
				"param_name"	=> "font",
				"value"			=> array(
					'Standard Headline Font' => 'font-inherit',
					'Special Font' => 'font-special',
				),
				"description"	=>esc_html__( "Headline Font & Special Font can be defined in Theme Options", 'welderpro' ),
				"group"	=>esc_html__( 'Custom Styling', 'welderpro' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=>esc_html__( "Custom Font Size", 'welderpro' ),
				"param_name"	=> "size",
				"value"			=> array(
					'Default' 		=> 'fontsize-inherit',
					'Extra Small' 	=> 'fontsize-xs',
					'Small' 		=> 'fontsize-s',
					'Medium' 		=> 'fontsize-m',
					'Large' 		=> 'fontsize-l',
					'Extra Large' 	=> 'fontsize-xl',
					'XXL' 			=> 'fontsize-xxl',
					'XXXL' 			=> 'fontsize-xxxl',
					'XXXXL' 			=> 'fontsize-xxxxl',
					'XXXXXL' 			=> 'fontsize-xxxxxl',
				),
				"description"	=>esc_html__( "Customize the Font Size or leave it at default (defined in Theme Options)", 'welderpro' ),
				"group"	=>esc_html__( 'Custom Styling', 'welderpro' ),
			),
			array(
				"type"			=> "colorpicker",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=>esc_html__( "Custom Font Color", 'welderpro' ),
				"param_name"	=> "color",
				"value"			=> "",
				"description"	=>esc_html__( "Choose a custom Font Color or leave it at default (defined in Theme Options)", 'welderpro' ),
				"group"	=>esc_html__( 'Custom Styling', 'welderpro' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=>esc_html__( "Custom Font Weight", 'welderpro' ),
				"param_name"	=> "weight",
				"value"			=> array(
					'Default' => 'fontweight-inherit',
					'Font Weight 300' => 'fontweight-300',
					'Font Weight 400' => 'fontweight-400',
					'Font Weight 500' => 'fontweight-500',
					'Font Weight 600' => 'fontweight-600',
					'Font Weight 700' => 'fontweight-700',
					'Font Weight 800' => 'fontweight-800',
					'Font Weight 900' => 'fontweight-900',
				),
				"description"	=>esc_html__( "Choose a custom Font Weight or leave it at default (defined in Theme Options)", 'welderpro' ),
				"group"	=>esc_html__( 'Custom Styling', 'welderpro' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=>esc_html__( "Custom Line Height", 'welderpro' ),
				"param_name"	=> "lineheight",
				"value"			=> array(
					'Default' 		=> 'lh-inherit',
					'Line-Height 1.2' 	=> 'lh-12',
					'Line-Height 1.3' 	=> 'lh-13',
					'Line-Height 1.4' 	=> 'lh-14',
					'Line-Height 1.5' 	=> 'lh-15',
					'Line-Height 1.6' 	=> 'lh-16',
					'Line-Height 1.7' 	=> 'lh-17',
					'Line-Height 1.8'   => 'lh-18',
					'Line-Height 1.9' 	=> 'lh-19',
					'Line-Height 2.0' 	=> 'lh-20',
				),
				"description"	=>esc_html__( "For Large Fonts over more than 2 lines you might want to define that value", 'welderpro' ),
				"group"	=>esc_html__( 'Custom Styling', 'welderpro' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=>esc_html__( "Custom Bottom Line Style", 'welderpro' ),
				"param_name"	=> "bottom_lines",
				"value"			=> array(
					'Line Bottom' 		=> 'bottom-line',
					'Line Bottom Left' 		=> 'bottom-line-left',
					'No Line Bottom' 	=> 'no',
				),
				"group"	=>esc_html__( 'Custom Styling', 'welderpro' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=>esc_html__( "Custom Text Transform", 'welderpro' ),
				"param_name"	=> "transform",
				"value"			=> array(
					'Default' => 'transform-inherit',
					'Uppercase' => 'transform-uppercase',
				),
				"group"	=>esc_html__( 'Custom Styling', 'welderpro' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=>esc_html__( "Text Align", 'welderpro' ),
				"param_name"	=> "align",
				"value"			=> array(
					'Center' => 'align-center',
					'Left' => 'align-left',
					'Right' => 'align-right',
				),
				"group"	=>esc_html__( 'Layout', 'welderpro' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=>esc_html__( "Margin", 'welderpro' ),
				"param_name"	=> "margin",
				"value"			=> "0 0 20px 0",
				"description"	=>esc_html__( "Margin - topmargin rightmargin bottommargin leftmargin. Default: 0 0 20px 0", 'welderpro' ),
				"group"	=>esc_html__( 'Layout', 'welderpro' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=>esc_html__( "Extra Class", 'welderpro' ),
				"param_name"	=> "class",
				"value"			=> "",
				"description"	=>esc_html__( "Add your own class and refer to it in your CSS file.", 'welderpro' ),
				"group"	=>esc_html__( 'Layout', 'welderpro' ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'welderpro_headline_vc' );




//Google Map



if
(function_exists('vc_map'))
{

	vc_map( array(

			"name" => esc_html__("DC Google Map", 'welderpro'),

			"base" => "ggmap",

			"class" => "",

			"icon" => "icon-st",

			"category" => 'Content',

			"params" => array(

				array(

					"type" => "textfield",

					"holder" => "div",

					"class" => "",

					"heading" => esc_html__("ID Map", 'welderpro'),

					"param_name" => "idmap",

					"value" => "",

					"description" => esc_html__("Ex: map-canvas, Please enter ID Map, map-canvas1, map-canvas2, map-canvas3, ..etc", 'welderpro')

				),

				array(

					"type" => "textfield",

					"holder" => "div",

					"class" => "",

					"heading" => esc_html__("Height Map", 'welderpro'),

					"param_name" => "height",

					"value" => 250,

					"description" => esc_html__("Please enter number height Map, 300, 350, 380, ..etc. Default: 250.", 'welderpro')

				),

				array(

					"type" => "textfield",

					"holder" => "div",

					"class" => "",

					"heading" => esc_html__("Latitude", 'welderpro'),

					"param_name" => "lat",

					"value" => 53.3525963,

					"description" => esc_html__("Please enter <a href='http://www.latlong.net/'>Latitude</a> google map. Default: 53.3525963.", 'welderpro')

				),

				array(

					"type" => "textfield",

					"holder" => "div",

					"class" => "",

					"heading" => esc_html__("Longitude", 'welderpro'),

					"param_name" => "long",

					"value" => -6.2623117,

					"description" => esc_html__("Please enter <a href='http://www.latlong.net/'>Longitude</a> google map. Default: -6.2623117", 'welderpro')



				),

				array(

					"type" => "textfield",

					"holder" => "div",

					"class" => "",

					"heading" => esc_html__("Zoom Map", 'welderpro'),

					"param_name" => "zoom",

					"value" => 18,

					"description" => esc_html__("Please enter Zoom Map, Default: 18", 'welderpro')

				),


				array(

					"type" => "attach_image",

					"holder" => "div",

					"class" => "",

					"heading" => "Icon Map marker",

					"param_name" => "icon",

					"value" => "",

					"description" => esc_html__("Icon Map marker, 58 x 67", 'welderpro')

				),



			)));



}

?>
