<?php 

class WP_Project_Milestones_Singleton extends WP_UnitTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->class_instance = WP_Project_Milestones::get_instance();

    }

    public function test_singleton_class()
    {
        $result = $this->class_instance instanceof WP_Project_Milestones;
        $expected = true;
        $this->assertEquals($expected, $result);
    }

}