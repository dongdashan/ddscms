<?php
if( !defined('IN_WEIZEPHP') ) {
    exit('Access Denied');
}
?><!DOCTYPE HTML>
<html>
    <head>
        <?php include $wconfig['theme_path'] . '/admin/head.inc.php';echo admin_head('字段管理');?>
    </head>
    <body>
        <?php include $wconfig['theme_path'] . '/admin/header.html.php';?>
            <h4 class="w-h4">字段管理</h4>
        <div class="row w-row">
            <div class="col-lg-12">

                <a class="btn btn-warning btn-sm" href="?m=model&a=fieldadd&modelid=<?php echo $modelid?>">添加字段</a>
            </div>
        </div>

            <div class="table-responsive">
                <table class="table w-table">
                    <thead class="w-thead-1">
                        <tr>
                            <th>排序</th>
                            <th>字段名称</th>
                            <th>字段别名</th>
                            <th>输入类型</th>
                            <th>字段类型</th>
                            <th>后台是否显示</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php
                    foreach($default_field as  $name =>$v) {
                        $show=$v['show']? '√': '×';
                        $disabled=$v['show']? '显示': '隐藏';
                        echo '<tr>' .
                            '<td> </td>' .
                            '<td>'. $name .'</td>' .
                            '<td>'. $v['name'] .'</td>' .
                            '<td> </td>' .
                            '<td> </td>' .
                            '<td>'.$show.'</td>' .
                            '<td>' .
                            '<a class="btn btn-info btn-xs w-a-btn" href="admin.php?m=model&a=modelupdate&name='. $name .'&modelid='. $modelid .'"  >更新</a>' .
                            ' - <a class="btn btn-success btn-xs w-a-btn" href="?m=model&a=modeldisabled&name='. $name .'&modelid='. $modelid .'">'.$disabled.'</a>' .
                             '</td>' .
                            '</tr>';
                    }
                    ?>

                    <?php
                    foreach($fields as  $v) {
                        $show=$v['disabled']? '√': '×';
                        $disabled=$v['disabled']? '显示': '隐藏';
                        echo '<tr>' .
                            '<td><input type="text" style="width:44px;height:28px;text-align:center;" class="form-control" value="'.$v['displayorder'].'" name="displayorder"></td>' .
                            '<td>'. $v['field'] .'</td>' .
                            '<td>'. $v['name'] .'</td>' .
                            '<td>'. $v['formtype'] .'</td>' .
                            '<td>'. $v['type'] .'</td>' .
                            '<td>'.$show.'</td>' .
                            '<td>' .
                            '<a class="btn btn-info btn-xs w-a-btn" href="admin.php?m=model&a=fieldupdate&fieldid='.  $v['fieldid'] .'"  >更新</a>' .
                            ' - <a class="btn btn-success btn-xs w-a-btn" href="?m=model&a=fielddisabled&fieldid='. $v['fieldid'] .'">'.$disabled.'</a>' .
                            ' - <a class="btn btn-danger btn-xs w-a-btn w-delete" href="?m=model&a=fielddelete&fieldid='. $v['fieldid'] .'&formtoken='. $wuser->formtoken .'">删除</a>' .

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