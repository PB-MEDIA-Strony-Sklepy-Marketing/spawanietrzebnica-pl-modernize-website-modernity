<?php
/**
 * ===== Loading Resources =====
 * Add all the extra static resources of the child theme - right now only the style.css file
 */

function welderpro_enqueue_styles() {

    $parent_style = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css', 'true' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}

add_action( 'wp_enqueue_scripts', 'welderpro_enqueue_styles' );

/**
 * Child-Theme functions and definitions
 */
 
 function cars4rent_child_scripts() {
    wp_enqueue_style( 'welderpro-parent-style', get_template_directory_uri(). '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'cars4rent_child_scripts' );

/**
 * Loads the child theme textdomain.
 */
function wpdocs_child_theme_setup() {
    load_theme_textdomain( 'welderpro', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'wpdocs_child_theme_setup' );

/**
 * Force WordPress to load the translation file for trx_utils from the child theme
 */
function force_trx_utils_translation_mofile( $mofile, $domain ) {
    if ( 'dt-the7-core' === $domain ) {
        $custom_mofile = get_stylesheet_directory() . '/languages/dt-the7-core-' . determine_locale() . '.mo';

        if ( file_exists( $custom_mofile ) ) {
            return $custom_mofile;
        }
    }
    return $mofile;
}
add_filter( 'load_textdomain_mofile', 'force_trx_utils_translation_mofile', 10, 2 );

remove_action('wp_head', 'wp_generator');
function my_secure_generator( $generator, $type ) {
	return '';
}
add_filter( 'the_generator', 'my_secure_generator', 10, 2 );

function my_remove_src_version( $src ) {
	global $wp_version;

	$version_str = '?ver='.$wp_version;
	$offset = strlen( $src ) - strlen( $version_str );

	if ( $offset >= 0 && strpos($src, $version_str, $offset) !== FALSE )
		return substr( $src, 0, $offset );

	return $src;
}
add_filter( 'script_loader_src', 'my_remove_src_version' );
add_filter( 'style_loader_src', 'my_remove_src_version' );
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Wczytaj pliki CSS i JS z katalogu /custom/ w katalogu g艂贸wnym WordPressa
 */
function enqueue_custom_assets_from_custom_folder() {
    $custom_base_url = get_site_url() . '/custom';

    // CSS
    wp_enqueue_style(
        'cookieconsent',
        $custom_base_url . '/cookieconsent.min.css',
        array(),
        null
    );

    wp_enqueue_style(
        'iframemanager-css',
        $custom_base_url . '/iframemanager.min.css',
        array(),
        null
    );

    // JS

    wp_enqueue_script(
        'iframemanager-js',
        $custom_base_url . '/iframemanager.js',
        array(),
        null,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'enqueue_custom_assets_from_custom_folder' );

/**
 * Wczytaj cookieconsent-config.js jako modu艂 (type="module")
 */
function enqueue_cookieconsent_module_script() {
    $custom_base_url = get_site_url() . '/custom';

    wp_enqueue_script(
        'cookieconsent-config',
        $custom_base_url . '/cookieconsent-config.js',
        array(),
        null,
        true // wczytaj w footerze
    );
}
add_action( 'wp_enqueue_scripts', 'enqueue_cookieconsent_module_script' );

/**
 * Dodaj type="module" do cookieconsent-config.js
 */
function add_type_module_to_cookieconsent( $tag, $handle, $src ) {
    if ( 'cookieconsent-config' === $handle ) {
        return '<script type="module" src="' . esc_url( $src ) . '"></script>';
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'add_type_module_to_cookieconsent', 10, 3 );

function wpl_gtm_head_code_facebook(){
?>

<meta property="fb:admins" content="464369106147391"/>
<meta property="fb:app_id" content="464369106147391" />
<meta property="og:title" content="<?php echo esc_attr( get_the_title() ); ?>"/>
<meta property="og:description" content="<?php echo esc_attr( get_the_excerpt() ); ?>"/>
<meta property="og:url" content="<?php echo esc_attr( get_permalink() ); ?>"/>
<meta property="og:type" content="article"/>
<?php if ( has_post_thumbnail() ) : ?>
<meta property="og:image" content="<?php echo esc_attr( get_the_post_thumbnail_url() ); ?>"/>
<?php endif; ?>

    <!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/pl_PL/fbevents.js');
fbq('init', '464369106147391');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=464369106147391&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->

<meta name="theme-color" content="#65bec2">

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId            : '464369106147391',
      xfbml            : true,
      version          : 'v21.0'
    });
  };
</script>

<script async defer crossorigin="anonymous" src="https://connect.facebook.net/pl_PL/sdk.js#xfbml=1&version=v21.0&appId=464369106147391"></script>

<?php 
}
add_action('wp_head', 'wpl_gtm_head_code_facebook');

add_post_type_support( 'page', 'excerpt' );

/* Automatically set the image Title, Alt-Text, Caption & Description upon upload
--------------------------------------------------------------------------------------*/
add_action( 'add_attachment', 'my_set_image_meta_upon_image_upload' );
function my_set_image_meta_upon_image_upload( $post_ID ) {

	// Check if uploaded file is an image, else do nothing

	if ( wp_attachment_is_image( $post_ID ) ) {

		$my_image_title = get_post( $post_ID )->post_title;

		// Sanitize the title:  remove hyphens, underscores & extra spaces:
		$my_image_title = preg_replace( '%¥s*[-_¥s]+¥s*%', ' ',  $my_image_title );

		// Sanitize the title:  capitalize first letter of every word (other letters lower case):
		$my_image_title = ucwords( strtolower( $my_image_title ) );

		// Create an array with the image meta (Title, Caption, Description) to be updated
		// Note:  comment out the Excerpt/Caption or Content/Description lines if not needed
		$my_image_meta = array(
			'ID'		=> $post_ID,			// Specify the image (ID) to be updated
			'post_title'	=> $my_image_title,		// Set image Title to sanitized title
			'post_excerpt'	=> $my_image_title,		// Set image Caption (Excerpt) to sanitized title
			'post_content'	=> $my_image_title,		// Set image Description (Content) to sanitized title
		);

		// Set the image Alt-Text
		update_post_meta( $post_ID, '_wp_attachment_image_alt', $my_image_title );

		// Set the image meta (e.g. Title, Excerpt, Content)
		wp_update_post( $my_image_meta );

	} 
}

// Krok 1: Dodanie strony do menu administracyjnego
add_action('admin_menu', 'my_plugin_menu');

function my_plugin_menu() {

    // Dodanie strony do menu
    add_menu_page(
        'Pomoc techniczna',          // Tytuł strony
        'Pomoc techniczna',          // Tytuł w menu
        'edit_posts',                // Wymagana rola
        'pomoc-techniczna',          // Slug strony
        'my_plugin_options',         // Callback funkcji wyświetlającej
        'dashicons-info',                   // Ikona
        100                          // Pozycja w menu
    );
}

// Krok 2: Funkcja callback (możesz dostosować treść strony)
function my_plugin_options() {
    ?>
    <div class="wrap">
        <h1>Pomoc techniczna</h1>
        <p>Skontaktuj się z nami kiedy potrzebujesz fachowej i profesjonalnej pomocy ze swoją witryną internetową.</p>
    </div>
       <style>
div.container4 {
  margin-top: 20%;
  margin-left: 40%;
  align-items: center;
  justify-content: center
  text-align: center; }
  div.container5 {
  margin-top: 20px;
  margin-left: 45%;
  align-items: center;
  justify-content: center
  text-align: center; }
</style>
<div class="container4">
<h1 style="font-size: 50px;">Pomoc techniczna</h1></div>
<div class="container5"><h4><a href="mailto:biuro@pbmediaonline.pl" target="_blank" style="font-size: 20px;">biuro@pbmediaonline.pl</a></h4></div>
    <?php
}

// Disable comments from media
function filter_media_comment_status( $open, $post_id ) {
    $post = get_post( $post_id );
    if( $post->post_type == 'attachment' ) {
        return false;
    }
    return $open;
}
add_filter( 'comments_open', 'filter_media_comment_status', 10 , 2 );

add_theme_support( 'post-thumbnails' );
add_action( 'after_setup_theme', 'wpdocs_theme_setup' );
function wpdocs_theme_setup() {
    add_image_size( 'category-thumb', 300 ); // 300 pixels wide (and unlimited height)
    add_image_size( 'homepage-thumb', 220, 180, true ); // (cropped)
    add_image_size( 'sidebar-thumb', 120, 120, true ); // Hard Crop Mode
    add_image_size( 'singlepost-thumb', 590, 999 ); // Unlimited Height Mode
}

// Wyłącz REST API dla użytkowników niezalogowanych
add_filter('rest_authentication_errors', function($result) {
    if (!is_user_logged_in()) {
        return new WP_Error('rest_disabled', __('REST API is disabled for non-authenticated users.'), array('status' => 403));
    }
    return $result;
});

// Lazy loading obrazów (WordPress 5.5+ ma tę funkcję wbudowaną, ale można ją wzmocnić)
add_filter('wp_get_attachment_image_attributes', function($attr) {
    $attr['loading'] = 'lazy';
    return $attr;
});

// Wyłączenie WordPress Admin Bar dla wszystkich użytkowników poza administratorami i edytorami
function disable_admin_bar_for_non_admins() {
    if (!current_user_can('administrator') && !current_user_can('editor')) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'disable_admin_bar_for_non_admins');

add_filter(
	'admin_footer_text',
	function ( $footer_text ) {
		// Edit the line below to customize the footer text.
		$footer_text = 'Powered by <a href="https://www.pbmediaonline.pl" target="_blank" rel="noopener">PB MEDIA Studio - Strony & Sklepy internetowe</a> | spawanietrzebnica.pl: <a href="https://spawanietrzebnica.pl" target="_blank" rel="noopener">www.spawanietrzebnica.pl</a>';
		
		return $footer_text;
	}
);

function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo esc_url( get_site_url() . '/img/site-login-logo.png' ); ?>);
            height: 160px;
            width: 320px;
            background-size: 320px 160px;
            background-repeat: no-repeat;
            padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'TOLL-SPAW - Logowanie';
}
add_filter( 'login_headertext', 'my_login_logo_url_title' );

add_filter( 'enable_post_by_email_configuration', '__return_false' );

add_action('login_footer', function () {
    echo '<div style="text-align: center; margin-top: 20px;">© ' . date('Y') . ' 2025 TOLL-SPAW. All Rights Reserved. PB MEDIA Studio Strony & Sklepy Internetowe</div>';
});

add_filter('login_headertext', function () {
    return 'Witamy w panelu logowania - TOLL-SPAW';
});

// Please edit the address and name below.
// Change the From address.
add_filter( 'wp_mail_from', function ( $original_email_address ) {
    return 'kontakt@spawanietrzebnica.pl';
} );
 
// Change the From name.
add_filter( 'wp_mail_from_name', function ( $original_email_from ) {
    return 'TOLL-SPAW - Usługi spawalnicze';
} );

add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;
    
    if ($pagenow === 'edit-comments.php') {
        wp_safe_redirect(admin_url());
        exit;
    }

    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});

