<?php 

const START_DATE = 'start_date';
const END_DATE = 'end_date';

function calendar_metaboxes_html($post)
{
   $start_date = get_post_meta($post->ID,START_DATE,true);
   $end_date = get_post_meta($post->ID,END_DATE,true);

   ?>
    <div class="form-group">
        <label for="<?php echo START_DATE; ?>">
            <?php echo str_replace('_',' ',ucfirst(START_DATE)); ?>
        </label>
        <input type="datetime-local" 
               name="<?php echo START_DATE; ?>" 
               id="<?php echo START_DATE; ?>" 
               value="<?php echo esc_attr($start_date); ?>" 
        />
    </div>

    <div class="form-group">
        <label for="<?php echo END_DATE; ?>">
            <?php echo str_replace('_',' ',ucfirst(END_DATE)); ?>
        </label>
        <input type="datetime-local" 
               name="<?php echo END_DATE; ?>" 
               id="<?php echo END_DATE; ?>" 
               value="<?php echo esc_attr($end_date); ?>" 
        />
    </div>
    <style>
        .form-group{
             display: flex;
             flex-direction: column;
             margin-bottom: 10px;
             width: 90%;
        }

        @media(min-width:500px){
            .form-group{
                width: 298px;
            }
        }
    </style>
   <?php
}

function add_calendar_metaboxes()
{
    add_meta_box('calendar_metaboxes','Dates','calendar_metaboxes_html',['post'],'normal','high');
}

add_action('add_meta_boxes','add_calendar_metaboxes');


function save_calendar_metaboxes($post_id)
{
    if(!current_user_can('edit_post',$post_id))
    {
        return;
    }

    if ( isset( $_POST[START_DATE] ) ) {
        update_post_meta( $post_id, START_DATE, sanitize_text_field( $_POST[START_DATE] ) );
    }

    if ( isset( $_POST[END_DATE] ) ) {
        update_post_meta( $post_id, END_DATE, sanitize_text_field( $_POST[END_DATE] ) );
    }
}

add_action('save_post','save_calendar_metaboxes');





