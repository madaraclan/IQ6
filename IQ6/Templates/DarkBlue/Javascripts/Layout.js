var shareInputBox = null;
$(function() {
    shareInputBox = $(".BoxInputText .ShareStatus").val();

    $(".BoxInputText .ShareStatus").focus(function() {
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

    $(".editable").click(function() {
        //this.contentEditable = true;
    });
})