<?php
/**
 * 导航菜单-列表
 */

if(!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}


$nav_arr =  $wdb->select("{$wconfig['db']['tablepre']}nav",
    array("nid", "pid", "level", "name", "status"),
    array("ORDER"=>array(
        "listorder" => "ASC",
        "nid" => "ASC"
    ))
);

include W_ROOT_PATH . '/app/admin/nav/nav.inc.php';
$nav_list = set_nav_level($nav_arr);
unset($nav_arr);

include $wconfig['theme_path'] . '/admin/nav/list.html.php';
