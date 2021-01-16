$(()=>{
  
  $('[name=preco_max],[name=preco_min]').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});

  $(":input").bind('keyup change input', function () {
    sendRequest()
  })

  function sendRequest(){
    $('form').ajaxSubmit({
      data:{'nome_imovel':$('input[name=texto__busca]').val()},
      success:function(data){
        $('.lista__imoveis .container').html(data);
      }
    })
  }

})