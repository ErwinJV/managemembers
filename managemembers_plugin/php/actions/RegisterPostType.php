<?php 

namespace managemembers_plugin\php\actions;

use managemembers_plugin\php\interfaces\Action;

class RegisterPostType implements Action {
      protected array $settings;

      public function __construct($settings)
      {
        $this->settings = $settings;
      }


      private function add_custom_post_types():void
      {
        foreach ( $this->settings as $type =>  $data ) {

			$labels = array(
				'name'                  => _x( ucfirst( $type ), 'Post Type General Name',PLUGIN_SITE_NAME),
				'singular_name'         => _x( ucfirst( $type ), 'Post Type Singular Name',PLUGIN_SITE_NAME),
				'menu_name'             => __( ucfirst( $data['plural'] ),PLUGIN_SITE_NAME ),
				'name_admin_bar'        => __( ucfirst( $data['plural'] ), PLUGIN_SITE_NAME),
				'archives'              => __( 'Archive ' . $data['plural'], PLUGIN_SITE_NAME ),
				'attributes'            => __( 'Attributes ' . $type, PLUGIN_SITE_NAME ),
				'parent_item_colon'     => __( ucfirst( $data['plural'] ) . ' padre:', PLUGIN_SITE_NAME ),
				'all_items'             => __( 'All', PLUGIN_SITE_NAME ),
				'add_new_item'          => __( 'Add new', PLUGIN_SITE_NAME ),
				'add_new'               => __( 'Add', PLUGIN_SITE_NAME ),
				'new_item'              => __( 'New', PLUGIN_SITE_NAME ),
				'edit_item'             => __( 'Edit', PLUGIN_SITE_NAME ),
				'update_item'           => __( 'Update', PLUGIN_SITE_NAME ),
				'view_item'             => __( 'See ' . $type, PLUGIN_SITE_NAME ),
				'view_items'            => __( 'See ' . $data['plural'], PLUGIN_SITE_NAME ),
				'search_items'          => __( 'Search ' . $type, PLUGIN_SITE_NAME ),
				'insert_into_item'      => __( 'Insert ' . $type, PLUGIN_SITE_NAME ),
				'uploaded_to_this_item' => __( 'Upload ' . $type, PLUGIN_SITE_NAME ),
				'items_list'            => __( 'List ' . $type, PLUGIN_SITE_NAME ),
				'items_list_navigation' => __( 'Navigation ' . $data['plural'], PLUGIN_SITE_NAME ),
				'filter_items_list'     => __( 'Filter ' . $data['plural'], PLUGIN_SITE_NAME ),
				'not_found'=>__('No found','sushi'),
				'not_found_in_trash'=>__('Not found in trash','sushi')
			);

			$rewrite = array(
				'slug'       => $data['slug'] ?? $type,
				'with_front' => true,
				'pages'      => true,
				'feeds'      => true,
			);

			$supports = array(
				'title',        // Post title
				'editor',       // Post content
				'excerpt',      // Allows short description
				'author',       // Allows showing and choosing author
				'thumbnail',    // Allows feature images
				'comments',     // Enables comments
				'trackbacks',   // Supports trackbacks
				'revisions',    // Shows autosaved version of the posts
				'custom-fields' // Supports by custom fields
			);

			$args = array(
				'label'               => __( ucfirst($type), PLUGIN_SITE_NAME ),
				'description'         => __( 'Content of ' . $data['plural'], PLUGIN_SITE_NAME ),
				'labels'              => $labels,
				'supports'            => $supports,
				//'taxonomies'          => $data['taxonomies'] ?? [],
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 5,
				'menu_icon'           => $data['icon'],
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'rewrite'             => $rewrite,
				'capability_type'     => 'page',
				'show_in_rest'        => true,
				
				'rest_base'          => $type.'-api',
				'rest_controller_class' => 'WP_REST_Posts_Controller'
			);

			register_post_type( 'cpt-'.$type, $args );

			flush_rewrite_rules();
		}
		
	
      }

      #[\Override]
	  public function run():void
	  {
		add_action('init',$this->add_custom_post_types(...));
	  }
}