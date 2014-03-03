$(document).on('ready', function(){

  AlxFormJs.init();

});


var AlxFormJs = new (function(){

  var self = this;
  this.wrap_error = "";

  this.init = function()
  {
    self.wrap_error = $('#alxform_wrap_error');
    $('#alxform_btn').on('click',self.validacion);
  }

  this.validacion = function()
  {
    self.wrap_error.html('');

    if($.trim($('#alxform_name').val()) == '')
    {
      self.wrap_error.html("Por favor ingrese su nombre");
      $('#alxform_name').focus();
      return false; 
    }
    if($.trim($('#alxform_email').val()) == '')
    {
      self.wrap_error.html("Por favor ingrese su email");
      $('#alxform_email').focus();
      return false; 
    }
    if($.trim($('#alxform_tel').val()) == '')
    {
      self.wrap_error.html("Por favor ingrese su telefono");
      $('#alxform_tel').focus();
      return false; 
    }
    if($.trim($('#alxform_cd').val()) == '')
    {
      self.wrap_error.html("Por favor ingrese su Ciudad");
      $('#alxform_cd').focus();
      return false; 
    }
    if($.trim($('#alxform_msj').val()) == '')
    {
      self.wrap_error.html("Por favor ingrese su mensaje");
      $('#alxform_msj').focus();
      return false; 
    }
    
    $('form#alxform_form').submit();
  };

})();
