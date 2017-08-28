<?php
/**
 * 文章列表
 */

if(!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}

$modelid = isset($_GET['modelid']) ? intval($_GET['modelid']) : 0;
if( $modelid < 1 ) {
    w_error('错误，非法索引ID');
}

// 包含扩展函数
include W_ROOT_PATH . '/lib/w_extend.func.php';

$models = $wdb->get("{$wconfig['db']['tablepre']}model","*",array("modelid"=>$modelid));
$models["setting"]=string2array($models["setting"]);
$default_field = $models["setting"]["default"];

$fields = $wdb->select("{$wconfig['db']['tablepre']}model_field","*");


// 包含模板
include $wconfig['theme_path'] . '/admin/model/fieldlist.html.php';
