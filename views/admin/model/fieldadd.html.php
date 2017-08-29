<?php
if( !defined('IN_WEIZEPHP') ) {
    exit('Access Denied');
}
?><!DOCTYPE HTML>
<html>
    <head>
        <?php include $wconfig['theme_path'] . '/admin/head.inc.php';echo admin_head('字段添加');?>
        <link rel="stylesheet" type="text/css" href="<?php echo $wconfig['public_path'];?>/webuploader/webuploader.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $wconfig['theme_skin'];?>/css/w-webuploader.css"/>
    </head>
    <body>
    <script>

        function ajaxname(){
            var title = $('#zdname').val();
            var url="general.php?m=comm&a=pinyin";
            var data={"title":title};
            var success=function(result){
                $("#field").val(result);
            }
            $.post(url,data,success);

        }
    </script>

        <?php  include $wconfig['theme_path'] . '/admin/header.html.php';?>
            <h4 class="w-h4">字段添加</h4>
            <form class="form-horizontal w-form" autocomplete="off">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">模型类型</label>
                    <div class="col-sm-10">
                         <p class="form-control-static"><?php echo $models['modelname']?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">字段别名<span class="text-danger">(*)</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="zdname" onblur="ajaxname()"  name="name" />
                        <span class="help-block">例如：文章标题</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">字段名称<span class="text-danger">(*)</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="field" name="field"   />
                        <span class="help-block">格式：只能由小写英文和数字组成(无需加表前缀)，命名不能重复，此项添加后不能修改</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">输入类型<span class="text-danger">(*)</span></label>
                    <div class="col-sm-10">
                    <select class="form-control" id="formtype" name="formtype" onchange="change_formtype(this.value)">
                        <option>---</option>
                        <option value="editor">编辑器</option>
                        <option value="input">单行文本</option>
                        <option value="textarea">多行文本</option>
                        <option value="select">下拉选项框</option>
                        <option value="radio">单选框</option>
                        <option value="checkbox">复选框</option>
                        <option value="image">单图上传</option>
                        <option value="file">文件上传</option>
                        <option value="files">多文件上传</option>
                    </select>
                    </div>
                </div>



                <div id="formtype_div" class="alert alert-warning" style=" margin-bottom:15px; ">

                </div>

                <script>
                    function change_formtype(type){
                        var url="admin.php?m=model&a=ajaxformtype";
                        var data={"type":type};
                        var success=function(result){
                            $("#formtype_div").html(result);
                            //alert(result)
                        }
                        $.post(url,data,success);
                    }
                </script>


                <div class="form-group" style="display: none">
                    <label for="subtitle" class="col-sm-2 control-label">字段类型<span class="text-danger">(*)</span></label>
                    <div class="col-sm-10">
                    <select class="form-control" id="type" name="type">
                        <option>---</option>
                        <option value="1">int</option>
                        <option value="2">varchar</option>
                        <option value="2">text</option>
                    </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">字段提示</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control"   name="tips" />

                    </div>
                </div>

                <div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">是否显示<span class="text-danger">(*)</span></label>
                    <div class="col-sm-10">
                        <select class="form-control" id="disabled" name="disabled">
                            <option value="0">否</option>
                            <option value="1" selected="selected">是</option>
                        </select>

                    </div>
                </div>



                <div style="height:50px"></div>
                <div class="form-group fixbottom">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="hidden" name="modelid" value="<?php echo $modelids['modelid'];?>" />
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
                $.post("?m=model&a=fieldadd", $(this).serialize(), function(result) {
                    if(result.status == 1) {
                        w_dialog_success(result.msg, '<?php echo $redirect;?>');
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