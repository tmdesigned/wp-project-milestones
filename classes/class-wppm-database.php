<?php 

class WPPM_Database{

    
    protected $projects_db;
    protected $project_meta_db;
    protected $project_statuses_db;
    protected $milestones_db;
    protected $milestone_items_db;
    protected $milestone_statuses_db;


    public function __construct(){

        $this->projects_db = new WPPM_Projects_DB;
        $this->project_meta_db = new WPPM_Project_Meta_DB;
        $this->project_statuses_db = new WPPM_Project_Statuses_DB;
        $this->milestones_db = new WPPM_Milestones_DB;
        $this->milestone_items_db = new WPPM_Milestone_Items_DB;
        $this->milestone_statuses_db = new WPPM_Milestone_Statuses_DB;

    }


    /**
     * Initial creation / updating of tables
     */
    public function create_tables(){

        $this->projects_db->create_table();
        $this->project_meta_db->create_table();
        $this->project_statuses_db->create_table();
        $this->milestones_db->create_table();
        $this->milestone_items_db->create_table();
        $this->milestone_statuses_db->create_table();

    }
}