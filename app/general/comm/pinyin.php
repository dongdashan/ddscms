<?php
/**
 *
 include_once 'Pinyin.php';
echo Pinyin::getPinyin("早上好");//获取拼音
echo Pinyin::getShortPinyin("早上好");//获取拼音缩写
 */

if(!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}


include W_ROOT_PATH . '/lib/Pinyin.php';

$title=addslashes(trim($_POST['title']));

echo Pinyin::getPinyin($title);