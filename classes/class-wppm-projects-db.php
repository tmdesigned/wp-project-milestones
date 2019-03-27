<?php

class WPPM_Projects_DB extends WPPM_DB {

    /**
     * Get things started
     *
     * @access  public
     * @since   1.0
    */
    public function __construct() {
        global $wpdb;
        $this->table_name  = $wpdb->prefix . 'wppm_projects';
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
			'id'          => '%d',
			'title'       => '%s',
			'name'        => '%s',
			'assigned_to' => '%d',
			'status'      => '%d'
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
			'id'          => 0,
			'title'       => '',
			'name'        => '',
			'assigned_to' => 0,
			'status'      => 0
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
        $users_table = $wpdb->prefix . "users";
        $project_statuses_table = $wpdb->prefix . "wppm_project_statuses";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        
        $sql = array();
        
        $sql[] = "CREATE TABLE " . $this->table_name . " (
            `id` INT NOT NULL AUTO_INCREMENT,
            `title` TEXT NOT NULL,
            `name` TEXT NOT NULL,
            `assigned_to` INT NOT NULL,
            `status` INT NOT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate;";

        $sql[] = "ALTER TABLE " . $this->table_name . "  ADD CONSTRAINT `Projects_fk0` FOREIGN KEY (`assigned_to`) REFERENCES `$users_table`(`ID`);";
        $sql[] = "ALTER TABLE " . $this->table_name . " ADD CONSTRAINT `Projects_fk1` FOREIGN KEY (`status`) REFERENCES `$project_statuses_table`(`id`);";
        
        dbDelta( $sql );
		update_option( $this->table_name . '_db_version', $this->version );
	}
}