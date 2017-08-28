<?php
/**
 * +----------------------------------------------------------------------
 * | WeizePHP framework
 * +----------------------------------------------------------------------
 * | Copyright (c) 2013-2113 http://weizephp.75hh.com/ All rights reserved.
 * +----------------------------------------------------------------------
 * | Author: Ze Wei <E-mail:weizesw@gmail.com> <QQ:310472156>
 * +----------------------------------------------------------------------
 * | Description: 框架常用函数库
 * +----------------------------------------------------------------------
 */

if( !defined('IN_WEIZEPHP') ) {
    exit('Access Denied');
}

/** ------------------------------------------------------------------- */



function msg($msg){
    echo "<script>alert('{$msg}');</script>";
}

function msgurl($msg,$url){
    echo "<script>alert('{$msg}');</script>";
    echo "<script>window.location.href='{$url}';</script>";
}

function turl($url){
    echo "<script>window.location.href='{$url}';</script>";
}


/*
**
* 返回经stripslashes处理过的字符串或数组   删除反斜杠
*/
function new_stripslashes($string)
{
    if (!is_array($string)) return stripslashes($string);
    foreach ($string as $key => $val) $string[$key] = new_stripslashes($val);
    return $string;
}

/**
 * 将字符串转换为数组
 * @param	string	$data	字符串
 * @return	array	返回数组格式，如果，data为空，则返回空数组
 */
function string2array($data)
{
    if ($data == '') return array();
    return unserialize($data);
}



/**
 * 将数组转换为字符串
 * @param	array	$data		数组
 * @param	bool	$isformdata	如果为0，则不使用new_stripslashes处理，可选参数，默认为1
 * @return	string	返回字符串，如果，data为空，则返回空
 */
function array2string($data, $isformdata = 1) {
    if($data == '') return '';
    if($isformdata) $data = new_stripslashes($data);
    return serialize($data);
}





// 后台上传的 加入到w_upload表 列出图片信息
/* upload/img/234.jpg
 * dirname：文件路径  如：upload/img
 * basename：如：234.jpg
 * format：后缀  如：jpg
 * filename：文件名  如：234
 * relformat：真实格式
*/

function w_getimg_info($path){

    $path=substr($path, 1);  // 原图片路径 /uploadfile/other/image/20170826/20170826221816_97849.jpg  去除第一个斜杠
    if(is_file($path)){
    $img_info = getimagesize($path);
    $path_info = pathinfo($path);
    $size=ceil(filesize($path) / 1024);
    switch($img_info["2"]){
        case 1:
           $relformat="gif";
            break;
        case 2:
            $relformat="jpg";
            break;
        case 3:
            $relformat="png";
            break;
        case 4:
            $relformat="swf";
            break;
        case 5:
            $relformat="psd";
            break;
        case 6:
            $relformat="bmp";
            break;
        default:
            $relformat="";
    }
    $new_img_info=array(
        "dirname"=>$path_info["dirname"],
        "basename"=>$path_info["basename"],
        "filename"=>$path_info["filename"],
        "format"=>$path_info["extension"],
        "filepath"=>$path_info["dirname"].'/'.$path_info["basename"],
        "relformat"=>$relformat,
        "width"=>$img_info["0"],
        "height"=>$img_info["1"],
        "size"=>$size
    );



    }else{
        $new_img_info=array();
    }

    return $new_img_info;
}


/**
 * Un-quotes a quoted string 反引用一个引用字符串
 * @param string or array $string
 * @return string or array
 */
function w_stripslashes($string) {
    if(empty($string)) {
        return $string;
    }
    if(is_array($string)) {
        foreach($string as $key => $val) {
            $string[$key] = w_stripslashes($val);
        }
    } else {
        $string = stripslashes($string);
    }
    return $string;
}

/**
 * Quote string with slashes 使用反斜线引用字符串
 * @param string or array $string
 * @return string or array
 */
function w_addslashes($string) {
    if(empty($string)) {
        return $string;
    }
    if(is_array($string)) {
        foreach($string as $key => $val) {
            unset($string[$key]);
            $string[addslashes($key)] = w_addslashes($val);
        }
    } else {
        $string = addslashes($string);
    }
    return $string;
}