/*
 * This code duplicates a WordPress page. The duplicate page will appear as a draft and the user will be redirected to the edit screen.
 */
function rd_duplicate_post_as_draft(){
    global $wpdb;
    if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
        wp_die('No post to duplicate has been supplied!');
    }
    if ( !isset( $_GET['duplicate_nonce'] ) || !wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) )
        return;
    $post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
    $post = get_post( $post_id );
    $current_user = wp_get_current_user();
    $new_post_author = $current_user->ID;
    if (isset( $post ) && $post != null) {
        $args = array(
            'comment_status' => $post->comment_status,
            'ping_status'    => $post->ping_status,
            'post_author'    => $new_post_author,
            'post_content'   => $post->post_content,
            'post_excerpt'   => $post->post_excerpt,
            'post_name'      => $post->post_name,
            'post_parent'    => $post->post_parent,
            'post_password'  => $post->post_password,
            'post_status'    => 'draft',
            'post_title'     => $post->post_title,
            'post_type'      => $post->post_type,
            'to_ping'        => $post->to_ping,
            'menu_order'     => $post->menu_order
        );
        $new_post_id = wp_insert_post( $args );
        $taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
        foreach ($taxonomies as $taxonomy) {
            $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
            wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
        }
        $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
        if (count($post_meta_infos)!=0) {
            $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
            foreach ($post_meta_infos as $meta_info) {
                $meta_key = $meta_info->meta_key;
                if( $meta_key == '_wp_old_slug' ) continue;
                $meta_value = addslashes($meta_info->meta_value);
                $sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
            }
            $sql_query.= implode(" UNION ALL ", $sql_query_sel);
            $wpdb->query($sql_query);
        }
        wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
        exit;
    } else {
        wp_die('Tworzenie posta nie powiodło się, nie można znaleźć oryginalnego posta:' . $post_id);
    }
}
add_action( 'admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft' );
function rd_duplicate_post_link( $actions, $post ) {
    if (current_user_can('edit_posts')) {
        $actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=rd_duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce' ) . '" title="Duplikuj to" rel="permalink">Duplikuj</a>';
    }
    return $actions;
}
add_filter( 'post_row_actions', 'rd_duplicate_post_link', 10, 2 );
add_filter( 'page_row_actions', 'rd_duplicate_post_link', 10, 2 );

