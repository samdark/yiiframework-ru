function answer_reply(answer_id) {
    $("#answer-parent_id").val(answer_id);
}

$(document).ready(function () {
    $('.q-info-like').click(function () {
        var clickElement = $(this);
        $.ajax({
            url: clickElement.data('url'),
            method: "get",
            data: {
                id: clickElement.data('questionid')
            },
            context: clickElement,
            success: function (status) {
                if (status == 1) {
                    this.addClass('active');
                } else {
                    this.removeClass('active');
                }

                this.children('.like-count').text(function () {
                    return parseInt(this.innerText) + parseInt(status);
                });
            }
        });
        return false;
    });
});