<?php
/**
 * 用户列表
 */

if(!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}

// 获取用户
$sql   = "SELECT `uid`, `username`, `email`, `status`, `roleid`, `lastlogintime`, `lastloginip` FROM `{$wconfig['db']['tablepre']}user` ORDER BY `uid` DESC";
$users = $wdb->pagination($sql, 30);
$pagination_output = $wdb->pagination_output();

// 获取角色

$roles = $wdb->select("{$wconfig['db']['tablepre']}role","roleid","status","rolename");

// 获取用户对应的角色
foreach($users as $uk => $uv) {
    $users[$uk]['rolename'] = '未定义角色';
    foreach($roles as $rv) {
        if($uv['roleid'] == $rv['roleid']) {
            $users[$uk]['rolename'] = htmlspecialchars($rv['rolename']);
        }
    }
}

// 包含模板
include $wconfig['theme_path'] . '/admin/user/list.html.php';
