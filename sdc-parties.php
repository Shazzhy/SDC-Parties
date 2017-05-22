<?php
/*Plugin Name: SDC - Gestion des parties
 * Version: 0.1
 * Plugin URI: http://www.shazzware.net/WP
 * Description: Systeme de gestion des pqrties pour les Saigneurs du Chaos
 * Author: Shazz@shazzware.net
 * Author URI: http://www.shazzware.net/WP
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: Saigneurs du Chaos
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author  Ludovic Dandois
 * @since 1.0.0
 */


// 1. Custom Post Type Registration (Events)

add_action( 'init', 'cpt_sdc_partie' );

function cpt_sdc_partie() {

$labels = array(
    'name' => _x('Parties', 'post type general name'),
    'singular_name' => _x('Partie', 'post type singular name'),
    'add_new' => _x('Créer partie', 'Parties'),
    'add_new_item' => __('Créer partie'),
    'edit_item' => __('Modifier partie'),
    'new_item' => __('Nouvelle partie'),
    'view_item' => __('Voir partie'),
    'search_items' => __('Chercher partie'),
    'not_found' =>  __('Pas de partie trouvée'),
    'not_found_in_trash' => __('Pas de partie trouvée dans la corbeille'),
    'parent_item_colon' => '',
);

$args = array(
    'label' => __('Parties'),
    'labels' => $labels,
    'public' => true,
    'can_export' => true,
    'show_ui' => true,
    '_builtin' => false,
    '_edit_link' => 'post.php?post=%d', // ?
    'capability_type' => 'post',
    'menu_icon' => get_bloginfo('template_url').'/images/event_16.png',
    'hierarchical' => false,
    'rewrite' => array( "slug" => "parties" ),
    'supports'=> array('title', 'thumbnail', 'excerpt', 'editor') ,
    'show_in_nav_menus' => true,
    'has_archive' => true,
    'taxonomies' => array( 'tax_categories_parties', 'post_tag')
);

register_post_type( 'parties', $args);

}





// 2. Custom Taxonomy Registration (Event Types)

function create_taxonomy_partie() {

    $labels = array(
        'name' => _x( 'Categories de parties', 'taxonomy general name' ),
        'singular_name' => _x( 'Category', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Categories' ),
        'popular_items' => __( 'Popular Categories' ),
        'all_items' => __( 'All Categories' ),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Edit Category' ),
        'update_item' => __( 'Update Category' ),
        'add_new_item' => __( 'Add New Category' ),
        'new_item_name' => __( 'New Category Name' ),
        'separate_items_with_commas' => __( 'Separate categories with commas' ),
        'add_or_remove_items' => __( 'Add or remove categories' ),
        'choose_from_most_used' => __( 'Choose from the most used categories' ),
    );

    register_taxonomy('tax_categories_parties','parties', array(
        'label' => __('Catégories de partie'),
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'categorie-partie' ),
    ));




        
        $Categories = array (
            '0' => array ('name'=>'Pathfinder'),
            '1' => array ('name'=>'Ars Magica'),
            '2' => array ('name'=>'Cthulu'),
            '3' => array ('name'=>'GURPS'),
            '4' => array ('name'=>'Vampire'),
            '5' => array ('name'=>'Warhammer'),
            '6' => array ('name'=>'Arsène Lupin'),
            '7' => array ('name'=>'Dongons & Dragons 3.5'),
            '8' => array ('name'=>'Fallout'),
            '9' => array ('name'=>'The Edler Scrolls'),
            '10' => array ('name'=>'Game of Thrones'),
            '11' => array ('name'=>'Héroïques'),
            '12' => array ('name'=>'Nephilim'),
            '13' => array ('name'=>'Le roi des gobelins'),
            '14' => array ('name'=>'Antika'),
            '15' => array ('name'=>'Advanced Dongeons & Dragons'),
            '16' => array ('name'=>'Barbarians of Lemuria'),
            '17' => array ('name'=>'Blacksad'),
            '18' => array ('name'=>'Dongons et Dragons 5ème édition'),
            '19' => array ('name'=>'Dongons et Dragons 4ème édition'),
            '20' => array ('name'=>'Degenesis Rebirth'),
            '21' => array ('name'=>'Dungeon World'),
            '22' => array ('name'=>'Hawkmoon'),
            '23' => array ('name'=>'Iron Kingdoms'),
            '24' => array ('name'=>'Jaune Radiation'),
            '25' => array ('name'=>'Khaos 1795'),
            '26' => array ('name'=>'Lady Blackbird'),
            '27' => array ('name'=>'Les larmes du cardinal'),
            '28' => array ('name'=>'Miles Christi'),
            '29' => array ('name'=>'MonsterHearts'),
            '30' => array ('name'=>'Le dongon de Naheulbeuk'),
            '31' => array ('name'=>'Naruto'),
            '32' => array ('name'=>'Les Ombres desteren'),
            '33' => array ('name'=>'Postapokémon'),
            '34' => array ('name'=>'Rushmore'),
            '35' => array ('name'=>'Shadow of the Demon Lord'),
            '36' => array ('name'=>'Shadowrun'),
            '37' => array ('name'=>'Te deum pour un massacre'),
            '38' => array ('name'=>'Terra Incognita'),
            '39' => array ('name'=>'Vietnam'),
            '40' => array ('name'=>'Yggdrasil')


        );  

        foreach ($Categories as $Categorie) {

            if( !term_exists( 'tax_categories_parties', $Categorie['name']) ) {
                wp_insert_term(
                    $Categorie['name'],
                    'tax_categories_parties'
                );
            unset( $Categorie ); 
        } 
    }

}

