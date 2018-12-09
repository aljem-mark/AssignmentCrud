function toggleEditable(el) {
    $(el).closest('tr').find('.apply-xeditable').editable('toggleDisabled');
}

$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '.toggle-editable', function(e) {
        toggleEditable(this);
    });

    $.fn.editable.defaults.mode = 'inline';
    $.fn.editable.defaults.disabled = true;
    $.each($('.apply-xeditable'), function(index, value){
        if ($(value).hasClass('gender')) {
            $(this).editable({
                source: [
                      {value: 'male', text: 'Male'},
                      {value: 'female', text: 'Female'},
                   ],
                error: function(response, newValue) {
                    if(response.status === 500) {
                        return 'Service unavailable. Please try later.';
                    } else {
                        var errors = response.responseJSON;
                        errorsHtml = '<div class="alert alert-danger" role="alert"><h4 class="alert-heading">Error:</h4><ul>';
                        $.each( errors, function( key, value ) {
                            errorsHtml += '<li>'+ value + '</li>';
                        });
                        errorsHtml += '</ul></di>';
                        $(".editable-error-block").html(errorsHtml);
                    }
                }
            });
        } else {
            $(this).editable({
                error: function(response, newValue) {
                    if(response.status === 500) {
                        return 'Service unavailable. Please try later.';
                    } else {
                        var errors = response.responseJSON;
                        errorsHtml = '<div class="alert alert-danger" role="alert"><h4 class="alert-heading">Error:</h4><ul>';
                        $.each( errors, function( key, value ) {
                            errorsHtml += '<li>'+ value + '</li>';
                        });
                        errorsHtml += '</ul></di>';
                        $(".editable-error-block").html(errorsHtml);
                    }
                }
            });
        }
    });

    $('.custom-file-input').on('change', function(e){
        var fileName = e.target.files[0].name;
        $(this).closest('.custom-file').find('.custom-file-label').text(fileName);

        var input = this;
        var url = $(this).val();
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
        {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(input).closest('.form-group').find('.img-thumbnail').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
        else
        {
            $(this).closest('.form-group').find('.img-thumbnail').attr('src', '/assets/no_preview.png');
        }
    });
});
