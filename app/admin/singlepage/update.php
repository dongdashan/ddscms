<?php
/**
 * 单页更新
 */

if(!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}

if( !isset($_POST['title']) ) {
    
    /**
     * 单页更新-页面
     */
    
    // 接收参数
    $spid = isset($_GET['spid']) ? intval($_GET['spid']) : 0;
    if( $spid < 1 ) {
        w_error('错误，非法索引ID');
    }
    
    // 载入图像处理类
    include W_ROOT_PATH . '/lib/w_image.class.php';
    
    // 获取数据

    $row = $wdb->get("{$wconfig['db']['tablepre']}singlepage","*",array("spid"=>$spid));

    if( empty($row) ) {
        w_error('抱歉，内容找不到，或者已经被删除');
    }
    
    // 获取内容

    $content =  $wdb->get("{$wconfig['db']['tablepre']}singlepage_content","*",array("AND"=>array("spid"=>$spid,"ispc"=>"pc")));
    $row['pccontent'] = $content['content'];

    $content =  $wdb->get("{$wconfig['db']['tablepre']}singlepage_content","*",array("AND"=>array("spid"=>$spid,"ispc"=>"wap")));
    $row['wapcontent'] = $content['content'];

    unset($content);
    
    // htmlspecialchars安全处理
    foreach( $row as $k => $v ) {
        if( $k != 'pccontent' && $k != 'wapcontent' ) {
            $row[$k] = htmlspecialchars($v);
        }
    }
    
    // 封面图地址处理
  /*  $pic = '';
    if( !empty($row['pic']) ) {
        $pic = w_image::thumbcache('./' . $row['pic'], 100, 100);
    }*/
    
    // 返回上一页URL定义
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '?m=singlepage&a=list';
    
    // 包含模板
    include $wconfig['theme_path'] . '/admin/singlepage/update.html.php';
    
} else {
    
    /**
     * 单页更新-数据入库
     */
    
    // 安全验证
    $formtoken = isset($_POST['formtoken']) ? trim($_POST['formtoken']) : '';
    if( $formtoken != $wuser->formtoken ) {
        exit('{"status":0, "msg":"非法操作"}');
    }
    
    // 接收数据
    $spid          = isset($_POST['spid']) ?  trim($_POST['spid'])  : '';
    
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
    if( $spid < 1 ) {
        exit('{"status":0, "msg":"错误，非法索引ID"}');
    }
    
    if( empty($title) ) {
        exit('{"status":0, "msg":"标题不能为空"}');
    }

    
    // 读取旧数据


    $old = $wdb->select("{$wconfig['db']['tablepre']}singlepage",
        array("spid",   "status", "title"),
        array("spid"=>$spid)
    );
    if( empty($old) ) {
        exit('{"status":0, "msg":"抱歉，内容找不到或者已经删除，无需操作"}');
    }
    

    
    // 保存数据

    $result=$wdb->update("{$wconfig['db']['tablepre']}singlepage",
        array(
            "status"=>$status,
            "displayorder"=>$displayorder,
            "title"=>$title,
            "subtitle"=>$subtitle,
            "keywords"=>$keywords,
            "description"=>$description,
            "updatetime"=>W_TIMESTAMP,
            "jumpurl"=>$jumpurl,
            "editor"=> $wuser->username,
            "pic_pc"=>$pic_pc,
            "pic_wap"=>$pic_wap
        ),
        array(
            "spid"=>$spid
        )
    );
    if( $result) {
        // 更新内容

        $wdb->update("{$wconfig['db']['tablepre']}singlepage_content",
            array(
                "content"=>$pccontent
            ),
            array("AND"=>array(
                "spid"=>$spid,
                "ispc"=>'pc'
            ))

        );

        $wdb->update("{$wconfig['db']['tablepre']}singlepage_content",
            array(
                "content"=>$wapcontent
            ),
            array("AND"=>array(
                "spid"=>$spid,
                "ispc"=>'wap'
            ))
        );

        // 增加管理记录
        if( $old['title'] != $title ) {
            $wuser->actionlog('把单页“'. $old['title'] .'”更新为：'. $title);
        } else {
            $wuser->actionlog("更新了单页：". $title);
        }
        // 返回成功消息
        exit('{"status":1, "msg":"操作成功"}');
    } else {
        exit('{"status":0, "msg":"操作失败"}');
    }
    
}
