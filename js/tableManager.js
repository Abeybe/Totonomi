//テーブル管理用
//roomで使用

$(window).on("load",function(){
    
    //表示管理
    function updateUserTable(){
        var tableId=$("select#select-table").val();
        $.ajax({
            type: "POST",
            url: "/room/index.php",
            data: { "ajax-get-usertable" : "___"},
            dataType : "json"
            }).done(function(data){
                // console.log("done",data);
                $("#remote-videos-area video").hide();
                $("#remote-videos-area video").prop("volume",0.05);
                $.each(data,function(i,e){
                    $("#"+e["SKYWAY_PEERID"]).show();
                    $("#"+e["SKYWAY_PEERID"]).prop("volume",1);
                });
            })
            // .fail(function(XMLHttpRequest, status, e){
            //     alert(e);
            // })
        ;
    }
    setInterval(function(){
        updateUserTable();
    },1000);

    function showVideos(){

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
        updateUserTable();
    });

});


function tableSetup(){
    updateUserTable();
}