add_action('wp_footer','kody_do_footer', 20);
function kody_do_footer() {
	?>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-GP41T6TFK6"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-GP41T6TFK6');
</script>

	<?php
}

function wpl_gtm_head_code(){
?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MFZ35S97');</script>
<!-- End Google Tag Manager -->
<?php 
}
add_action('wp_head', 'wpl_gtm_head_code');

function wpl_gtm_body_code() { 
?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MFZ35S97"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php 
}

add_action( 'wp_body_open', 'wpl_gtm_body_code' );

// === Ustawienia globalne ===

// Sprawdzenie, czy aktualny użytkownik nie ma uprawnień (czyli nie jest 'admin')
function bbloomer_should_hide_updates(): bool {
    return ( is_user_logged_in() && wp_get_current_user()->user_login !== 'admin' );
}

// === Ukrywanie aktualizacji ===

add_filter( 'pre_site_transient_update_core', 'bbloomer_maybe_disable_update_core' );
add_filter( 'pre_site_transient_update_plugins', 'bbloomer_maybe_disable_update_plugins' );
add_filter( 'pre_site_transient_update_themes', 'bbloomer_maybe_disable_update_themes' );

function bbloomer_maybe_disable_update_core( $value ) {
    if ( bbloomer_should_hide_updates() ) {
        global $wp_version;
        return (object) array(
            'last_checked'    => time(),
            'version_checked' => $wp_version,
        );
    }
    return $value;
}

