<?php
/**
 *  更新
 */

if(!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}

    // 接收参数
    $modelid = isset($_GET['modelid']) ? intval($_GET['modelid']) : 0;
    if( $modelid < 1 ) {
        w_error('错误，非法索引ID');
    }

    $name   = isset($_GET['name']) ? addslashes(trim($_GET['name'])) : '';

    $models = $wdb->get("{$wconfig['db']['tablepre']}model","*",array("modelid"=>$modelid));
    $setting=string2array($models["setting"]);

    $show =  $setting["default"][$name]["show"];

    $setting['default'][$name]['show'] = $show==1?0:1;

    // 保存数据
    $result=$wdb->update("{$wconfig['db']['tablepre']}model",
        array(
            "setting"=>array2string($setting)
        ),
        array(
            "modelid"=>$modelid
        )
    );
if ($result) {

    // 返回成功消息
    turl($_SERVER["HTTP_REFERER"]);
} else {
    msgurl("操作失败",$_SERVER["HTTP_REFERER"]);
}

    

