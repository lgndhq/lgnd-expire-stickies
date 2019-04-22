<?php
 /**
  * Plugin Name: Expire Stickies
  * Description: Automatically expire sticky posts after a set period of days
  * Version: 1.0
  * Author: LGND
  * Author URI: https://lgnd.com
  * Contributors: mccahan
  */

define('LGND_EXPIRE_STICKIES_DAYS', 14);

function lgndCronActivation()
{
  if (!wp_next_scheduled('lgnd_expire_stickies'))
    wp_schedule_event(time()+30, 'hourly', 'lgnd_expire_stickies');
}
register_activation_hook(__FILE__, 'lgndCronActivation');

// Delete cronjob on deactivation
function lgndCronDeactivation()
{
  $time = wp_next_scheduled('lgnd_expire_stickies');
  wp_unschedule_event($time, 'lgnd_expire_stickies');
}
register_deactivation_hook(__FILE__, 'lgndCronDeactivation');

// Cronjob function
function lgndExpireStickiesCron()
{
  $before = time() - LGND_EXPIRE_STICKIES_DAYS*86400;
  $args = [
    'posts_per_page' => -1,
    'post__in' => get_option('sticky_posts'),
    'date_query' => [
      [
        'before' => [
          'year' => date('Y', $before),
          'month' => date('m', $before),
          'day' => date('d', $before)
        ]
      ]
    ]
  ];
  $query = new WP_Query($args);

  while ($query->have_posts())
  {
    $query->the_post();
    unstick_post(get_the_ID());
  }
  wp_reset_postdata();
}
add_action('lgnd_expire_stickies', 'lgndExpireStickiesCron');
