<?php 

namespace managemembers_plugin\php\actions\classes;

use managemembers_plugin\php\interfaces\Action;

class RegisterNavMenu implements Action {

    protected array $settings;

    public function __construct($settings)
    {
        $this->settings = $settings;
    }

    private function add_menu():void
    {
       register_nav_menus($this->settings);  
    }

    #[\Override]
    public function run():void
    {
     add_action('init',$this->add_menu(...));    
    }


}