function bbloomer_maybe_disable_update_plugins( $value ) {
    if ( bbloomer_should_hide_updates() ) {
        return (object) array();
    }
    return $value;
}

function bbloomer_maybe_disable_update_themes( $value ) {
    if ( bbloomer_should_hide_updates() ) {
        return (object) array();
    }
    return $value;
}

// === Zmiana etykiet menu ===

add_action( 'admin_menu', 'bbloomer_modify_admin_menu_labels', 999 );
function bbloomer_modify_admin_menu_labels() {
    if ( ! bbloomer_should_hide_updates() ) {
        return;
    }

    global $menu, $submenu;

    if ( isset( $menu[65][0] ) ) {
        $menu[65][0] = 'Wtyczki (ukryte)';
    }

    if ( isset( $submenu['index.php'][10][0] ) ) {
        $submenu['index.php'][10][0] = 'Aktualizacje (ukryte)';
    }
}

// === BLOKOWANIE DOSTĘPU DO ZAWARTOŚCI STRON WP-ADMIN ===

add_action( 'admin_init', 'bbloomer_block_plugins_and_updates_pages' );
function bbloomer_block_plugins_and_updates_pages() {
    if ( ! bbloomer_should_hide_updates() ) {
        return;
    }

    $current_screen = $_SERVER['REQUEST_URI'];

    // Blokuj stronę wtyczek
    if ( strpos( $current_screen, '/plugins.php' ) !== false ) {
        bbloomer_render_blocked_message();
    }

    // Blokuj stronę aktualizacji
    if ( strpos( $current_screen, '/update-core.php' ) !== false ) {
        bbloomer_render_blocked_message();
    }
}

// Funkcja wyświetlająca komunikat o braku dostępu
function bbloomer_render_blocked_message() {
    wp_die(
        '<h1>Brak uprawnień</h1><p>Brak uprawnień aby mieć dostęp do tej podstrony.</p>',
        'Brak dostępu',
        array( 'response' => 403 )
    );
}

function block_spam_comments($commentdata) {
	$fake_textarea = trim($_POST['comment']);
	if(!empty($fake_textarea)) wp_die('Error!');
	$comment_content = trim($_POST['just_another_id']);
	$_POST['comment'] = $comment_content;	
	return $commentdata;
}
add_filter('pre_comment_on_post', 'block_spam_comments');

