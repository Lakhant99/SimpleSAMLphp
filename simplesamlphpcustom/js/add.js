(function ($) {
    Drupal.behaviors.simplesamlphpcustom = {
      attach: function (context, settings) {
        $('.js-form-item-role-eval-every-time input.form-checkbox', context).once('simplesamlphpcustom').each(function (e) {     
            var inputBox = $('.js-form-item-keep-default-role input.form-checkbox', context);
            $(this).on('change', function () {
                if ($(this).is (':checked'))  {
                    inputBox.prop('checked', false);
                    inputBox.attr("disabled", true);
                }
                else{
                    inputBox.attr("disabled", false);
                }
            });
            if ($(this).is (':checked'))  {
                inputBox.prop('checked', false);
                inputBox.attr("disabled", true);
            }
        });
        var obsolete = $('input[name="field_obsolete_value"]:checked').val();
        if(obsolete == '2') {
            $('.w3-table-all').find('td').each(function(){
                $(this).find('#obsoleteText').parent().parent().addClass('w3-hide');
            });
        }
        $(document).once('simplesamlphpcustom').ajaxComplete(function (e, xhr, settings) {
            var obsolete = $('input[name="field_obsolete_value"]:checked').val();
            if(obsolete == '2') {
                $('.w3-table-all').find('td').each(function(){
                    $(this).find('#obsoleteText').parent().parent().addClass('w3-hide');
                });
            }
            else{
                $('.w3-table-all').find('td').each(function(){
                    $(this).find('#obsoleteText').parent().parent().removeClass('w3-hide');
                });
            }
        });
      }
  
    };
  })(jQuery);