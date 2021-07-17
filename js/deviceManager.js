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
    await localVideo.play().catch(console.error);

    console.log("Device ready");

    $("#camera-switch").on("click",function(){
        if(localStream){
            var b=localStream.getVideoTracks()[0].enabled;
            localStream.getVideoTracks()[0].enabled=!b;
            $(this).val((b)?"カメラON":"カメラOFF");
        }
    });
    
    $("#mic-switch").on("click",function(){
        if(localStream){
            var b=localStream.getAudioTracks()[0].enabled;
            localStream.getAudioTracks()[0].enabled=!b;
            $(this).val((b)?"マイクON":"マイクOFF");
        }
    });
    
}

