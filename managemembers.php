<?php 
/**
 * Plugin Name: Manage website visitor members 
 * Description: Let visitors to register them in the website for business purposes
 * Version: 1.0
 */

 spl_autoload_register(function (string $className) {
   $path = str_replace('\\', '/', $className);
   $classPath = __DIR__ . "/$path" . ".php";
   if (file_exists($classPath)) {
       require $classPath;
   }
});


require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/managemembers_plugin/php/helpers/utils_api_requests.php';
require __DIR__ . '/managemembers_plugin/php/Plugin.php';
require __DIR__ . '/managemembers_plugin/php/api/update_member.php';
require __DIR__ . '/managemembers_plugin/php/menus/manage_members.php';
require __DIR__ . '/managemembers_plugin/php/api/register_members.php';
require __DIR__ . '/managemembers_plugin/php/api/get_members.php';
require __DIR__ . '/managemembers_plugin/php/actions/functions/login_action.php';

use managemembers_plugin\php\actions\classes\EnqueueScript;
use managemembers_plugin\php\actions\classes\EnqueueStyle;





// Enqueue JS scripts
// $enqueue_scripts = new EnqueueScript('front-page',[
//    [
//       'name' => 'manage-members-bundle-js',
//       'path_uri' => plugins_url('dist/m.js',__FILE__),
//       'deps' => [],
//       'version' => '1.0',
//       'args' => ['strategy'=>'defer'],
//    ],
// ]);
// $enqueue_scripts->run();

$enqueue_admin_scripts = new EnqueueScript('admin',[
  [
   'name'=>'manage-members-bundle-js',
   'path_uri'=>plugins_url('dist/manageMember.bundle.js',__FILE__),
   'deps'=>[],
   'version'=>'1.0',
   'args'=>[]
  ]
]);
$enqueue_admin_scripts->run();

$enqueue_admin_styles = new EnqueueStyle('admin',[
   [
   'name'=>'manage-members-styles-css',
   'path_uri'=>plugins_url('dist/main.css',__FILE__),
   'deps'=>[],
   'version'=>'1.0',
   'media'=>'all'
   ],
]);
$enqueue_admin_styles->run();


register_activation_hook(__FILE__,['Plugin','plugin_activation']);
register_deactivation_hook(__FILE__,['Plugin','plugin_deactivation']);
