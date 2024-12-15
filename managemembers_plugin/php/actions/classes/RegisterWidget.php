<?php 

namespace managemembers_plugin\php\actions\classes;

use managemembers_plugin\php\interfaces\Action;

class RegisterWidget implements Action {

    private array $widgets;
     
    public function __construct(array $widgets)
    {
        $this->widgets = $widgets;
    }

    private function add_widgets()
    {
       foreach($this->widgets as $widget){
          register_widget($widget);
       }
      
    }

    #[\Override] 
    public function run():void
    {
        add_action('widgets_init',$this->add_widgets(...));
    }
}
