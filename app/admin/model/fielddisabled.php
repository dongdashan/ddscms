<?php
/**
 *  更新
 */

if (!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}

// 接收参数
$fieldid = isset($_GET['fieldid']) ? intval($_GET['fieldid']) : 0;
if ($fieldid < 1) {
    w_error('错误，非法索引ID');
}


$row = $wdb->get("{$wconfig['db']['tablepre']}model_field", "disabled",
    array(
        "fieldid" => $fieldid
    )
);

$disabled=$row["disabled"]==1?0:1;

// 保存数据
$result = $wdb->update("{$wconfig['db']['tablepre']}model_field",
    array(
        "disabled" => $disabled
    ),
    array(
        "fieldid" => $fieldid
    )
);
if ($result) {

    // 返回成功消息
    turl($_SERVER["HTTP_REFERER"]);
} else {
    msgurl("操作失败",$_SERVER["HTTP_REFERER"]);
}
    
