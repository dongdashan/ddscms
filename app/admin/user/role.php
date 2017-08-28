<?php
/**
 * 角色管理
 */

if(!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}



$roles = $wdb->select("{$wconfig['db']['tablepre']}role",array("roleid","status","rolename") );
 foreach($roles as $k => $v) {
    $roles[$k]['rolename'] = htmlspecialchars($v['rolename']);
}

include $wconfig['theme_path'] . '/admin/user/role.html.php';
