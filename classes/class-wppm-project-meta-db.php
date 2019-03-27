<?php

class WPPM_Project_Meta_DB extends WPPM_DB {

    /**
     * Get things started
     *
     * @access  public
     * @since   1.0
    */
    public function __construct() {
        global $wpdb;
        $this->table_name  = $wpdb->prefix . 'wppm_project_meta';
        $this->primary_key = 'id';
        $this->version     = '1.0';
    }
	
	/**
	 * Get columns and formats
	 *
	 * @access  public
	 * @since   1.0
	*/
	public function get_columns() {
		return array(
			'id'          	=> '%d',
			'name' 			=> '%s',
			'value'  		=> '%s',
			'created'  		=> '%s'
		);
    }
    
	/**
	 * Get default column values
	 *
	 * @access  public
	 * @since   1.0
	*/
	public function get_column_defaults() {
		return array(
			'id'          	=> 0,
			'name' 			=> '',
			'value'  		=> '',
			'created'  		=> '1000-01-01'
		);
	}

	/**
	 * Create the table
	 *
	 * @access  public
	 * @since   1.0
	*/
	public function create_table() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
		$projects_table = $wpdb->prefix . "wppm_projects";
		
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        
        $sql = array();
        
        $sql[] = "CREATE TABLE " . $this->table_name . " (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` TEXT NOT NULL,
            `value` TEXT NOT NULL,
            `created` DATE NOT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate;";

        $sql[] = "ALTER TABLE " . $this->table_name . " ADD CONSTRAINT `ProjectMeta_fk0` FOREIGN KEY (`id`) REFERENCES `$projects_table`(`id`);";

		dbDelta( $sql );
		update_option( $this->table_name . '_db_version', $this->version );
	}
}