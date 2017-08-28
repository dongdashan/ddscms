<?php
/**
 * 文章分类列表
 */

if(!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}

include W_ROOT_PATH . '/lib/w_extend.func.php';


$categories = $wdb->select("{$wconfig['db']['tablepre']}article_category",array("cid","pid","name","status","displayorder"));

$categories = w_category_tree_html($categories);

include $wconfig['theme_path'] . '/admin/article/categorylist.html.php';
