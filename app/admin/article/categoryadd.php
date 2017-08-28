<?php
/**
 * 文章分类添加
 */

if(!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}

if( !isset($_POST['name']) ) {
    
    /**
     * 文章分类添加-页面
     */
    include W_ROOT_PATH . '/lib/w_extend.func.php';

    $categories = $wdb->select("{$wconfig['db']['tablepre']}article_category",
        array("cid", "pid", "name", "status", "displayorder")
    );
    $categories = w_category_tree_html($categories);
    include $wconfig['theme_path'] . '/admin/article/categoryadd.html.php';
    
} else {
    
    /**
     * 文章分类添加-数据入库
     */
    $formtoken = isset($_POST['formtoken']) ? trim($_POST['formtoken']) : '';
    if( $formtoken != $wuser->formtoken ) {
        exit('{"status":0, "msg":"非法操作"}');
    }
    
    $pid            = isset($_POST['pid'])            ? intval($_POST['pid']) : 0;
    $name           = isset($_POST['name'])           ? addslashes(trim($_POST['name'])) : '';
    $status         = isset($_POST['status'])         ? intval($_POST['status']) : 0;
    $displayorder   = isset($_POST['displayorder'])   ? intval($_POST['displayorder']) : 1;
    $pic_pc   = isset($_POST['pic_pc']) ? addslashes(trim($_POST['pic_pc'])) : '';
    $pic_wap   = isset($_POST['pic_wap']) ? addslashes(trim($_POST['pic_wap'])) : '';
    $seotitle       = isset($_POST['seotitle'])       ? addslashes(trim($_POST['seotitle'])) : '';
    $seokeywords    = isset($_POST['seokeywords'])    ? addslashes(trim($_POST['seokeywords'])) : '';
    $seodescription = isset($_POST['seodescription']) ? addslashes(trim($_POST['seodescription'])) : '';
    $language='cn';
    
    if( empty($name) ) {
        exit('{"status":0, "msg":"分类名称不能为空"}');
    }

    // 同名分类
   /*
    $row = $wdb->get("{$wconfig['db']['tablepre']}article_category","cid",array("name"=>$name));
    if( !empty($row) ) {
        exit('{"status":0, "msg":"同名分类已经存在"}');
    }*/
    

    $result=$wdb->insert("{$wconfig['db']['tablepre']}article_category",array(
        "pid"=>$pid,
        "name"=>$name,
        "status"=>$status,
        "pic_pc"=>$pic_pc,
        "pic_wap"=>$pic_wap,
        "displayorder"=>$displayorder,
        "seotitle"=>$seotitle,
        "seokeywords"=>$seokeywords,
        "seodescription"=>$seodescription,
        "language"=>$language
    ));
    if($result) {
        $wuser->actionlog("添加文章分类：". $name);
        exit('{"status":1, "msg":"操作成功"}');
    } else {
        exit('{"status":0, "msg":"操作失败"}');
    }
    
}
