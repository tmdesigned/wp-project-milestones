<?php
/**
 * Plugin Name: WP Project Milestones
 * Plugin URI:  https://tmdesigned.com
 * Description: WordPress Project Milestones - Track a project based on its milestone points, with dynamic adjusted target dates
 * Version:     .1
 * Author:      Taylor Morgan
 * Author URI:  https://tmdesigned.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wppm
 */

require_once( 'classes/wp_project_milestones_activation.class.php' );

class WP_Project_Milestones{

    function __construct(){

        register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );

    }

    function plugin_activation(){

        WP_Project_Milestones_Activation::activate();

    }
}