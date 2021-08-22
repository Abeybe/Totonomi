
$("#create_letter").on("click",function(){
    var roomId=$("#room_id").val();
    var letter=
        "遠飲(TOTONOMI) 招待状\n"+
        "招待コード:"+roomId+"\n"+
        "参加URL:totonomi.prodbyfit.com/check?room="+roomId+"\n"
    ;
 
});