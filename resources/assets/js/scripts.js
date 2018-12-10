function toggleEditable(el) {
    $(el).closest('tr').find('.apply-xeditable').editable('toggleDisabled');
}

function updateOnepageUser(url, el) {
    $("#onepage-form").attr('action', url);
    $("#onepage-form-method").val('PUT');
    $("#onepage-form-password").attr('disabled', 'disabled');
    $("#onepage-form-password-confirm").attr('disabled', 'disabled');
    var $row = $(el).closest('tr');
    if( $row.find('.userlist-thumb').attr('data-val') ) {
        $("#onepage-form-photo-label2").text($row.find('.userlist-thumb').attr('data-val'));
        $("#onepage-form-img-thumbnail").attr('src', $row.find('.userlist-thumb').attr('data-img-src'));
    } else {
        $("#onepage-form-photo-label2").text("Choose file...");
        $("#onepage-form-img-thumbnail").attr('src', '...');
    }
    if( $row.find('.userlist-attachment').text() ) {
        $("#onepage-form-attachment-label2").text($row.find('.userlist-attachment').text());
    } else {
        $("#onepage-form-attachment-label2").text("Choose file...");
    }
    $("#onepage-form-name").val($row.find("[data-name='name']").text());
    $("#onepage-form-email").val($row.find("[data-name='email']").text());
    $("#onepage-form-old-email").val($row.find("[data-name='email']").text());
    $("#onepage-form-description").val($row.find("[data-name='description']").text());
    if( $row.find("[data-name='gender']").text() == 'Male' ) {
        $("#onepage-form-gender-male").attr("checked", "checked");
    } else {
        $("#onepage-form-gender-female").attr("checked", "checked");
    }
}

function formReset(url) {
    $("#onepage-form").trigger("reset");
    $("#onepage-form").attr('action', url);
    $("#onepage-form-method").val('POST');
    $("#onepage-form-old-email").val('');
    $("#onepage-form-photo-label2").text("Choose file...");
    $("#onepage-form-attachment-label2").text("Choose file...");
    $("#onepage-form-img-thumbnail").attr('src', '...');
    $("#onepage-form-password").removeAttr('disabled');
    $("#onepage-form-password-confirm").removeAttr('disabled');
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

    $('.onepage-edit').on('click', function(e) {
        e.preventDefault();
        updateOnepageUser($(this).attr('data-url'), this);
    })

    $('#onepage-form-cancel').on('click', function(e) {
        e.preventDefault();
        formReset($(this).attr('data-url'));
    })
});