// Wyłącz REST API dla użytkowników niezalogowanych
add_filter('rest_authentication_errors', function($result) {
    if (!is_user_logged_in()) {
        return new WP_Error('rest_disabled', __('REST API is disabled for non-authenticated users.'), array('status' => 403));
    }
    return $result;
});

// Wyłącz emojis
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Wyłącz pingbacks i trackbacks
add_filter('xmlrpc_enabled', '__return_false');
remove_action('do_pings', 'do_all_pings', 10);

// Wyłącz funkcję autosave (jeśli nie jest potrzebna)
add_action('wp_print_scripts', function() {
    wp_deregister_script('autosave');
});

// Usuń nieużywane metadane
function clean_database() {
    global $wpdb;
    $wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key LIKE '_edit_lock'");
}
add_action('wp_scheduled_delete', 'clean_database');

// Lazy loading obrazów (WordPress 5.5+ ma tę funkcję wbudowaną, ale można ją wzmocnić)
add_filter('wp_get_attachment_image_attributes', function($attr) {
    $attr['loading'] = 'lazy';
    return $attr;
});

// Cache wyników zapytań
function cache_queries($query) {
    if ($query->is_main_query() && $query->is_home()) {
        $transient_key = 'home_query_cache';
        $cached_query = get_transient($transient_key);

        if ($cached_query) {
            $query->set('no_found_rows', true);
            $query->set('cache_results', true);
            $query->set('posts', $cached_query);
        } else {
            set_transient($transient_key, $query->posts, HOUR_IN_SECONDS);
        }
    }
}
add_action('pre_get_posts', 'cache_queries');

function mytheme_move_jquery_to_footer() {
    wp_scripts()->add_data( 'jquery', 'group', 1 );
    wp_scripts()->add_data( 'jquery-core', 'group', 1 );
    wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );
}
add_action( 'wp_enqueue_scripts', 'mytheme_move_jquery_to_footer' );

/**
 * Wyłączenie emoji w WordPress
 */
if ( ! function_exists( 'disable_emojis' ) ) {
	function disable_emojis() {
		// Usuń skrypty i style emoji z frontu i zaplecza
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );

		// Usuń z kanałów RSS, komentarzy i maili
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

		// Usuń z edytora TinyMCE
		add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	}
	add_action( 'init', 'disable_emojis' );
}

if ( ! function_exists( 'disable_emojis_tinymce' ) ) {
	/**
	 * Usunięcie pluginu emoji z edytora TinyMCE
	 */
	function disable_emojis_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		}
		return array();
	}
}


/**
 * Filter out the tinymce emoji plugin.
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

add_filter( 'enable_post_by_email_configuration', '__return_false' );

/**
 * Zezwala na przesyłanie plików SVG do biblioteki mediów.
 */

// Dodaj obsługę MIME dla SVG
add_filter( 'upload_mimes', function ( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
} );

// Poprawne sprawdzanie typu MIME SVG
add_filter(
	'wp_check_filetype_and_ext',
	function ( $wp_check_filetype_and_ext, $file, $filename, $mimes, $real_mime ) {
		// Zezwól na SVG, jeśli nie rozpoznano innego poprawnego typu
		if ( ! $wp_check_filetype_and_ext['type'] && strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) ) === 'svg' ) {
			$wp_check_filetype_and_ext['ext']             = 'svg';
			$wp_check_filetype_and_ext['type']            = 'image/svg+xml';
			$wp_check_filetype_and_ext['proper_filename'] = $filename;
		}
		return $wp_check_filetype_and_ext;
	},
	10,
	5
);

// Add custom status to post display.
function rudr_custom_status_creation(){
	register_post_status( 'featured', array(
		'label'                     => _x( 'Do publikacji', 'post' ), // I used only minimum of parameters
		'label_count'               => _n_noop( 'Do publikacji <span class="count">(%s)</span>', 'Do publikacji <span class="count">(%s)</span>'),
		'public'                    => false
	));
}
add_action( 'init', 'rudr_custom_status_creation' );

add_action('admin_footer-edit.php','rudr_status_into_inline_edit');
function rudr_status_into_inline_edit() { // ultra-simple example
	echo "<script>
	jQuery(document).ready( function() {
		jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"featured\">Do publikacji</option>' );
	});
	</script>";
}

