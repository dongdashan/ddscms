<?php
if( !defined('IN_WEIZEPHP') ) {
    exit('Access Denied');
}
?><!DOCTYPE HTML>
<html>
    <head>
        <?php include $wconfig['theme_path'] . '/admin/head.inc.php';echo admin_head('后台管理');?>
    </head>
    <body>
        <?php include $wconfig['theme_path'] . '/admin/header.html.php';?>
            <div class="table-responsive">
                <table class="table w-table">
                    <thead class="w-thead">
                        <tr>
                            <th colspan="2">系统信息</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> 程序版本</td>
                            <td><?php echo $wconfig['version'];?>  </td>
                        </tr>
                        <tr>
                            <td>服务器系统及 PHP</td>
                            <td><?php echo $server_info;?></td>
                        </tr>
                        <tr>
                            <td>服务器软件</td>
                            <td><?php echo $server_soft;?></td>
                        </tr>
                        <tr>
                            <td>服务器 MySQL 版本</td>
                            <td><?php echo $db_version['version'];?></td>
                        </tr>
                        <tr>
                            <td>当前数据库大小</td>
                            <td><?php echo $db_size;?></td>
                        </tr>
                        <tr>
                            <td>上传许可</td>
                            <td><?php echo $file_upload;?></td>
                        </tr>
                    </tbody>
                    
                    <thead class="w-thead">
                        <tr>
                            <th colspan="2">提示</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> 问题</td>
                            <td> 回答 </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        <?php include $wconfig['theme_path'] . '/admin/footer.html.php';?>
    </body>
</html>