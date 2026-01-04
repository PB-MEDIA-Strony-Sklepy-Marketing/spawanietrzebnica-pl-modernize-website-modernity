<?php 
defined( 'ABSPATH' ) || exit;
return array (
  'speed_optimization' => 
  array (
    'act_cache' => 1,
    'add_expires' => 1,
    'clean_cache' => 1,
    'clean_cache_each_params' => 1,
    'devices' => 
    array (
      'cache_desktop' => 1,
      'cache_tablet' => 1,
      'cache_mobile' => 1,
    ),
    'query_strings' => 1,
    'cleanup_on_save' => 1,
    'disable_page' => 
    array (
      0 => '',
    ),
    'remove_rest_api' => 1,
    'remove_rss_feed' => 1,
    'cache_external_script' => 1,
  ),
  'disable_page' => 
  array (
    0 => '',
  ),
  'homepage' => 'https://spawanietrzebnica.pl',
  'disable_per_adminuser' => 0,
  'disable_roles' => 
  array (
  ),
); 
