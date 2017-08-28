<?php
/**
 * 导航菜单添加
 */

if(!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}

if( !isset($_POST['target']) ) {
    
    /**
     * 导航菜单添加-页面
     */

    $nav_arr = $wdb->select("{$wconfig['db']['tablepre']}nav",
        array("nid", "pid", "level", "name", "status"),
        array("status"=>'1'),
        array("ORDER"=>array(
            "listorder" => "ASC",
            "nid" => "ASC"
        ))
    );
    
    include W_ROOT_PATH . '/app/admin/nav/nav.inc.php';
    $nav_list = set_nav_level($nav_arr);
    unset($nav_arr);
    
    include $wconfig['theme_path'] . '/admin/nav/add.html.php';
    
} else {
    
    /**
     * 导航菜单添加-保存数据
     */
    $formtoken = isset($_POST['formtoken']) ? trim($_POST['formtoken']) : '';
    if( $formtoken != $wuser->formtoken ) {
        exit('{"status":0, "msg":"非法操作"}');
    }
    
    $pid         = isset($_POST['pid']) ? intval($_POST['pid']) : 0;
    $name        = isset($_POST['name']) ?  trim($_POST['name'])  : '';
    $status      = isset($_POST['status']) ? intval($_POST['status']) : 0;
    $listorder   = isset($_POST['listorder']) ? intval($_POST['listorder']) : 0;
    $internal    = isset($_POST['internal']) ? intval($_POST['internal']) : 0;
    $url         = isset($_POST['url']) ?  trim($_POST['url'])  : '';
    $target      = isset($_POST['target']) ? intval($_POST['target']) : 0;

    $description = isset($_POST['description']) ?  trim($_POST['description'])  : '';

    $language='cn';
    $pic_pc   = isset($_POST['pic_pc']) ?  trim($_POST['pic_pc'])  : '';
    $pic_wap   = isset($_POST['pic_wap']) ?  trim($_POST['pic_wap'])  : '';
    
    if( empty($name) ) {
        exit('{"status":0, "msg":"名称不能为空"}');
    }
    if( empty($url) ) {
        exit('{"status":0, "msg":"导航链接不能为空"}');
    }
    
    // 同名检查...
    
    $pic = '';
    if( $pic_id > 0 ) {
        $sql     = "SELECT `id`, `uid`, `filepath` FROM `{$wconfig['db']['tablepre']}upload` WHERE `id`='{$pic_id}'";
        $pic_row = $wdb->get_row($sql);
        $pic     = isset($pic_row['filepath']) ? $pic_row['filepath'] : '';
    }
    
    $level = 1;
    
    if( $pid > 0 ) {
        $sql = $sql = "SELECT `nid`, `pid`, `level`, `name` FROM `{$wconfig['db']['tablepre']}nav` WHERE `nid`='{$pid}'";
        $parent = $wdb->get_row($sql);
        // 目前只支持3级
        if( !empty($parent) ) {
            if( $parent['level'] < 3 ) {
                $level = $parent['level'] + 1;
            } else {
                $pid   = $parent['pid'];
                $level = $parent['level'];
            }
        }
    }
    if($level > 3) {
        exit('{"status":0, "msg":"目前只支持3级"}');
    }
    

    $insert_id=$wdb->insert("{$wconfig['db']['tablepre']}nav",array(
        "pid"=>$pid,
        "level"=>$level,
        "name"=>$name,
        "status"=>$status,
        "listorder"=>$listorder,
        "internal"=> $internal,
        "url"=>$url,
        "target"=>$target,
        "pic_pc"=>$pic_pc,
        "pic_wap"=>$pic_wap,
        "description"=>$description,

        "language"=>$language

    ));
    if( $insert_id) {

        $wuser->actionlog("添加了导航：". $name);
        exit('{"status":1, "msg":"操作成功"}');
    } else {
        exit('{"status":0, "msg":"操作失败"}');
    }
    
}
