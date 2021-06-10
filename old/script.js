
window.onload =
(async function main(){
    let localStream=await navigator.mediaDevices.getUserMedia(
        {audio:true,video:true}
    );
    let localVideo=$("#local-video").get(0);
    localVideo.muted=true;
    localVideo.srcObject=localStream;
    localVideo.playsInline=true;
    localVideo.play().catch(console.error);
    
    $("#video-switch").attr("title",
        localStream.getVideoTracks()[0].label);//.split("(")[0]);
    $("#audio-switch").attr("title",
        localStream.getAudioTracks()[0].label);//.split("(")[0]);

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

});//onload

function changeCss(e,c){
    var nowClass=$(e).attr("class");
    $.each(nowClass,function(i,v){
        $(e).removeClass(v);
    });
    $(e).addClass(c);
}