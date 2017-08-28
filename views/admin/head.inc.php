<?php
if( !defined('IN_WEIZEPHP') ) {
    exit('Access Denied');
}
function admin_head($title) {
    global $wconfig;
    $head = <<<EOT
<meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
        <title>{$title}</title>
        <link rel="stylesheet" href="{$wconfig['public_path']}/bootstrap-3.3.7/css/bootstrap.min.css"/>
<link rel="stylesheet" href="{$wconfig['public_path']}/layui/css/layui.css" />
        <link rel="stylesheet" href="{$wconfig['theme_admin']}/css/global.css"/>
        <link rel="stylesheet" href="{$wconfig['theme_admin']}/css/admin.css"/>
        <link rel="stylesheet" type="text/css" href="{$wconfig['public_path']}/webuploader/webuploader.css"/>
        <link rel="stylesheet" type="text/css" href="{$wconfig['theme_admin']}/css/w-webuploader.css"/>
        <script>
        // 当前页不允许在框架(iframe)下显示
        if(window.top != window.self) {
            window.top.location = window.self.location;
        }
        </script>
        <script src="{$wconfig['public_path']}/js/jquery-1.12.4.min.js"></script>
        <script src="{$wconfig['public_path']}//bootstrap-3.3.7/js/bootstrap.min.js"></script>
        <script src="{$wconfig['theme_admin']}/js/jQuery.Huifold.js"></script>
    <link rel="stylesheet" href="{$wconfig['public_path']}/kindeditor4.1.100/themes/default/default.css" />
    <link rel="stylesheet" href="{$wconfig['public_path']}/kindeditor4.1.100/plugins/code/prettify.css" />
    <script charset="utf-8" src="{$wconfig['public_path']}/kindeditor4.1.100/kindeditor-all-min.js"></script>
    <script charset="utf-8" src="{$wconfig['public_path']}/kindeditor4.1.100/lang/zh_CN.js"></script>
    <script charset="utf-8" src="{$wconfig['public_path']}/kindeditor4.1.100/plugins/code/prettify.js"></script>


    <script charset="utf-8" src="{$wconfig['public_path']}/layui/layui.js"></script>


EOT;
    return $head;
}