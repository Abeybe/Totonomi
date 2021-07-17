//テーブル管理用
//roomで使用

$(function(){
    //表示管理
    function updateTableStatus(){

    }

    //移動検知,DB反映
    $("select#select-table").change(function(){
        $.ajax({
            type: "POST",
            url: "/room/index.php",
            data: { "ajax-table-id" : $(this).val()},
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