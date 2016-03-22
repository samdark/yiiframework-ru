function answer_reply(answer_id)
{
    $("#answer-parent_id").val(answer_id);
}

$(function () {
    $('.q-info-like > a').click(function () {
        var $link = $(this),
            $parent = $link.closest('.q-info-like');
        $.ajax({
            url: $link.attr('href'),
            method: "get",
            // TODO Лучше реализовать через Post
            //data: {
            //    id: $link.data('question-id'),
            //    _csrf: yii.getCsrfToken()
            //},
            //context: clickElement,
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