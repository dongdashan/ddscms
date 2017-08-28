<?php
/**
 * 文章删除
 */

if(!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}

// formtoken安全验证
$formtoken = isset($_GET['formtoken']) ? trim($_GET['formtoken']) : '';
if( $formtoken != $wuser->formtoken ) {
    exit('{"status":0, "msg":"非法操作"}');
}

// 不允许删除
//exit('{"status":0, "msg":"^_^系统不允许删除，如果不想使用了，可以修改为不显示"}');


// 接收参数
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if( $id < 1 ) {
    exit('{"status":0, "msg":"错误，非法索引ID"}');
}

// 获取标题,pic图片

$row = $wdb->get("{$wconfig['db']['tablepre']}upload","*",array("id"=>$id));

// 删除pic图片
if( !empty($row['filepath']) ) {
    if( is_file($row['filepath']) ) {
        unlink($row['filepath']);
        //clearstatcache();
    }else{

    }
}


// 删除数据库数据

 $sql_del =$wdb->delete("{$wconfig['db']['tablepre']}upload", array("id"=>$id));
if($sql_del ) {

    exit('{"status":1, "msg":"操作成功"}');
} else {
    exit('{"status":0, "msg":"操作失败"}');
}

