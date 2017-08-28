<?php
/**
 * 文章列表
 */

if(!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}



// 包含扩展函数
include W_ROOT_PATH . '/lib/w_extend.func.php';


$articles = $wdb->select("{$wconfig['db']['tablepre']}model","*");


// 包含模板
include $wconfig['theme_path'] . '/admin/model/list.html.php';
