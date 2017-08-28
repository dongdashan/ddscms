<?php
/**
 * 角色添加
 */

if(!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}

$formtoken = isset($_POST['formtoken']) ? trim($_POST['formtoken']) : '';
if( $formtoken != $wuser->formtoken ) {
    exit('{"status":0, "msg":"非法操作"}');
}

$rolename = isset($_POST['rolename']) ? trim($_POST['rolename'])  : '';
if( empty($rolename) ) {
    exit('{"status":0, "msg":"角色名称不能为空"}');
}


$result=$wdb->insert("{$wconfig['db']['tablepre']}role",
    array(
        "status"=>"1",
        "rolename"=>$rolename,
        "permission"=>""
    )
);
if($result ) {
    $wuser->actionlog('添加角色：'. $rolename);
    exit('{"status":1, "msg":"操作成功"}');
} else {
    exit('{"status":0, "msg":"操作失败"}');
}
