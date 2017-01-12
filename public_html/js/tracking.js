//обработка ajax запроса поиска трек-номера
$('#search').on('pjax:send', function() {
  $('.spinner').show(500);
  $('#search-results').hide(500);
})
$('#search').on('pjax:complete', function() {
  $('#search-results').show(500);
  $('.spinner').hide(500);
  window.history.replaceState(null, null, "?track="+$('#track-tracknumber').val());
})
$('#search').on('pjax:error', function() {
  $('#canceled-error').show();
  $('#search-results').hide();
})

//Обработчик кнопки отследить в разделе "сохраненные трек-номера"
$('.search-btn').on('click', function() {
    var txt = $(this).attr('track-number');

        $('#track-tracknumber').val(txt);
        $('#track-submit-btn').click();
        console.log ('load_button_pressed');
});


