<?php

namespace managemembers_plugin\php\actions\classes;

use managemembers_plugin\php\interfaces\Action;

class EnqueueStyle implements Action
{

    protected array $styles;
    protected string $type;

    public function __construct(string $type, array $styles)
    {
        $this->styles = $styles;
        $this->type = $type;
    }

    private function add_styles()
    {
    foreach ($this->styles as $style) {

            extract($style, EXTR_OVERWRITE);

            if($this->type==='admin'){
                wp_register_style($name,$path_uri,$deps,$version,$media);
                wp_enqueue_style($name);
            }else{
                wp_enqueue_style($name, $path_uri, $deps, $version, $media);
            }

           
        }
    }

    #[\Override]
    public function run(): void
    {

        if($this->type ==='admin') {
        
          add_action('admin_enqueue_scripts', $this->add_styles(...));
            
        }else{
            add_action('wp_enqueue_scripts', $this->add_styles(...));
        }

    }

}
