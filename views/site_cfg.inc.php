<?php
/**
 * 网站配置
 */
if( !defined('IN_WEIZEPHP') ) {
    exit('Access Denied');
}


$list_cfg = $wdb->select("{$wconfig['db']['tablepre']}config","ckey","cvalue");

$site_cfg = array();
foreach($list_cfg as $val) {
    $site_cfg[$val['ckey']] = htmlspecialchars($val['cvalue']);
}

unset($sql_cfg, $list_cfg);