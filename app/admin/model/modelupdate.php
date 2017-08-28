<?php
/**
 *  更新
 */

if(!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}

if( !isset($_POST['title']) ) {
    
    /**
     * 文章更新-页面
     */
    
    // 接收参数
    $modelid = isset($_GET['modelid']) ? intval($_GET['modelid']) : 0;
    if( $modelid < 1 ) {
        w_error('错误，非法索引ID');
    }

    $name   = isset($_GET['name']) ? addslashes(trim($_GET['name'])) : '';
    
    // 载入扩展函数
    include W_ROOT_PATH . '/lib/w_extend.func.php';

    $models = $wdb->get("{$wconfig['db']['tablepre']}model","*",array("modelid"=>$modelid));
    $setting=string2array($models["setting"]);
    $title = $setting["default"][$name]["name"];
    $show =  $setting["default"][$name]["show"];
    
    // 返回上一页URL定义
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '?m=model&a=list';
    
    // 包含模板
    include $wconfig['theme_path'] . '/admin/model/modelupdate.html.php';
    
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

    $modelid         = isset($_POST['modelid']) ?  intval($_POST['modelid'])  : '';
    $name        = isset($_POST['name']) ?  trim($_POST['name'])  : '';

    $title        = isset($_POST['title']) ?  trim($_POST['title'])  : '';
    $show       = isset($_POST['show']) ? intval($_POST['show']) : 1;

    $models = $wdb->get("{$wconfig['db']['tablepre']}model","*",array("modelid"=>$modelid));
    $setting=string2array($models["setting"]);

    $setting['default'][$name]['name'] = $title;
    $setting['default'][$name]['show'] = $show;



    // 输入检查
    if( $modelid < 1 ) {
        exit('{"status":0, "msg":"错误，非法索引ID"}');
    }
    
    if( empty($title) ) {
        exit('{"status":0, "msg":"标题不能为空"}');
    }


    // 保存数据
    $result=$wdb->update("{$wconfig['db']['tablepre']}model",
        array(
            "setting"=>array2string($setting)
        ),
        array(
            "modelid"=>$modelid
        )
    );
    if($result ) {

        // 返回成功消息
        exit('{"status":1, "msg":"操作成功"}');
    } else {
        exit('{"status":0, "msg":"操作失败"}');
    }
    
}
