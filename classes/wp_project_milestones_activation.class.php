<?php

class WP_Project_Milestones_Activation{

    function __construct(){

    }

    function activate(){
        
        self::create_tables();

    }

    function create_tables(){

        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $users_table = $wpdb->prefix . "Users";

        $prefix = $wpdb->prefix . "WPPM_";

        $projects_table = $prefix . "Projects";
        $project_statuses_table = $prefix . "Project_Statuses";
        $milestones_table = $prefix . "Milestones";
        $milestone_statuses_table = $prefix . "Milestone_Statuses";
        $milestone_items_table = $prefix . "Milestone_Items";
        $project_meta_table = $prefix . "Project_Meta";

        $sql = array();

        $sql[] = "CREATE TABLE `$projects_table` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `title` TEXT NOT NULL,
            `name` TEXT NOT NULL,
            `assigned_to` INT NOT NULL,
            `status` INT NOT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate;";

        $sql[] = "CREATE TABLE `$project_statuses_table` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `title` TEXT NOT NULL,
            PRIMARY KEY (`id`)
        );";

        $sql[] = "CREATE TABLE `$milestones_table` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `project_id` INT NOT NULL,
            `status` INT NOT NULL,
            `title` TEXT NOT NULL,
            `original_start` DATE NOT NULL,
            `original_due` DATE NOT NULL,
            `adjusted_start` DATE NOT NULL,
            `adjusted_due` DATE NOT NULL,
            `completed` DATE NOT NULL,
            `modified` DATE NOT NULL,
            `modified_by` DATE NOT NULL,
            PRIMARY KEY (`id`)
        );";

        $sql[] = "CREATE TABLE `$milestone_statuses_table` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `title` TEXT NOT NULL,
            PRIMARY KEY (`id`)
        );";

        $sql[] = "CREATE TABLE `$milestone_items_table` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `milestone_id` INT NOT NULL,
            `title` TEXT NOT NULL,
            `date` DATE NOT NULL,
            `note` TEXT NOT NULL,
            `modified` DATE NOT NULL,
            `modified_by` TEXT NOT NULL,
            PRIMARY KEY (`id`)
        );";

        $sql[] = "CREATE TABLE `$project_meta_table` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` TEXT NOT NULL,
            `value` TEXT NOT NULL,
            `created` DATE NOT NULL,
            PRIMARY KEY (`id`)
        );";

        $sql[] = "ALTER TABLE `$projects_table` ADD CONSTRAINT `Projects_fk0` FOREIGN KEY (`assigned_to`) REFERENCES `$users_table`(`id`);";

        $sql[] = "ALTER TABLE `$projects_table` ADD CONSTRAINT `Projects_fk1` FOREIGN KEY (`status`) REFERENCES `$project_statuses_table`(`id`);";

        $sql[] = "ALTER TABLE `$milestones_table` ADD CONSTRAINT `Milestones_fk0` FOREIGN KEY (`project_id`) REFERENCES `$projects_table`(`id`);";

        $sql[] = "ALTER TABLE `$milestones_table` ADD CONSTRAINT `Milestones_fk1` FOREIGN KEY (`status`) REFERENCES `$milestone_statuses_table`(`id`);";

        $sql[] = "ALTER TABLE `$milestones_table` ADD CONSTRAINT `Milestones_fk2` FOREIGN KEY (`modified_by`) REFERENCES `$users_table`(`id`);";

        $sql[] = "ALTER TABLE `$milestone_items_table` ADD CONSTRAINT `MilestoneItems_fk0` FOREIGN KEY (`milestone_id`) REFERENCES `$milestones_table`(`id`);";

        $sql[] = "ALTER TABLE `$milestone_items_table` ADD CONSTRAINT `MilestoneItems_fk1` FOREIGN KEY (`modified_by`) REFERENCES `$users_table`(`id`);";

        $sql[] = "ALTER TABLE `$project_meta_table` ADD CONSTRAINT `ProjectMeta_fk0` FOREIGN KEY (`id`) REFERENCES `$projects_table`(`id`);";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }
}