add_action( 'init', 'create_taxonomy_partie', 0 );

//Ajouter les catégories



// 3. Show Columns

add_filter ("manage_edit-parties_columns", "parties_edit_columns");
add_action ("manage_posts_custom_column", "parties_custom_columns");

function parties_edit_columns($columns) {

    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "tf_col_ev_cat" => "Catégorie",
        "tf_col_ev_date" => "Date",
        "tf_col_ev_times" => "Heure",
        "tf_col_ev_thumb" => "Image",
        "title" => "Partie",
        "tf_col_ev_desc" => "Description",
        );

    return $columns;

}

function parties_custom_columns($column) {

    global $post;
    $custom = get_post_custom();
    $date_format = get_option('date_format'); 
    switch ($column)

        {
            case "tf_col_ev_cat":
                // - show taxonomy terms -
                $eventcats = get_the_terms($post->ID, "tax_categories_parties");
                $eventcats_html = array();
                if ($eventcats) {
                    foreach ($eventcats as $eventcat)
                    array_push($eventcats_html, $eventcat->name);
                    echo implode($eventcats_html, ", ");
                } else {
                _e('None', 'themeforce');;
                }
            break;
            case "tf_col_ev_date":
                // - show dates -
                $startd = $custom["parties_startdate"][0];
               $endd = $custom["parties_enddate"][0];
                $startdate = date($date_format, $startd);
               $enddate = date($date_format, $endd);
                echo $startdate . '<br /><em>' . $enddate . '</em>';
            break;
            case "tf_col_ev_times":
                // - show times -
                $startt = $custom["parties_startdate"][0];
               // $endt = $custom["parties_enddate"][0];
                $time_format = get_option('time_format');
                $starttime = date($time_format, $startt);
               // $endtime = date($time_format, $endt);
                echo $starttime ;//. ' - ' .$endtime;
            break;
            case "tf_col_ev_thumb":
                // - show thumb -
                $post_image_id = get_post_thumbnail_id(get_the_ID());
                if ($post_image_id) {
                    $thumbnail = wp_get_attachment_image_src( $post_image_id, 'post-thumbnail', false);
                    if ($thumbnail) (string)$thumbnail = $thumbnail[0];
                    echo '<img src="';
                    echo bloginfo('template_url');
                    echo '/timthumb/timthumb.php?src=';
                    echo $thumbnail;
                    echo '&h=60&w=60&zc=1" alt="" />';
                }
            break;
            case "tf_col_ev_desc";
                the_excerpt();
            break;

        }
}

