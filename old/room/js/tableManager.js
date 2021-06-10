// {
//     "max_member":12, //最大参加人数
//     "max_table":6, //テーブル数
//     "count":1 //現在の参加者カウント
//     "host":"", //ホストのID
//     "entrance":[], //待機してる参加者のID一覧
//     "leave":[], // 一度退室した参加者IDを保持
//     "table":[ //テーブル一覧
//         {
//             "name":"table 1", //管理用テーブル名
//             "topic":"", //話題
//             "member":[] //参加者のID一覧
//         },
//         {
//             "name":"table 2",
//             "topic":"",
//             "member":[]
//         }
//     ]
// }

$(function(){

    $("#table-select select").change(function(){
        var pTableId=tableId; 
        tableId=$("option:selected").val();
        
        room.send("<FIT>TABLE</FIT>"+pTableId+"TO"+tableId);
        console.log("MyPeerId : "+myPeerId);
        tableChange(
            myPeerId,
            roomData.table[pTableId].memberId,
            roomData.table[tableId].memberId
            );
        updateTable();
    });

})//$

function tableChange(mId,beforeArray,afterArray){
    delArray(mId,beforeArray);
    addArray(mId,afterArray);
}


function tableSetup(){
    $("#table-select select").empty();
    $.each(roomData.table,function(i,e){
        if(e.id==tableId){
            $("#table-select select").append("<option value='"+i+"' checked='checked' >"+e.name+"</option>");
        }else $("#table-select select").append("<option value='"+i+"' >"+e.name+"</option>");
    });
    updateTable();
}

function updateTable(){
    var cnt=0;
    var max=roomData.table[tableId].memberId.length;
    $.each($(".remote-stream"),function(i,e){
        // console.log(i,e,$(e).find("video"));
        if($.inArray($(e).find("video")[0].id,roomData.table[tableId].memberId)>=0){
            $(e).css("display","inline-block");
            $(e).volume=1;
            cnt++;
        }else{
            $(e).css("display","none");
            $(e).volume=0.2;
        }
    });
}

function arrayPush(ary,val){
    if(ary.indexOf(val)==-1){
        ary.push(val);
    }
}

function findTableByMember(memberId){
    $.each(roomData["table"],function(i,t){
        $.each(t,function(j,m){
            if(memberId==m)return t;
        });
    });
}