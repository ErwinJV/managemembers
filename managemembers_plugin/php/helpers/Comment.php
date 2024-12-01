<?php 
namespace includes\helpers;

class Comment {
     
    public function view_comments($comment,$args,$depth)
    {
          $GLOBALS['comment'] = $comment;

          switch($comment->comment_type){
            case 'pingback':
            case 'trackback':
        ?>

        <li class="comment">
            <p>
                <?php _e('Pingback',SITE_NAME); ?> <?php comment_author_link(); ?>
                <?php edit_comment_link(__('Edit',SITE_NAME),' ') ?>
            </p>
        </li>
        <?php

           break;
           default:
        ?>
         
         <li <?php comment_class('comment p-3 bg-green-200'); ?> id="li-comment-<?php comment_ID(); ?>" >
            <article id="comment-<?php comment_ID(); ?>">
                <div class="comment-meta">
                    <div class="comment-author vcard">
                         <?php
                           $args = [
                              'class'=> 'avatar avatar-60 photo'
                           ];
                          echo get_avatar($comment,60);

                         ?>

                         <?php 
                            printf(__('<b class="fn">%s</b> <span class="says hide">says:</span>',SITE_NAME),
                            sprintf('<cite class="fn">%s</cite>',get_comment_author_link()));
                            ;
                         ?>

                         <div class="comment-context">
                            <?php comment_text(); ?>
                         </div>

                          <div class="comment-metadata">
                            <a href="<?php echo esc_url(get_comment_link($comment->comment_ID));?>">
                               <time pubdate datetime="<?php comment_time('c'); ?>">
                                  <?php
                                    printf(
                                        __('%1$s at %2$s', SITE_NAME ),
                                        get_comment_date(),
                                        get_comment_time()
                                    );
                                  ?>
                               </time>
                            </a>
                            <?php edit_comment_link(__('(Edit)',SITE_NAME),' '); ?>
                          </div>

                          <div class="reply">
                            <?php comment_reply_link(array_merge($args,['depth'=>$depth])); ?>
                          </div>

                          <?php if($comment->comment_approved == '0'): ?>
                               <em><?php _e('Your comment is awaiting moderation.',SITE_NAME); ?></em>
                          <?php endif; ?>
                    </div>
                </div>
            </article>
         </li>
          
        <?php
        
          
          }
    }
}