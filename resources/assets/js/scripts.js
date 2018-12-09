$(document).ready(function(){
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
