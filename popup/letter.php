
<link rel="stylesheet" href="/css/popup.css"/>
<div id="popup_letter" class="popup">
    <div class="popup-content">
        <div id="letter_text">
            <p>遠飲(TOTONOMI) 招待状</p>
            <p>招待コード:<span id="invite_code"></span></p>
            <p>参加URL:<span id="invite_url"></span></p>
        </div>
        <input id="room_name" type="text" name="room-name"/>
        <input id="user_name" type="text" name="user-name"/>

        <?php//script.js linkCopy("elementId") ?>
        <input type="button" name="invite-code-copy" value="コピー"
            onclick="linkCopy('#letter_text')"/>
        <button id="popup_close">閉じる</button>
    </div>
</div>
<script>
    $("#invite_code").text(roomId);
    $("#invite_url").text("totonomi.prodbyfit.com/check?room="+roomId);
</script>