<?php

/*  Initialize the meta boxes.
/* ------------------------------------ */
add_action( 'admin_init', '_custom_meta_boxes' );

function _custom_meta_boxes() {

	$prefix = 'sp_';
  
/*  Custom meta boxes
/* ------------------------------------ */
$page_options = array(
	'id'          => 'page-options',
	'title'       => 'Page Options',
	'desc'        => '',
	'pages'       => array( 'page', 'post', 'team', 'gallery', 'service' ),
	'context'     => 'normal',
	'priority'    => 'default',
	'fields'      => array(
		array(
			'label'		=> 'Primary Sidebar',
			'id'		=> $prefix . 'sidebar_primary',
			'type'		=> 'sidebar-select',
			'desc'		=> 'Overrides default'
		),
		array(
			'label'		=> 'Layout',
			'id'		=> $prefix . 'layout',
			'type'		=> 'radio-image',
			'desc'		=> 'Overrides the default layout option',
			'std'		=> 'inherit',
			'choices'	=> array(
				array(
					'value'		=> 'inherit',
					'label'		=> 'Inherit Layout',
					'src'		=> SP_ASSETS_ADMIN . 'images/layout-off.png'
				),
				array(
					'value'		=> 'col-1c',
					'label'		=> '1 Column',
					'src'		=> SP_ASSETS_ADMIN . 'images/col-1c.png'
				),
				array(
					'value'		=> 'col-2cl',
					'label'		=> '2 Column Left',
					'src'		=> SP_ASSETS_ADMIN . 'images/col-2cl.png'
				),
				array(
					'value'		=> 'col-2cr',
					'label'		=> '2 Column Right',
					'src'		=> SP_ASSETS_ADMIN . 'images/col-2cr.png'
				)
			)
		)
	)
);

/*$post_options = array(
	'id'          => 'post-options',
	'title'       => 'Post Options',
	'desc'        => '',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Primary Sidebar',
			'id'		=> $prefix . 'sidebar_primary',
			'type'		=> 'sidebar-select',
			'desc'		=> 'Overrides default'
		),
		array(
			'label'		=> 'Layout',
			'id'		=> $prefix . 'layout',
			'type'		=> 'radio-image',
			'desc'		=> 'Overrides the default layout option',
			'std'		=> 'inherit',
			'choices'	=> array(
				array(
					'value'		=> 'inherit',
					'label'		=> 'Inherit Layout',
					'src'		=> SP_ASSETS_ADMIN . 'images/layout-off.png'
				),
				array(
					'value'		=> 'col-1c',
					'label'		=> '1 Column',
					'src'		=> SP_ASSETS_ADMIN . 'images/col-1c.png'
				),
				array(
					'value'		=> 'col-2cl',
					'label'		=> '2 Column Left',
					'src'		=> SP_ASSETS_ADMIN . 'images/col-2cl.png'
				),
				array(
					'value'		=> 'col-2cr',
					'label'		=> '2 Column Right',
					'src'		=> SP_ASSETS_ADMIN . 'images/col-2cr.png'
				)
			)
		)
	)
);*/

/* ---------------------------------------------------------------------- */
/*	Home Sliders post type
/* ---------------------------------------------------------------------- */
$post_type_home_sliders = array(
	'id'          => 'home-slide-setting',
	'title'       => 'Home slide meta',
	'desc'        => '',
	'pages'       => array( 'home_slider' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Description',
			'id'		=> $prefix . 'slide_desc',
			'type'		=> 'textarea',
			'desc'		=> 'Enter text to describe about this slide.'
		),
		array(
			'label'		=> 'Link button',
			'id'		=> $prefix . 'slide_btn_name',
			'type'		=> 'text',
			'std'		=> 'Learn more',
			'desc'		=> 'Name of button link'
		),
		array(
			'label'		=> 'Slide URL/Link',
			'id'		=> $prefix . 'slide_btn_url',
			'type'		=> 'text',
			'std'		=> '#',
			'desc'		=> 'Enter slide URL'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Service post type
/* ---------------------------------------------------------------------- */
$post_type_service = array(
	'id'          => 'service-setting',
	'title'       => 'Service meta',
	'desc'        => '',
	'pages'       => array( 'service' ),
	'context'     => 'side',
	'priority'    => 'low',
	'fields'      => array(
		array(
			'label'		=> 'Loan amount',
			'id'		=> $prefix . 'loan_amount',
			'type'		=> 'text',
			'std'		=> '100$ - 10,000$',
			//'desc'		=> 'Enter range amount of loan e.g. 100$ - 10,000$'
		),
		array(
			'label'		=> 'Period',
			'id'		=> $prefix . 'loan_period',
			'type'		=> 'text',
			'std'		=> '1 - 12 Month',
			//'desc'		=> 'Enter duration/period of loan e.g. 1 - 12 Month'
		),
		array(
			'label'		=> 'Rate',
			'id'		=> $prefix . 'loan_rate',
			'type'		=> 'text',
			'std'		=> '1.3%',
			//'desc'		=> 'Enter number of interest of loan e.g. 1.3%'
		)

	)
);

/* ---------------------------------------------------------------------- */
/*	Team post type
/* ---------------------------------------------------------------------- */
$post_type_team = array(
	'id'          => 'team-setting',
	'title'       => 'Team Member meta',
	'desc'        => '',
	'pages'       => array( 'team' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Position',
			'id'		=> $prefix . 'team_position',
			'type'		=> 'text',
			'desc'		=> 'Enter the team member\'s position within the team.'
		),
		array(
			'label'		=> 'Email address',
			'id'		=> $prefix . 'team_email',
			'type'		=> 'text',
			'desc'		=> 'Enter the team member\'s email address.'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Testimonial post type
/* ---------------------------------------------------------------------- */
$post_type_testimonial = array(
	'id'          => 'testimonial-setting',
	'title'       => 'Testimonial meta',
	'desc'        => '',
	'pages'       => array( 'client' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Testimonial Cite',
			'id'		=> $prefix . 'testimonial_cite',
			'type'		=> 'text',
			'desc'		=> 'Enter the cite name for the testimonial.'
		),
		array(
			'label'		=> 'Testimonial Cite Subtext',
			'id'		=> $prefix . 'testimonial_cite_subtext',
			'type'		=> 'text',
			'desc'		=> 'Enter the cite subtext for the testimonial (optional).'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Gallery post type
/* ---------------------------------------------------------------------- */
$post_type_gallery = array(
	'id'          => 'gallery-setting',
	'title'       => 'Upload photos',
	'desc'        => 'These settings enable you to upload photos.',
	'pages'       => array( 'gallery' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Upload photo',
			'id'		=> $prefix . 'gallery',
			'type'		=> 'gallery',
			'desc'		=> 'Upload photos'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Slider post type
/* ---------------------------------------------------------------------- */
$post_type_slider = array(
	'id'          => 'gallery-setting',
	'title'       => 'Upload photos',
	'desc'        => 'These settings enable you to upload photos.',
	'pages'       => array( 'slider', 'service' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Upload photo',
			'id'		=> $prefix . 'sliders',
			'type'		=> 'gallery',
			'desc'		=> 'Upload photos'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Branch
/* ---------------------------------------------------------------------- */
$post_type_branch = array(
	'id'          => 'branch-meta',
	'title'       => 'Branch meta',
	'desc'        => '',
	'pages'       => array( 'branch' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Latitude and Longitude',
			'id'		=> $prefix . 'lat_long',
			'type'		=> 'text',
			'desc'		=> 'e.g. 11.544873,104.892167. You can get this value from <a href="http://itouchmap.com/latlong.html" target="_blank">itouchmap</a>'
		),
		array(
			'label'		=> 'Adress',
			'id'		=> $prefix . 'branch_address',
			'type'		=> 'textarea',
			'rows'		=> '2'
		),
		array(
			'label'		=> 'Tel',
			'id'		=> $prefix . 'branch_tel',
			'type'		=> 'text',
			'desc'		=> 'e.g. (855)-23-990 225/ 10 8888 76'
		),
		array(
			'label'		=> 'E-mail',
			'id'		=> $prefix . 'branch_email',
			'type'		=> 'text',
			'desc'		=> 'e.g. info@seilanithih.com.kh'
		),
	)
);

/* ---------------------------------------------------------------------- */
/*	Exchange Rate
/* ---------------------------------------------------------------------- */
$post_type_exchange = array(
	'id'          => 'exchange-meta',
	'title'       => 'Exchange meta',
	'desc'        => '',
	'pages'       => array( 'exchange' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Buying',
			'id'		=> $prefix . 'buy_rate',
			'type'		=> 'text',
		),
		array(
			'label'		=> 'Selling',
			'id'		=> $prefix . 'sell_rate',
			'type'		=> 'text',
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Post Format: video
/* ---------------------------------------------------------------------- */
$post_format_video = array(
	'id'          => 'format-video',
	'title'       => 'Format: Video',
	'desc'        => 'These settings enable you to embed videos into your posts.',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Video URL',
			'id'		=> $prefix . 'video_url',
			'type'		=> 'text',
			'desc'		=> 'Recommended to use.'
		),
		array(
			'label'		=> 'Video Embed Code',
			'id'		=> $prefix . 'video_embed_code',
			'type'		=> 'textarea',
			'rows'		=> '2'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Post Format: Audio
/* ---------------------------------------------------------------------- */
$post_format_audio = array(
	'id'          => 'format-audio',
	'title'       => 'Format: Audio',
	'desc'        => 'These settings enable you to embed audio into your posts. You must provide both .mp3 and .ogg/.oga file formats in order for self hosted audio to function accross all browsers.',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'MP3 File URL',
			'id'		=> $prefix . 'audio_mp3_url',
			'type'		=> 'upload',
			'desc'		=> 'The URL to the .mp3 or .m4a audio file'
		),
		array(
			'label'		=> 'OGA File URL',
			'id'		=> $prefix . 'audio_ogg_url',
			'type'		=> 'upload',
			'desc'		=> 'The URL to the .oga, .ogg audio file'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Post Format: Gallery
/* ---------------------------------------------------------------------- */
$post_format_gallery = array(
	'id'          => 'format-gallery',
	'title'       => 'Format: Gallery',
	'desc'        => '<a title="Add Media" data-editor="content" class="button insert-media add_media" id="insert-media-button" href="#">Add Media</a> <br /><br />
						To create a gallery, upload your images and then select "<strong>Uploaded to this post</strong>" from the dropdown (in the media popup) to see images attached to this post. You can drag to re-order or delete them there. <br /><br /><i>Note: Do not click the "Insert into post" button. Only use the "Insert Media" section of the upload popup, not "Create Gallery" which is for standard post galleries.</i>',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array()
);

/* ---------------------------------------------------------------------- */
/*	Post Format: Chat
/* ---------------------------------------------------------------------- */
$post_format_chat = array(
	'id'          => 'format-chat',
	'title'       => 'Format: Chat',
	'desc'        => 'Input chat dialogue.',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Chat Text',
			'id'		=> $prefix . 'chat',
			'type'		=> 'textarea',
			'rows'		=> '2'
		)
	)
);
/* ---------------------------------------------------------------------- */
/*	Post Format: Link
/* ---------------------------------------------------------------------- */
$post_format_link = array(
	'id'          => 'format-link',
	'title'       => 'Format: Link',
	'desc'        => 'Input your link.',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Link Title',
			'id'		=> $prefix . 'link_title',
			'type'		=> 'text'
		),
		array(
			'label'		=> 'Link URL',
			'id'		=> $prefix . 'link_url',
			'type'		=> 'text'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Post Format: quote
/* ---------------------------------------------------------------------- */
$post_format_quote = array(
	'id'          => 'format-quote',
	'title'       => 'Format: Quote',
	'desc'        => 'Input your quote.',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Quote',
			'id'		=> $prefix . 'quote',
			'type'		=> 'textarea',
			'rows'		=> '2'
		),
		array(
			'label'		=> 'Quote Author',
			'id'		=> $prefix . 'quote_author',
			'type'		=> 'text'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Metabox for Home template
/* ---------------------------------------------------------------------- */
$page_template_home = array(
	'id'          => 'home-settings',
	'title'       => 'Home settings',
	'desc'        => '',
	'pages'       => array( 'page' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Slideshow',
			'id'		=> $prefix . 'slide_options',
			'type'		=> 'tab'
		),
		array(
			'label'		=> 'Number of Slide to show',
			'id'		=> $prefix . 'slide_num',
			'type'		=> 'text',
			'std'		=> '5',
			'desc'		=> 'Enter number of slide e.g. 5'
		),

		array(
			'label'		=> 'Services',
			'id'		=> $prefix . 'service_options',
			'type'		=> 'tab'
		), 
		array(
			'label'		=> 'Section title',
			'id'		=> $prefix . 'service_title',
			'type'		=> 'text',
			'std'		=> 'Explore Our Products and Services'
		),
		array(
			'label'		=> 'Description',
			'id'		=> $prefix . 'service_desc',
			'type'		=> 'textarea',
			'rows'      => '2',
			'std'		=> 'Choose your suitable intereste rate for each kind of your business'
		),
		array(
			'label'		=> 'Number of Service to show',
			'id'		=> $prefix . 'service_num',
			'type'		=> 'text',
			'std'		=> '-1',
			'desc'		=> 'Enter number of service e.g. 5'
		),

		array(
			'label'		=> 'Process Step',
			'id'		=> $prefix . 'process_options',
			'type'		=> 'tab'
		), 
		array(
			'label'		=> 'Section title',
			'id'		=> $prefix . 'process_title',
			'type'		=> 'text',
			'std'		=> 'Explore Our Products and Services'
		),
		array(
			'label'		=> 'Description',
			'id'		=> $prefix . 'process_desc',
			'type'		=> 'textarea',
			'rows'      => '1',
			'std'		=> 'Choose your suitable intereste rate for each kind of your business'
		),
		array(
			'label'		=> 'Title of step 1',
			'id'		=> $prefix . 'process_step_1',
			'type'		=> 'text',
			'std'		=> 'ANALYSIS YOUR BUSINESS'
		),
		array(
			'label'		=> 'Overview text',
			'id'		=> $prefix . 'process_txt_1',
			'type'		=> 'textarea',
			'rows'      => '1'
		),
		array(
			'label'		=> 'Title of step 2',
			'id'		=> $prefix . 'process_step_2',
			'type'		=> 'text',
			'std'		=> 'VERIFY YOUR DOCUMENTS'
		),
		array(
			'label'		=> 'Overview text',
			'id'		=> $prefix . 'process_txt_2',
			'type'		=> 'textarea',
			'rows'      => '1'
		),
		array(
			'label'		=> 'Title of step 3',
			'id'		=> $prefix . 'process_step_3',
			'type'		=> 'text',
			'std'		=> 'LOAN DISBURSEMENT'
		),
		array(
			'label'		=> 'Overview text',
			'id'		=> $prefix . 'process_txt_3',
			'type'		=> 'textarea',
			'rows'      => '1'
		),
		array(
			'label'		=> 'Background image',
			'id'		=> $prefix . 'process_bg',
			'type'		=> 'upload'
		),
		array(
			'label'		=> 'FAQs',
			'id'		=> $prefix . 'faq_options',
			'type'		=> 'tab'
		), 
		array(
			'label'		=> 'Section title',
			'id'		=> $prefix . 'faq_title',
			'type'		=> 'text',
			'std'		=> 'FAQs'
		),
		array(
			'label'		=> 'Number of question and answer',
			'id'		=> $prefix . 'faq_num',
			'type'		=> 'text',
			'std'		=> '5',
			'desc'		=> 'Enter number of FAQs e.g. 5'
		),
		array(
			'label'		=> 'FAQs page',
			'id'		=> $prefix . 'faq_page_id',
			'type'		=> 'page-select'
		),
		array(
			'label'		=> 'Clients',
			'id'		=> $prefix . 'client_options',
			'type'		=> 'tab'
		), 
		array(
			'label'		=> 'Section title',
			'id'		=> $prefix . 'client_title',
			'type'		=> 'text',
			'std'		=> 'Happy Clients'
		),
		array(
			'label'		=> 'Client page',
			'id'		=> $prefix . 'client_page_id',
			'type'		=> 'page-select'
		),
		array(
			'label'		=> 'Partners',
			'id'		=> $prefix . 'partner_options',
			'type'		=> 'tab'
		), 
		array(
			'label'		=> 'Section title',
			'id'		=> $prefix . 'partner_title',
			'type'		=> 'text',
			'std'		=> 'Partners and Donors'
		),
		array(
			'label'		=> 'Number of parnter\'s logo',
			'id'		=> $prefix . 'partner_num',
			'type'		=> 'text',
			'std'		=> '-1',
			'desc'		=> 'Enter number of logo e.g. 10'
		),
	)
);

function rw_maybe_include() {
	// Include in back-end only
	if ( ! defined( 'WP_ADMIN' ) || ! WP_ADMIN ) {
		return false;
	}

	// Always include for ajax
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return true;
	}

	if ( isset( $_GET['post'] ) ) {
		$post_id = $_GET['post'];
	}
	elseif ( isset( $_POST['post_ID'] ) ) {
		$post_id = $_POST['post_ID'];
	}
	else {
		$post_id = false;
	}

	$post_id = (int) $post_id;
	$post    = get_post( $post_id );

	$template = get_post_meta( $post_id, '_wp_page_template', true );

	return $template;
}

/*  Register meta boxes
/* ------------------------------------ */
	ot_register_meta_box( $page_options );
	/*ot_register_meta_box( $post_options );
	ot_register_meta_box( $post_format_audio );
	ot_register_meta_box( $post_format_chat );
	ot_register_meta_box( $post_format_link );
	ot_register_meta_box( $post_format_quote );
	ot_register_meta_box( $post_format_video );
	ot_register_meta_box( $post_format_gallery );*/
	ot_register_meta_box( $post_type_home_sliders );
	ot_register_meta_box( $post_type_service );
	ot_register_meta_box( $post_type_team );
	ot_register_meta_box( $post_type_testimonial );
	ot_register_meta_box( $post_type_gallery );
	ot_register_meta_box( $post_type_slider );
	ot_register_meta_box( $post_type_branch );
	ot_register_meta_box( $post_type_exchange );

	$template_file = rw_maybe_include();
	if ( $template_file == 'template-home.php' ) {
	    ot_register_meta_box( $page_template_home );
	}
}