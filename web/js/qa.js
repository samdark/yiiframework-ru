function answer_reply(answer_id)
{
    $("#answer-parent_id").val(answer_id);
}

$(function () {
    $('.q-info-like > a').click(function () {
        var $link = $(this),
            $parent = $link.closest('.q-info-like'),
            questionId = $link.data('question-id');
        $.ajax({
            url: $link.attr('href'),
            method: "post",
            data: {
                questionId: questionId,
                _csrf: yii.getCsrfToken()
            },
            success: function (status) {
                if (status == 1) {
                    $parent.addClass('active');
                } else {
                    $parent.removeClass('active');
                }

                $parent.children('span').text(function () {
                    return parseInt(this.innerText) + parseInt(status);
                });
            }
        });

        return false;
    });
});
