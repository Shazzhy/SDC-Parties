<?php
/*Plugin Name: SDC - Gestion des parties
 * Version: 0.5
 * Plugin URI: http://www.shazzware.net/WP
 * Description: Systeme de gestion des parties pour les Saigneurs du Chaos
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


/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Plugin Boilerplate
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Your Name or Your Company
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin-name
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
require plugin_dir_path( __FILE__ ) . 'public/partials/SDC-parties-public.php';
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/SDC-Parties-activator.php
 */
function activate_SDC_parties() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/SDC-Parties-activator.php';
	SDC_Parties_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name-deactivator.php';
	Plugin_Name_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_SDC_parties' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name() {

	$plugin = new Plugin_Name();
	$plugin->run();

}
run_plugin_name();


define('PLUGIN_URL', plugin_dir_url( __FILE__ ));
// 1. Custom Post Type

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

// 2. Custom Taxonomy

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
		'0' => array ('name'=>"Pathfinder"),
		'1' => array ('name'=>"Ars Magica"),
		'2' => array ('name'=>"Cthulu"),
		'3' => array ('name'=>"GURPS"),
		'4' => array ('name'=>"Vampire"),
		'5' => array ('name'=>"Warhammer"),
		'6' => array ('name'=>"Arsène Lupin"),
		'7' => array ('name'=>"Dongons et Dragons 3.5"),
		'8' => array ('name'=>"Fallout"),
		'9' => array ('name'=>"The Edler Scrolls"),
		'10' => array ('name'=>"Game of Thrones"),
		'11' => array ('name'=>"Héroïques"),
		'12' => array ('name'=>"Nephilim"),
		'13' => array ('name'=>"Le roi des gobelins"),
		'14' => array ('name'=>"Antika"),
		'15' => array ('name'=>"Advanced Dongeons and Dragons"),
		'16' => array ('name'=>"Barbarians of Lemuria"),
		'17' => array ('name'=>"Blacksad"),
		'18' => array ('name'=>"Dongons et Dragons 5ème édition"),
		'19' => array ('name'=>"Dongons et Dragons 4ème édition"),
		'20' => array ('name'=>"Degenesis Rebirth"),
		'21' => array ('name'=>"Dungeon World"),
		'22' => array ('name'=>"Hawkmoon"),
		'23' => array ('name'=>"Iron Kingdoms"),
		'24' => array ('name'=>"Jaune Radiation"),
		'25' => array ('name'=>"Khaos 1795"),
		'26' => array ('name'=>"Lady Blackbird"),
		'27' => array ('name'=>"Les larmes du cardinal"),
		'28' => array ('name'=>"Miles Christi"),
		'29' => array ('name'=>"MonsterHearts"),
		'30' => array ('name'=>"Le dongon de Naheulbeuk"),
		'31' => array ('name'=>"Naruto"),
		'32' => array ('name'=>"Les Ombres d'Esteren"),
		'33' => array ('name'=>"Postapokémon"),
		'34' => array ('name'=>"Rushmore"),
		'35' => array ('name'=>"Shadow of the Demon Lord"),
		'36' => array ('name'=>"Shadowrun"),
		'37' => array ('name'=>"Te deum pour un massacre"),
		'38' => array ('name'=>"Terra Incognita"),
		'39' => array ('name'=>"Vietnam"),
		'40' => array ('name'=>"Yggdrasil"),
		'41' => array ('name'=>"L'oeil Noir")


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

function parties_archive_template( $archive_template ) {
	global $post;
	if ( $post->post_type ==  ( 'parties' ) ) {
		$archive_template = dirname( __FILE__ ) . '/public/archive-parties.php';
	}
	return $archive_template;
}
add_filter( 'archive_template', 'parties_archive_template' ) ;




////////////////// LISTES CAMPAGNES /////////////////
// ShortCode
function archive_campagnes_list() {

	$output = campagnes_list();
	return $output;
}
add_shortcode('Liste_Campagnes', 'archive_campagnes_list');

