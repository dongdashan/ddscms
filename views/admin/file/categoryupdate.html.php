<?php
if( !defined('IN_WEIZEPHP') ) {
    exit('Access Denied');
}
?><!DOCTYPE HTML>
<html>
    <head>
        <?php include $wconfig['theme_path'] . '/admin/head.inc.php';echo admin_head('附件分类更新');?>

    </head>
    <body>
        <?php include $wconfig['theme_path'] . '/admin/header.html.php';?>
            <h4 class="w-h4">附件分类更新</h4>
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


                <div class="form-group">
                    <label for="seodescription" class="col-sm-2 control-label">描述</label>
                    <div class="col-sm-10">
                        <textarea rows="3" id="description" class="form-control" name="description"><?php echo $row['description'];?></textarea>
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
                $.post("?m=file&a=categoryupdate", $(this).serialize(), function(result) {
                    if(result.status == 1) {
                        $("#fileList").find("input").remove();
                        w_dialog_success(result.msg, '?m=file&a=categorylist');
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