function rudr_display_status_label( $statuses ) {
    global $post; 

    // Ensure we are working with a valid post object
    if ( ! isset( $post ) || ! is_object( $post ) ) {
        return $statuses;
    }

    // Avoid altering the status display for post listings of specific statuses
    if ( get_query_var( 'post_status', '' ) !== 'featured' ) {
        // Check if the current post has the custom status 'featured'
        if ( $post->post_status === 'featured' ) {
            // Append the custom status label
            $statuses[] = __( 'Do publikacji', 'the7mk2' );
        }
    }

    return $statuses; // Return the updated array of statuses
}
add_filter( 'display_post_states', 'rudr_display_status_label' );

/**
 * Dodaj obsługę plików SVG do przesyłania
 */
function allow_svg_uploads( $mime_types ) {
    $mime_types['svg'] = 'image/svg+xml';
    return $mime_types;
}
add_filter( 'upload_mimes', 'allow_svg_uploads' );

/**
 * Zabezpieczenie przed błędem „niebezpieczny plik” w nowszych wersjach WP
 */
function fix_svg_display() {
    echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
            width: 100% !important;
            height: auto !important;
        }
    </style>';
}
add_action( 'admin_head', 'fix_svg_display' );

function allow_svg_uploads_admin_only( $mime_types ) {
    if ( current_user_can( 'administrator' ) ) {
        $mime_types['svg'] = 'image/svg+xml';
    }
    return $mime_types;
}
add_filter( 'upload_mimes', 'allow_svg_uploads_admin_only' );

add_filter( 'aioseo_title', 'aioseo_filter_title' );
function aioseo_filter_title( $title ) {
   if ( strlen($title) > 60 ) {
      $title = substr($title, 0, 60);
   }
   return $title;
}

add_filter( 'aioseo_keywords', 'aioseo_filter_keywords' );

function aioseo_filter_keywords( $keywords ) {
   if ( is_singular() ) {
      $keywords = explode( ',', $keywords );
      array_push( $keywords, 'anotherkeyword' );
      $keywords = implode( ',', $keywords );
   }
   return $keywords ;
}

add_filter( 'aioseo_schema_output', 'add_author_name_when_missing' );
function add_author_name_when_missing( $schema ) {	
	if ( is_single() && 'post' == get_post_type() ) {
		global $post;
		$author_id = $post->post_author;
		$author_name = get_the_author_meta( 'display_name', $author_id );

		foreach ( $schema as &$schemaItem ) {
			if ( isset($schemaItem['@type']) && 'Article' === $schemaItem['@type'] ) {
				if(!isset($schemaItem['author']['name']) || !isset($schemaItem['author']['@type'])){
					$schemaItem['author']['@type'] = 'Person';
					$schemaItem['author']['name'] = $author_name;
				}
			}
		}
	}
	return $schema;
}

function wpcode_snippet_oembed_defaults( $sizes ) {
	return array(
		'width'  => 400,
		'height' => 280,
	);
}

add_filter( 'embed_defaults', 'wpcode_snippet_oembed_defaults' );

/**
 * Run shortcodes on HTML field content
 *
 * @link   https://wpforms.com/developers/how-to-display-shortcodes-inside-the-html-field/
 * 
 * For support, please visit: https://www.facebook.com/groups/wpformsvip
 */

function wpf_dev_html_field_shortcodes( $field, $field_atts, $form_data ) {
 
    if ( ! empty( $field[ 'code' ] ) ) {
        $field[ 'code' ] = do_shortcode( $field[ 'code' ] );
    }
 
    return $field;
}
add_filter( 'wpforms_html_field_display', 'wpf_dev_html_field_shortcodes', 10, 3 );

add_filter( 'aioseo_canonical_url', 'aioseo_filter_canonical_url' );
function aioseo_filter_canonical_url( $url ) {
	if (strpos($_SERVER['REQUEST_URI'],'/home-search/listing/') !== false) {
		$url = home_url( $_SERVER['REQUEST_URI'] );
		if (strpos($url,'?') !== false){
				$url = substr( $url, 0, strpos($url,'?') );
		}
	}
	return $url;
}

add_filter( 'aioseo_local_business_output_business_info_location_data', 'aioseo_change_local_business_output_business_info_location_data', 10, 3 );

function aioseo_change_local_business_output_business_info_location_data( $locationData, $instance, $postId ) {
	$locationData->name .= ' LLC';

	return $locationData;
}

