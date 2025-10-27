jQuery(document).ready(function ($) {
    var checked = $("input[name=move-script-to-footer]:checked").length;
    if (checked) {
        $(".exclude-script-mtf").show();
    }

    var layzychecked = $("input[name=lazy-loading]:checked").length;
    if (layzychecked) {
        $(".exclude-lazyloading-mtf").show();
    }

    $("input[name=move-script-to-footer]").click(function(){
        var checked = $("input[name=move-script-to-footer]:checked").length;
        if (checked) {
            $(".exclude-script-mtf").show('slow');
        } else {
            $(".exclude-script-mtf").hide('slow');
        }
    });

    $("input[name=lazy-loading]").click(function(){
        var checked = $("input[name=lazy-loading]:checked").length;
        if (checked) {
            $(".exclude-lazyloading-mtf").show('slow');
        } else {
            $(".exclude-lazyloading-mtf").hide('slow');
        }
    });

    // Show/Hide textarea exclude from defer css
    let excludeDeferCSS = $("input[name=defer-css]:checked").length;
    if (excludeDeferCSS) {
        $(".exclude-path-from-defer-css").show();
    }

    // onclick button
    $('input[name=defer-css]').click(function(){
        let checked =  $('input[name=defer-css]:checked').length;
        if (checked) {
            $(".exclude-path-from-defer-css").show('slow');
        } else {
            $(".exclude-path-from-defer-css").hide('slow');
        }
    });

    // trim textarea value
    var textarea = $("textarea");
    textarea.each(function () {
        this.value = this.value.trim();
    });
});

