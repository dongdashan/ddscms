<?php
/**
 * 文章添加
 */

if(!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}

if( !isset($_POST['pic_pc']) ) {
    
    /**
     * 文章添加-页面
     */
    include W_ROOT_PATH . '/lib/w_extend.func.php';

    $categories = $wdb->select("{$wconfig['db']['tablepre']}upload_category",
        array("cid", "pid", "name", "status", "displayorder"),
        array("status"=>'1')
    );
    $categories = w_category_tree_html($categories);
    include $wconfig['theme_path'] . '/admin/file/add.html.php';
    
} else {
    
    /**
     * 文章添加-数据入库
     */
    
    // 安全验证
    $formtoken = isset($_POST['formtoken']) ? trim($_POST['formtoken']) : '';
    if( $formtoken != $wuser->formtoken ) {
        exit('{"status":0, "msg":"非法操作"}');
    }
    
    // 接收数据
    $cid          = isset($_POST['cid']) ? intval($_POST['cid']) : 0;
    $pic_pc   = isset($_POST['pic_pc']) ?  trim($_POST['pic_pc'])  : '';

    
    // 输入检查
    if( empty($pic_pc) ) {
        exit('{"status":0, "msg":"附件不能为空"}');
    }
    if( $cid < 1 ) {
        exit('{"status":0, "msg":"分类必须"}');
    }

    

    // 保存数据
    $getimg=w_getimg_info($pic_pc);
    if( !empty($pic_pc) && !empty($getimg) ) {
        $insert_id=$wdb->insert("{$wconfig['db']['tablepre']}upload",array(
            "cid"=>$cid,
            "uid"=>"",
            "uploadtime"=>W_TIMESTAMP,
            "format"=>$getimg["format"],
            "relformat"=>$getimg["relformat"],
            "filepath"=>$getimg["filepath"],
            "basename"=>$getimg["basename"],
            "filesize"=>$getimg["size"],
            "width"=>$getimg["width"],
            "height"=>$getimg["height"],
        ));

        if( $insert_id) {


            exit('{"status":1, "msg":"操作成功"}');
        } else {
            exit('{"status":0, "msg":"操作失败"}');
        }
    }



}
