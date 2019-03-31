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

//Autoload classes
spl_autoload_register( 'wppm_autoloader' );
function wppm_autoloader( $class_name ) {
    if ( false !== strpos( $class_name, 'WPPM' ) ) {
        $classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR;
        $file_name = 'class-' . strtolower( str_replace( '_' , '-', $class_name ) ) . '.php';
        require_once $classes_dir . $file_name;
    }
}

class WP_Project_Milestones{
    
    private static $instance;

    public $db;
    
    
    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    private function __construct(){

        register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );

        $this->db = new WPPM_Database;

    }


    public function plugin_activation(){

        $this->db->create_tables();

    }




}

$wppm_instance = WP_Project_Milestones::get_instance();
