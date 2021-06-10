const Peer=window.Peer;
let room;
let localStream;
let localVideo;

// {
//     "max_member":12, //最大参加人数
//     "max_table":6, //テーブル数
//     "count":1 //現在の参加者カウント
//     "host":"", //ホストのID
//     //"entrance":[], //待機してる参加者のID一覧
//     "leave":[], // 一度退室した参加者IDを保持
//     "memberData":{
//          "":{}
// 
//          
//     },
//     "table":[ //テーブル一覧
//         {
//             "id":1,
//             "name":"table 1", //管理用テーブル名
//             "topic":"", //話題
//             "member":[] //参加者のID一覧
//         },
//         {
//             "id":2,
//             "name":"table 2",
//             "topic":"",
//             "member":[]
//         }
//     ]
// }

let myPeerId;
let roomData={
    max_member:null,
    max_table:null,
    count:0,
    host:null,
    // "entrance":[],
    leave:[],
    memberData:{},
    table:[
        {
            id:"entrance",
            name:"エントランス(待機場所)",
            topic:null,
            memberId:[]
        }
    ]
};
// let member=[];
let status="";
let tableId=0;

window.onload=
(async function main(){
    console.log("hello");
    localStream=await navigator.mediaDevices.getUserMedia(
        {audio:true, video:true}
    );
    localVideo=$("#local-video").get(0);
    localVideo.muted=true;
    localVideo.srcObject=localStream;
    localVideo.playsInline=true;
    await localVideo.play().catch(console.error);
    // console.log(localStream.getVideoTracks()[0],localStream.getAudioTracks()[0]);
    $("#video-switch").attr("title",
        localStream.getVideoTracks()[0].label);//.split("(")[0]);
    $("#audio-switch").attr("title",
        localStream.getAudioTracks()[0].label);//.split("(")[0]);

    localStream.getVideoTracks()[0].enabled=(phpUserCamera=="on");
    $("#video-switch-check").attr("checked",(phpUserCamera=="on"));
    localStream.getAudioTracks()[0].enabled=(phpUserMic=="on");
    $("#audio-switch-check").attr("checked",(phpUserMic=="on"));

    $("#video-switch").on("click",function(){
        if(localStream){
            var e=localStream.getVideoTracks()[0].enabled;
            localStream.getVideoTracks()[0].enabled=!e;
            $("#local-stream img.device-icon").attr("src",
                "/img/"+((e)?"camera-off.png":"camera-on.png"
            ));            
            $("#local-stream img.device-icon").fadeIn(1000,"swing",function(){
                $("#local-stream img.device-icon").fadeOut(1000,"swing");
            });
            console.log($("#local-stream img.device-icon"));
        }
    });
    $("#audio-switch").on("click",function(){
        if(localStream){
            var e=localStream.getAudioTracks()[0].enabled;
            localStream.getAudioTracks()[0].enabled=!e;
            $("#local-stream img.device-icon").attr("src",
                "/img/"+((e)?"mic-off.png":"mic-on.png"
            ));
            $("#local-stream img.device-icon").fadeIn(1000,"swing",function(){
                $("#local-stream img.device-icon").fadeOut(1000,"swing");
            });
        }
    });

    const peer=(window.peer=new Peer({
        key:window.__SKYWAY_KEY__,
        debug:1
    }));

    // if(!peer.open)return;

    peer.on("open",function(id){  
        myPeerId=id;
        console.log("Peer Open[ID:"+id+"]");
        console.log(peer.listAllPeers());
        room=peer.joinRoom(phpRoomId,{
            mode: "mesh",
            stream: localStream
        });
        room.once("open",function(){
            console.log("You Jointed "+phpRoomId);
            if(phpUserStatus=="HOST"){
                // room.send("<FIT>REQUEST</FIT>host");
                status="host";
                roomData.hostId=id;
                roomData.max_member=phpMaxNum;
                roomData.max_table=phpMaxNum/2;
                roomData.memberData[id]={name:phpUserName};
                roomData.count++;
                roomData.table[0].memberId.push(id);
                for(var i=0;i<roomData.max_table;i++){
                    roomData.table.push({
                        id:i+1,
                        name:"テーブル "+(i+1),
                        topic:"",
                        memberId:[]
                    });
                }

                var peers=room.getPeerConnections();
                for([key,value] of Object.entries(peers)){
                    console.log(key,value);
                    if(!roomData.memberData[key].name)roomData.memberData[key]={name:""};
                    // roomData.memberData[key]={name:""};
                    roomData.table[0].memberId.push(key);
                }
                if(peers && peers.length>0)room.send("<FIT>NAME_REQ</FIT>");

                tableSetup();
                sendRoomData();
                room.send("<FIT>SETUP</FIT>");
                // room.send("<FIT>SETUP</FIT>"+JSON.stringify(roomData));
            }
            //else
            room.send("<FIT>NAME</FIT>"+phpUserName);
        });
    
        room.on("peerJoin",function(peerId){
            // member[peerId]="";
            console.log(peerId+" Jointed");
            if(status=="host"){
                updateMember("join",peerId);
            }
            // var peers=room.getPeerConnections();
            // if(status=="host")updateMember("join",peerId);
        });
    
        room.on("stream",async function(stream){
            var div=$("<div>",{
                id:stream.id,
                class:"remote-stream"
            });
            div.appendTo("#remote-stream-area");
            var video=$("<video>",{
                id:stream.peerId,//stream.id,
                playsInline:true
            });
            video.get(0).srcObject=stream;
            // video.appendTo("#remote-stream-area");
            video.appendTo(div);
            var name=(roomData.memberData[stream.peerId])?
                roomData.memberData[stream.peerId].name:" ";
            var nameTag=$(
                "<p class='member-name' id=name-"+stream.peerId+">"+
                name+
                "</p>"
            );
            nameTag.appendTo(div);
            video.get(0).play().catch(console.error);
        });
    
        room.on("peerLeave",function(peerId){
            console.log(peerId+" Leaved");
            $("video#"+peerId).parent().remove();
            if(status=="host")updateMember("leave",peerId);
            room.send("<FIT>LEAVE</FIT>");
        });
    
        room.once("close",function(){
            //自分がホストで閉じたときの動作
            //TODO:ブラウザ閉じたときの挙動も別途必要
            if(status=="host" && roomData.count>=2){
                roomData.memberDataData.shift(id);
                var nextHost=firstKeyOfList(roomData.memberData);
                room.send("<FIT>CHANGEHOST["+nextHost+"]</FIT>");
            }
            $("#remote-stream-area").find("video").each(function(i,e){
                var video=e.get(0);
                video.srcObject.getTracks().forEach(t=>t.stop());
                video.srcObject=null;
                e.remove();
            });
        })
    
        room.on("data",function({data,src}){
            console.log(src+":"+data);
            var tag=data.split("<FIT>")[1].split("</FIT>")[0];
            var detail=data.split("<FIT>")[1].split("</FIT>")[1];
            //data.match(/\<(\w+)\>(.+)\<\/\1\>/)[0];
            switch(tag){
                // case "REQUEST":
                //     if(status=="host"){
                //         //自分がホストで、ホスト権限の要求が来たら却下
                //         room.send("<FIT>REJECTED</FIT>host");
                //         sendRoomData();
                //     }
                //     break;
                // case "REJECTED":
                //     if(status=="host"){
                //         //権限要求後にホストからの却下が来たら取り消し
                //         status="";
                //     }
                //     break;                
                case "NAME_REQ":
                    if(status!="host"){
                        room.send("<FIT>NAME</FIT>");
                    }
                    break;
                case "NAME":
                    roomData.memberData[src]={name:detail};
                    if(status=="host"){
                        // var n=data.replace("<FIT>NAME</FTT>","");
                        // console.log("name : "+n);
                        sendRoomData();
                    }
                    $("p#name-"+src).text(detail);
                    break;
                case "TABLE":
                    var [del,add]=detail.split("TO");
                    // roomData.table[del].memberId.shift(src);
                    console.log("Before ",roomData.table[del],roomData.table[add]);
                    tableChange(
                        src,
                        roomData.table[del].memberId,
                        roomData.table[add].memberId
                        );
                    updateTable();
                    console.log("After ",roomData.table[del],roomData.table[add]);
                    break;
                // case "JOIN":
                //     if(status=="host"){
                //         updateMember("join",src);
                //         if(roomData["count"]>roomData["max_member"])room.send("<FIT>OVER["+src+"]</FIT>");
                //     }
                //     room.send("<FIT>UPDATE</FIT>"+JSON.stringify(roomData));
                //     break;
                // case "LEAVE":
                //     if(status="host"){
                //         updateMember("leave",src);
                //     }
                //     break;
                case "SETUP":
                    if(status!="host")tableSetup();
                    break;
                case "UPDATE":
                    if(status!="host"){
                        try{
                            roomData=JSON.parse(detail);//data.replace("<FIT>UPDATE</FIT>",""));
                            // console.log(roomData);
                        }catch(e){
                            room.send("<FIT>RESEND_REQ</FIT>");
                        }
                        //TODO:room.send()が治り次第、下記に変更
                        tableSetup();
                        // updateTable();
                    }
                    break;
                case "RESEND_REQ":
                    if(status=="host")sendRoomData();
                    break;
                case "OVER["+id+"]":
                    room.close();
                    alert("定員に達したため、退出しました。");
                    break;
                case "CHANGEHOST["+id+"]":
                    update("changehost",src);
                    alert("ホスト権限の以降がされ、あなたがホストになりました。");
                    break;
                default:break;
            }            
        });

        function updateMember(action,mId){
            switch(action){
                case "join":
                    // roomData.memberData[memberId]="";
                    if(roomData.memberData[mId] && !roomData.memberData[mId].name)roomData.memberData[mId]={name:""};
                    roomData.count++;
                    roomData.table[0].memberId.push(mId);
                    // roomData["entrance"].push(memberId);
                    break;
                case "leave":
                    delete roomData.memberData[mId];
                    // roomData.memberData=$.grep(roomData.memberData,function(val){
                    //     return val!=src;
                    // });
                    // roomData["entrance"]=$.grep(roomData["entrance"],function(val){
                    //     return val!=src;
                    // });
                    $.each(roomData.table,function(i,e){
                        e.memberId=$.grep(e.memberId,function(val){
                            return val!=mId;
                        });
                    });
                    roomData.count--;
                    break;
                case "changehost":
                        status="host";
                        roomData.hostId=id;
                    break;
                default:break;
            }
            updateTable();
            sendRoomData();
        }

        function sendRoomData(){
            console.log(roomData);
            room.send("<FIT>UPDATE</FIT>"+JSON.stringify(roomData));
        }

    });//peer
 
});//onload

function changeCss(e,c){
    var nowClass=$(e).attr("class");
    $.each(nowClass,function(i,v){
        $(e).removeClass(v);
    });
    $(e).addClass(c);
}

function firstKeyOfList(list){
    var key;
    $.each(list,function(k,v){
        key=k;
        return false;
    })
    return list[key];
}

function indexOfArray(ary,val){
    var index;
    $(ary,function(i,e){
        if(val==e)index=i;
    });
    return index;
}

function delArray(val,ary){
    var index=$.inArray(val,ary);
    if(index>=0)ary.splice(index,1);
        // ary=ary.filter(function(e){
        //     return e!=val;
        // });
}

function addArray(val,ary){
    if($.inArray(val,ary)<0)ary.push(val);
}