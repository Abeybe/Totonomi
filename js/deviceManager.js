//デバイス管理用
//check,roomで利用

let localStream;
let localVideo;

async function deviceSetup(){
    //カメラマイクデバイスの取得
    localStream=await navigator.mediaDevices.getUserMedia({
        audio:true,
        video:true
    });
    //表示用videoの取得
    localVideo=$("#local-video").get(0);
    localVideo.srcObject=localStream;
    localVideo.playsInline=true;
    localVideo.muted=true;
    await localVideo.play().catch(console.error);

    console.log("Device ready");

    if(localStream){
        localStream.getVideoTracks()[0].enabled=$("#camera-enabled").val()=="true";
        localStream.getAudioTracks()[0].enabled=$("#mic-enabled").val()=="true";
    }

    $("#camera-switch").on("click",function(){
        if(localStream){
            var b=localStream.getVideoTracks()[0].enabled;
            localStream.getVideoTracks()[0].enabled=!b;
            $(this).val((!b)?"カメラON":"カメラOFF");
            $("#camera-enabled").val(b);
        }
    });
    
    $("#mic-switch").on("click",function(){
        if(localStream){
            var b=localStream.getAudioTracks()[0].enabled;
            localStream.getAudioTracks()[0].enabled=!b;
            $(this).val((!b)?"マイクON":"マイクOFF");
            $("#mic-enabled").val(b);
        }
    });
}

async function replaceVideo(replaceStream){
    localVideo.srcObject=replaceStream;
    await localVideo.play().catch(console.error);
}


