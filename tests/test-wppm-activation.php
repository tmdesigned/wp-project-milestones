<?php 

class WP_Project_Milestones_Singleton extends WP_UnitTestCase{

    
    public function setUp(){
    
        parent::setUp();

        $this->class_instance = WP_Project_Milestones::get_instance();

    }


    /**
     * Simple test for existance of class
     */
    public function test_singleton_class(){

        $result = $this->class_instance instanceof WP_Project_Milestones;
        $expected = true;
        $this->assertEquals($expected, $result);

    }


    /**
     * Test project status table
     * 
     * Test existance of temporary table by writing value and reading value
     * Value is read when attemping to add second time
     */
    public function test_project_status_db(){

        $this->class_instance->db->create_tables();

        $status = new WPPM_Project_Status;
        $status->title = "test_title";

        //Inserting a status should return a status ID
        $first_result = $this->class_instance->db->add_project_status( $status );
        $this->assertGreaterThan( 0, $first_result );

        //Inserting the same status should return false (already exists)
        $second_result = $this->class_instance->db->add_project_status( $status );
        $this->assertFalse( $second_result );
        
    }

}