<?php
namespace managemembers_plugin\php\widgets;

use \WP_Widget;

class ExampleWidget extends WP_Widget
{

    public function __construct()
    {
        $widget_options = [
            'classname' => 'sushi-varieties-widget',
            'description' => __('Widget for display  example widget', SITE_NAME),
        ];

      

        parent::__construct('sushi_varieties', __('Example widget', SITE_NAME), $widget_options);

    }

    public function form($instance)
    {


    }

    public function update($new_instance, $old_instance)
    {
       return $new_instance;
    }

    public function widget($args, $instance)
    {
    

    }



}
