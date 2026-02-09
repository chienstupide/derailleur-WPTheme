<?php


require 'vendor/autoload.php';
// use Timber\Timber;

// Timber::init();

// wp_nav_menu( [
//     'menu' => 'primary',
// ] );



function montheme_supports(){

    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('menus');
    register_nav_menus( [
        'primary' => __( 'Primary Menu', 'montheme' ),
        'footer'  => __( 'Footer Menu', 'montheme' ),
    ] );
}

// dd(get_template_directory_uri());


    // <script src="lib/jquery/jquery.min.js"></script>
    // <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    // <script src="lib/easing/easing.min.js"></script>
    // <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    // <script src="lib/counterup/jquery.counterup.js"></script>

//   <!-- Bootstrap CSS File -->
//   <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
//       <!-- Libraries CSS Files -->
//   <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
//   <link href="lib/animate/animate.min.css" rel="stylesheet">
//   <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
//   <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
//   <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

function montheme_register_assets(){

    // CSS FILES
    wp_register_style('montheme', get_stylesheet_uri());
    wp_register_style('bootstrap-css', get_template_directory_uri(). '/lib/bootstrap/css/bootstrap.min.css');
    wp_register_style('font-awesome', get_template_directory_uri(). '/lib/font-awesome/css/font-awesome.min.css');
    wp_register_style('animate', get_template_directory_uri(). '/lib/animate/animate.min.css');
    wp_register_style('ionicons', get_template_directory_uri(). '/lib/ionicons/css/ionicons.min.css');
    wp_register_style('owlcarousel', get_template_directory_uri(). '/lib/owlcarousel/assets/owl.carousel.min.css');
    wp_register_style('lightbox', get_template_directory_uri(). '/lib/lightbox/css/lightbox.min.css');


    // SCRIPT FILES
    wp_register_script('main',get_template_directory_uri() . '/js/main.js');
    wp_register_script('jquery-min',get_template_directory_uri() . '/lib/jquery/jquery.min.js');
    wp_register_script('bootstrap',get_template_directory_uri() . '/lib/bootstrap/js/bootstrap.min.js');
    wp_register_script('easing',get_template_directory_uri() . '/lib/easing/easing.min.js');
    wp_register_script('owlcarousel',get_template_directory_uri() . '/lib/owlcarousel/owl.carousel.min.js');
    wp_register_script('counterup',get_template_directory_uri() . '/lib/counterup/jquery.counterup.js');
       


    
    wp_enqueue_style('bootstrap-css');
    wp_enqueue_style('font-awesome');
    wp_enqueue_style('animate');
    wp_enqueue_style('ionicons');
    wp_enqueue_style('owlcarousel');
    wp_enqueue_style('lightbox');
    wp_enqueue_style('montheme');
    // wp_enqueue_script('bootstrap');
    
    wp_enqueue_script('jquery-min','', [], false, true);
    wp_enqueue_script('bootstrap','', [], false, true);
    wp_enqueue_script('easing','', [], false, true);
    wp_enqueue_script('owlcarousel','', [], false, true);
    wp_enqueue_script('counterup','', [], false, true);
    wp_enqueue_script('main','', [], false, true);
}

function montheme_metaboxes(){
    add_meta_box(
        'montheme_agenda_type',           // Unique ID
        'Agenda',      // Box title
        'montheme_agenda_type_html',  // Content callback, must be of type callable
        'post' ,
        'side'                          // Post type
    );
    add_meta_box(
        'montheme_agenda_date',           // Unique ID
        'Agenda',      // Box title
        'montheme_agenda_date_html',  // Content callback, must be of type callable
        'post' ,
        'side'                          // Post type
    );
    add_meta_box(
        'montheme_agenda_lieu',           // Unique ID
        'Agenda',      // Box title
        'montheme_agenda_lieu_html',  // Content callback, must be of type callable
        'post' ,
        'side'                          // Post type
    );
}

