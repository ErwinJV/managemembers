<?php

namespace managemembers_plugin\php\actions;

use managemembers_plugin\php\interfaces\Action;

class EnqueueScript implements Action {

    protected array $scripts;
    protected string $type;
     
    public function __construct(string $type,array $scripts)
     {
         $this->scripts = $scripts;
         $this->type = $type;

     }

     private function add_scripts()
     {
         foreach($this->scripts as $script)
         {
            extract($script,EXTR_OVERWRITE);
            wp_enqueue_script($name,$path_uri,$deps,$version,$args);
         }
     }

     #[\Override] 
     public function run(): void
     { 
        if($this->type ==='admin'){
            add_action('admin_enqueue_scripts', $this->add_scripts(...)); 
        }else{
            add_action('wp_enqueue_scripts', $this->add_scripts(...));
        }
        
     }



}