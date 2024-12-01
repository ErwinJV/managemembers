<?php 

namespace managemembers_plugin\php\actions;

use managemembers_plugin\php\interfaces\Action;

class RegisterSidebar implements Action {

   private array $settings;

   public function __construct(array $settings)
   {
      $this->settings = $settings;
   }

   private function add_sidebars()
   {
     foreach($this->settings as $setting){
          
        register_sidebar($setting);

     }
   }


    #[\Override]
    public function run():void
    {
        add_action('widgets_init',$this->add_sidebars(...));
    }
     
}