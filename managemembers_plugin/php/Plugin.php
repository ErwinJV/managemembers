<?php

namespace managemembers_plugin\php;

class Plugin
{

    static public function plugin_activation()
    {
        global $wpdb;
        $query = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}members(
                  `id` INT NOT NULL AUTO_INCREMENT,
                  `name` VARCHAR(40),
                  `last_name` VARCHAR(40),
                  `email` VARCHAR(40) UNIQUE,
                  `document` INT UNIQUE,
                  `member_status` VARCHAR(10),
                  `created` DATETIME,
                   PRIMARY KEY(`id`));";
        
        $wpdb->query($query);
    }

   static public function plugin_deactivation()
    {

    }
}