function montheme_agenda_type_html($post){
    $value = get_post_meta($post->ID, '_montheme_agenda_type_key', true);
    wp_nonce_field( 'montheme_agenda_type_nonce', 'montheme_agenda_type_nonce' );
    ?>
    <label for="montheme_agenda_type_field">Type d'événement :</label>
    <select name="montheme_agenda_type_field" id="montheme_agenda_type_field" class="postbox">
        <option value="evenement" <?php selected( $value, 'evenement' ); ?>>Événement</option>
        <option value="balade" <?php selected( $value, 'balade' ); ?>>Balade</option>
        <option value="atelier" <?php selected( $value, 'atelier' ); ?>>Atelier</option>
    </select>
    <?php
}
function montheme_agenda_date_html($post){
    $value = get_post_meta($post->ID, '_montheme_agenda_date_key', true);
     wp_nonce_field( 'montheme_agenda_date_nonce', 'montheme_agenda_date_nonce' );
    ?>
    <label for="montheme_agenda_date_field">Date :</label>
    <input name="montheme_agenda_date_field" type="text" value="<?php echo $value; ?>"></input>
   
    <?php
}
function montheme_agenda_lieu_html($post){
    $value = get_post_meta($post->ID, '_montheme_agenda_lieu_key', true);
     wp_nonce_field( 'montheme_agenda_lieu_nonce', 'montheme_agenda_lieu_nonce' );
    ?>
    <label for="montheme_agenda_lieu_field">Lieu :</label>
    <input name="montheme_agenda_lieu_field" type="text" value="<?php echo $value; ?>"></input>
   
    <?php
}



function montheme_agenda_save($post_id){
    if (array_key_exists('montheme_agenda_type_field', $_POST)
        && wp_verify_nonce( $_POST['montheme_agenda_type_nonce'], 'montheme_agenda_type_nonce' )) {
        update_post_meta(
            $post_id,
            '_montheme_agenda_type_key',
            $_POST['montheme_agenda_type_field']
        );
    }
    if (array_key_exists('montheme_agenda_date_field', $_POST)
        && wp_verify_nonce( $_POST['montheme_agenda_date_nonce'], 'montheme_agenda_date_nonce' )
        ) {
        update_post_meta(
            $post_id,
            '_montheme_agenda_date_key',
            $_POST['montheme_agenda_date_field']
        );
    }
    if (array_key_exists('montheme_agenda_lieu_field', $_POST)
        && wp_verify_nonce( $_POST['montheme_agenda_lieu_nonce'], 'montheme_agenda_lieu_nonce' )
        ) {
        update_post_meta(
            $post_id,
            '_montheme_agenda_lieu_key',
            $_POST['montheme_agenda_lieu_field']
        );
    }

}
// add_action ('after_setup_theme', function() {
//     add_theme_support('post-thumbnails');
//     // add_theme_support('title-tag');
// });
add_action('wp_head', function() {
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Raleway:wght@400;500;600;700;800;900&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"> 
    <?php
});
add_action ('after_setup_theme', 'montheme_supports');
add_action( 'wp_enqueue_scripts', 'montheme_register_assets' );

add_action('add_meta_boxes','montheme_metaboxes');

add_action('save_post', 'montheme_agenda_save');

// dump($_POST);



// ADMIN CONFIGURATION
function my_custom_section_callback(){
	// echo 'Champs personnalisés pour les informations de contact';
}

//callback to print a simple input field
function my_custom_field_callback(){
	echo '<fieldset><legend class="screen-reader-text"><span>Information de contact</span></legend>
            <br>
            <label>Téléphone : <input name="derailleur_contact_phone" value="'. get_option('derailleur_contact_phone') .'" /></label>
            <br>
            <label>Adresse : <input name="derailleur_contact_address" value="'. get_option('derailleur_contact_address') .'" /></label>
            <br>
            <label>Email : <input name="derailleur_contact_email" value="'. get_option('derailleur_contact_email') .'" /></label>
            </fieldset>';

    }



function add_my_custom_section_to_settings(){

    //register setting to save the data
	register_setting( 'general', 'derailleur_contact_phone' );
	register_setting( 'general', 'derailleur_contact_address' );
	register_setting( 'general', 'derailleur_contact_email' );

	//add the section to general page in admin panel
	add_settings_section(
		'derailleur_contact_section', //id of the section
		'',
		'my_custom_section_callback',
		'general',
		// array(
		// 	'before_section' => 'Text Before the Section', //html for before the section
		// 	'after_section' => 'Text After the Section', //html for after the section
		// )
	);

	//add a sample field to this section.
	add_settings_field(
		'derailleur_contact_phone',
		'Information de contact',
		'my_custom_field_callback',
		'general',
		//put the id of custom section here:
		'derailleur_contact_section'
	);

}
add_action('admin_init', 'add_my_custom_section_to_settings');