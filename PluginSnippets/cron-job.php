<?php
/**
 * add method to register event to WordPress init
 */
add_action( 'init', 'register_daily_notify_user_send_email_event');
 
/**
 * this method will register the cron event
 */
function register_daily_notify_user_send_email_event() {
    // make sure this event is not scheduled
    if( !wp_next_scheduled( 'notify_user_send_email' ) ) {
        // schedule an event
        wp_schedule_event( time(), 'daily', 'notify_user_send_email' );
    }
}
 
/**
 * notify_user_send_email method will be call when the cron is executed
 */
add_action( 'notify_user_send_email', 'notify_all_user_send_email' );
 
/**
 * this method will call when cron executes
 */
function notify_all_user_send_email() {
    //here you can build logic and email to all users	
    //send email to admin
    wp_mail( 'user@yoursite.com', 'wordpress tutorial', 'Visit my blog for wordpress tutorial ...!');
}

http://scripthere.com/how-to-setup-cron-job-in-wordpress-without-plugin/




function custom_cron_job_recurrence( $schedules ) 
{
    if(!isset($schedules['10sec']))
    {
        $schedules['10sec'] = array(
            'display' => __( 'Every 10 Seconds', 'twentyfifteen' ),
            'interval' => 10,
        );
    }
     
    if(!isset($schedules['15sec']))
    {
        $schedules['15sec'] = array(
        'display' => __( 'Every 15 Seconds', 'twentyfifteen' ),
        'interval' => 15,
        );
    }
     
    return $schedules;
}
add_filter( 'cron_schedules', 'custom_cron_job_recurrence' );
