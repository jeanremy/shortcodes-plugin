<?php

/*
  Plugin Name: Shortcodes for WordPress
  Description: Des shortcodes dans l'éditeur et les styles du site dans l'éditeur.
  Version: 1.0.0
  Author: JR
  Author URI: https://www.jeanremypraud.com
 */

class JRWPShortcodes {

    public function __construct() {
        // TINY MCE BUTTONS
        add_action( 'admin_head', array($this, 'jrwps_add_buttons'));
        add_action( 'admin_init', array($this, 'my_theme_add_editor_styles' ));  

        // SHORTCODES
        add_shortcode( 'ca', array($this, 'jrwps_shortcodes_ca' ));    
        add_shortcode( 'map', array($this, 'jrwps_shortcodes_map' ));
        add_shortcode( 'galerie-slider', array($this, 'jrwps_shortcodes_galerie' ));

    }

    /********************
     * TINY MCE BUTTONS *
     ********************/

    public function my_theme_add_editor_styles() {
        // Path to my css theme file
        add_editor_style( 'css/main.min.css' );
    }

    public function jrwps_add_buttons() {
	    global $typenow;

	    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
	   		return;
	    }

	    if( ! in_array( $typenow, array( 'post', 'page' ) ) )
	        return;

		if ( get_user_option('rich_editing') == 'true') {
			add_filter('mce_external_plugins', array($this, 'jrwps_add_tinymce_plugin'));
            add_filter('mce_buttons', array($this, 'jrwps_register_buttons'));
            add_filter('mce_buttons_2', array($this, 'jrwps_custom_styles'));
            add_filter( 'tiny_mce_before_init', array($this, 'jrwps_before_init_insert_formats' ));  
		}
    }

    public function jrwps_add_tinymce_plugin() {
        $plugin_array['jrwps_column_button'] = plugins_url( '/js/jrwps-columns.js', __FILE__ ); 
	   	$plugin_array['jrwps_shortcodes_button'] = plugins_url( '/js/jrwps-shortcodes.js', __FILE__ ); 
	   	return $plugin_array;
  	}

  	public function jrwps_register_buttons($buttons) {
       array_push($buttons, 'jrwps_shortcodes_button');
       return $buttons;
    }

    function jrwps_custom_styles( $buttons ) {
       array_push($buttons, 'jrwps_column_button');
       array_unshift( $buttons, 'styleselect' );
        return $buttons;
    }

    // Définir ici les styles en lien avec le thème
    function jrwps_before_init_insert_formats( $init_array ) {  

        $style_formats = array(             
            array(  
                'title' => 'Titre 2', 
                'selector' => 'h2',
                'classes' => 'level2',
                'wrapper' => true,
            ),
            array(  
                'title' => 'Titre 3',  
                'selector' => 'h3',
                'classes' => 'level3',
                'wrapper' => true,
            ),
            array(  
                'title' => 'Titre 4', 
                'selector' => 'h4',
                'classes' => 'level4',
                'wrapper' => true,
            ),
            array(  
                'title' => 'Légende de photo',  
                'selector' => 'p',
                'classes' => 'caption',
                'wrapper' => true,
            ),
            array(  
                'title' => 'Intro',  
                'selector' => 'p',
                'classes' => 'intro',
                'wrapper' => true,
            )
        );  

        // On remove les styles qui ne nous intéressent pas
        $init_array['style_formats'] = json_encode( $style_formats ); 
        $init_array['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4';

        return $init_array;  
      
    } 


	/**************
     * SHORTCODES *
     **************/

    // Quelques exemples de shortcodes, qui vont chercher des "bouts" du thème dans don rép

    public function jrwps_shortcodes_ca() {
        ob_start();
        get_template_part('content', 'ca');
        return ob_get_clean();
    }

    public function jrwps_shortcodes_map() {
        wp_enqueue_script('googlemap', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCir074JzICd5zCN-PMdP0a-H4_DUWHNmY', array(), '', true);
        wp_enqueue_script('map', plugin_dir_url(__FILE__) . 'js/jrwps-map.js', array('jquery', 'googlemap'), '', true);        
        wp_localize_script('map', 'MAP', array(
            'plugin_url' => plugin_dir_url(__FILE__),
            'lat' => get_option('_jrwps_theme_options')['lat'],
            'long' => get_option('_jrwps_theme_options')['long'] )
        );
        ob_start();
        get_template_part('content', 'map');
        return ob_get_clean();
    }

    public function jrwps_shortcodes_galerie() {
        wp_enqueue_script('galerie_js', plugin_dir_url(__FILE__) . 'js/jrwps-galerie.js', array('jquery'), '', true);
        wp_enqueue_style('galerie_css', plugin_dir_url(__FILE__) . 'css/jrwps-galerie.css');
        ob_start();
        get_template_part('slider', 'galerie');
        return ob_get_clean();        
    }

}

new JRWPShortcodes();