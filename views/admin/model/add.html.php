<?php
if( !defined('IN_WEIZEPHP') ) {
    exit('Access Denied');
}
?><!DOCTYPE HTML>
<html>
    <head>
        <?php include $wconfig['theme_path'] . '/admin/head.inc.php';echo admin_head('模型添加');?>
        <link rel="stylesheet" type="text/css" href="<?php echo $wconfig['public_path'];?>/webuploader/webuploader.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $wconfig['theme_skin'];?>/css/w-webuploader.css"/>
    </head>
    <body>
    <script>

        function ajaxname(){
            var title = $('#modelname').val();

            var url="general.php?m=comm&a=pinyin";
            var data={"title":title};
            var success=function(result){
                $("#tablename").val(result);
            }
            $.post(url,data,success);

        }
    </script>

        <?php  include $wconfig['theme_path'] . '/admin/header.html.php';?>
            <h4 class="w-h4">模型添加</h4>
            <form class="form-horizontal w-form" autocomplete="off">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">模型类型</label>
                    <div class="col-sm-10">
                         <p class="form-control-static">内容模型</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">模型名称<span class="text-danger">(*)</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" onblur="ajaxname()" id="modelname" name="modelname" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">模型表名<span class="text-danger">(*)</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="tablename" name="tablename" />
                        <span class="help-block">只能由小写英文和数字组成(无需加表前缀)，命名不能重复，此项添加后不能修改</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">栏目模板<span class="text-danger">(*)</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="categorytpl" name="categorytpl" />
                        <span class="help-block">格式：category.html</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">列表模板<span class="text-danger">(*)</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="listtpl" name="listtpl" />
                        <span class="help-block">格式：list.html</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">内容模板<span class="text-danger">(*)</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="showtpl" name="showtpl" />
                        <span class="help-block">格式：show.html</span>
                    </div>
                </div>


                <div style="height:50px"></div>
                <div class="form-group fixbottom">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="hidden" name="formtoken" value="<?php echo $wuser->formtoken;?>" />
                        <button type="submit" class="btn btn-info">提 交</button>
                    </div>
                </div>
            </form>
        <?php include $wconfig['theme_path'] . '/admin/footer.html.php';?>
        <?php include $wconfig['theme_path'] . '/w_dialog_success.html.php';?>
        <?php include $wconfig['theme_path'] . '/w_dialog_error.html.php';?>

        <script type="text/javascript">
        $(document).ready(function() {

            
            //-------------------------------
            
            // 提交数据
            $('.w-form').submit(function() {
                $.post("?m=model&a=add", $(this).serialize(), function(result) {
                    if(result.status == 1) {
                        w_dialog_success(result.msg, '?m=model&a=list');
                    } else {
                        w_dialog_error(result.msg);
                    }
                }, 'json');
                return false;
            });
        });
        </script>
    </body>
</html>