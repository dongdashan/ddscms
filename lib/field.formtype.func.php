<?php

function formtype($type,$height,$dvalue,$content,$dtype){
    $height= empty($height)?'150':$height;
    $dvalue= empty($dvalue)?'':$dvalue;
    $content= empty($content)?'':$content;
    $dtype= empty($dtype)?'':$dtype;
    switch ($type) {
        case "editor":
            return '<div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">高度</label>
                    <div class="col-sm-10">' .
            '<input type="text" class="form-control"  name="setting[height]" value="'.$height.'" />' .
            '</div></div>' .
            '<div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">默认值</label>
                    <div class="col-sm-10">' .
            '<input type="text" class="form-control"  name="setting[dvalue]" value="'.$dvalue.'" />' .
            '</div></div>';

            break;
        case "input":
            return  '<div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">默认值</label>
                    <div class="col-sm-10">' .
            '<input type="text" class="form-control"  name="setting[dvalue]" value="'.$dvalue.'" />' .
            '</div></div>';

            break;
        case "textarea":
            return '<div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">高度</label>
                    <div class="col-sm-10">' .
            '<input type="text" class="form-control"  name="setting[height]" value="'.$height.'" />' .
            '</div></div>' .
            '<div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">默认值</label>
                    <div class="col-sm-10">' .
            '<input type="text" class="form-control"  name="setting[dvalue]" value="'.$dvalue.'" />' .
            '</div></div>';
        case "select":
            return  '<div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">选项列表</label>
                    <div class="col-sm-10">' .
            '<textarea class="form-control" rows="3"  name="setting[content]">'.$content.'</textarea>' .
            '<span class="help-block">格式：名称|赋值</span>' .
            '</div></div>'.
            '<div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">默认值</label>
                    <div class="col-sm-10">' .
            '<input type="text" class="form-control"  name="setting[dvalue]" value="'.$dvalue.'" />' .
            '</div></div>';

            break;
        case "radio":
            return  '<div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">选项列表</label>
                    <div class="col-sm-10">' .
            '<textarea class="form-control" rows="3"  name="setting[content]">'.$content.'</textarea>' .
            '<span class="help-block">格式：名称|赋值</span>' .
            '</div></div>'.
            '<div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">默认值</label>
                    <div class="col-sm-10">' .
            '<input type="text" class="form-control"  name="setting[dvalue]" value="'.$dvalue.'" />' .
            '</div></div>';

            break;
        case "checkbox":
            return  '<div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">选项列表</label>
                    <div class="col-sm-10">' .
            '<textarea class="form-control" rows="3"  name="setting[content]">'.$content.'</textarea>' .
            '<span class="help-block">格式：名称|赋值</span>' .
            '</div></div>'.
            '<div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">默认值</label>
                    <div class="col-sm-10">' .
            '<input type="text" class="form-control"  name="setting[dvalue]" value="'.$dvalue.'" />' .
            '</div></div>';

            break;
        case "image":
            return  '';

            break;
        case "file":
            return  '<div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">允许格式</label>
                    <div class="col-sm-10">' .
            '<input type="text" class="form-control"  name="setting[type]" value="'.$dtype.'" />' .
            '<span class="help-block">多个格式以,&分开，如：gif&png&jpg&zip&rar&tar</span>' .
            '</div></div>';


            break;
        case "files":
            return  '<div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">允许格式</label>
                    <div class="col-sm-10">' .
            '<input type="text" class="form-control"  name="setting[type]" value="'.$dtype.'" />' .
            '<span class="help-block">多个格式以,&分开，如：gif&png&jpg&zip&rar&tar</span>' .
            '</div></div>';


            break;
        default :
            return "";

    }
}