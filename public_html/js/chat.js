var $isTracking = false;

$(function() {
    window.isActive = true;
    $(window).focus(function() { this.isActive = true;});
    $(window).blur(function() { this.isActive = false;});
});

$('#search').on('pjax:send', function() {
  $isTracking = true;
})
$('#search').on('pjax:complete', function() {
  $isTracking = false;
})

window.onload = function(){
    last_message_id = $('.message').first().attr('id');
    setCookie('last_message_id', last_message_id);
    setCookie('message_count' ,5);
    $.pjax.reload({container: "#chat-pjax"});
};

setInterval(function(){
    if(!$isTracking && window.isActive)
    {
    last_message_id = $('.message').first().attr('id');
    setCookie('last_message_id', last_message_id);
    setCookie('message_count' ,$('.message').length);
    $.pjax.reload({container: "#chat-pjax", timeout:10000});
    console.log ('chat_update_v3');
    }
    else
    {
        console.log ('busy, no chat update');
    }
}, 5000);

var urlIndex = $('#chat-send-btn').attr('url_for_js');
    $('#chat-form').submit(function(){
            addMessageCount(0);
            event.preventDefault();
            $('#chat-send-btn').prop("disabled",true);
            var data = $('#chat-form').serialize();
            $.post(urlIndex,data,function(data,status){
              if( status == 'success' )
                $.pjax.reload({container: "#chat-pjax"});
                $('#chat-message_text').val('');
                $('#chat-send-btn').prop("disabled",false);
                        var date = new Date();
                        date.setTime(date.getTime() + (30 * 1000));
                        document.cookie="message_sent=true;path=/;"+date;
        })
});

$('#message_more').click(function(){
    addMessageCount(5);
    $.pjax.reload({container: "#chat-pjax"});
    $('#message_more').hide();
});

function addMessageCount(value)
{
    setCookie('message_count', value + parseInt( getCookie('message_count') ));
}

jQuery(function($) {
    $('.panel-body').on('scroll', function() {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            addMessageCount(5);
            $.pjax.reload({container: "#chat-pjax"});
        }
    })
});

