<?php
if( !defined('IN_WEIZEPHP') ) {
    exit('Access Denied');
}
?>
        </div>
            </div>
        </div>
        
        <script>
        $(document).ready(function() {
            // 弹出菜单
            $("#w-navbar-toggle").on("click", function() {
                if( $("#w-navbar").css("display") == "none" ) {
                    $("#w-navbar").css("border-bottom", "1px solid #cbe6bd").slideDown("slow");
                } else {
                    $("#w-navbar").css("border-bottom", "0px solid #cbe6bd").slideUp("slow");
                }
            });

            $("#w-navbar").Huifold({
                titCell:'.w-sidebar-item h4',
                mainCell:'.w-sidebar-item .nav-sidebar',
                type:3,
                trigger:'click',
                className:"selected",
                speed:"fast"
            });


        });


        function delimg(id){
            if(confirm("确认删除吗？")){
                $(id).parent().hide();
                $(id).parent().parent().siblings('input[type=text]').val('');

            }

        }
        </script>
