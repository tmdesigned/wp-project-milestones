<?php

class WPPM_Milestones_DB extends WPPM_DB {

    /**
     * Get things started
     *
     * @access  public
     * @since   1.0
    */
    public function __construct() {
        global $wpdb;
        $this->table_name  = $wpdb->prefix . 'wppm_milestones';
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
			'project_id'	=> '%d',
			'title'			=> '%s',
			'status'		=> '%d',
			'original_start' => '%s',
			'original_due' 	=> '%s',
			'adjusted_start' => '%s',
			'adjusted_due' => '%s',
			'completed'  => '%s',
			'modified'  => '%s',
			'modified_by'  => '%d'
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
			'project_id'	=> 0,
			'title'			=> '',
			'status'		=> 0,
			'original_start' => '1000-01-01',
			'original_due' 	=> '1000-01-01',
			'adjusted_start' => '1000-01-01',
			'adjusted_due' => '1000-01-01',
			'completed'  => null,
			'modified'  => '1000-01-01',
			'modified_by'  => 0
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
		$projects_table = $wpdb->prefix . "wppm_projects";
		$milestone_statuses_table = $wpdb->prefix . "wppm_milestones_statuses";
		
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        
        $sql = array();
        
        $sql[] = "CREATE TABLE " . $this->table_name . " (
            `id` INT NOT NULL AUTO_INCREMENT,
            `project_id` INT NOT NULL,
            `status` INT NOT NULL,
            `title` TEXT NOT NULL,
            `original_start` DATE NOT NULL,
            `original_due` DATE NOT NULL,
            `adjusted_start` DATE NOT NULL,
            `adjusted_due` DATE NOT NULL,
            `completed` DATE,
            `modified` DATE NOT NULL,
            `modified_by` DATE NOT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate;";

        $sql[] = "ALTER TABLE " . $this->table_name . "  ADD CONSTRAINT `Milestones_fk2` FOREIGN KEY (`modified_by`) REFERENCES `$users_table`(`id`);";
        $sql[] = "ALTER TABLE " . $this->table_name . "  ADD CONSTRAINT `Milestones_fk0` FOREIGN KEY (`project_id`) REFERENCES `$projects_table`(`id`);";
        $sql[] = "ALTER TABLE " . $this->table_name . "  ADD CONSTRAINT `Milestones_fk1` FOREIGN KEY (`status`) REFERENCES `$milestone_statuses_table`(`id`);";

		dbDelta( $sql );
		update_option( $this->table_name . '_db_version', $this->version );
	}
}