// 4. Show Meta-Box

add_action( 'admin_init', 'parties_create' );

function parties_create() {
    add_meta_box('parties_meta', 'Parties', 'parties_meta', 'parties');
}

function parties_meta () {

    // - grab data -

    global $post;
    $custom = get_post_custom($post->ID);
    $meta_sd = $custom["parties_startdate"][0];
    $meta_ed = $custom["parties_enddate"][0];
   // $meta_st = $meta_sd;
   // $meta_et = $meta_ed;

    // - grab wp time format -

    $date_format = get_option('date_format'); // Not required in my code
  //  $time_format = get_option('time_format');

    // - populate today if empty, 00:00 for time -

    if ($meta_sd == null) { $meta_sd = date(); $meta_ed = $meta_sd;} //$meta_st = 0; $meta_et = 0;

    // - convert to pretty formats -

    $clean_sd = date($date_format, $meta_sd);
   $clean_ed = date($date_format, $meta_ed);
  //  $clean_st = date($time_format, $meta_st);
  //  $clean_et = date($time_format, $meta_et);

    // - security -

    echo '<input type="hidden" name="parties-nonce" id="parties-nonce" value="' .
    wp_create_nonce( 'parties-nonce' ) . '" />';

    // - output -

    ?>
    <div class="tf-meta">
        <ul>
            <li><label>Start Date</label><input name="parties_startdate" class="tfdate" value="<?php echo $clean_sd; ?>" /></li>
           <!-- <li><label>Start Time</label><input name="parties_starttime" value="<?php echo $clean_st; ?>" /><em>Use 24h format (7pm = 19:00)</em></li>
            -->
            <li><label>End Date</label><input name="parties_enddate" class="tfdate" value="<?php echo $clean_ed; ?>" /></li>
           <!-- <li><label>End Time</label><input name="parties_endtime" value="<?php echo $clean_et; ?>" /><em>Use 24h format (7pm = 19:00)</em></li>
           -->
            
        </ul>
    </div>
    <?php
}

// 5. Save Data

add_action ('save_post', 'save_parties');

function save_parties(){

    global $post;

    // - still require nonce

    if ( !wp_verify_nonce( $_POST['parties-nonce'], 'parties-nonce' )) {
        return $post->ID;
    }

    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;

    // - convert back to unix & update post

    if(!isset($_POST["parties_startdate"])):
        return $post;
        endif;
        $updatestartd = strtotime ( $_POST["parties_startdate"] );//. $_POST["parties_starttime"] 
        update_post_meta($post->ID, "parties_startdate", $updatestartd );

    if(!isset($_POST["parties_enddate"])):
       return $post;
        endif;
        $updateendd = strtotime ( $_POST["parties_enddate"]);// . $_POST["parties_endtime"]);
       update_post_meta($post->ID, "parties_enddate", $updateendd );

}

// 6. Customize Update Messages

add_filter('post_updated_messages', 'events_updated_messages');

