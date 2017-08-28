<?php
/**
 * 单页查看
 */

if( !defined('IN_WEIZEPHP') ) {
    exit('Access Denied');
}

$aid = isset($_GET['aid']) ? intval($_GET['aid']) : 0;
if($aid < 1) {
    w_error('非法索引ID', '?');
}



$wdb->update("{$wconfig['db']['tablepre']}article",
    array(
        "hits[+]"=>1,
        "hitstime"=>W_TIMESTAMP
    ),
    array(
        "aid"=>$aid
    )
);



$row = $wdb->get("{$wconfig['db']['tablepre']}article","*",array("aid"=>$aid));
if(empty($row)) {
    w_error('没有找到内容', '?');
}

$content =  $wdb->get("{$wconfig['db']['tablepre']}article_content","*",array("AND"=>array("aid"=>$aid,"ispc"=>"pc")));
$row['content'] = $content['content'];


unset($content);

// htmlspecialchars安全处理
foreach( $row as $k => $v ) {
    if( $k != 'content'   ) {
        $row[$k] = htmlspecialchars($v);
    }
}

include $wconfig['theme_path'] . '/pc/default/content/article/view.html.php';
