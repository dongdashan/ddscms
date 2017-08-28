<?php
/**
 * 网站配置
 */

if(!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}

$list = $wdb->select("{$wconfig['db']['tablepre']}config","*");

$site_cfg = array();
foreach($list as $val) {
    $site_cfg[$val['ckey']] = htmlspecialchars($val['cvalue']);
}

include $wconfig['theme_path'] . '/admin/system/config.html.php';