function events_updated_messages( $messages ) {

  global $post, $post_ID;

  $messages['parties'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Partie mise à jour. <a href="%s">View item</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Partie mise à jour.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Event restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Partie publiée. <a href="%s">View event</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Partie sauvée.'),
    8 => sprintf( __('Event submitted. <a target="_blank" href="%s">Preview event</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Event scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview event</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Event draft updated. <a target="_blank" href="%s">Preview event</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

// 7. JS Datepicker UI

function events_styles() {
    global $post_type;
    if( 'parties' != $post_type )
        return;
    wp_enqueue_style('ui-datepicker', get_bloginfo('template_url') . '/css/jquery-ui-1.8.9.custom.css');
}

function events_scripts() {
    global $post_type;
    if( 'parties' != $post_type )
    return;
    wp_enqueue_script('jquery-ui', get_bloginfo('template_url') . '/js/jquery-ui-1.8.9.custom.min.js', array('jquery'));
    wp_enqueue_script('ui-datepicker', get_bloginfo('template_url') . '/js/jquery.ui.datepicker.min.js');
    wp_enqueue_script('custom_script', get_bloginfo('template_url').'/js/pubforce-admin.js', array('jquery'));
}

add_action( 'admin_print_styles-post.php', 'events_styles', 1000 );
add_action( 'admin_print_styles-post-new.php', 'events_styles', 1000 );

add_action( 'admin_print_scripts-post.php', 'events_scripts', 1000 );
add_action( 'admin_print_scripts-post-new.php', 'events_scripts', 1000 );


define('PLUGIN_URL', plugin_dir_url( __FILE__ ));

function load_datetimepicker_js(){

wp_enqueue_style( 'datepickerstyle', PLUGIN_URL. '/public/js/jquery.datetimepicker.min.css' );
wp_enqueue_script('datetimepicker', PLUGIN_URL. '/public/js/jquery.datetimepicker.full.min.js', array('jquery'));


}
add_action('wp_head', 'load_datetimepicker_js');

function load_userpicker_js(){

wp_enqueue_style( 'userpickerstyle', PLUGIN_URL. '/public/js/userpicker.css' );
wp_enqueue_script('userpicker', PLUGIN_URL. '/public/js/userpicker.js', array('jquery'));


}
add_action('wp_head', 'load_userpicker_js');

function load_full_calendar_js() {
 
wp_enqueue_style( 'fullcalstyles', PLUGIN_URL. '/public/js/fullcalendar/fullcalendar.css' );
wp_enqueue_script('jquery', PLUGIN_URL. '/public/js/fullcalendar/lib/jquery.min.js', array('jquery'));
wp_enqueue_script('moment', PLUGIN_URL. '/public/js/fullcalendar/lib/moment.min.js', array('jquery'));
wp_enqueue_script('fullcalendar', PLUGIN_URL. '/public/js/fullcalendar/fullcalendar.js', array('jquery'));
wp_enqueue_script('fullcalendarfrench', PLUGIN_URL. '/public/js/fullcalendar/locale/fr.js', array('jquery'));
wp_enqueue_script('calendar-header' ,  PLUGIN_URL. '/public/js/head_insert_calendar.js',  array('jquery' ));   

// - set path to json feed -
$json_public_calendar = PLUGIN_URL. 'includes/json_public_calendar.php';
 
// - tell JS to use this variable instead of a static value -
wp_localize_script( 'fullcalendar', 'load_full_calendar_js', array('events' => $json_public_calendar));

 }
add_action('wp_head', 'load_full_calendar_js');


//Add ShortCode to Create Game file

function display_create_game_page(){

          ob_start();
          //include the specified file
          include(dirname( __FILE__ ) . '/public/create_game.php');
          //assign the file output to $content variable and clean buffer
          $content = ob_get_clean();
          //return the $content
          //return is important for the output to appear at the correct position
          //in the content
          return $content;


}
//register the Shortcode handler
add_shortcode('create_game', 'display_create_game_page');

//Add ShortCode to display public calendar

function display_public_calendar(){

          ob_start();
          //include the specified file
          include(dirname( __FILE__ ) . '/public/public_calendar.php');
          //assign the file output to $content variable and clean buffer
          $content = ob_get_clean();
          //return the $content
          //return is important for the output to appear at the correct position
          //in the content
          return $content;


}
//register the Shortcode handler
add_shortcode('public_calendar', 'display_public_calendar');


function parties_archive_template( $archive_template ) {
     global $post;
     if ( $post->post_type ==  ( 'parties' ) ) {
          $archive_template = dirname( __FILE__ ) . '/public/archive-parties.php';
     }
     return $archive_template;
}
add_filter( 'archive_template', 'parties_archive_template' ) ;

function parties_single_template( $single_template ) {
     global $post;
     if ( $post->post_type ==  ( 'parties' ) ) {
          $single_template = dirname( __FILE__ ) . '/public/single-parties.php';
     }
     return $single_template;
}
add_filter( 'single_template', 'parties_single_template' ) ;
?>