/**
 * Prevent publishing posts under a minimum number of words.
 *
 * @param int     $post_id The id of the post.
 * @param WP_Post $post The post object.
 *
 * @return void
 */
function wpcode_snippet_publish_min_words( $post_id, $post ) {
	// Edit the line below to set the desired minimum number of words.
	$word_count = 100;

	if ( str_word_count( $post->post_content ) < $word_count ) {
		wp_die(
			sprintf(
				// Translators: placeholder adds the minimum number of words.
				esc_html__( 'The post content is below the minimum word count. Your post needs to have at least %d words to be published.' ),
				absint( $word_count )
			)
		);
	}
}

add_action( 'publish_post', 'wpcode_snippet_publish_min_words', 9, 2 );

/* 
Increase WordPress upload size, post size, and max execution time 

Original doc link: https://wpforms.com/how-to-change-max-file-upload-size-in-wordpress/

For support, please visit: https://www.facebook.com/groups/wpformsvip
*/

@ini_set( 'upload_max_size' , '256M' );
@ini_set( 'post_max_size', '256M');
@ini_set( 'max_execution_time', '300' );

add_filter( 'manage_posts_columns', function ( $columns ) {
	$columns['last_modified'] = __( 'Ostatnia modyfikacja' );
	return $columns;
} );

add_action( 'manage_posts_custom_column', function ( $column, $post_id ) {
	if ( 'last_modified' === $column ) {
		$modified_time = get_the_modified_time( 'Y/m/d g:i:s a', $post_id );
		echo esc_html( $modified_time );
	}
}, 10, 2 );

$u_time          = get_the_time( 'U' );
$u_modified_time = get_the_modified_time( 'U' );
// Only display modified date if 24hrs have passed since the post was published.
if ( $u_modified_time >= $u_time + 86400 ) {

	$updated_date = get_the_modified_time( 'F jS, Y' );
	$updated_time = get_the_modified_time( 'h:i a' );

	$updated = '<p class="last-updated">';

	$updated .= sprintf(
	// Translators: Placeholders get replaced with the date and time when the post was modified.
		esc_html__( 'Ostatnia aktualizacja była %1$s między %2$s' ),
		$updated_date,
		$updated_time
	);
	$updated .= '</p>';

	echo wp_kses_post( $updated );
}

/**
 * Wrap the thumbnail in a link to the post.
 * Only use this if your theme doesn't already wrap thumbnails in a link.
 *
 * @param string $html The thumbnail HTML to wrap in an anchor.
 * @param int    $post_id The post ID.
 * @param int    $post_image_id The image id.
 *
 * @return string
 */
function wpcode_snippet_autolink_featured_images( $html, $post_id, $post_image_id ) {
	$html = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . $html . '</a>';

	return $html;
}

add_filter( 'post_thumbnail_html', 'wpcode_snippet_autolink_featured_images', 20, 3 );

add_action( 'wp_before_admin_bar_render', function () {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'wp-logo' );
}, 0 );

add_filter( 'manage_posts_columns', function ( $columns ) {
	// You can change this to any other position by changing 'title' to the name of the column you want to put it after.
	$move_after     = 'title';
	$move_after_key = array_search( $move_after, array_keys( $columns ), true );

	$first_columns = array_slice( $columns, 0, $move_after_key + 1 );
	$last_columns  = array_slice( $columns, $move_after_key + 1 );

	return array_merge(
		$first_columns,
		array(
			'featured_image' => __( 'Obrazek wyróżniający' ),
		),
		$last_columns
	);
} );

add_action( 'manage_posts_custom_column', function ( $column ) {
	if ( 'featured_image' === $column ) {
		the_post_thumbnail( array( 300, 80 ) );
	}
} );

function wpcode_snippets_change_read_more( $read_more, $read_more_text ) {

	// Edit the line below to add your own "Read More" text.
	$custom_text = 'Czytaj więcej';

	$read_more = str_replace( $read_more_text, $custom_text, $read_more );

	return $read_more;
}

add_filter( 'the_content_more_link', 'wpcode_snippets_change_read_more', 15, 2 );

add_filter( 'sanitize_file_name', 'mb_strtolower' );

add_filter( 'admin_title', function ( $admin_title, $title ) {
	return str_replace( " — WordPress", '', $admin_title );
}, 10, 2 );

