$(function(){
    $("#room_slide_chat,#room_slide_settings").delay(1000).slideUp();

    $("#room_hover_chat").hover(function(){
        $("#room_slide_chat").slideDown();
    });
    $("#room_close_chat").on("click",function(){
        $("#room_slide_chat").slideUp();
    });

    $("#room_click_settings").on("click",function(){
        $("#room_slide_settings").slideToggle();
        $(this).toggleClass("active");
    });

    
});