<?php
if( !defined('IN_WEIZEPHP') ) {
    exit('Access Denied');
}
?><!DOCTYPE HTML>
<html>
<head>
    <?php include $wconfig['theme_path'] . '/admin/head.inc.php';echo admin_head('字段更新');?>
    <link rel="stylesheet" type="text/css" href="<?php echo $wconfig['public_path'];?>/webuploader/webuploader.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $wconfig['theme_skin'];?>/css/w-webuploader.css"/>
</head>
<body>


<?php  include $wconfig['theme_path'] . '/admin/header.html.php';?>
<h4 class="w-h4">字段更新</h4>
<form class="form-horizontal w-form" autocomplete="off">
    <div class="form-group">
        <label for="title" class="col-sm-2 control-label">模型名称</label>
        <div class="col-sm-10">
            <p class="form-control-static"><?php echo $models['modelname'];?></p>

        </div>
    </div>
    <div class="form-group">
        <label for="subtitle" class="col-sm-2 control-label">字段别名<span class="text-danger">(*)</span></label>
        <div class="col-sm-10">
            <input type="text" class="form-control"  value="<?php echo $title;?>"  name="title" />
        </div>
    </div>
    <div class="form-group">
        <label for="subtitle" class="col-sm-2 control-label">后台是否显示</label>
        <div class="col-sm-10">
            <select class="form-control"   name="show">
                <?php
                if( $show == 1 ) {
                    echo '<option value="0">否</option><option value="1" selected="selected">是</option>';
                } else {
                    echo '<option value="0" selected="selected">否</option><option value="1">是</option>';
                }
                ?>
            </select>
        </div>
    </div>

    <div style="height:50px"></div>
    <div class="form-group fixbottom">
        <div class="col-sm-offset-2 col-sm-10">
            <input type="hidden" name="formtoken" value="<?php echo $wuser->formtoken;?>" />
            <input type="hidden" name="name" value="<?php echo $name;?>" />
            <input type="hidden" name="modelid" value="<?php echo $models['modelid'];?>" />
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
            $.post("?m=model&a=modelupdate", $(this).serialize(), function(result) {
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