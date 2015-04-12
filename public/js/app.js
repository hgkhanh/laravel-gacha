$(function(){
    window.setInterval(function(){
        $(".coin_area").html(parseInt($(".coin_area").html()) + 1);
    }, 1000);
});