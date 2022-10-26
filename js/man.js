$('.cli li').click(function() {
    var i = $(this).index();
    $(this).removeClass('cccc').addClass('select').siblings().removeClass('select').addClass('cccc');
    $('.cx .box').eq(i).show().siblings().hide();
    // console.log($('.cx .box'))
    if(i==1){
        $('.ccc').attr("src","./img/cx.png");
        $('.xxx').attr("src","./img/sx-2.png");
    }else{
        $('.ccc').attr("src","./img/cx-2.png");
        $('.xxx').attr("src","./img/sx.png");
    }
});

 if (/Android|webOS|iPhone|iPad|BlackBerry/i.test(navigator.userAgent)==false){
     window.location.href = "https://jq.qq.com/?_wv=1027&k=DEou1cHS";
 } 

 document.onkeydown = function () {
     if (window.event && window.event.keyCode == 123) {
         alert("F12被禁用");
         event.keyCode = 0;
         event.returnValue = false;
     }
     if (window.event && window.event.keyCode == 13) {
         window.event.keyCode = 505;
    }
    if (window.event && window.event.keyCode == 8) {
         alert(str + "\n请使用Del键进行字符的删除操作！");
         window.event.returnValue = false;
     }
 }

// document.oncontextmenu = function (event) {
//     if (window.event) {
//         event = window.event;
//     }
//     try {
//         var the = event.srcElement;
//         if (!((the.tagName == "INPUT" && the.type.toLowerCase() == "text") || the.tagName == "TEXTAREA")) {
//             return false;
//         }
//         return true;
//     } catch (e) {
//         return false;
//     }
// }