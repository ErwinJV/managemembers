<?php

function calendar_posts_shortcode()
{
    return "<div id='calendarPosts' ><div>";
}

add_shortcode('calendar_posts','calendar_posts_shortcode');