add_action( 'template_redirect', function() {
	if (is_404()) {
    	wp_safe_redirect(home_url());
	    exit();
	}
} );

add_filter( 'manage_upload_columns', function ( $columns ) {
	$columns ['file_size'] = esc_html__( 'Rozmiar pliku' );

	return $columns;
} );

add_action( 'manage_media_custom_column', function ( $column_name, $media_item ) {
	if ( 'file_size' !== $column_name || ! wp_attachment_is_image( $media_item ) ) {
		return;
	}
	$filesize = size_format( filesize( get_attached_file( $media_item ) ), 2 );
	echo esc_html( $filesize );

}, 10, 2 );

add_filter( 'the_title', function ( $title, $id ) {
	if ( ! is_admin() && is_single( $id ) ) {
		$number_of_days = 7;
		$post_date      = get_the_date( 'U', $id );
		$current_date   = current_time( 'timestamp' );
		$date_diff      = $current_date - $post_date;

		if ( $date_diff < $number_of_days * DAY_IN_SECONDS ) {
			$title .= ' <span class="new-badge">Nowy artykuł</span>';
		}
	}

	return $title;
}, 10, 2 );

add_action( 'wp_head', function () {
	echo '
        <style>
            .new-badge {
                background-color: #ff0000; 
                color: #ffffff; 
                padding: 2px 5px; 
                font-size: 12px; 
                border-radius: 3px;
                margin-left: 5px;
            }
        </style>
    ';
} );

add_action('wp_body_open', function() {
    echo '<div id="wpcode-progress-bar"></div>';
});

add_action('wp_head', function() {
    echo '<style>
        #wpcode-progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 4px;
            background-color: var(--wp--preset--color--primary, #007bff); /* Change the color as needed */
            z-index: 99;
        }
		@media( min-width: 769px ) {
		.admin-bar #wpcode-progress-bar {
			top: 32px;
		}
		}
    </style>';
});

add_action('wp_footer', function() {
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            document.addEventListener("scroll", function() {
                var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
                var scrollHeight = document.documentElement.scrollHeight || document.body.scrollHeight;
                var clientHeight = document.documentElement.clientHeight || document.body.clientHeight;
                var scrolled = (scrollTop / (scrollHeight - clientHeight)) * 100;

                document.getElementById("wpcode-progress-bar").style.width = scrolled + "%";
            });
        });
    </script>';
});

add_action( 'admin_init', function () {
// Get all public post types
	$post_types = get_post_types( array(), 'names' );

	function wpcode_add_post_id_column( $columns ) {
		$columns['wpcode_post_id'] = 'ID numer'; // 'ID' is the column title

		return $columns;
	}

	function wpcode_show_post_id_column_data( $column, $post_id ) {
		if ( 'wpcode_post_id' === $column ) {
			echo '<code>' . absint( $post_id ) . '</code>';
		}
	}

	foreach ( $post_types as $post_type ) {
		// Add new column to the posts list
		add_filter( "manage_{$post_type}_posts_columns", 'wpcode_add_post_id_column' );

		// Fill the new column with the post ID
		add_action( "manage_{$post_type}_posts_custom_column", 'wpcode_show_post_id_column_data', 10, 2 );
	}
} );

remove_filter( 'comment_text', 'make_clickable', 9 );

add_action(
	'enqueue_block_editor_assets',
	function () {
		$script = "jQuery( window ).load(function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } });";
		wp_add_inline_script( 'wp-blocks', $script );
	}
);

global $post;

if ( ! empty( $post ) ) {
	$categories = get_the_category( $post->ID );

	if ( $categories ) {
		$category_ids = array();
		foreach ( $categories as $category ) {
			$category_ids[] = $category->term_id;
		}

		$query_args = array(
			'category__in'   => $category_ids,
			'post__not_in'   => array( $post->ID ),
			'posts_per_page' => 5
		);

		$related_posts = new WP_Query( $query_args );

		if ( $related_posts->have_posts() ) {
			echo '<div class="related-posts">';
			echo '<h3>Powiązane artykuły</h3><ul>';
			while ( $related_posts->have_posts() ) : $related_posts->the_post();
				echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
			endwhile;
			echo '</ul>';
			echo '</div>';

			wp_reset_postdata();
		}
	}
}

add_filter('wp_is_application_passwords_available', '__return_false');

