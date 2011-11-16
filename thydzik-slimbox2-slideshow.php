<?php 
/* 
	Plugin Name: Slimbox2 with Slideshow
	Plugin URI: http://thydzik.com/category/slimbox2-slideshow/
	Description: Slimbox2 with auto-resize and slideshow
	Version: 1.1
	Author: Travis Hydzik
	Author URI: http://thydzik.com
*/ 
/*  Copyright 2011 Travis Hydzik (mail@thydzik.com)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/

define("TSS_VERSION", '1.1');
define("TSS_FOLDER", "thydzik-slimbox2-slideshow");


//lets create some nice output for our google bots.
if(!function_exists("get_option")) {
	$host = $_SERVER['HTTP_HOST'];
	//function does not exist so not being run from wordpress
	header("Content-Type: text/html; charset=UTF-8");
	echo "<!doctype html><html><head><title>Slimbox2 Slideshow</title></head><body><a href='http://{$host}' target='_self'>{$host}</a> are proudly using the <a href='http://wordpress.org' target='_blank'>WordPress</a> plugin <a href='http://thydzik.com/category/slimbox2-slideshow/' target='_blank'>Slimbox2 Slideshow</a> to auto resized lightbox and slideshow.</body></html>";
	//create dummy function
	function get_option($s) {
		return $s;
	}
	exit;
}

//default values
$tss_options = array(
	"tss_tag" 	=> "checked",
	"tss_gal" 	=> "checked",
	"tss_auto" 	=> "checked",
	"tss_scaling" => 0.75,
	"tss_maps" 	=> "",
	"tss_all"	=> "",
	"tss_time"	=> 10);

function tss_create_xml() {
	global $wpdb;

	$posts = $wpdb->get_results("SELECT post_content, post_title FROM $wpdb->posts where post_status='publish'");

	$dom = new DOMDocument;
	
	$image_ext = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'thm', 'tif');
	
	$xml = new DOMDocument();
	$xml->formatOutput = true;
	
	//root node
	$blog = $xml->createElement('blog');
	$blog = $xml->appendChild($blog);
	
	foreach ($posts as $post) {
		//echo $post->post_title."<br/>";
		$post_content =  $post->post_content;
		if ($post_content) {
			@$dom->loadHTML($post_content);
			$as = $dom->getElementsByTagName('a');
			
			//fwrite($fh, "<image>\r\n");
			foreach ($as as $a) {

				if ($title_string=$a->getAttribute('title')) {
					$href_string=$a->getAttribute('href');
					if (in_array(strtolower(pathinfo($href_string, PATHINFO_EXTENSION)), $image_ext)) {
						//write the data
						$image = $xml->createElement('image');
						$image = $blog->appendChild($image);
						
						
						//title
						$title = $xml->createElement('title');
						$title = $image->appendChild($title);
						$text = $xml->createTextNode($title_string);
						$text = $title->appendChild($text);
						
						//href
						$href = $xml->createElement('href');
						$href = $image->appendChild($href);
						$text = $xml->createTextNode($href_string);
						$text = $href->appendChild($text);
					}
				}
			}

		}
	}
	
	$file = dirname(__FILE__)."/images.xml";
	$xml->save($file);
}


function tss_admin_menu() {
	if (function_exists("add_submenu_page")) {
		add_submenu_page("plugins.php", "Slimbox2 Slideshow","Slimbox2 Slideshow", 10, basename(__FILE__), "tss_submenu_page");
	}
}

function tss_submenu_page() {
	global $tss_options;
	
	echo "<div class='wrap'><h2>Slimbox2 Slideshow Options</h2>";
	if($_POST['action'] == "save") {
		echo  "<div id='message' class='updated fade'><p>Slimbox2 Slideshow Options Updated.</p></div>";
		if (is_numeric($_POST["tss_scaling"])) {
			update_option("tss_scaling", $_POST["tss_scaling"]);
		}
		if (is_numeric($_POST["tss_time"])) {
			update_option("tss_time", $_POST["tss_time"]);
		}	
		
		if ($_POST["tss_tag"]) {
			update_option("tss_tag", 'checked');
		} else {
			update_option("tss_tag", '');
		}
		if ($_POST["tss_gal"]) {
			update_option("tss_gal", 'checked');
		} else {
			update_option("tss_gal", '');
		}
		if ($_POST["tss_auto"]) {
			update_option("tss_auto", 'checked');
		} else {
			update_option("tss_auto", '');
		}
		if ($_POST["tss_maps"]) {
			update_option("tss_maps", 'checked');
		} else {
			update_option("tss_maps", '');
		}
		if ($_POST["tss_all"]) {
			update_option("tss_all", 'checked');
		} else {
			update_option("tss_all", '');
		}
	}
	
	echo 	"<form name='form' method='post'><p>\r\n".
			"<table cellspacing='2' cellpadding='5' class='form-table'>\r\n".
			"<tr>\r\n".
			"	<th scope='row'>Automatic Image Link Tagging:</th>\r\n".
			"	<td><input type='checkbox' name='tss_tag' value='anyvalue' ".get_option("tss_tag", $tss_options[tss_tag]).">\r\n".
			"	<p><small>Automatically apply rel=\"lightbox\" tags to links.</small></p></td>\r\n".
			"</tr>\r\n".
			"<tr>\r\n".
			"	<th scope='row'>Automatic Gallery Image Link Tagging:</th>\r\n".
			"	<td><input type='checkbox' name='tss_gal' value='anyvalue' ".get_option("tss_gal", $tss_options[tss_gal]).">\r\n".
			"	<p><small>Automatically apply rel=\"lightbox\" tags to WordPress Gallery image links.</small></p></td>\r\n".
			"</tr>\r\n".
			"<tr>\r\n".
			"	<th scope='row'>Automatic Resize:</th>\r\n".
			"	<td><input type='checkbox' name='tss_auto' value='anyvalue' ".get_option("tss_auto", $tss_options[tss_auto]).">\r\n".
			"	<p><small>Automatically resize images to fit in browser window.</small></p></td>\r\n".
			"</tr>\r\n".
			"<tr>\r\n".
			"	<th scope='row'>Image Scaling Factor:</th>\r\n".
			"	<td><input type='text' size='4' name='tss_scaling' value='".get_option("tss_scaling", $tss_options[tss_scaling])."'>\r\n".
			"	<p><small>The approximate size the image will fit in the browser window. Default of 0.75 (75%) works well.</small></p></td>\r\n".
			"</tr>\r\n".
			"<tr>\r\n".
			"	<th scope='row'>Enable Slimbox on Image Maps:</th>\r\n".
			"	<td><input type='checkbox' name='tss_maps' value='anyvalue' ".get_option("tss_maps", $tss_options[tss_maps]).">\r\n".
			"	<p><small>Enable Slimbox to be displayed on Image Maps.</small></p></td>\r\n".
			"</tr>\r\n".
			"<tr>\r\n".
			"	<th scope='row'>Enable Slideshow on All:</th>\r\n".
			"	<td><input type='checkbox' name='tss_all' value='anyvalue' ".get_option("tss_all", $tss_options[tss_all]).">\r\n".
			"	<p><small>Slideshow will start on Image Groups as well.</small></p></td>\r\n".
			"</tr>\r\n".
			"<tr>\r\n".
			"	<th scope='row'>Slide Time:</th>\r\n".
			"	<td><input type='text' size='4' name='tss_time' value='".get_option("tss_time", $tss_options[tss_time])."'>\r\n".
			"	<p><small>When slideshow's started, time in seconds between images.</small></p></td>\r\n".
			"</tr>\r\n".
			"</table>\r\n".
			"<p class='submit'>\r\n".
			"	<input type='hidden' name='action' value='save'>\r\n".
			"	<input type='submit' name='submit' value='Update options &raquo;'>\r\n".
			"</p></form></div>";
}

//load the scripts
function tss_init() {
	global $tss_options;

    if (!is_admin()) {
			wp_deregister_script("jquery");
			wp_register_script("jquery", "http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js", array(), Null);
			wp_enqueue_script("jquery");
			wp_register_script("tss_js", plugins_url("tss.min.js",__FILE__), array("jquery"), TSS_VERSION);
			wp_enqueue_script( "tss_js" );
			wp_register_style( "tss_css", plugins_url("tss.css",__FILE__), array(), TSS_VERSION);
			wp_enqueue_style(  "tss_css");
    }
	
	//pass some variables from php to javascript
	$tss_data = array(
		"tss_gal" => get_option("tss_gal", $tss_options[tss_gal]),
		"tss_auto" => get_option("tss_auto", $tss_options[tss_auto]),
		"tss_scaling" => get_option("tss_scaling", $tss_options[tss_scaling]),
		"tss_maps" => get_option("tss_maps", $tss_options[tss_maps]),
		"tss_all" => get_option("tss_all", $tss_options[tss_all]),
		"tss_time" => get_option("tss_time", $tss_options[tss_time]),
		"tss_images" => plugins_url("images.xml",__FILE__));

	wp_localize_script("tss_js", "tss_objects", $tss_data);
}


// function based on lightbox2 plugin
// http://www.stimuli.ca/
function tss_addrel($content) {

	global $post;
	$pattern        = '%(<a(?![^>]*?rel=[\'"]lightbox.*)[^>]*?href=[\'"][^\'"]+?\.(?:bmp|gif|jpg|jpeg|png)[\'"][^>]*?)(/?>)%i';
	$replacement    = '$1 rel="lightbox'.$post->ID.'" $2';
	$content = preg_replace($pattern, $replacement, $content);

	return $content;
}

if (get_option("tss_tag", $tss_options[tss_tag])){
	add_filter('the_content', 'tss_addrel');
	add_filter('the_excerpt', 'tss_addrel');
}

//create index on plugin activation
//register_activation_hook( __FILE__, 'tss_create_xml' );

//above does not get fired for upgrades, so check if file exists instead
if (!file_exists(dirname(__FILE__)."/images.xml")) {
	tss_create_xml();
}

//add the scripts
add_action('init', 'tss_init');

// admin hooks
add_action("admin_menu", "tss_admin_menu");

// generate index whenever a page/post is modified
add_action('edit_post', 'tss_create_xml');

?>