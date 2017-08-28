<?php
if( !defined('IN_WEIZEPHP') ) {
    exit('Access Denied');
}
?><!DOCTYPE HTML>
<html>
<head>
    <?php include $wconfig['theme_path'] . '/admin/head.inc.php';echo admin_head('附件添加');?>
    <link rel="stylesheet" type="text/css" href="<?php echo $wconfig['public_path'];?>/webuploader/webuploader.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $wconfig['theme_skin'];?>/css/w-webuploader.css"/>
</head>
<body>
<?php include $wconfig['theme_path'] . '/admin/header.html.php';?>
<h4 class="w-h4">附件添加</h4>
<form class="form-horizontal w-form" autocomplete="off">

    <div class="form-group">
        <label for="cid" class="col-sm-2 control-label">分类<span class="text-danger">(必选)</span></label>
        <div class="col-sm-10">
            <select class="form-control" id="cid" name="cid">
                <option value="0">≡ 请选择 ≡</option>
                <?php
                foreach($categories as $v) {
                    echo '<option value="'. $v['cid'] .'">'. $v['name_fmt'] .'</option>';
                }
                ?>
            </select>
        </div>
    </div>


    <script>
        KindEditor.ready(function(K) {
            var editor = K.editor({
                uploadJson: '<?php echo $wconfig['public_path'];?>/kindeditor4.1.100/php/upload_json.php',
                allowFileManager : true
            });

            K('#image3').click(function() {
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        showRemote : false,
                        imageUrl : K('#url3').val(),
                        clickFn : function(url, title, width, height, border, align) {
                            K('#url3').val(url);
                            editor.hideDialog();
                            $("#tb3").show();
                            $("#tb3 a").attr('href',url);
                            $("#tb3 img").attr('src',url);
                        }
                    });
                });
            });

        });
    </script>
    <div class="form-group">
        <label for="displayorder" class="col-sm-2 control-label">PC封面图</label>
        <div class="col-sm-10">

            <div class="w-uploader-box">
                <div id="fileList" class="uploader-list">
                    <div class="file-item thumbnail" id="tb3" style="display: none"><a title="点击查看原图" href="" target="_blank"><img style="position: absolute;top:30%; width: 100px;max-height:70px;" src=""/></a><div id="w-pic-remove" class="remove" onclick="delimg(this)">×</div></div>

                </div>
                <div class="clearfix"></div>
                <input class="form-control wtxt"   type="text"  value=" " id="url3"  name="pic_pc" /> <input class="wbtn" type="button" id="image3" value="选择图片" />
            </div>
            <span class="help-block"> </span>
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
            $.post("?m=file&a=add", $(this).serialize(), function(result) {
                if(result.status == 1) {
                    w_dialog_success(result.msg, '?m=file&a=list');
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