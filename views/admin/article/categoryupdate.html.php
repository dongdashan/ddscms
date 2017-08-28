<?php
if( !defined('IN_WEIZEPHP') ) {
    exit('Access Denied');
}
?><!DOCTYPE HTML>
<html>
    <head>
        <?php include $wconfig['theme_path'] . '/admin/head.inc.php';echo admin_head('文章分类更新');?>

    </head>
    <body>
        <?php include $wconfig['theme_path'] . '/admin/header.html.php';?>
            <h4 class="w-h4">文章分类更新</h4>
            <form class="form-horizontal w-form" autocomplete="off">
                <div class="form-group">
                    <label for="pid" class="col-sm-2 control-label">上级</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="pid" name="pid">
                            <option value="0">≡ 作为一级 ≡</option>
                            <?php
                            foreach($categories as $v) {
                                if($v['cid'] == $row['pid']) {
                                    echo '<option value="'. $v['cid'] .'" selected="selected">'. $v['name_fmt'] .'</option>';
                                } else {
                                    echo '<option value="'. $v['cid'] .'">'. $v['name_fmt'] .'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">分类名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name'];?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">是否显示</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="status" name="status">
                            <?php
                            if($row['status'] == 1) {
                                echo '<option value="0">否</option><option value="1" selected="selected">是</option>';
                            } else {
                                echo '<option value="0" selected="selected">否</option><option value="1">是</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="displayorder" class="col-sm-2 control-label">排序</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="displayorder" name="displayorder" value="<?php echo $row['displayorder'];?>" />
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
                                        if($('#tb3').length>0){
                                            $("#tb3").show();
                                            $("#tb3 a").attr('href',url);
                                            $("#tb3 img").attr('src',url);
                                        }else{
                                            $(".ft3").before(
                                                '<div class="file-item thumbnail" id="tb3"><a title="点击查看原图" href="'+url+'" target="_blank"><img style="position: absolute;top:30%;width: 100px;max-height:70px;" src="'+url+'"/></a><div id="w-pic-remove" class="remove" onclick="delimg(this)">×</div></div>'
                                            )

                                        }
                                    }
                                });
                            });
                        });
                        K('#image4').click(function() {
                            editor.loadPlugin('image', function() {
                                editor.plugin.imageDialog({
                                    showRemote : false,
                                    imageUrl : K('#url4').val(),
                                    clickFn : function(url, title, width, height, border, align) {
                                        K('#url4').val(url);
                                        editor.hideDialog();
                                        if($('#tb4').length>0){
                                            $("#tb4").show();
                                            $("#tb4 a").attr('href',url);
                                            $("#tb4 img").attr('src',url);
                                        }else{
                                            $(".ft4").before(
                                                '<div class="file-item thumbnail" id="tb4"><a title="点击查看原图" href="'+url+'" target="_blank"><img style="position: absolute;top:30%;width: 100px;max-height:70px;" src="'+url+'"/></a><div id="w-pic-remove" class="remove" onclick="delimg(this)">×</div></div>'
                                            )

                                        }

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
                            <div id="fileList" class="uploader-list ft3">
                                <?php
                                if( !empty($row['pic_pc']) ) {
                                    echo '<div class="file-item thumbnail" id="tb3"><a title="点击查看原图" href="'. $row['pic_pc'] .'" target="_blank"><img style="position: absolute;top:30%;width: 100px;max-height:70px;" src="'. $row['pic_pc'] .'"/></a><div id="w-pic-remove" class="remove" onclick="delimg(this)">×</div></div>';
                                }
                                ?>
                            </div>
                            <div class="clearfix"></div>
                            <input class="form-control wtxt" type="text"  value="<?php echo $row['pic_pc'];?>" id="url3"  name="pic_pc" /> <input class="wbtn" type="button" id="image3" value="选择图片" />
                        </div>
                        <span class="help-block"> </span>
                    </div>
                </div>
                <?php if($wconfig['mobile']):?>
                <div class="form-group">
                    <label for="displayorder" class="col-sm-2 control-label">移动端封面图</label>
                    <div class="col-sm-10">
                        <div class="w-uploader-box">
                            <div id="fileList" class="uploader-list ft4">
                                <?php
                                if( !empty($row['pic_wap']) ) {
                                    echo '<div class="file-item thumbnail" id="tb4"><a title="点击查看原图" href="'. $row['pic_wap'] .'" target="_blank"><img style="position: absolute;top:30%;width: 100px;max-height:70px;" src="'. $row['pic_wap'] .'"/></a><div id="w-pic-remove" class="remove" onclick="delimg(this)">×</div></div>';
                                }
                                ?>
                            </div>
                            <div class="clearfix"></div>
                            <input   class="form-control wtxt" type="text"  value="<?php echo $row['pic_wap'];?>" id="url4"  name="pic_wap" /> <input class="wbtn" type="button" id="image4" value="选择图片" />
                        </div>
                        <span class="help-block"> </span>
                    </div>
                </div>
                <?php endif;?>

                <div class="form-group">
                    <label for="seotitle" class="col-sm-2 control-label">SEO标题</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="seotitle" name="seotitle" value="<?php echo $row['seotitle'];?>" />
                        <span class="help-block">限60个字符</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="seokeywords" class="col-sm-2 control-label">SEO关键字</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="seokeywords" name="seokeywords" value="<?php echo $row['seokeywords'];?>" />
                        <span class="help-block">限100个字符</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="seodescription" class="col-sm-2 control-label">SEO简介</label>
                    <div class="col-sm-10">
                        <textarea rows="3" id="seodescription" class="form-control" name="seodescription"><?php echo $row['seodescription'];?></textarea>
                    </div>
                </div>
                <div style="height:50px"></div>
                <div class="form-group fixbottom">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="hidden" name="formtoken" value="<?php echo $wuser->formtoken;?>" />
                        <input type="hidden" name="cid" value="<?php echo $cid;?>" />
                        <input type="hidden" name="pic_delete" value="no" id="pic_delete" />
                        <button type="submit" class="btn btn-info">提 交</button>
                        - <a class="btn btn-default" href="?m=article&a=categorylist">返回上一页</a>
                    </div>
                </div>
            </form>
        <?php include $wconfig['theme_path'] . '/admin/footer.html.php';?>
        <?php include $wconfig['theme_path'] . '/w_dialog_success.html.php';?>
        <?php include $wconfig['theme_path'] . '/w_dialog_error.html.php';?>
        <?php include $wconfig['theme_path'] . '/w_dialog_confirm.html.php';?>
        <script type="text/javascript" src="<?php echo $wconfig['public_path'];?>/webuploader/webuploader.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function() {

            //-------------------------------
            
            // 提交
            $('.w-form').submit(function() {
                $.post("?m=article&a=categoryupdate", $(this).serialize(), function(result) {
                    if(result.status == 1) {
                        $("#fileList").find("input").remove();
                        w_dialog_success(result.msg, '?m=article&a=categorylist');
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