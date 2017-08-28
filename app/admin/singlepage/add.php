<?php
/**
 * 单页添加
 */

if(!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}

if( !isset($_POST['title']) ) {
    
    /**
     * 单页添加-页面
     */
    include $wconfig['theme_path'] . '/admin/singlepage/add.html.php';
    
} else {
    
    /**
     * 单页添加-数据入库
     */
    
    // 安全验证
    $formtoken = isset($_POST['formtoken']) ? trim($_POST['formtoken']) : '';
    if( $formtoken != $wuser->formtoken ) {
        exit('{"status":0, "msg":"非法操作"}');
    }
    
    // 接收数据
    $title        = isset($_POST['title']) ?  trim($_POST['title'])  : '';
    $subtitle     = isset($_POST['subtitle']) ?  trim($_POST['subtitle'])  : '';
    
    $status       = isset($_POST['status']) ? intval($_POST['status']) : 1;
    $displayorder = isset($_POST['displayorder']) ? intval($_POST['displayorder']) : 10;
    

    $jumpurl      = isset($_POST['jumpurl']) ?  trim($_POST['jumpurl'])  : '';
    
    $keywords     = isset($_POST['keywords']) ?  trim($_POST['keywords'])  : '';
    $description  = isset($_POST['description']) ?  trim($_POST['description'])  : '';

    $language='cn';
    $pic_pc   = isset($_POST['pic_pc']) ?  trim($_POST['pic_pc'])  : '';
    $pic_wap   = isset($_POST['pic_wap']) ?  trim($_POST['pic_wap'])  : '';
    $pccontent     = isset($_POST['pccontent']) ?  $_POST['pccontent']  : '';
    $wapcontent     = isset($_POST['wapcontent']) ?  $_POST['wapcontent']  : '';
    
    // 输入检查
    if( empty($title) ) {
        exit('{"status":0, "msg":"标题不能为空"}');
    }

    

    // 保存数据


    $insert_id=$wdb->insert("{$wconfig['db']['tablepre']}singlepage",array(
        "status"=>$status,
        "displayorder"=>$displayorder,
        "title"=> $title ,
        "subtitle"=> $subtitle ,
        "keywords"=> $keywords ,
        "description"=> $description ,
        "hits"=>"0",
        "hitstime"=>"0",
        "createtime"=>W_TIMESTAMP,
        "updatetime"=>W_TIMESTAMP,
        "jumpurl"=>$jumpurl,
        "editor"=>$wuser->username,
        "language"=>$language,
        "pic_pc"=>$pic_pc,
        "pic_wap"=>$pic_wap,
    ));
    if( $insert_id ) {


        $wdb->insert("{$wconfig['db']['tablepre']}singlepage_content",array(
            "spid"=>$insert_id,
            "content"=>$pccontent,
            "ispc"=>'pc',
            "language"=>$language
        ));
        $wdb->insert("{$wconfig['db']['tablepre']}singlepage_content",array(
            "spid"=>$insert_id,
            "content"=>$wapcontent,
            "ispc"=>'wap',
            "language"=>$language
        ));

        // 增加管理记录
        $wuser->actionlog("添加了单页：". $title);
        // 返回成功消息
        exit('{"status":1, "msg":"操作成功"}');
    } else {
        exit('{"status":0, "msg":"操作失败"}');
    }
    
}
