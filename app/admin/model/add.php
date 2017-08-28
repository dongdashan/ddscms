<?php
/**
 * 文章添加
 */

if(!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}

if( !isset($_POST['modelname']) ) {
    
    /**
     * 文章添加-页面
     */
    include W_ROOT_PATH . '/lib/w_extend.func.php';



    include $wconfig['theme_path'] . '/admin/model/add.html.php';
} else {
    
    /**
     * 文章添加-数据入库
     */
    include W_ROOT_PATH . '/app/admin/model/setting.php';

    // 安全验证
    $formtoken = isset($_POST['formtoken']) ? trim($_POST['formtoken']) : '';
    if( $formtoken != $wuser->formtoken ) {
        exit('{"status":0, "msg":"非法操作"}');
    }
    
    // 接收数据
    $typeid          = isset($_POST['typeid']) ? intval($_POST['cid']) : 1;

    $modelname        = isset($_POST['modelname']) ?  trim($_POST['modelname'])  : '';
    $tablename     = isset($_POST['tablename']) ?  trim($_POST['tablename'])  : '';
    $categorytpl       = isset($_POST['categorytpl']) ?  trim($_POST['categorytpl'])  : '';
    $listtpl     = isset($_POST['listtpl']) ?  trim($_POST['listtpl'])  : '';
    $showtpl        = isset($_POST['showtpl']) ?  trim($_POST['showtpl'])  : '';

    $setting_model=array2string($setting_model);
    $setting_field=array2string($setting_field);
    
    // 输入检查
    if( empty($modelname) ) {
        exit('{"status":0, "msg":"模型名称不能为空"}');
    }

    if( empty($tablename) ) {
        exit('{"status":0, "msg":"模型表名不能为空"}');
    }

    if( empty($categorytpl) ) {
        exit('{"status":0, "msg":"栏目模板不能为空"}');
    }

    if( empty($listtpl) ) {
        exit('{"status":0, "msg":"列表模板不能为空"}');
    }

    if( empty($showtpl) ) {
        exit('{"status":0, "msg":"内容模板不能为空"}');
    }

    $row=$wdb->get("{$wconfig['db']['tablepre']}model","tablename",array("tablename"=>$tablename));
     if(!empty($row)){
         exit('{"status":0, "msg":"模型表名已经存在"}');
     }

    // 保存数据

    $insert_id=$wdb->insert("{$wconfig['db']['tablepre']}model",array(
        "typeid"=>$typeid,
        "modelname"=>$modelname,
        "tablename"=>$tablename,
        "categorytpl"=>$categorytpl,
        "listtpl"=>$listtpl,
        "showtpl"=>$showtpl,
        "setting"=>$setting_model

    ));
    if( $insert_id){

        $wdb->query("CREATE TABLE `w_content_{$tablename}` (
  `aid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT 'ID',
  `cid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `content` text NOT NULL COMMENT '内容',
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;");


    $wdb->insert("{$wconfig['db']['tablepre']}model_field",array(
            "modelid"=>$insert_id,
            "field"=>"content",
            "name"=>"内容",
            "type"=>"text",
            "isshow"=>"1",
            "formtype"=>"编辑器",
            "disabled"=>"1",
            "setting"=>$setting_field

        ));

        // 返回成功消息
        exit('{"status":1, "msg":"操作成功"}');
    } else {
        exit('{"status":0, "msg":"操作失败"}');
    }
    
}
