<?php 

namespace managemembers_plugin\php\actions;

use managemembers_plugin\php\interfaces\Action;

class RegisterTaxonomy implements Action {
    private array $settings;
    public function __construct($settings)
    {
        $this->settings = $settings;

    }

    private function create_taxonomy():void
    {
        foreach($this->settings as $type => $data){
             $labels = array(
                'name'=>_x(ucfirst($type),'taxonomy general name',PLUGIN_SITE_NAME),
                'singular_name'=>_x(ucfirst($type),'taxonomy singular name',PLUGIN_SITE_NAME),
                'search_items'=>__("Search $type",PLUGIN_SITE_NAME),
                'all_items'=>__("All",'sushi',PLUGIN_SITE_NAME),
                'parent_item'=>__("Main $type",PLUGIN_SITE_NAME),
                'parent_item_colon'=>__("Main $type:",PLUGIN_SITE_NAME),
                'edit_item'=>__('Edit','sushi',PLUGIN_SITE_NAME),
                'update_item'=>__('Update',PLUGIN_SITE_NAME),
                'add_new_item'=>__('Add new',PLUGIN_SITE_NAME),
                'new_item_name'=>__('New name',PLUGIN_SITE_NAME),
                'menu_name'=>__(ucfirst($type),PLUGIN_SITE_NAME),
             );

             $args = array(
               'labels'=>$labels,
                ...$data['args'],
             );

             register_taxonomy(
                       $type,
                       
                       array(...$data['object_type']),
                       $args
                    );

           
        }
    }

    #[\Override]
    public function run():void
    {
        add_action('init',$this->create_taxonomy(...));
    }
}