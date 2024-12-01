<?php 

namespace includes\helpers;

use \WP_Query;

class Paginate {

    private int $max_pages = 999999;
    public WP_Query $posts;
    public array $args;
    
    public function __construct($args=array())
    {
      
      $this->args = $args;
    }

    public function set_posts(WP_Query $posts)
    {
      $this->posts = $posts;
    }


    public function get_pagination()
    {
        if(!$this->posts){
          return;
        }

        $args = array(
          'base'=> str_replace($this->max_pages,'%#%',esc_url(get_pagenum_link($this->max_pages))),
          'format'=>'?paged=%#%',
          'current' => max(1,get_query_var('paged')),
          'show_all'=>false,
          'end_size'=>1,
          'mind_size'=>2,
          'prev_next'=>true,
          'prev_text'=>'<<',
          'next_text'=>'>>',
          'type'=>'plain',
          'add_args'=>false,
          'add_fragment'=>'',
          'before_page_number'=>'',
          'after_page_number'=>'',
          'type'=>'array',
          'total'=>$this->posts->max_num_pages,
          ...$this->args
        );

    $pages = paginate_links($args);

    if( is_array( $pages ) ) {
    
        echo '<br/><div class="w-full"><ul class="flex flex-row justify-center">';
        foreach ( $pages as $page ) {
                echo "<li class='p-2 text-2xl font-medium' >$page</li>";
        }
        echo '</ul></div>';
        }

       
    }



    public function search_posts_pagination()
    {
      the_posts_pagination();
    }

    public function paginate_comments()
    {
      the_comments_pagination(array(
          'prev_text'=>'<span class="screen-reader-text">'.__('Previous','sushi').'</span>',
          'next_text'=>'<span class="screen-reader-text">'.__('Next ','sushi').'</span>'
      )
    );
    }

  
}