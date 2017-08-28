<?php
/**
 * 文章分类更新
 */

if(!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}

if( !isset($_POST['name']) ) {
    
    /**
     * 文章分类更新-页面
     */
    include W_ROOT_PATH . '/lib/w_extend.func.php';
    include W_ROOT_PATH . '/lib/w_image.class.php';
    
    $cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;

    $categories = $wdb->select("{$wconfig['db']['tablepre']}article_category","*");
    
    $row = array();
    foreach($categories as $v) {
        if($v['cid'] == $cid) {
            $row = $v;
            break;
        }
    }
    
    if( empty($row) ) {
        w_error("没有该分类，请返回上一页");
    }
    
    foreach($row as $k => $v) {
        $row[$k] = htmlspecialchars($v);
    }
    
    $categories = w_category_tree_html($categories);
    
    foreach($categories as $k => $v) {
        if($v['cid'] == $cid) {
            unset($categories[$k]);
            break;
        }
    }


    /*if( !empty($row['pic_pc']) ) {
        $pic_pc = w_image::thumbcache('./' . $row['pic_pc'], 100, 100);
    }

    if( !empty($row['pic_wap']) ) {
        $pic_wap = w_image::thumbcache('./' . $row['pic_wap'], 100, 100);
    }*/
    
    include $wconfig['theme_path'] . '/admin/article/categoryupdate.html.php';
    
} else {
    
    /**
     * 文章分类更新-数据入库
     */
    $formtoken = isset($_POST['formtoken']) ? trim($_POST['formtoken']) : '';
    if( $formtoken != $wuser->formtoken ) {
        exit('{"status":0, "msg":"非法操作"}');
    }
    
    $cid            = isset($_POST['cid'])            ? intval($_POST['cid']) : 0;
    $pid            = isset($_POST['pid'])            ? intval($_POST['pid']) : 0;
    $name           = isset($_POST['name'])           ? addslashes(trim($_POST['name'])) : '';
    $status         = isset($_POST['status'])         ? intval($_POST['status']) : 0;
    $pic_pc   = isset($_POST['pic_pc']) ? addslashes(trim($_POST['pic_pc'])) : '';
    $pic_wap   = isset($_POST['pic_wap']) ? addslashes(trim($_POST['pic_wap'])) : '';
    $displayorder   = isset($_POST['displayorder'])   ? intval($_POST['displayorder']) : 1;
    $seotitle       = isset($_POST['seotitle'])       ? addslashes(trim($_POST['seotitle'])) : '';
    $seokeywords    = isset($_POST['seokeywords'])    ? addslashes(trim($_POST['seokeywords'])) : '';
    $seodescription = isset($_POST['seodescription']) ? addslashes(trim($_POST['seodescription'])) : '';
    

    
    if( empty($name) ) {
        exit('{"status":0, "msg":"分类名称不能为空"}');
    }
    if( $pid == $cid ) {
        exit('{"status":0, "msg":"上级分类不能选择自身"}');
    }
    

    $old = $wdb->select("{$wconfig['db']['tablepre']}article_category",array(
        "cid", "pid", "name", "pic"
    ),array(
        "cid"=> $cid
    ));



    $result=$wdb->update("{$wconfig['db']['tablepre']}article_category",array(
        "pid"=>$pid,
        "name"=>$name,
        "status"=>$status,
        "pic_pc"=>$pic_pc,
        "pic_wap"=>$pic_wap,
        "displayorder"=>$displayorder,
        "seotitle"=>$seotitle,
        "seokeywords"=>$seokeywords,
        "seodescription"=>$seodescription,
    ),array(
        "cid"=>$cid
    ));

    if($result) {
        if( $old['name'] != $name ) {
            $wuser->actionlog('把文章分类“'. $old['name'] .'”更新为：'. $name);
        } else {
            $wuser->actionlog('更新了文章分类：'. $name);
        }
        exit('{"status":1, "msg":"更新成功"}');
    } else {
        exit('{"status":0, "msg":"更新失败"}');
    }
    
}
