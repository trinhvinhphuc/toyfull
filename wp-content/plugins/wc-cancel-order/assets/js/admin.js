function wc_cancel_get_param(name,url){
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function wc_cancel_box_btn(btn,btn_txt){
    if(btn){
        return '<button type="button" data-value="1" class="button-primary wcc-confirm">' + btn_txt + "</button>";
    }
    else
    {
        return '';
    }
}

function wc_cancel_spinner(spin){
    if(!spin){
        return '<div class="wcc-spinner"><div class="fancybox-loading"></div></div>';
    }
    else
    {
        return '';
    }
}

jQuery(function($){
    var wcc_request = null;
    $.Wc_Cancel_Confirm = function(opts) {
        opts = $.extend(
            true,
            {
                title: "",
                sub_title:"",
                message: "",
                wcc_btn: false,
                okButton: "OK",
                noButton: "Cancel",
                callback: $.noop
            },
            opts || {}
        );

        $.fancybox.open({
            type: "html",
            src:
                '<div class="wc-cancel-admin-main">' +
                '<div class="wc-cancel-head">' + opts.title + "</div>" +
                '<div class="wc-cancel-order-num">' + opts.sub_title + '</div>' +
                '<div class="wc-cancel-note">'+wc_cancel_spinner(opts.wcc_btn)+'</div>'+
                '<p class="wc-cancel-buttons">' +
                '<button type="button" data-fancybox-close class="button wcc-close">' + opts.noButton + "</button>" +wc_cancel_box_btn(opts.wcc_btn,opts.okButton)+ "</p>" +
                "</div>",
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
                afterShow: function(instance, current, e){
                    $(".wc-cancel-admin-main").on("click","button.wcc-confirm",function(e){
                        var button = e ? e.target || e.currentTarget : null;
                        var value = button ? $(button).data("value") : 0;
                        opts.callback(value);
                    });

                    if(!opts.wcc_btn){
                        opts.callback(1);
                    }
                }
            }
        });
    };

    $('.wc-cancel-order-list table.wp-list-table tr td.order_actions a').click(function(e){
        e.stopPropagation();
        e.preventDefault();
        var wcc_box = false,
            wcc_btn = false,
            wcc_title = '';
        if($(this).hasClass('wc-cancel-view-req')){
            wcc_box = true;
            wcc_title = wc_cancel_back.wcc_view;
        }
        else if($(this).hasClass('wc-cancel-approve-req')){
            wcc_box = true;
            wcc_btn = true;
            wcc_title = wc_cancel_back.wcc_approval;
        }
        else if($(this).hasClass('wc-cancel-decline-req')){
            wcc_box = true;
            wcc_btn = true;
            wcc_title = wc_cancel_back.wcc_decline;
        }

        if(wcc_box){
            var cancel_url = $(this).attr('href');
            var order_num = wc_cancel_get_param('order_num',cancel_url),
                order_id = wc_cancel_get_param('order_id',cancel_url);
            $.Wc_Cancel_Confirm({
                title: wcc_title,
                sub_title: wc_cancel_back.wcc_order_text+order_num,
                message: "",
                wcc_btn: wcc_btn,
                okButton: wc_cancel_back.wcc_confirm_btn,
                noButton: wc_cancel_back.wcc_close,
                callback:function(value){
                    if(value){
                        wcc_request = $.ajax({
                            type	: "POST",
                            cache	: false,
                            url     : cancel_url,
                            dataType : 'json',
                            data: {
                                'order_id' : order_id,
                                'wcc_ajax' : true,
                            },
                            beforeSend:function(){
                                if(wcc_request != null){
                                    wcc_request.abort();
                                }
                                $(document).find('.wc-cancel-admin-main .wc-cancel-note').html('<div class="wcc-spinner"><div class="fancybox-loading"></div></div>');
                                parent.jQuery.fancybox.getInstance().update();
                                $(document).find("button.wcc-confirm").prop('disabled',true);
                            },
                            success: function(data){
                                if(data.reload){
                                    window.location.reload();
                                }
                                else
                                {
                                    $(document).find('.wc-cancel-admin-main .wc-cancel-note').html(data.html);
                                    parent.jQuery.fancybox.getInstance().update();
                                }
                            }
                        });
                    }
                }
            });
        }

    });
});