// Page
////////////////////////////////////////////////////////////////////
function campagnes_list() {
	ob_start();

	global $wpdb;
	$campagnes = $wpdb->get_results("
   SELECT
p.ID, p.post_title
    FROM wp_119092_posts p LEFT JOIN wp_119092_postmeta pm1 ON ( pm1.post_id = p.ID)                 
    WHERE p.post_type= 'parties' AND p.post_status = 'publish'
    GROUP BY p.ID, p.post_title
     HAVING MAX(CASE WHEN pm1.meta_key = 'type' then pm1.meta_value ELSE NULL END)= 'campagne'
AND MAX(CASE WHEN pm1.meta_key = 'active' then pm1.meta_value ELSE NULL END)= 'on'
     ");

	foreach($campagnes as $campagne) :
		?>
		<h4>
			<a href=<?php echo get_permalink($campagne->ID);?>><?php echo $campagne->post_title;?></a>
		</h4>
		<?php
	endforeach;
	return ob_get_clean();
}

////////////////// LISTES CAMPAGNES /////////////////
// ShortCode
function sc_mes_campagnes_list() {

	$output = mes_campagnes_list();
	return $output;
}
add_shortcode('Liste_Mes_Campagnes', 'sc_mes_campagnes_list');

// Page
////////////////////////////////////////////////////////////////////
function mes_campagnes_list() {
	ob_start();
	$user_id = get_current_user_id();
	global $wpdb;
	$campagnes = $wpdb->get_results("
   SELECT
p.ID, p.post_title
    FROM wp_119092_posts p LEFT JOIN wp_119092_postmeta pm1 ON ( pm1.post_id = p.ID)                 
    WHERE p.post_type= 'parties' AND p.post_status = 'publish'
    GROUP BY p.ID, p.post_title
     HAVING MAX(CASE WHEN pm1.meta_key = 'type' then pm1.meta_value ELSE NULL END)= 'campagne'
AND MAX(CASE WHEN pm1.meta_key = 'mj' then pm1.meta_value ELSE NULL END)='".$user_id."'"
	);

	foreach($campagnes as $campagne) :
		?>
		<h4>
			<a href=<?php echo get_permalink($campagne->ID);?>><?php echo $campagne->post_title;?></a>
		</h4>
		<?php
	endforeach;
	return ob_get_clean();
}

////////////////// LISTES PARTIES /////////////////
// ShortCode
function sc_liste_parties_calendrier() {

	$output = liste_parties_calendrier();
	return $output;
}
add_shortcode('liste_parties_calendrier', 'sc_liste_parties_calendrier');

// Page
////////////////////////////////////////////////////////////////////
function liste_parties_calendrier() {
	ob_start();

	global $wpdb;
	$dates = $wpdb->get_results("SELECT
    MAX(CASE WHEN pm1.meta_key = 'début' then (FROM_UNIXTIME(meta_value)) ELSE NULL END) as début

    
    FROM wp_119092_posts p LEFT JOIN wp_119092_postmeta pm1 ON ( pm1.post_id = p.ID)                 
    WHERE p.post_type= 'parties' AND p.post_status = 'publish'

    GROUP BY p.ID, p.post_title
        HAVING MAX(CASE WHEN pm1.meta_key = 'calendrier' then pm1.meta_value ELSE NULL END)  = 'on'
        AND MAX(CASE WHEN pm1.meta_key = 'début' then (FROM_UNIXTIME(meta_value)) ELSE NULL END) >= now()
        AND  MAX(CASE WHEN pm1.meta_key = 'type' then pm1.meta_value ELSE NULL END)= 'partie'
        
        ORDER BY début");

	foreach($dates as $date) :
		?>
		<h4>

			<?php
			$formattedate=date_create($date->début);
			echo date_format($formattedate,"d-m-Y");?>
		</h4>

		<?php
		$parties = $wpdb->get_results("SELECT
p.ID, p.post_title
    FROM wp_119092_posts p LEFT JOIN wp_119092_postmeta pm1 ON ( pm1.post_id = p.ID)                 
    WHERE p.post_type= 'parties' AND p.post_status = 'publish'

    GROUP BY p.ID, p.post_title
        HAVING MAX(CASE WHEN pm1.meta_key = 'calendrier' then pm1.meta_value ELSE NULL END)  = 'on'
        AND  MAX(CASE WHEN pm1.meta_key = 'type' then pm1.meta_value ELSE NULL END)= 'partie'
        AND MAX(CASE WHEN pm1.meta_key = 'début' then (FROM_UNIXTIME(meta_value)) ELSE NULL END) ='".$date->début."'");



		foreach($parties as $partie) :
			$post = get_post( $partie->ID );
			?>
			<a href=<?php echo get_permalink($partie->ID);?>><?php echo $partie->post_title;?></a> (<?php
			$term_list = wp_get_post_terms( $partie->ID, 'tax_categories_parties',array("fields" => "names"));
			echo $term_list[0];
			?>)
			<BR>
			<?php
		endforeach;
		echo "<BR>";
	endforeach;
	return ob_get_clean();
}


////////////////// LISTES PARTIES /////////////////
// ShortCode
function sc_liste_parties_non_calendrier() {

	$output = liste_parties_non_calendrier();
	return $output;
}
add_shortcode('liste_parties_non_calendrier', 'sc_liste_parties_non_calendrier');

// Page
////////////////////////////////////////////////////////////////////
function liste_parties_non_calendrier() {
	ob_start();

	global $wpdb;
	$parties = $wpdb->get_results("
  SELECT
p.ID, p.post_title
    FROM wp_119092_posts p LEFT JOIN wp_119092_postmeta pm1 ON ( pm1.post_id = p.ID)                 
    WHERE p.post_type= 'parties' AND p.post_status = 'publish'
    GROUP BY p.ID, p.post_title
        HAVING  MAX(CASE WHEN pm1.meta_key = 'calendrier' then pm1.meta_value ELSE NULL END)  != 'on'
        AND MAX(CASE WHEN pm1.meta_key = 'type' then pm1.meta_value ELSE NULL END)= 'partie'");

	foreach($parties as $partie) :
		// $post = get_post( $partie->ID );
		?>
		<a href=<?php echo get_permalink($partie->ID);?>><?php echo $partie->post_title;?></a> (<?php
		$term_list = wp_get_post_terms( $partie->ID, 'tax_categories_parties',array("fields" => "names"));
		echo $term_list[0];
		?>)
		<BR>
		<?php
	endforeach;

	return ob_get_clean();
}







// Create bbpress posts

function create_update_topic( $ID, $post ) {
	$post_parent_nonfull = 554;
	$post_parent_full = 556;
	$topic_id = get_post_meta( $ID, 'topic_id',true);
	// $forum_id = get_post_meta( $ID, 'forum_id',true);
	$author = $post->post_author;
	$name = get_the_author_meta( 'display_name', $author );
	$title = $post->post_title;



	$permalink = get_permalink( $ID );
	$content = $post->post_content;
	$subject = sprintf( $title );
	$message ='';
	if (get_post_meta( $ID, 'full',true) != 'on'){
		if (get_post_meta( $ID, 'type',true) == 'campagne'){
			$message = sprintf ("<H3>Campagne: ".$title . " </H3><p></p>");
			$message = $message.sprintf ("Cette campagne vous intéresse? Inscrivez-vous ici: ".$permalink . " <p></p>");
		}
		else {
			$message = sprintf ("<H3>Partie: ".$title . "   " . (date('d-m-Y H:i',(get_post_meta($ID, 'début',true))))." </H3><p></p>");
			$message = $message.sprintf ("Cette partie vous intéresse? Inscrivez-vous ici: ".$permalink . " <p></p>");
		}
	}

	if (get_post_meta( $ID, 'full',true) == 'on'){
		if (get_post_meta( $ID, 'type',true) == 'campagne'){
			$message = sprintf ("<H3>Campagne: ".$title . " </H3><p></p>");
			$message = $message.sprintf ("voir les détails de cette campagne: ".$permalink . " <p></p>");
		}
		else {
			$message = sprintf ("<H3>Partie: ".$title . "   " . (date('d-m-Y H:i',(get_post_meta($ID, 'début',true))))." </H3><p></p>");
			$message = $message.sprintf ("voir les détails de cette partie: ".$permalink . " <p></p>");

		}

	}
	$message = sprintf ($message.$content);

	if (get_post_meta( $ID, 'accueil',true) == 'on'){
		$title = '[ACCUEIL] '. $title;
	}
	if (get_post_meta( $ID, 'full',true) == 'on'){
		$title = '[FULL] '. $title;
	}

	if (get_post_meta( $ID, 'type',true) == 'partie'){
		$title = '[ONE SHOT] '. $title;
	}

	if (get_post_meta( $ID, 'type',true) == 'campagne'){
		$title = '[CAMPAGNE] '. $title;
	}

	if (wp_get_post_parent_id($ID)!= 0) {//check if post parent exist. If exist, take topicid from parent. add post linked to penret forum id
		$post_parent = get_post_meta( wp_get_post_parent_id($ID), 'topic_id',true);

	} else {

		if (get_post_meta( $ID, 'full',true) == 'on'){
			$post_parent=$post_parent_full;
		}
		else {
			$post_parent=$post_parent_nonfull;
		}
	}
	if ( empty($topic_id) ) { // Create New topic
//AND empty($forum_id)
		$new_post = array(
			'post_title'    => $subject,
			'post_content'  => $message,
			'post_parent' => $post_parent,
			'post_status'   => 'publish',
			'post_type' => 'topic'
		);


		$topic_id = bbp_insert_topic($new_post);

		if ( !empty( $topic_id ) ) {
			bbp_update_topic_last_active_time(  $topic_id, current_time('mysql',1));
			add_post_meta($ID, 'topic_id', $topic_id, true);
			//   add_post_meta($ID, 'forum_id', $post_parent, true);
		}
	}
	else {

		// Update Topic
		global $wpdb;
		$ptable = $wpdb->posts;
		$datetime = date("Y-m-d H:i:s");
		$sql = $wpdb->prepare("UPDATE $ptable SET post_parent=%s, post_title=%s,post_content=%s WHERE ID=%s", $post_parent, $title, $message, $topic_id);
		bbp_update_topic_last_active_time(  $topic_id, current_time('mysql',1));
		update_post_meta($ID, 'topic_id', $topic_id, true);
		//  update_post_meta($ID, 'forum_id', $post_parent, true);

		if ($sql === false) {
			echo '<p>DB update error for topic #'.$topic_id.' !</p>';
		}
		$wpdb->query($sql);
		update_post_meta($ID, 'topic_id', $topic_id, true);
		//  update_post_meta($ID, 'forum_id', $post_parent, true);

	}
	// $topic_meta = array(
	//     'forum_id'       => $new_post['post_parent']
	// );

	bbp_update_forum(array('forum_id' => 554));
	bbp_update_forum(array('forum_id' => 556));
}



//-----DATE TIME PICKER
function load_datetimepicker_js(){

	wp_enqueue_style( 'datepickerstyle', PLUGIN_URL. 'public/js/jquery.datetimepicker.min.css' );
	wp_enqueue_script('datetimepicker', PLUGIN_URL. 'public/js/jquery.datetimepicker.full.min.js', array('jquery'));


}
add_action('wp_head', 'load_datetimepicker_js');


//-----CALENDRIER
function load_full_calendar_js() {

	wp_enqueue_style( 'fullcalstyles', PLUGIN_URL. 'public/js/fullcalendar/fullcalendar.css' );
	//wp_enqueue_script('jquery', PLUGIN_URL. 'public/js/fullcalendar/lib/jquery.min.js', array('jquery'));
	wp_enqueue_script('moment', PLUGIN_URL. 'public/js/fullcalendar/lib/moment.min.js', array('jquery'));
	wp_enqueue_script('fullcalendar', PLUGIN_URL. 'public/js/fullcalendar/fullcalendar.min.js', array('jquery'));
	wp_enqueue_script('fullcalendarfrench', PLUGIN_URL. 'public/js/fullcalendar/locale/fr.js', array('jquery'));
	wp_enqueue_script('calendar-header' ,  PLUGIN_URL. 'public/js/head_insert_calendar.js',  array('jquery' ));

// - set path to json feed -
	$json_public_calendar = PLUGIN_URL. 'includes/json_public_calendar.php';

// - tell JS to use this variable instead of a static value -
	wp_localize_script( 'fullcalendar', 'load_full_calendar_js', array('events' => $json_public_calendar));

}
add_action('wp_head', 'load_full_calendar_js');



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

function add_login_logout_register_menu( $items, $args ) {
	if ( $args->theme_location != 'primary' ) {
		return $items;
	}

	if ( is_user_logged_in() ) {
		$items .= '<li><a href="' . wp_logout_url() . '">' . __( 'Se déconnecter' ) . '</a></li>';
	} else {
		$items .= '<li><a href="' . wp_login_url() . '">' . __( 'Se connecter' ) . '</a></li>';
		$items .= '<li><a href="' . wp_registration_url() . '">' . __( 'Inscription' ) . '</a></li>';
	}

	return $items;
}

add_filter( 'wp_nav_menu_items', 'add_login_logout_register_menu', 199, 2 );

//add_action('after_setup_theme', 'remove_admin_bar');

//function remove_admin_bar() {
//if (!current_user_can('administrator') && !is_admin())  {
//  show_admin_bar(false);
//}
//}


function my_wp_nav_menu_args( $args = '' ) {

	if ( is_user_logged_in() ) {
		$args['menu'] = 'logged-in';
	} else {
		$args['menu'] = 'logged-out';
	}

	return $args;
}
add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );






function inscription_desinscription_partie() {

	if ( ! empty( $_POST ) AND (isset($_POST['inscription']))) {

		$inscription = $_POST['inscription'];
		$user_id = $_POST['user_id'];
		$partie_id = $_POST['partie_id'];
		$parent_id = wp_get_post_parent_id( $partie_id ) ;

		global $wpdb;
		$table_name = $wpdb->prefix . 'sdc_inscriptions';


		if ($inscription=="1") {


			if (get_post_meta( $partie_id, 'type',true) == 'partie'){ //Inscription Partie simple




				$wpdb->insert($table_name, array(
					'partie_id' => $partie_id,
					'user_id' => $user_id
				));
			}

			else
			{ // inscription campagne

// Inscription Campagne

				$wpdb->insert($table_name, array(
					'partie_id' => $partie_id,
					'user_id' => $user_id
				));


// Effacer toute inscription aux prochianes parties



				$wpdb->query("DELETE FROM ". $table_name." WHERE user_id='".$user_id ."' AND partie_id IN (
    SELECT p.ID
    FROM wp_119092_posts p LEFT JOIN wp_119092_postmeta pm1 ON (pm1.post_id = p.ID)                 
    WHERE p.post_type= 'parties' AND p.post_status = 'publish' AND p.post_parent='".$partie_id."'
    GROUP BY p.ID
     HAVING  MAX(CASE WHEN pm1.meta_key = 'début' then pm1.meta_value ELSE NULL END) >=  UNIX_TIMESTAMP(NOW())
    )");

// Ajouter inscription aux procahines parties

				$wpdb->query("INSERT INTO ".$table_name." (partie_id, user_id)
    (SELECT p.ID, ".$user_id."
    FROM wp_119092_posts p LEFT JOIN wp_119092_postmeta pm1 ON (pm1.post_id = p.ID)                 
    WHERE p.post_type= 'parties' AND p.post_status = 'publish' AND p.post_parent='".$partie_id."'
    GROUP BY p.ID
     HAVING  MAX(CASE WHEN pm1.meta_key = 'début' then pm1.meta_value ELSE NULL END) >=  UNIX_TIMESTAMP(NOW())
    )
    ");


			}}

		if ($inscription=="0") {

			if (get_post_meta( $partie_id, 'type',true) == 'partie'){ //Désinscription Partie simple

				$wpdb->query("DELETE FROM ". $table_name." WHERE partie_id='". $partie_id ."' AND user_id='". $user_id ."'");

			}

			else
			{ // Désinscription campagne

				$wpdb->query("DELETE FROM ". $table_name." WHERE partie_id='". $partie_id ."' AND user_id='". $user_id ."'");

// Effacer toute inscription aux prochianes parties



				$wpdb->query("DELETE FROM ". $table_name." WHERE user_id='".$user_id ."' AND partie_id IN (
    SELECT p.ID
    FROM wp_119092_posts p LEFT JOIN wp_119092_postmeta pm1 ON (pm1.post_id = p.ID)                 
    WHERE p.post_type= 'parties' AND p.post_status = 'publish' AND p.post_parent='".$partie_id."'
    GROUP BY p.ID
     HAVING  MAX(CASE WHEN pm1.meta_key = 'début' then pm1.meta_value ELSE NULL END) >=  UNIX_TIMESTAMP(NOW())
    )
    ");


			}
		}
		$url = get_permalink( $partie_id );
		wp_redirect($url);
		exit();
	}}


add_action('init', 'inscription_desinscription_partie');

function parties_campagnes_template($single_template) {
	global $post;
	$type = '';
	$type = get_post_meta($post->ID, 'type',true);


	if ($post->post_type == 'parties') {
		if ($type == '' OR $type == 'partie')
		{
			$single_template = dirname( __FILE__ ) . '/public/single-partie.php';
		}
		if ($type == 'campagne')
		{
			$single_template = dirname( __FILE__ ) . '/public/single-campagne.php';
		}

	}
	return $single_template;
}
add_filter( 'single_template', 'parties_campagnes_template' );

function bbp_enable_visual_editor( $args = array() ) {
	$args['tinymce'] = true;
	return $args;
}
add_filter( 'bbp_after_get_the_content_parse_args', 'bbp_enable_visual_editor' );

// Add custom styles to TinyMCE editor
if ( ! function_exists('tdav_css') ) {
	function tdav_css($wp) {
		$wp .= ',' . PLUGIN_URL . 'public/css/editor.css';
		return $wp;
	}
}
add_filter( 'mce_css', 'tdav_css' );

function new_wp_trim_excerpt($text) {
	$raw_excerpt = $text;
	if ( '' == $text ) {
		$text = get_the_content('');

		$text = strip_shortcodes( $text );

		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]>', $text);
		$text = strip_tags($text, '<a>');
		$excerpt_length = apply_filters('excerpt_length', 55);

		$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
		$words = preg_split('/(<a.*?a>)|\n|\r|\t|\s/', $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE );
		if ( count($words) > $excerpt_length ) {
			array_pop($words);
			$text = implode(' ', $words);
			$text = $text . $excerpt_more;
		} else {
			$text = implode(' ', $words);
		}
	}
	return apply_filters('new_wp_trim_excerpt', $text, $raw_excerpt);

}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'new_wp_trim_excerpt');
?>