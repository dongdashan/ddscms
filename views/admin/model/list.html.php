<?php
if( !defined('IN_WEIZEPHP') ) {
    exit('Access Denied');
}
?><!DOCTYPE HTML>
<html>
    <head>
        <?php include $wconfig['theme_path'] . '/admin/head.inc.php';echo admin_head('模型列表');?>
    </head>
    <body>
        <?php include $wconfig['theme_path'] . '/admin/header.html.php';?>
            <h4 class="w-h4">模型列表</h4>
        <br/>

            <div class="table-responsive">
                <table class="table w-table">
                    <thead class="w-thead-1">
                        <tr>
                            <th>ID</th>
                            <th>模型名称</th>
                            <th>数据表名</th>
                            <th>模型类型</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($articles as $v) {

                            echo '<tr>' .
                                '<td>'. $v['modelid'] .'</td>' .
                                '<td>'. htmlspecialchars($v['modelname']) .'</td>' .
                                '<td>'. htmlspecialchars($v['tablename']) .'</td>' .
                                '<td>内容模型</td>' .
                                '<td>' .
                                    '<a class="btn btn-info btn-xs w-a-btn" href="admin.php?m=model&a=fieldlist&modelid='. $v['modelid'] .'"  >字段管理</a>' .
                                    ' - <a class="btn btn-success btn-xs w-a-btn" href="?m=model&a=update&modelid='. $v['modelid'] .'">编辑</a>' .
                                ' - <a class="btn btn-success btn-xs w-a-btn" href="?m=model&a=disabled&modelid='. $v['modelid'] .'">禁用</a>' .
                                    ' - <a class="btn btn-danger btn-xs w-a-btn w-delete" href="?m=model&a=delete&modelid='. $v['modelid'] .'&formtoken='. $wuser->formtoken .'">删除</a>' .
                                '</td>' .
                            '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        <?php include $wconfig['theme_path'] . '/admin/footer.html.php';?>
        <?php include $wconfig['theme_path'] . '/w_dialog_success.html.php';?>
        <?php include $wconfig['theme_path'] . '/w_dialog_error.html.php';?>
        <?php include $wconfig['theme_path'] . '/w_dialog_confirm.html.php';?>
        <script type="text/javascript">
        $(document).ready(function() {
            $('.w-delete').click(function() {
                var href = $(this).attr('href');
                w_dialog_confirm("确认删除吗？", function() {
                    $.getJSON(href, function(data) {
                        if( data.status == 1 ) {
                            window.location.reload(true);
                        } else {
                            w_dialog_error(data.msg);
                        }
                    });
                });
                return false;
            });
        });
        </script>
    </body>
</html>