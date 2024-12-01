<?php 

namespace managemembers_plugin\php\actions;

use managemembers_plugin\php\interfaces\Action;

class AddThemeSupport implements Action{
     
     private array $settings;

     public function __construct(array $settings)
     {
        $this->settings = $settings;
     }

    #[\Override]
    public function run():void
    {
      foreach($this->settings as $setting){
           if(is_array($setting)){
               add_theme_support(...$setting);  
           }else{
               add_theme_support($setting);
           }
           
      }   
    }
    
}

