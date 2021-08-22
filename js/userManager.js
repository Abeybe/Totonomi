//ユーザ情報管理用
//roomで利用

$(function (){
    $("#user-name").on("change",function(){
        var userName=$(this).val();
        
        console.log(userName);
        $.ajax({
            type: "POST",
            url: "/room/index.php",
            data: { "ajax-change-username" : userName},
            dataType : "json"
            }).done(function(data){
                console.log("done",data);
            })
            // .fail(function(XMLHttpRequest, status, e){
            //     alert(e);
            // })
            ;
    });
});

