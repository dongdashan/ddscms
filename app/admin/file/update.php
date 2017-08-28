<?php
/**
 * 文章更新
 */

if(!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}

if( !isset($_POST['title']) ) {
    
    /**
     * 文章更新-页面
     */
    
    // 接收参数
    $aid = isset($_GET['aid']) ? intval($_GET['aid']) : 0;
    if( $aid < 1 ) {
        w_error('错误，非法索引ID');
    }
    
    // 载入扩展函数
    include W_ROOT_PATH . '/lib/w_extend.func.php';
    
    // 载入图像处理类
    include W_ROOT_PATH . '/lib/w_image.class.php';
    
    // 获取分类树
    $categories = $wdb->select("{$wconfig['db']['tablepre']}article_category",
        array("cid", "pid", "name", "status", "displayorder"),
        array("status"=>'1')
    );
    $categories = w_category_tree_html($categories);
    
    // 获取文章

    $row = $wdb->get("{$wconfig['db']['tablepre']}article","*",array("aid"=>$aid));
    if( empty($row) ) {
        w_error('抱歉，找不到文章，或者文章已经被删除');
    }


    $content =  $wdb->get("{$wconfig['db']['tablepre']}article_content","*",array("AND"=>array("aid"=>$aid,"ispc"=>"pc")));
    $row['pccontent'] = $content['content'];

    $content =  $wdb->get("{$wconfig['db']['tablepre']}article_content","*",array("AND"=>array("aid"=>$aid,"ispc"=>"wap")));
    $row['wapcontent'] = $content['content'];

    unset($content);
    
    // htmlspecialchars安全处理
    foreach( $row as $k => $v ) {
        if( $k != 'pccontent' && $k != 'wapcontent' ) {
            $row[$k] = htmlspecialchars($v);
        }
    }


    
    // 封面图地址处理
    /*$pic = '';
    if( !empty($row['pic']) ) {
        $pic = w_image::thumbcache('./' . $row['pic'], 100, 100);
    }*/
    
    // 返回上一页URL定义
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '?m=article&a=list';
    
    // 包含模板
    include $wconfig['theme_path'] . '/admin/article/update.html.php';
    
} else {
    
    /**
     * 文章更新-数据入库
     */
    
    // 安全验证
    $formtoken = isset($_POST['formtoken']) ? trim($_POST['formtoken']) : '';
    if( $formtoken != $wuser->formtoken ) {
        exit('{"status":0, "msg":"非法操作"}');
    }
    
    // 接收数据
    // 1、已使用PDO的queto  为SQL语句中的字符串添加引号或者转义特殊字符串。
// get或者post 无需 使用addslashes()

    $aid          = isset($_POST['aid']) ?  trim($_POST['aid'])  : '';
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
    if( $aid < 1 ) {
        exit('{"status":0, "msg":"错误，非法索引ID"}');
    }
    
    if( empty($title) ) {
        exit('{"status":0, "msg":"标题不能为空"}');
    }
    if( $cid < 1 ) {
        exit('{"status":0, "msg":"分类必须"}');
    }

    // 读取旧数据

    $old = $wdb->select("{$wconfig['db']['tablepre']}article",
        array("aid", "cid", "status", "title"),
        array("aid"=>$aid)
    );
    if( empty($old) ) {
        exit('{"status":0, "msg":"抱歉，找不到文章，或者文章已经被删除，无需操作"}');
    }

    
    // 保存数据

    $result=$wdb->update("{$wconfig['db']['tablepre']}article",
        array(
            "cid"=>$cid,
            "status"=>$status,
            "displayorder"=>$displayorder,
            "title"=>$title,
            "subtitle"=>$subtitle,
            "keywords"=>$keywords,
            "description"=>$description,
            "updatetime"=>W_TIMESTAMP,
            "jumpurl"=>$jumpurl,
            "source"=>$source,
            "sourceurl"=>$sourceurl,
            "editor"=> $wuser->username,
            "pic_pc"=>$pic_pc,
            "pic_wap"=>$pic_wap
        ),
        array(
            "aid"=>$aid
        )
    );
    if($result ) {
        // 更新内容

        $wdb->update("{$wconfig['db']['tablepre']}article_content",
            array(
                "content"=>$pccontent
            ),
            array("AND"=>array(
                "aid"=>$aid,
                "ispc"=>'pc'
            ))

        );

        $wdb->update("{$wconfig['db']['tablepre']}article_content",
            array(
                "content"=>$wapcontent
            ),
            array("AND"=>array(
                "aid"=>$aid,
                "ispc"=>'wap'
            ))
        );

        // 增加管理记录
        if( $old['title'] != $title ) {
            $wuser->actionlog('把文章“'. $old['title'] .'”更新为：'. $title);
        } else {
            $wuser->actionlog("更新了文章：". $title);
        }
        // 返回成功消息
        exit('{"status":1, "msg":"操作成功"}');
    } else {
        exit('{"status":0, "msg":"操作失败"}');
    }
    
}
