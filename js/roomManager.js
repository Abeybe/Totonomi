const Peer=window.Peer;
let room;

let roomData={
    max_member:null,
    max_table:null,
    count:0,
    host:null, 
    leave:[],
    memberData:{},
    table:[
        {
            id:"entrance",
            name:"エントランス(待機場所)",
            topic:null,
            memberId:[]
        },
        {
            id:"stage",
            name:"ステージ(司会席)", 
            topic:null,
            memberId:[]
        }
    ]
};



async function peerJoin(){

    //接続準備
    const peer=await (window.peer=new Peer({
        key:window.__SKYWAY_KEY__,
        debug:1
    }));

    //接続開始
    peer.on("open",function(id){
        //roomIdは指定する
        room=peer.joinRoom(roomId,{
            mode:"mesh",
            stream:localStream
        });
        console.log("RoomId:"+roomId);
        console.log("PeerId:"+id);

        //roomのopenイベント(部屋が開かれた時ではない)
        room.once("open",function(){
            //DBのにSKYWAYのユーザID(peerId)を保持
            $.ajax({
                type: "POST",
                url: "/room/index.php",
                data: { "skyway-peerid" : id},
                dataType : "json"
                }).done(function(data){
                    console.log("done",data);
                }).fail(function(XMLHttpRequest, status, e){
                    alert(e);
                });
        });//room.once open

        //roomのcloseイベント
        room.once("close",function(){

        });//room.once close

        //他者接続時
        room.on("peerJoin",function(peerId){

        });//room.on peerJoin

        //他者の映像取得時
        room.on("sream",function(stream){
            var newVideo=$("<video>",{
                id:stream.peerId,
                playsInline:true

            });
            newVideo.get(0).srcObject=tream;
            video.appendTo("");//ToDo
        });//room on stream

        //他者の映像切断時
        room.on("peerLeave",function(peerId){
            //<video>を削除
            $("video#"+peerId).remove();
        });//room.on peerLeave

        //データ取得イベント
        //チャットに利用予定
        room.on("data",function({peerId,data}){

        });//room.on data
    });

}