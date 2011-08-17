var shareInputBox = null;
$(function() {
    shareInputBox = $(".BoxInputText input[type=text]").val();

    $(".BoxInputText input[type=text]").focus(function() {
        if ($(this).val() == shareInputBox) {
            $(this).val("");
            $(this).addClass('Active');
        }
        
    }).blur(function() {
        if($(this).val() == "") {
            $(this).val(shareInputBox);
            $(this).removeClass('Active');
        }
    });
})