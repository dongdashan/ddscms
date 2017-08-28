<?php
/**
 * 文章添加
 */

if(!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}

if( !isset($_POST['title']) ) {
    
    /**
     * 文章添加-页面
     */
    include W_ROOT_PATH . '/lib/w_extend.func.php';

    $categories = $wdb->select("{$wconfig['db']['tablepre']}article_category",
        array("cid", "pid", "name", "status", "displayorder"),
        array("status"=>'1')
    );
    $categories = w_category_tree_html($categories);
    include $wconfig['theme_path'] . '/admin/article/add.html.php';
    
} else {
    
    /**
     * 文章添加-数据入库
     */
    
    // 安全验证
    $formtoken = isset($_POST['formtoken']) ? trim($_POST['formtoken']) : '';
    if( $formtoken != $wuser->formtoken ) {
        exit('{"status":0, "msg":"非法操作"}');
    }
    
    // 接收数据
    $cid          = isset($_POST['cid']) ? intval($_POST['cid']) : 0;
    $status       = isset($_POST['status']) ? intval($_POST['status']) : 1;
    $displayorder = isset($_POST['displayorder']) ? intval($_POST['displayorder']) : 10;

    $title        = isset($_POST['title']) ?  trim($_POST['title'])  : '';
    $subtitle     = isset($_POST['subtitle']) ?  trim($_POST['subtitle'])  : '';

    $jumpurl      = isset($_POST['jumpurl']) ?  trim($_POST['jumpurl'])  : '';
    $source       = isset($_POST['source']) ?  trim($_POST['source'])  : '';
    $sourceurl    = isset($_POST['sourceurl']) ?  trim($_POST['sourceurl'])  : '';
    $keywords     = isset($_POST['keywords']) ?  trim($_POST['keywords'])  : '';
    $description  = isset($_POST['description']) ? trim($_POST['description']): '';

    $language='cn';
    $pic_pc   = isset($_POST['pic_pc']) ?  trim($_POST['pic_pc'])  : '';
    $pic_wap   = isset($_POST['pic_wap']) ?  trim($_POST['pic_wap'])  : '';
    $pccontent     = isset($_POST['pccontent']) ?  $_POST['pccontent']  : '';
    $wapcontent     = isset($_POST['wapcontent']) ?  $_POST['wapcontent']  : '';
    
    // 输入检查
    if( empty($title) ) {
        exit('{"status":0, "msg":"标题不能为空"}');
    }
    if( $cid < 1 ) {
        exit('{"status":0, "msg":"分类必须"}');
    }

    

    // 保存数据

    $insert_id=$wdb->insert("{$wconfig['db']['tablepre']}article",array(
        "cid"=>$cid,
        "status"=>$status,
        "displayorder"=>$displayorder,
        "title"=>$title,
        "subtitle"=>$subtitle,
        "keywords"=>$keywords,
        "description"=>$description,
        "pic_pc"=>$pic_pc,
        "pic_wap"=>$pic_wap,
        "hits"=>"0",
        "hitstime"=>"0",
        "createtime"=>W_TIMESTAMP,
        "updatetime"=>W_TIMESTAMP,
        "jumpurl"=>$jumpurl,
        "source"=>$source,
        "sourceurl"=>$sourceurl,
        "editor"=>$wuser->username,
        "language"=>$language

    ));
    if( $insert_id) {

        $getimg=w_getimg_info($pic_pc);
        if( !empty($pic_pc) && !empty($getimg) ) {
             $wdb->insert("{$wconfig['db']['tablepre']}upload",array(
                 "cid"=>"1",
                 "uid"=>"",
                 "uploadtime"=>W_TIMESTAMP,
                 "format"=>$getimg["format"],
                 "relformat"=>$getimg["relformat"],
                 "filepath"=>$getimg["filepath"],
                 "basename"=>$getimg["basename"],
                 "filesize"=>$getimg["size"],
                 "width"=>$getimg["width"],
                 "height"=>$getimg["height"],
             ));
         }

       $getimg=w_getimg_info($pic_wap);
        if( !empty($pic_wap) && !empty($getimg) ) {
            $wdb->insert("{$wconfig['db']['tablepre']}upload",array(
                "cid"=>"1",
                "uid"=>"",
                "uploadtime"=>W_TIMESTAMP,
                "format"=>$getimg["format"],
                "relformat"=>$getimg["relformat"],
                "filepath"=>$getimg["filepath"],
                "basename"=>$getimg["basename"],
                "filesize"=>$getimg["size"],
                "width"=>$getimg["width"],
                "height"=>$getimg["height"],
            ));
        }

         $wdb->insert("{$wconfig['db']['tablepre']}article_content",array(
            "aid"=>$insert_id,
            "content"=>$pccontent,
             "ispc"=>'pc',
             "language"=>$language
        ));
        $wdb->insert("{$wconfig['db']['tablepre']}article_content",array(
            "aid"=>$insert_id,
            "content"=>$wapcontent,
            "ispc"=>'wap',
            "language"=>$language
        ));

        // 增加管理记录
        $wuser->actionlog("添加了文章：". $title);
        // 返回成功消息
        exit('{"status":1, "msg":"操作成功"}');
    } else {
        exit('{"status":0, "msg":"操作失败"}');
    }
    
}
