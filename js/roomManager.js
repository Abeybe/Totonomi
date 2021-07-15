const Peer=window.Peer;
let room;
let localStream;
let localVideos;

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

//check,roomで使用
$(window).on("load",async function(){
    //カメラマイクデバイスの取得
    localStream=await navigator.mediaDevices.getUserMedia({
        audio:true,
        video:true
    });
    console.log(localStream);
    //表示用videoの取得
    localVideo=$("#local-video").get(0);
    localVideo.srcObject=localStream;
    localVideo.playsInline=true;
    await localVideo.play().catch(console.error);
});//$

//roomで使用
function peerJoin(){

    //接続準備
    const peer=(window.peer=new Peer({
        key:window.__SKYWAY_KEY__,
        debug:1
    }));

    //接続開始
    //roomはこの中で扱う
    peer.on("on",function(id){
        //roomIdは指定する
        room=peer.joinRoom("",{
            mode:"mesh",
            stream:localStream
        });

        //roomのopenイベント(部屋が開かれた時ではない)
        room.once("open",function(){

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

    });//peer.on
}