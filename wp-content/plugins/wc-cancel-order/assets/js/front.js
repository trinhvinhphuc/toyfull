function wc_cancel_get_param(name,url){
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function get_wc_cancel_reason_text(){
    var html = '';
    html = '<div class="wc-cancel-txt-main">';
    html+= '<div class="wc-cancel-reasons-head">'+wc_cancel.wcc_additional+'</div>';
    html+= '<div class="wc-cancel-reason-txt"><textarea name="wc-cancel-additional-text" rows="5"></textarea></div>';
    html+= '</div>';
    return html;
}

function get_wc_cancel_note(note){
    return note.trim()!=='' ? '<div class="wc-cancel-note">'+note+'</div>' : '';
}

jQuery(function($){

    $.Wc_Cancel_Order = function(opts) {
        opts = $.extend(
            true,
            {
                title: "Request Order Cancellation",
                note : "",
                sub_title: "",
                message: [],
                order_id: "",
                confirm_btn: "Confirm Cancellation",
                close_btn: "Close",
                security : "",
                callback: $.noop
            },
            opts || {}
        );

        $.fancybox.open({
            type: "html",
            src:
                '<div class="wc-cancel-main"><form method="post" id="wc-cancel-form">' +
                '<div class="wc-cancel-head">' + opts.title + '</div>' +
                '<div class="wc-cancel-order-num">' + opts.sub_title + '</div>' +
                 get_wc_cancel_note(opts.note) +
                '<div class="wc-cancel-notice"></div>' +
                '<div class="wc-cancel-reason-text">' + get_wc_cancel_reason_text() + '</div>' +
                '<p class="wc-cancel-buttons">' +
                '<button type="button" data-value="0" data-fancybox-close class="btn btn-primary wc-cancel-close">' + opts.close_btn + "</button>" +
                '<button type="button" data-key="'+opts.security+'" data-value="1" data-order-id="'+opts.order_id+'" class="btn btn-primary wc-cancel-confirm">' + opts.confirm_btn + "</button>" +
                '</p>' +
                '<p class="wcc-load"></p>'+
                '</form></div>',
            opts: {
                animationDuration: 350,
                animationEffect: "material",
                modal: true,
                baseTpl:
                    '<div class="fancybox-container fc-container" role="dialog" tabindex="-1">' +
                    '<div class="fancybox-bg"></div>' +
                    '<div class="fancybox-inner">' +
                    '<div class="fancybox-stage"></div>' +
                    "</div>" +
                    "</div>",
                afterShow: function(instance,current, e){
                    $(".wc-cancel-main").on("click","button.wc-cancel-confirm",function(e){
                        var button = e ? e.target || e.currentTarget : null;
                        var value = button ? $(button).data("value") : 0;
                        var key = button ? $(button).data("key") : '';
                        opts.callback(value,key);
                    });
                }
            }
        });
    };

    $(document).on('click','a.wc-cancel-order',function(e){
        e.stopPropagation();
        e.preventDefault();
        var cancel_url = $(this).attr('href');
        var order_id = wc_cancel_get_param('order_id',cancel_url),
            order_num = wc_cancel_get_param('order_num',cancel_url),
            order_key = wc_cancel_get_param('key',window.location.href),
            cancel_reason = '',
            cancel_reason_text = '';
        $.Wc_Cancel_Order({
            order_id:order_id,
            title: wc_cancel.wcc_head_text,
            sub_title: wc_cancel.wcc_order_text+order_num,
            note: wc_cancel.wcc_note,
            text_input: wc_cancel.wcc_text_input,
            confirm_btn: wc_cancel.wcc_confirm,
            close_btn: wc_cancel.wcc_close,
            security: wc_cancel.wcc_nonce,
            callback: function(value,key){
                if(value){

                    if($('textarea[name=wc-cancel-additional-text]','#wc-cancel-form').length){
                        if(wc_cancel.wcc_text_required && $('textarea[name=wc-cancel-additional-text]','#wc-cancel-form').val().trim()===''){
                            $(document).find('.wc-cancel-notice').html('<span class="wcc_error">'+wc_cancel.wcc_txt_error+'</span>');
                            return false;
                        }
                        else
                        {
                            cancel_reason_text = $('textarea[name=wc-cancel-additional-text]','#wc-cancel-form').val();
                        }
                    }

                    $(document).find('.wcc-load').html('<div class="fancybox-loading"></div>');
                    parent.jQuery.fancybox.getInstance().update();
                    $("button.wc-cancel-confirm").prop('disabled',true);

                    $.ajax({
                        type	: "POST",
                        cache	: false,
                        url     : cancel_url,
                        dataType : 'json',
                        data: {
                            'order_id' : order_id,
                            'reason' : cancel_reason,
                            'additional_details' : cancel_reason_text,
                            'order_key' : order_key,
                            '_wpnonce' : key,
                            'wcc_ajax' : true
                        },
                        success: function(data){
                            if(data.res){
                                if(data.hasOwnProperty("fragments")){
                                    $.each(data.fragments, function(key,value){
                                        $(key).replaceWith(value);
                                    });
                                }
                            }
                            setTimeout(function(){
                                window.location.reload();
                                },1500);

                        }
                    });
                }
            },
        });
    });
});