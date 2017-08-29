
$(document).ready(function() {
    // 全选或全取消
    $('.select_all').click(function(e) {
        if( $(this).prop('checked') == true ) {
            $('.check_arr').prop('checked', true);
        } else {
            $('.check_arr').prop('checked', false);
        }
    });


    // 删除提交
    $('.w-delete').click(function(e) {
        w_dialog_confirm("一旦删除将无法恢复，确定要删除吗？", function() {
            $.post("?m=system&a=adminlogdelete", $('.w-form').serialize(), function(data) {
                if( data.status == 1 ) {
                    window.location.href = self.location.href;
                } else {
                    w_dialog_error( data.msg );
                }
            }, "json");
        });
    });
});


function manySend(href) {
    var form = document.form1;
    form.action = href;
    form.submit()
}

function selectAll2() {
    var checklist = document.getElementsByName("check_id[]");
    if (document.getElementById("controlAll").checked) {
        for (var i = 0; i < checklist.length; i++) {
            checklist[i].checked = 1
        }
    } else {
        for (var j = 0; j < checklist.length; j++) {
            checklist[j].checked = 0
        }
    }
}