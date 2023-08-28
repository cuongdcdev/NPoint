<?php 

function get_mycred_points_history(){
    if(current_user_can("administrator")){
        return do_shortcode('[mycred_history]');
    }else{
        return do_shortcode('[mycred_history user_id="current"]');
    }
}