/** ------------------------------------------------------------------- */

/**
 * Get part of string 截取部分字符串
 * @param string $str
 * @param int $start
 * @param int $length
 * @param string $charset
 * @param boolean $suffix
 * @return string
 */
function w_substr($str, $start = 0, $length = 30, $charset = "utf-8", $suffix = false) {
    $suffix_str = $suffix ? '…' : '';
    if(function_exists('mb_substr')) {
        return mb_substr($str, $start, $length, $charset) . $suffix_str;
    } elseif(function_exists('iconv_substr')) {
        return iconv_substr($str, $start, $length, $charset) . $suffix_str;
    } else {
        $pattern = array();
        $pattern['utf-8'] = '/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/';
        $pattern['gb2312'] = '/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/';
        $pattern['gbk'] = '/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/';
        $pattern['big5'] = '/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/';
        preg_match_all($pattern[$charset], $str, $matches);
        $slice = implode("", array_slice($matches[0], $start, $length));
        return $slice . $suffix_str;
    }
}

/**
 * Count data sizes 数据大小统计
 * @param int $size
 * @return string
 */
function w_sizecount($size) {
    if($size >= 1073741824) {
        $size = round($size / 1073741824 * 100) / 100 . ' GB';
    } elseif($size >= 1048576) {
        $size = round($size / 1048576 * 100) / 100 . ' MB';
    } elseif($size >= 1024) {
        $size = round($size / 1024 * 100) / 100 . ' KB';
    } else {
        $size = $size . ' Bytes';
    }
    return $size;
}

/**
 * Get client ip 获取客户端IP
 * @return string
 */
function w_get_client_ip() {
    $ip = $_SERVER['REMOTE_ADDR'];
    if( isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP']) ) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches) ) {
        foreach ($matches[0] as $value_ip) {
            if (!preg_match('/^(10|172\.16|192\.168)\./', $value_ip)) {
                $ip = $value_ip;
                break;
            }
        }
    }
    return $ip;
}

/** ------------------------------------------------------------------- */

/**
 * Random string 生产随机字符串
 * @param int $length
 * @param string $chars
 * @return string
 */
function w_random($length = 6, $chars = '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ') {
    $hash = '';
    $max = strlen($chars) - 1;
    for($i = 0; $i < $length; $i++) {
        $hash .= $chars[mt_rand(0, $max)];
    }
    return $hash;
}

/** ------------------------------------------------------------------- */

/**
 * Sign 签名函数
 * @param array $array
 * @return string
 */
function w_sign($array) {
    sort($array);
    $string = "";
    foreach($array as $val) {
        $string .= $val;
    }
    return md5($string);
}

/** ------------------------------------------------------------------- */

/**
 * Replace language 语言替换
 * @param string $lang
 * @param array  $array
 * @return string
 *
 * Use：
 * $wlang['hello'] = '你好{name}';
 * $wlang['hello'] = w_lang($wlang['hello'], array('name'=>'韦泽')); // output：你好韦泽
 */
function w_lang($lang, $array = array()) {
    if(!empty($array)) {
        foreach($array as $key => $val) {
            $lang = str_replace('{'.$key.'}', $val, $lang);
        }
        return $lang;
    } else {
        return $lang;
    }
}

/** ------------------------------------------------------------------- */

/**
 * Send an error message to the defined error handling routines 记录系统发出的错误消息
 * @param int $errno
 * @param string $errstr
 * @param string $errfile
 * @param int $errline
 */
function w_error_log($errno, $errstr, $errfile, $errline) {
    $current_url = htmlspecialchars($_SERVER['REQUEST_URI']);
    $date        = date('Y-m-d H:i:s', W_TIMESTAMP);
    $message     = "<?php exit; ?> [Date]{$date} [URL]{$current_url} [ErrNO]{$errno} [ErrStr]{$errstr} [ErrFile]{$errfile} [ErrLine]{$errline}\n";
    error_log($message, 3, W_ROOT_PATH . '/data/log/' . date('Ymd', W_TIMESTAMP) . '_php_error.php');
}

