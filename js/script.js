
function linkCopy(inputId){
    var text=$(inputId).val();
    // テキストエリアの作成
    let $textarea = $('<textarea></textarea>');
    // テキストエリアに文章を挿入
    $textarea.text(text);
    //　テキストエリアを挿入
    $("body").append($textarea);
    //　テキストエリアを選択
    $textarea.select();
    // コピー
    document.execCommand('copy');
    // テキストエリアの削除
    $textarea.remove();
    var msg=$("<div id='copy_massage'>コピーしました！</div>");
    msg.appendTo(inputId);
}