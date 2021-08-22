//SkyWay接続管理用
//roomで使用

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
        console.log(localStream);
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
                data: { "ajax-skyway-peerid" : id},
                dataType : "json"
                }).done(function(data){
                    console.log("done",data);
                })
                .fail(function(XMLHttpRequest, status, e){
                    alert(e);
                })
                ;
        });//room.once open

        //roomのcloseイベント
        room.once("close",function(){

        });//room.once close

        //他者接続時
        room.on("peerJoin",function(peerId){
            console.log(peerId+" Joined");
        });//room.on peerJoin

        //他者の映像取得時
        room.on("stream",async function(stream){
            console.log("on Stream");
            var newVideo=$("<video>",{
                id:stream.peerId,
                class:"remote-video",
                playsInline:true
            });
            newVideo.get(0).srcObject=stream;
            await newVideo.get(0).play().catch(console.error);
            newVideo.appendTo("#remote-videos-area");//ToDo

            //最初はすべて隠したい(ajaxの更新時に出す)
            $("#"+stream.peerId).prop("volume",0.05);
            $("#"+stream.peerId).hide();
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

        let replaceFlag=false;
        let localStreamTmp;
        $("#share-screen").on("click",async function(){
            var replaceStream;
            if(!replaceFlag){
                try{
                    // console.log(localStream.getVideoTracks()[0],localStream.getAudioTracks()[0]);
                    replaceStream=await navigator.mediaDevices.getDisplayMedia({video:true});
                    replaceFlag=true;
                    // localVideo.srcObject=replaceStream;
                }finally{ 
                    replaceStream.addTrack(localStream.getAudioTracks()[0]);     
                    // console.log(replaceStream.getVideoTracks()[0],replaceStream.getAudioTracks()[0]);
                    room.replaceStream(replaceStream);
                }
            }else{
                replaceStream=await navigator.mediaDevices.getUserMedia({
                    audio:true,
                    video:true
                });
                replaceFlag=false;
            }

            replaceVideo(replaceStream);
        });
    });

}