/**
 * Defined error handler function 定义系统“错误处理函数”
 * @param int $errno
 * @param string $errstr
 * @param string $errfile
 * @param int $errline
 */
function w_error_handler($errno, $errstr, $errfile, $errline) {
    w_error_log($errno, $errstr, $errfile, $errline);
}

/**
 * Closes a previously opened database connection, 关闭以前打开的数据库连接，
 * and get the last occurred error. 和获取系统最后的错误。
 */
/*function w_shutdown() {
    if(isset($GLOBALS["wdb"])) {
        $GLOBALS["wdb"]->close();
    }
    $errinfo = error_get_last();
    if(!empty($errinfo) && isset($errinfo['type'])) {
        w_error_log($errinfo['type'], $errinfo['message'], $errinfo['file'], $errinfo['line']);
    }
}*/

/** ------------------------------------------------------------------- */

/**
 * Send a cookie 发送cookie到浏览器
 * @param string $name
 * @param string $value
 * @param int $expire
 * @param boolean $httponly
 */
function w_setcookie($name, $value, $expire = 0, $httponly = false) {
    global $wconfig;
    $secure = $_SERVER['SERVER_PORT'] == 443 ? true : false;
    $path   = $httponly && PHP_VERSION < '5.2.0' ? $wconfig['cookie']['path'] . '; HttpOnly' : $wconfig['cookie']['path'];
    if(PHP_VERSION < '5.2.0') {
        setcookie($name, $value, $expire, $path, $wconfig['cookie']['domain'], $secure);
    } else {
        setcookie($name, $value, $expire, $path, $wconfig['cookie']['domain'], $secure, $httponly);
    }
}

/** ------------------------------------------------------------------- */

/**
 * Success message 成功提示
 * @param string $message
 * @param string $url
 */
function w_success($message, $url = 'javascript:window.history.back();') {
    global $wconfig, $wlang;
    include $wconfig['theme_path'] . '/w_success.html.php';
    exit;
}

/**
 * Error message 错误提示
 * @param string $message
 * @param string $url
 */
function w_error($message, $url = 'javascript:window.history.back();') {
    global $wconfig, $wlang;
    include $wconfig['theme_path'] . '/w_error.html.php';
    exit;
}

function w_f5($message, $url = 'javascript:window.history.back();') {
    global $wconfig, $wlang;
    include $wconfig['theme_path'] . '/w_f5.html.php';
    exit;
}


function w_prefresh(){
    empty($_SERVER['HTTP_VIA']) or exit('Access Denied');
    $seconds = 3; //时间段[秒]
    $refresh = 16; //刷新次数
//设置监控变量
    $cur_time = time();
    session_start();
    if(isset($_SESSION['last_time'])){
        $_SESSION['refresh_times'] += 1;
    }else{
        $_SESSION['refresh_times'] = 1;
        $_SESSION['last_time'] = $cur_time;
    }
//处理监控结果
    if($cur_time - $_SESSION['last_time'] < $seconds){
        if($_SESSION['refresh_times'] >= $refresh){
//跳转验证
            w_f5("您刷新过快了","?");
        }
    }else{
        $_SESSION['refresh_times'] = 0;
        $_SESSION['last_time'] = $cur_time;
    }
}

/** ------------------------------------------------------------------- */

/**
 * URL rewrite 伪静态函数
 * @param string $url
 * @return string
 */
function w_rewriteurl($url) {
    global $wconfig;
    if( ($wconfig['rewrite']['on'] === true) && isset($wconfig['rewrite'][W_APPNAME]) ) {
        $patterns = $replacements = array();
        foreach($wconfig['rewrite'][W_APPNAME] as $key => $value) {
            $patterns[]     = $key;
            $replacements[] = $value;
        }
        $url = preg_replace($patterns, $replacements, $url);
        unset($patterns, $replacements);
    }
    return $url;
}

/** ------------------------------------------------------------------- */

/**
 * Get site url 获取网站网址
 * @return string
 */
function w_get_siteurl() {
    $protocol = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
    $sitepath = substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
    $siteurl = htmlspecialchars($protocol . $host . $sitepath . '/');
    return $siteurl;
}

/** ------------------------------------------------------------------- */
