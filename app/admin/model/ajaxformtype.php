<?php

if (!defined('IN_WEIZEPHP')) {
    exit('Access Denied');
}



include W_ROOT_PATH . '/lib/field.formtype.func.php';

$type = isset($_POST['type']) ? addslashes(trim($_POST['type'])) : '';
echo formtype($type,'','','','');


