<?php
/**
 * 文章分类删除
 */

if(!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}

$formtoken = isset($_GET['formtoken']) ? trim($_GET['formtoken']) : '';
if( $formtoken != $wuser->formtoken ) {
    exit('{"status":0, "msg":"非法操作"}');
}

//exit('{"status":0, "msg":"^_^系统不允许删除，如果不想使用了，可以修改分类为不显示"}');


$cid      = isset($_GET['cid']) ? intval($_GET['cid']) : 0;

$category = $wdb->get("{$wconfig['db']['tablepre']}article_category","name", array("cid"=>$cid));
if( empty($category) ) {
    exit('{"status":0, "msg":"该ID分类不存在"}');
}

$article = $wdb->get("{$wconfig['db']['tablepre']}article","*", array("cid"=>$cid));
if( !empty($article) ) {
    exit('{"status":0, "msg":"该ID分类存在文章，不能删除"}');
}


$sql_del = $wdb->delete("{$wconfig['db']['tablepre']}article_category", array("cid"=>$cid));
if( $sql_del) {
    $wuser->actionlog("删除文章分类：". $category['name']);
    exit('{"status":1, "msg":"操作成功"}');
} else {
    exit('{"status":0, "msg":"操作失败"}');
}

// 目前删除上级，下级没删掉
// 改进：递归 下级 提示后全删掉   或   简单的检测是否有下级，手动逐一删除