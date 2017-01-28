$("document").ready(function(){
    if ($('.markdown-editor').length) {
        initEditor($('.markdown-editor'));
    }

	if( document.cookie.indexOf('yii-feature=close') != -1 ){
		$(".yii-features").toggleClass('f-hidden');
	}
	$(".ico-f-close").click(function(){
		$(".yii-features").toggleClass('f-hidden'); // Close features
		document.cookie = 'yii-feature=close;max-age=' + 86400 * 365 * 5 +';'
	});

    $(".subnav-btn").click(function(){
        $(".subnav-all").toggleClass('subnav-visible'); // Show subnav on mobile
    });

    $("#add-comm-01").click(function(){
        $("#comm-01").toggleClass('comm-visible'); // Show add comment block
    });

    $("#add-comm-02").click(function(){
        $("#comm-02").toggleClass('comm-visible'); // Show add comment block
    });

    $("#add-comm-03").click(function(){
        $("#comm-03").toggleClass('comm-visible'); // Show add comment block
    });

    $(".sect-title").sticky({ topSpacing: 0, bottomSpacing: 840, center:true, className:"title-stick" }); // Sticker page title
    $(".subnav").sticky({ topSpacing: 140, bottomSpacing: 400, center:true, className:"subnav-stick" }); // Sticker page subnav
});