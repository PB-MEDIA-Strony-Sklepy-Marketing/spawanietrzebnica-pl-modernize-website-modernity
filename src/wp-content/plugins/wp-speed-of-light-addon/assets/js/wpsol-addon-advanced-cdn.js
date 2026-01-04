jQuery(document).ready(function ($) {
    // Show account api display
    if($("#cloudflare-cache").is(":checked")){
        $("#cloudflare-cache-form").show();
    }
    if($("#keycdn-cache").is(":checked")){
        $("#keycdn-cache-form").show();
    }
    if($("#maxcdn-cache").is(":checked")){
        $("#maxcdn-cache-form").show();
    }

    if($("#varnish-cache").is(":checked")){
        $("#varnish-cache-form").show();
    }

    $(".thirds-party-select").on('change',function(){
        var selected = $(this).attr('id');
        if ($(this).is(':checked')) {
            $("#"+selected+"-form").show("blind", 500);
        }else{
            $("#"+selected+"-form").hide("blind", 500);
        }

    });

    // On change Cloudflare purge type
    if ($('#cf-pruge-type').val() === 'individual') {
        $('#cf-purge-urls').show();
    } else {
        $('#cf-purge-urls').hide();
    }

    $('#cf-pruge-type').on('change', function () {
        if ($('#cf-pruge-type').val() === 'individual') {
            $('#cf-purge-urls').show();
        } else {
            $('#cf-purge-urls').hide();
        }
    });

    // Remove empty string
    $('#cf-purge-urls').val($('#cf-purge-urls').val().trim());

    // Click to Purge Cloudflare button
    $('#purge-cf-cache-btn').on('click', () => {
        if ($('#cloudflare-cache').is(':checked')) {
            var params = {
                'username' : $('#cloudflare-cache-form input[name=cloudflare-username]').val().trim(),
                'key' : $('#cloudflare-cache-form input[name=cloudflare-key]').val().trim(),
                'domain' : $('#cloudflare-cache-form input[name=cloudflare-domain]').val().trim(),
                'purge_type' : $('#cloudflare-cache-form select[name=cloudflare-purgetype]').val().trim(),
                'purge_urls' : $('#cloudflare-cache-form textarea[name=cloudflare-urls]').val().trim()
            };
            // sent ajax request
            $.ajax({
                url: wpsolAddonParams.ajaxurl,
                dataType: 'json',
                method: 'POST',
                data: {
                    action: 'wpsol_ajax_single_purge_cf_cache',
                    wpsol_ajax_nonce: wpsolAddonParams.wpsol_nonce,
                    params: params
                },
                beforeSend: function () {
                    $('.cdn-ajax-message .ajax-loader-icon').show();
                },
                success: function (res) {
                    $('.cdn-ajax-message .ajax-loader-icon').hide();
                    if (typeof res !== "undefined" && res.message !== '') {
                        if (res.message.indexOf('success') !== -1) {
                            $('.cdn-ajax-message .cdn-ajax-result').removeClass('ju-notice-error').addClass('ju-notice-success').html('<strong>'+res.message+'</strong>').show();
                        } else {
                            $('.cdn-ajax-message .cdn-ajax-result').removeClass('ju-notice-success').addClass('ju-notice-error').html('<strong>'+res.message+'</strong>').show();
                        }
                    }
                }
            })
        }
    });

});

