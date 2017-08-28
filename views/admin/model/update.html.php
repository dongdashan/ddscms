<?php
if( !defined('IN_WEIZEPHP') ) {
    exit('Access Denied');
}
?><!DOCTYPE HTML>
<html>
    <head>
        <?php include $wconfig['theme_path'] . '/admin/head.inc.php';echo admin_head('文章更新');?>
        <link rel="stylesheet" type="text/css" href="<?php echo $wconfig['public_path'];?>/webuploader/webuploader.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $wconfig['theme_skin'];?>/css/w-webuploader.css"/>
    </head>
    <body>

        <?php var_dump(w_getimg_info("/uploadfile/other/image/20170826/20170826221816_97849.jpg")); include $wconfig['theme_path'] . '/admin/header.html.php';?>
            <h4 class="w-h4">文章更新</h4>
            <form class="form-horizontal w-form" autocomplete="off">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">标题<span class="text-danger">(必填)</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo $row['title'];?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">副标题</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="subtitle" name="subtitle" value="<?php echo $row['subtitle'];?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="cid" class="col-sm-2 control-label">分类<span class="text-danger">(必选)</span></label>
                    <div class="col-sm-10">
                        <select class="form-control" id="cid" name="cid">
                            <option value="0">≡ 请选择 ≡</option>
                            <?php
                            foreach($categories as $v) {
                                if( $v['cid'] == $row['cid'] ) {
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
                    <label for="status" class="col-sm-2 control-label">是否显示</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="status" name="status">
                            <?php
                            if( $row['status'] == 1 ) {
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
                    <label for="jumpurl" class="col-sm-2 control-label">跳转网址</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="jumpurl" name="jumpurl" value="<?php echo $row['jumpurl'];?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="source" class="col-sm-2 control-label">文章来源</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="source" name="source" value="<?php echo $row['source'];?>" />
                        <span class="help-block">如：新华网</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="sourceurl" class="col-sm-2 control-label">文章来源网址</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="sourceurl" name="sourceurl" value="<?php echo $row['sourceurl'];?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="keywords" class="col-sm-2 control-label">关键字(SEO用)</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="keywords" name="keywords" value="<?php echo $row['keywords'];?>" />
                        <span class="help-block">限100个字符</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">简介<span class="text-danger">(必填)</span></label>
                    <div class="col-sm-10">
                        <textarea rows="3" class="form-control" id="description" name="description"><?php echo $row['description'];?></textarea>
                    </div>
                </div>
                <script>
                    KindEditor.ready(function(K) {
                        var editor1 = K.create('textarea[name="pccontent"]', {
                            uploadJson: '<?php echo $wconfig['public_path'];?>/kindeditor4.1.100/php/upload_json.php',
                            fileManagerJson: '<?php echo $wconfig['public_path'];?>/kindeditor4.1.100/php/file_manager_json.php',
                            allowFileManager: true,
                            filterMode:false,
                            afterBlur: function() {
                                this.sync();
                            }
                        });

                        var editor2 = K.create('textarea[name="wapcontent"]', {
                            uploadJson: '<?php echo $wconfig['public_path'];?>/kindeditor4.1.100/php/upload_json.php',
                            fileManagerJson: '<?php echo $wconfig['public_path'];?>/kindeditor4.1.100/php/file_manager_json.php',
                            allowFileManager: true,
                            filterMode:false,
                            afterBlur: function() {
                                this.sync();
                            }
                        });

                    });
                </script>
                <div class="form-group">
                    <label for="content" class="col-sm-2 control-label">PC内容</label>
                    <div class="col-sm-10">

                        <textarea name="pccontent" style="width:100%;height:500px;visibility:hidden;"><?php echo $row['pccontent'];?></textarea>
                    </div>
                </div>
                <?php if($wconfig['mobile']):?>
                    <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">移动端内容</label>
                        <div class="col-sm-10">

                            <textarea name="wapcontent" style="width:100%;height:500px;visibility:hidden;"><?php echo $row['wapcontent'];?></textarea>
                        </div>
                    </div>

                <?php endif;?>
                <div style="height:50px"></div>
                <div class="form-group fixbottom">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="hidden" name="formtoken" value="<?php echo $wuser->formtoken;?>" />
                        <input type="hidden" name="aid" value="<?php echo $row['aid'];?>" />
                        <input type="hidden" name="pic_delete" value="no" id="pic_delete" />
                        <button type="submit" class="btn btn-info">提 交</button>
                        - <a href="<?php echo $redirect;?>" class="btn btn-default">返回上一页</a>
                    </div>
                </div>
            </form>
        <?php include $wconfig['theme_path'] . '/admin/footer.html.php';?>
        <?php include $wconfig['theme_path'] . '/w_dialog_success.html.php';?>
        <?php include $wconfig['theme_path'] . '/w_dialog_error.html.php';?>
        <?php include $wconfig['theme_path'] . '/w_dialog_confirm.html.php';?>
        <script type="text/javascript" src="<?php echo $wconfig['public_path'];?>/ueditor/ueditor.config.js"></script>
        <script type="text/javascript" src="<?php echo $wconfig['public_path'];?>/ueditor/ueditor.all.min.js"></script>
        <script type="text/javascript" src="<?php echo $wconfig['public_path'];?>/webuploader/webuploader.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function() {

            //-------------------------------
            
            // 提交数据
            $('.w-form').submit(function() {
                $.post("?m=article&a=update", $(this).serialize(), function(result) {
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