<?php
/**
 * 文章添加
 */

if(!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}


if( !isset($_POST['name']) ) {

    $modelid = isset($_GET['modelid']) ? intval($_GET['modelid']) : 0;
    if( $modelid < 1 ) {
        w_error('错误，非法索引ID');
    }

    $models = $wdb->get("{$wconfig['db']['tablepre']}model",array("modelid","modelname"),array("modelid"=>$modelid));
    if( empty($models) ) {
        w_error('模型不存在');
    }

    // 返回上一页URL定义
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '?m=article&a=list';


    include $wconfig['theme_path'] . '/admin/model/fieldadd.html.php';
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
    $modelid         = isset($_POST['modelid']) ? intval($_POST['modelid']) : 1;

    $name        = isset($_POST['name']) ?  trim($_POST['name'])  : '';
    $field     = isset($_POST['field']) ?  trim($_POST['field'])  : '';
    $type       = isset($_POST['formtype']) ?  trim($_POST['formtype'])  : '';
    $tips       = isset($_POST['tips']) ?  trim($_POST['tips'])  : '';
    $disabled       = isset($_POST['disabled']) ? intval($_POST['disabled']) : 1;

    $setting       = isset($_POST['setting']) ?  $_POST['setting']  : '';


  /*  function arrayLevel($arr){
        $al = array(0);
        function aL($arr,&$al,$level=0){
            if(is_array($arr)){
                $level++;
                $al[] = $level;
                foreach($arr as $v){
                    aL($v,$al,$level);
                }
            }
        }
        aL($arr,$al);
        return max($al);
    }
    $s11=arrayLevel($setting);

    $ddd=array(
        "status"=>"0",
        "msg"=>$s11
    );
    $ddd=json_encode($ddd);
    exit($ddd);*/
    switch($type){
        case "editor":
            $formtype="编辑框";
            break;
        case "input":
            $formtype="单行文本";
            break;
        case "textarea":
            $formtype="多行文本";
            break;
        case "select":
            $formtype="下拉选项框";
            break;
        case "radio":
            $formtype="单选框";
            break;
        case "checkbox":
            $formtype="复选框";
            break;
        case "image":
            $formtype="单图上传";
            break;
        case "file":
            $formtype="文件上传";
            break;
        case "files":
            $formtype="多文件上传";
            break;
    }
    
    // 输入检查
    if( empty($name) ) {
        exit('{"status":0, "msg":"字段别名不能为空"}');
    }

    if( empty($field) ) {
        exit('{"status":0, "msg":"字段名称不能为空"}');
    }

    if( empty($formtype) ) {
        exit('{"status":0, "msg":"输入类型不能为空"}');
    }


    $row=$wdb->get("{$wconfig['db']['tablepre']}model_field","field",array("field"=>$field));
     if(!empty($row)){
         exit('{"status":0, "msg":"该字段已经存在"}');
     }

    // 保存数据

    $insert_id=$wdb->insert("{$wconfig['db']['tablepre']}model_field",array(
        "modelid"=>$modelid,
        "name"=>$name,
        "field"=>$field,
        "type"=>$type,
        "formtype"=>$formtype,
        "disabled"=>$disabled,
        "tips"=>$tips,
        "setting"=>$setting

    ));
    //  medoo 数组自动序列化  使用 insert  upadte
    if( $insert_id){

      /*  $wdb->query(" ");*/


        // 返回成功消息
        exit('{"status":1, "msg":"操作成功"}');
    } else {
        exit('{"status":0, "msg":"操作失败"}');
    }
    
}
