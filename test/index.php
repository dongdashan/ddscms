<?php

$str="";

var_dump(is_file($str));

print_r(pathinfo($str));

print_r(filesize($str));

echo "<br>";

print_r(ceil(filesize($str) / 1024));

echo "<br>";

$remote_png_url = 'http://www.runoob.com/wp-content/themes/w3cschool.cc/assets/img/logo-domain-green2.png';

print_r(getimagesize($str));


$arr = array('eid'=>10,'ename'=>'Tom','isMarried'=>true, 'birthday'=>'2015-10-15');
//echo $arr;
echo json_encode($arr);//编码为JSON字符串


$sst='a:2:{s:4:"auth";a:2:{s:9:"adminpost";s:1:"0";s:10:"memberpost";s:1:"0";}s:7:"default";a:4:{s:5:"title";a:2:{s:4:"name";s:6:"标题";s:4:"show";s:1:"1";}s:5:"thumb";a:2:{s:4:"name";s:9:"缩略图";s:4:"show";s:1:"1";}s:8:"keywords";a:2:{s:4:"name";s:9:"关键字";s:4:"show";s:1:"1";}s:11:"description";a:2:{s:4:"name";s:6:"描述";s:4:"show";s:1:"1";}}}';


$sst2='a:1:{s:7:"default";a:6:{s:5:"title";a:2:{s:4:"name";s:6:"标题";s:4:"show";s:1:"1";}s:8:"keywords";a:2:{s:4:"name";s:9:"关键字";s:4:"show";s:1:"1";}s:5:"thumb";a:2:{s:4:"name";s:9:"缩略图";s:4:"show";s:1:"1";}s:11:"description";a:2:{s:4:"name";s:6:"描述";s:4:"show";s:1:"1";}s:4:"time";a:2:{s:4:"name";s:12:"发布时间";s:4:"show";s:1:"1";}s:4:"hits";a:2:{s:4:"name";s:9:"阅读数";s:4:"show";s:1:"1";}}}';

print_r(unserialize($sst2));

$sst3=unserialize($sst2);


print_r(Array2String($sst3));





