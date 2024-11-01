!function($){var a={init:function(a){var c,b=$.extend({placeholder:!1,allowClear:!1,autofocus:!0,search:!!$(this).attr("data-wpm-search")&&"true"==$(this).attr("data-wpm-search")},a),d=b.search?"wpm-select-wrap_open":"wpm-select-wrap_open-dropdown";return this.each(function(){var h,g,k,e=this;$(e).css({position:"absolute",zIndex:"-1",opacity:"0",width:"1px",height:"1px"}),$(e).on("change",function(){var a=$(this).val();f.trigger("click",!0),p.children().filter(function(e,b){var c=a.toLowerCase().trim(),d=$(this).attr("data-wpmval").toLowerCase().trim();c===d&&s($(b),!0)})}),$(this).attr("data-wpm-placeholder")&&(h=$(this).attr("data-wpm-placeholder"),$(e).prepend('<option disabled value=""></option>'),$(e).val($(e).children().first().val()));var q={options:[]},l=$('<div class="wpm-select-wrap"></div>'),f=$('<div class="wpm-select-placeholder"></div>');h?(g=$("<div class='wpm-select-placeholder__single'></div>"),f.append(g),k=$("<div class='wpm-select-placeholder__rendered'>"+h+"</div>"),f.append(k)):(g=$("<div class='wpm-select-placeholder__single'>"+e.options[0].innerText+"</div>"),f.append(g));var i=$('<div class="wpm-select-placeholder__buttons"></div>'),m=$('<div class="wpm-select-placeholder__arrow"><svg height="20" width="20" viewBox="0 0 20 20"><path fill="rgb(40, 43, 93)" d="M4.516 7.548c0.436-0.446 1.043-0.481 1.576 0l3.908 3.747 3.908-3.747c0.533-0.481 1.141-0.446 1.574 0 0.436 0.445 0.408 1.197 0 1.615-0.406 0.418-4.695 4.502-4.695 4.502-0.217 0.223-0.502 0.335-0.787 0.335s-0.57-0.112-0.789-0.335c0 0-4.287-4.084-4.695-4.502s-0.436-1.17 0-1.615z"></path></svg></div>');if(f.append(i),m.on("click",function(a){l.hasClass(d)&&(a.preventDefault(),a.stopPropagation(),t=!1,l.removeClass(d))}),i.append(m),b.allowClear&&b.search){var n=$('<div style="opacity: 0;" class="wpm-select-placeholder__clear"><svg height="20" width="20" viewBox="0 0 20 20"><path fill="rgb(40, 43, 93)" d="M14.348 14.849c-0.469 0.469-1.229 0.469-1.697 0l-2.651-3.030-2.651 3.029c-0.469 0.469-1.229 0.469-1.697 0-0.469-0.469-0.469-1.229 0-1.697l2.758-3.15-2.759-3.152c-0.469-0.469-0.469-1.228 0-1.697s1.228-0.469 1.697 0l2.652 3.031 2.651-3.031c0.469-0.469 1.228-0.469 1.697 0s0.469 1.229 0 1.697l-2.758 3.152 2.758 3.15c0.469 0.469 0.469 1.229 0 1.698z"></path></svg></div>');i.prepend(n),n.on("click",function(b){l.hasClass(d)||(p.html(""),h?($(e).val(""),g.text(""),k.text(h)):($(e).val($(e.options).first().val()),g.text($(e.options).first().text())),g.removeClass("wpm-select-placeholder__single_active"),p.find(".wpm-select-dropdown__option").first().addClass("wpm-select-dropdown__option_highlighted").siblings().removeClass("wpm-select-dropdown__option_highlighted"),j.focus(),j.val("").trigger("keyup"),t=!0,l.addClass(d),void 0!==a.onClear&&a.onClear($(e)))})}if(b.search){var j=$('<input type="text" class="wpm-select-placeholder__search">');f.prepend(j),j.on("keyup",function(a){clearTimeout(c);var b=$(this);p.html("");var d=b.val().toLowerCase().trim();d?q.options.filter(function(a){$(a).text().toLowerCase().trim().indexOf(d)> -1&&p.append($(a))}):q.options.filter(function(a){p.append($(a))}),p&&p.find(".wpm-select-dropdown__option").first().addClass("wpm-select-dropdown__option_highlighted"),r(p.find(".wpm-select-dropdown__option")),0==p.children().length&&p.html('<div class="wpm-select-dropdown__empty">No options</div>'),("Enter"===a.key||13===a.keyCode)&&s(p.find(".wpm-select-dropdown__option_highlighted"),!0)}),j.on("keydown",function(a){9===a.keyCode&&s(p.find(".wpm-select-dropdown__option_highlighted"),!0)})}l.append(f),$(e).after(l);var o=$('<div class="wpm-select-dropdown-container"></div>'),p=$('<div class="wpm-select-dropdown"></div>');function r(a){a.on("mouseenter",function(){$(this).addClass("wpm-select-dropdown__option_highlighted").siblings().removeClass("wpm-select-dropdown__option_highlighted")}),s(a)}function s(b,c){b.on("click",function(b){b.stopPropagation(),b.stopImmediatePropagation();var g=$(this).attr("data-wpmval").toLowerCase().trim(),c=$(this).text();f.find(".wpm-select-placeholder__single").text(c).addClass("wpm-select-placeholder__single_active"),t=!1,l.removeClass(d),$(e.options).filter(function(c,a){var b=$(a).val().toLowerCase().trim();g===b&&$(e).val($(a).val())}),void 0!==a.onSelected&&a.onSelected($(e))}),c&&b.trigger("click")}o.append(p),$("body").on("click",function(a){t=!1,l.removeClass(d)});var t=!1,u=!1;f.on("click",function(c,g){if(c.stopPropagation(),!u){u=!0;for(var h=document.createDocumentFragment(),a=0;a<e.options.length;a++)if(e.options[a].value){var c=document.createElement("div");c.className="wpm-select-dropdown__option",c.setAttribute("data-wpmval",$(e.options[a]).clone().val()),c.textContent=$(e.options[a]).clone().text(),h.appendChild(c),q.options.push('<div class="wpm-select-dropdown__option" data-wpmval="'+$(e.options[a]).val()+'">'+$(e.options[a]).text()+"</div>")}p.get(0).appendChild(h),f.after(o)}t||(g||(t=!0),p.find(".wpm-select-dropdown__option_highlighted").length||p.find(".wpm-select-dropdown__option").first().addClass("wpm-select-dropdown__option_highlighted"),!g&&(l.addClass(d),b.autofocus&&b.search&&j.get(0).focus()),r(p.find(".wpm-select-dropdown__option")))})})},show:function(){},hide:function(){},setVal:function(a){var b=this;$(this).children().each(function(){($(this).val()&&$(this).val().toLowerCase().trim())===(a&&a.toLowerCase().trim())&&$(b).val(a).trigger("change")})}};$.fn.wpmSelect=function(b){return a[b]?a[b].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof b&&b?void $.error("Method "+b+" does not exist on jQuery.wpmSelect"):a.init.apply(this,arguments)}}(jQuery);

jQuery(document).ready(function($) {

    jQuery(document).on('click', '#what-is-sprinque, #wat-is-sprinque', function(){
        WhatIsSprinque.open({ lang: document.documentElement.lang.substring(0, 2) ?? 'en', netTermsDays: window.admin.pay_in_x_days });
    });

    var countries = [];

    function getLang() {
        let language = document.documentElement.lang;
        language = language.replace('_', '-');
        language = language.split('-');
        language = language.shift();

        return language;
    }

    function PaymentTermSelect() {
        this.payment_terms = window.admin.payment_terms;
        this.amount = 0;
        this.selected_fee = 0;
        this.selected_term = null;
        this.eligible_payment_terms = [];

        if (typeof this.payment_terms === "undefined") {
            this.payment_terms = {};
        }
    }

    PaymentTermSelect.prototype = {
        setEligiblePaymentTerms(paymentTerms) {
            this.eligible_payment_terms = paymentTerms;
        },
        setAmount(amount) {
            this.amount = amount;
            this.recalculateTotal();
        },
        setSelected(term) {
            if (typeof this.payment_terms[term] === "undefined") {
                return ;
            }

            this.selected_fee = this.payment_terms[term];
            this.selected_term = term.toUpperCase();

            this.recalculateTotal();
        },
        getPaymentTerm() {
            return this.selected_term;
        },

        update() {
            let is_terms = false;
            let is_instalments = false;
            if( $(document).find('#wpm-terms').find('.wpm-terms-row').length > 0 ){
                $(document).find('#wpm-terms').find('.wpm-terms-row').remove();
            }
            if( $(document).find('.wpm-instalments-row').length > 0 ){
                $(document).find('.wpm-instalments-row').remove();
            }
            for (let key in this.payment_terms) {
                if( key === 'pay_in_3' ||  key === 'pay_in_6' ||  key === 'pay_in_9' ||  key === 'pay_in_12' ){
                    continue;
                }
                const keyUpper = key.toUpperCase();
                if (this.eligible_payment_terms.indexOf(keyUpper) > -1) {
                    const availableTermUpperCase = this.eligible_payment_terms[keyUpper];
                    const fee = this.payment_terms[key];
                    const days = key.replace('net', '');
                    const format = window.admin.net_term_format;
                    const label = format.replace('%s', days);

                    if ( typeof fee === "undefined" ) {
                        continue;
                    }

                    $('.wpm-modal-form-tab__terms').append(`
                    <label class="wpm-terms-row">
                        <input type="radio" name="wpm_net_term" value="${availableTermUpperCase}" data-fee="${fee}" data-term="${key}" />
                        <div class="input-placeholder"></div>
                        <div class="label">${label}</div>
                        <div class="value">${this.calculateWithFee(fee)}</div>
                    </label>
                `);
                }
                is_terms = true;
            }
            for (let key in this.payment_terms) {
                if( key === 'pay_in_3' ||  key === 'pay_in_6' ||  key === 'pay_in_9' ||  key === 'pay_in_12' ){
                    const keyUpper = key.toUpperCase();
                    if (this.eligible_payment_terms.indexOf(keyUpper) > -1) {
                        const availableTermUpperCase = this.eligible_payment_terms[keyUpper];
                        const fee = this.payment_terms[key];
                        const instalments = key.replace('pay_in_', '');
                        const format = window.admin.pay_in_instalments_format;
                        const label = format.replace('%s', instalments);

                        if ( typeof fee === "undefined" ) {
                            continue;
                        }

                        const totalAmount = this.getCalculatedTotal(fee);
                        const numberOfMonths = parseInt(instalments);
                        const monthlyAmount = totalAmount / numberOfMonths;

                        
                        // Create and append the dynamic HTML
                        let dynamicHtml = `
                            <label class="wpm-instalments-row">
                                <div class="wpm-instalments-row-label">
                                    <input type="radio" name="wpm_net_term" value="${availableTermUpperCase}" data-fee="${fee}" data-term="${key}">
                                    <div class="input-placeholder"></div>
                                    <div class="label">${label}</div>
                                    <div class="value">${this.calculateWithFee(fee)}</div>
                                </div>
                                <div class="wpm-instalments-row-circles">
                        `;

                        // Add wpm-instalments-row-circle-item elements
                        for (let i = 1; i <= numberOfMonths; i++) {
                            const label = i * 30 + ' ' + window.admin.days;
                            dynamicHtml += `
                                <div class="wpm-instalments-row-circle-item">
                                    <div class="wpm-instalments-row-circle-item-days">${label}</div>
                                    <div class="wpm-instalments-row-circle-item-price">${window.admin.currency_symbol}${monthlyAmount.toFixed(2)}</div>
                                </div>
                            `;

                            // Add the arrow element after all but the last circle item
                            if (i < numberOfMonths) {
                                dynamicHtml += `<div class="wpm-instalments-row-circle-item-arrow"></div>`;
                            }
                        }

                        dynamicHtml += `
                                </div>
                            </label>
                        `;

                        $('.wpm-instalments-options').append(dynamicHtml);
                        is_instalments = true;

                    }
                }
            }

            if( is_instalments && is_terms ) {
                jQuery('#wpm-terms-and-instalments').show();
                jQuery('.wpm-modal-form-tab__dsc_terms_and_instalments').show();
                jQuery('.wpm-modal-form-tab__dsc_terms').hide();
            }else if( is_terms && ! is_instalments ) {
                jQuery('#wpm-terms-and-instalments').hide();
                jQuery('.wpm-modal-form-tab__dsc_terms_and_instalments').hide();
                jQuery('.wpm-modal-form-tab__dsc_terms').show();
            }
        },

        calculateWithFee(fee) {
            const calculatedFee = ( this.amount * (Number(fee) / 100.0) );

            if (calculatedFee === 0.0) {
                return window.admin.free;
            }

            return '+' + this.formatValue(fee) + '% (' + window.admin.currency_symbol + calculatedFee.toFixed(2) + ')';
        },
        recalculateTotal() {
            const fee = 1.0 + (Number(this.selected_fee) / 100.0);
            const totalWithFee = this.amount * fee;

            jQuery('.wpm-terms-row.total .value').text(window.admin.currency_symbol + totalWithFee.toFixed(2));
        },
        getCalculatedTotal( selected_fee ) {
            const fee = 1.0 + (Number(selected_fee) / 100.0);
            const totalWithFee = this.amount * fee;

            return totalWithFee.toFixed(2);
        },
        formatValue( value ) {
            let number = parseFloat(value); // Convert the string to a number
            if (number % 1 === 0) { // Check if it's an integer
              return number.toString(); // If it is an integer, convert to string without decimals
            } else {
              return number.toFixed(1); // If it's not an integer, keep one decimal place
            }
        }
    };

    const selectPaymentTerm = new PaymentTermSelect();

    if ($('#wpm-modal-form').length) {

        $('body').on('click', '[data-wpm-close]', function(e) {
            e.preventDefault();
            var modal = $(this).attr('data-wpm-close');
            hidePopup(modal);
        });

        $('body').on('click', '[data-wpm-proceed]', function(e) {
            e.preventDefault();
            var modal = $(this).attr('data-wpm-proceed');

            $('#search-by').hide();
            $('#company-name-label').show();

            if (countries.length < 1) {
                get_countries();
            } else {
                toggle_radio_buttons();
            }
            get_companies_list();

            showTab(modal);
        });

        $('body').on('change', '.wpm-terms-row input[type="radio"]', function () {
            const terms = jQuery(this).closest('.wpm-modal-form-tab__terms');
            jQuery('.active', terms).removeClass('active');
            jQuery(this).closest('.wpm-terms-row').addClass('active');
            jQuery('.confirm-order-term').removeAttr('disabled');

            const instalments = jQuery('.wpm-modal-form-tab__instalments');
            jQuery('.active', instalments).removeClass('active');

            recalculateTotal();
        });

        $('body').on('change', '.wpm-instalments-row input[type="radio"]', function () {
            const instalments = jQuery(this).closest('.wpm-modal-form-tab__instalments');
            jQuery('.active', instalments).removeClass('active');
            jQuery(this).closest('.wpm-instalments-row').addClass('active');
            jQuery('.confirm-order-term').removeAttr('disabled');

            const terms = jQuery('.wpm-modal-form-tab__terms');
            jQuery('.active', terms).removeClass('active');

            recalculateTotal();
        });

        $('body').on('click', '.confirm-order-term', function () {
            $(this).attr('disabled', 'disabled');

            authorize_company_payment(function () {
                showTab('.finalizing-order');
                orderPayed = true;
                $('#place_order').trigger( "click" );
            }, {
                payment_terms: selectPaymentTerm.getPaymentTerm()
            });
        });

        $('#wpm-modal-form input, #wpm-modal-form textarea').focus(function() {
            $(this).data('placeholder', $(this).attr('placeholder'))
                .attr('placeholder', '');
        }).blur(function() {
            $(this).attr('placeholder', $(this).data('placeholder'));
        });

        if ($('#select_country_pay').data('select2')) {
            jQuery('#select_country_pay').select2('destroy');
        }

        $('#select_country_pay').wpmSelect({
            search: true,
            allowClear: true,
            onClear: function(val) {
                if ($('.search-company-result').is('.search-company-result_selected, .search-company-result_loading, .search-company-result_loaded')) {
                    clear_fields();
                    clear_timeout();
                }
            },
            onSelected: function(val) {
                if ($('.search-company-result').is('.search-company-result_selected, .search-company-result_loading, .search-company-result_loaded')) {
                    clear_fields();
                    clear_timeout();
                }
                $( '#reg_number_pay' ).attr('disabled', false );

                updateRegistrationNumberRequiredMark();

                toggle_radio_buttons();
            }
        });

        var register_new_business_fields = $('.register_new_business input.required-input');
        register_new_business_fields.on("input", function(e) {
            var isRegisterNewBusinessFieldsVal = register_new_business_fields.toArray().some(function(item) {
                return !($(item).val());
            });
            $('#register_buyer_company').prop('disabled', isRegisterNewBusinessFieldsVal);
        });
    }

    function updateRegistrationNumberRequiredMark() {
        if (countries.length < 1) {
            return ;
        }

        const country_code = $('#select_country_pay').val();
        const country = countries.find(country => country.code === country_code);
        const is_registration_number_required = country.is_registration_number_required;

        if ( is_registration_number_required ) {
            $('.registration-number-required').show();
            var country_code_v = country_code.toLowerCase();
            const reg_number = $('#reg_number_pay').val();
            let language = getLang();
    
            //if (country.is_registration_number_required) {
            const validation = Sprinque.checkRegNumber(reg_number, country_code_v, language);
            if( $('#reg_number_pay').val() !== '' ) {
                $('#reg_number_warning')
                    .show()
                    .text(validation.message);
            } else {
                $('#reg_number_warning').hide();
            }

        } else {
            $('.registration-number-required, #reg_number_warning').hide();
        }
    }

    function recalculateTotal() {
        if (jQuery('.wpm-terms-row.active').length >= 1 ) {
            selectPaymentTerm.setSelected(jQuery('.wpm-terms-row.active input:checked').attr('data-term'));
        }

        if (jQuery('.wpm-instalments-row.active').length >= 1 ) {
            selectPaymentTerm.setSelected(jQuery('.wpm-instalments-row.active input:checked').attr('data-term'));
        }
    }

    function canProceedWithoutCompany() {
        const isChecked = $('#sprinque_agree_policy').prop('checked');
        const isButtonValidated = typeof $('#confirm-company-order').attr('data-company-selected') !== "undefined";
        const canProceed = !isButtonValidated && $('#reg_number_pay').val().length > 0;

        return canProceed && isChecked;
    }

    function verifyCanProceed() {
        const isChecked = $('#sprinque_agree_policy').prop('checked');
        const isButtonValidated = typeof $('#confirm-company-order').attr('data-company-selected') !== "undefined";

        const canProceed = isButtonValidated || (
          !isButtonValidated && $('#reg_number_pay').val().length > 0
        );

        $('#confirm-company-order').prop('disabled', !(canProceed && isChecked));

        return canProceed && isChecked;
    }

    function checkRegisterFields()
    {
        if($('#address_company_pay').length && $('#address_company_pay').val().length > 0 &&
            $('#city_company_pay').length && $('#city_company_pay').val().length > 0 &&
            $('#zip_company_pay').length && $('#zip_company_pay').val().length > 0) {
            $('#register_buyer_company').prop('disabled', false);
        }

        $('#select_country_pay').wpmSelect('setVal', $('#billing_country').val());
        $('#company_name_pay').val($('#billing_company').val());
    }

    checkRegisterFields();

    function showPopup(elem, ignoreValidation = false) {
        if (ignoreValidation) {
            showPopupContent(elem);
            return ;
        }

        const form = document.querySelector('form[name="checkout"]');
        const formData = new FormData(form);
        formData.append('action', 'sprinque_validate_checkout');

        $.ajax({
            url: window.admin.ajaxurl,
            method: 'POST',
            processData: false,
            contentType: false,
            data: formData
        }).done(function (response) {
            $('form.woocommerce-checkout div.woocommerce-NoticeGroup').remove();

            if (response.success === true) {
                showPopupContent(elem);
            } else {
                $('form[name="checkout"].woocommerce-checkout').prepend('<div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout"></div>')
                $('form.woocommerce-checkout div.woocommerce-NoticeGroup').prepend('<ul class="woocommerce-error" role="alert"></ul>');
                $('form.woocommerce-checkout div.woocommerce-NoticeGroup ul.woocommerce-error').append(
                  response.data.messages.map(message => `<li>${message}</li>`)
                );
                $(document).scrollTop(0);
                $(document.body).trigger('checkout_error');
            }
        });
    }

    function showPopupContent(elem) {
        $('body').css({
            'paddingRight': getScrollbarWidth() + 'px',
        }).addClass('wpm-overflow-hidden');
        $(elem).addClass('modal-form_anim modal-form_show');
        $(elem).removeClass('modal-middle');
        $('.error-confirm-order').hide();
        // showTab('.select_payment_term');

        const lang = getLang();
        $('.policy-description').text(window.Sprinque.getTranslatedText(lang, 'privacyPolicyText'));
        $('.policy-checkbox-label').html(window.Sprinque.getTranslatedText(lang, 'privacyPolicy'));
    }

    function hidePopup(elem) {
        $('body').css({
            'paddingRight': 0,
        }).removeClass('wpm-overflow-hidden');
        $(elem).removeClass('modal-form_anim');
        setTimeout(function() {
            $(elem).removeClass('modal-form_show');
        }, 300);
    }

    function getScrollbarWidth() {
        return window.innerWidth - document.documentElement.clientWidth;
    }

    function OTPInput() {
        const inputs = document.querySelectorAll('#wpm-otp > *[id]');
        for (let i = 0; i < inputs.length; i++) {

            inputs[i].addEventListener('keydown', function(event) {
                if (event.key === "Backspace") {
                    if (!(inputs[i].value)) {
                        inputs[i].value = '';
                        if (i !== 0) inputs[i - 1].focus();
                    }
                } else {
                    if (i === inputs.length && inputs[i].value !== '') {
                        return true;
                    } else if (event.keyCode > 47 && event.keyCode < 58 && !(event.ctrlKey) && !(event.metaKey) ) {
                        inputs[i].value = event.key;
                        if (i !== inputs.length - 1) inputs[i + 1].focus();
                        event.preventDefault();
                    } else if (event.keyCode > 64 && event.keyCode < 91 && !(event.ctrlKey) && !(event.metaKey) ) {
                        // inputs[i].value = String.fromCharCode(event.keyCode);
                        inputs[i].value = event.key;
                        if (i !== inputs.length - 1) inputs[i + 1].focus();
                        event.preventDefault();
                    }
                }

            });

            inputs[i].addEventListener('keyup', function(e) {
                var isFields = $(inputs).toArray().some(function(item) {
                    return !($(item).val());
                });
                $('#confirm-email-code').prop('disabled', isFields);
            });
            $(inputs).on({
                paste: function(e) {
                    var pastedData = e.originalEvent.clipboardData.getData('text');
                    var pastedChars = pastedData.split("");

                    var curIndex = $(inputs).index(this)

                    for (var i=0; i < pastedChars.length; i++) {
                        var char = pastedChars[i]
                        $(inputs).eq(curIndex + i).val(char).focus();
                    }
                }
            })

        }
    }

    OTPInput();

    function showTab(el) {
        $(el).siblings().hide();
        $(el).show();
    }

    var timer;
    var orderPayed = false;

    var buyer_email;
    var merchant_buyer_id;

    $("body").on("click", "#place_order", function(event) {
        if(!orderPayed && $('#payment_method_wpm_srinque_pay').length && $('#payment_method_wpm_srinque_pay').is(':checked')) {
            const $form = $('form.checkout');
            const $errorsGroup = $form.find('.woocommerce-NoticeGroup-checkout');
            $errorsGroup.hide();
            // The field does not allow you to make a payment. Thus, only validation will be performed.
            $form.append('<input type="hidden" name="woocommerce_checkout_update_totals" value="true">');
            $form.trigger('submit');
        }
    });

    var metadata = {};

    function sendFullStoryEvent(name, step, extraObj) {
        if (
          !window.admin.hasOwnProperty('enable_user_tracking') ||
          window.admin.enable_user_tracking == '0'
        ) {
            return ;
        }

        if (typeof FS !== 'undefined') {
            var eventPayload = {
                source_str: 'woo-commerce',
                step_int: step,
                fingerprint_id_str: metadata?.visitor_id || 'undefined',
                location_host_str: window.location.host,
                ...extraObj,
            };
        
            FS.event(name, eventPayload);
        }
      }


    // Exclude Sprinque domains from the fullstory
    if(
        window.hasOwnProperty('admin') &&
        window.admin.hasOwnProperty('enable_user_tracking') &&
        window.admin.enable_user_tracking == '1' &&
        $('#payment_method_wpm_srinque_pay').is(':checked')
    ){
        window['_fs_host'] = 'fullstory.com';
        window['_fs_script'] = 'edge.fullstory.com/s/fs.js';
        window['_fs_org'] = 'o-1ESJKB-na1';
        window['_fs_namespace'] = 'FS';
        (function(m,n,e,t,l,o,g,y){
            if (e in m) {if(m.console && m.console.log) { m.console.log('FullStory namespace conflict. Please set window["_fs_namespace"].');} return;}
            g=m[e]=function(a,b,s){g.q?g.q.push([a,b,s]):g._api(a,b,s);};g.q=[];
            o=n.createElement(t);o.async=1;o.crossOrigin='anonymous';o.src='https://'+_fs_script;
            y=n.getElementsByTagName(t)[0];y.parentNode.insertBefore(o,y);
            g.identify=function(i,v,s){g(l,{uid:i},s);if(v)g(l,v,s)};g.setUserVars=function(v,s){g(l,v,s)};g.event=function(i,v,s){g('event',{n:i,p:v},s)};
            g.anonymize=function(){g.identify(!!0)};
            g.shutdown=function(){g("rec",!1)};g.restart=function(){g("rec",!0)};
            g.log = function(a,b){g("log",[a,b])};
            g.consent=function(a){g("consent",!arguments.length||a)};
            g.identifyAccount=function(i,v){o='account';v=v||{};v.acctId=i;g(o,v)};
            g.clearUserCookie=function(){};
            g.setVars=function(n, p){g('setVars',[n,p]);};
            g._w={};y='XMLHttpRequest';g._w[y]=m[y];y='fetch';g._w[y]=m[y];
            if(m[y])m[y]=function(){return g._w[y].apply(this,arguments)};
            g._v="1.3.0";
        })(window,document,window['_fs_namespace'],'script','user');
    }

    $(document.body).on('checkout_error', function() {
        // Check if the sprinque payment gateway is selected
        if(!$('#payment_method_wpm_srinque_pay').length || !$('#payment_method_wpm_srinque_pay').is(':checked')) {
            return;
        }

        try {
            const fpPromise = import('https://fpjscdn.net/v3/VLQShOCoxtQifKWEZS4O')
                        .then(FingerprintJS => FingerprintJS.load({region: 'eu'}));
                    fpPromise
                        .then(fp => fp.get({ extendedResult: true }))
                        .then(result => ( 
                            metadata = Sprinque.convertFingerprintDataToSprinquePayload( result ) 
                            ) )
                        .catch(() => {
                            metadata = {};
                        });
        } catch (e) {
            console.log(e);
        }

        const $form = $('form.checkout');
        const $errorsGroup = $form.find('.woocommerce-NoticeGroup-checkout');
        const $errors = $errorsGroup.find('.woocommerce-error > li, .is-error ul > li, .is-error .wc-block-components-notice-banner__content');
        const $notices = $errorsGroup.find('.woocommerce-info, .is-info .wc-block-components-notice-banner__content');
        
        var srinque_email_validation_error = false;
        var srinque_email_validation_notice = false;

        $form.find('input[name="woocommerce_checkout_update_totals"]').remove();
        $errorsGroup.show();

        if ($errors.length ) {
            $errors.each( function() {
                if ( $(this).text().trim() === admin.email_validation_error ) {
                    $(this).remove();
                    srinque_email_validation_error = true;
                }
            } );
        }
        if( $notices.length ) {
            $notices.each( function() {
                if ( $(this).text().trim() === admin.email_validation_notice ) {
                    $(this).remove();
                    srinque_email_validation_notice = true;
                }
            } );
        }

        if( srinque_email_validation_error && $errors.length == 1 && ! $notices.length ) {
            jQuery( 'html, body' ).stop();
            showPopup('#wpm-modal-form', true);
            showTab('.sprinque_email_validation_error');
        }
        if( srinque_email_validation_notice && $notices.length == 1 && ! $errors.length ) {
            jQuery( 'html, body' ).stop();
            showPopup('#wpm-modal-form', true);
            showTab('.sprinque_email_validation_notice');
        }

        if( $errors.length || $notices.length ) {
            return;
        }

        jQuery( 'html, body' ).stop();

        $('#search-by').hide();
        $('#company-name-label').show();

        if (countries.length < 1) {
            get_countries();
        } else {
            toggle_radio_buttons();
        }
        get_companies_list();
        showTab('.search_already_added_company');
        showPopup('#wpm-modal-form');

        sendFullStoryEvent('Modal opened', 1);


        // Set buyer email
        buyer_email = $('#billing_email').val();

    });

    setInterval(function() {
        if($('#address_company_pay').length && $('#address_company_pay').val().length > 0 &&
            $('#city_company_pay').length && $('#city_company_pay').val().length > 0 &&
            $('#zip_company_pay').length && $('#zip_company_pay').val().length > 0) {
            $('#register_buyer_company').prop('disabled', false);
        }
    }, 100);

    $("body").on("updated_checkout", sprinque_translate);

    $("body").on("click", "#cancel-order-sprinque", function(event) {
        showPopup('#wpm-modal-form');
    });

    $("body").on("change", "#select_country_pay", function(event) {
        $('.error-confirm-order').hide();
        clear_timeout()
    });

    $("body").on("change", "#billing_country", function(event) {
        var country = $(this).val();
        $("#select_country_pay option").each(function() {
            if($(this).val() == country) {
                $('#select_country_pay').wpmSelect('setVal', country);
                $('#company_name_pay').val($('#billing_company').val());
            }
        });
    });

    $("body").on("change", 'input[name="search_by"]', function () {
        var selected_search_type = $(this).val();
        var placeholder = $(this).data('placeholder');
        $('#company_name_pay').attr('placeholder', placeholder);
        get_companies_list();
    });

    $("body").on("change input", "#billing_company", function(event) {
        var company = $(this).val();
        $('#company_name_pay').val(company);
    });

    $("body").on("change input", "#billing_address_1", function(event) {
        var billing_address_1 = $(this).val();
        $('#address_company_pay').val(billing_address_1);
    });

    $("body").on("change input", "#billing_address_2", function(event) {
        var billing_address_2 = $(this).val();
        $('#apartment_company_pay').val(billing_address_2);
    });

    $("body").on("change input", "#billing_city", function(event) {
        var billing_city = $(this).val();
        $('#city_company_pay').val(billing_city);
    });

    $("body").on("change input", "#billing_postcode", function(event) {
        var billing_postcode = $(this).val();
        $('#zip_company_pay').val(billing_postcode);
    });

    $("body").on("input", "#company_name_pay", function(event) {
        $('.error-confirm-order').hide();
        clear_timeout()
    });

    $("body").on("input", "#reg_number_pay", function(event) {
        let country_code_upper = $('#select_country_pay').val();
        const country_code = country_code_upper.toLowerCase();
        const reg_number = $(this).val();
        let language = getLang();

        var country_reg_n = countries.find(country => country.code === country_code_upper);
        if ( $(this).val() !== '' ) {
            const validation = Sprinque.checkRegNumber(reg_number, country_code, language);
            if ( validation.isValid ) {
                $('#reg_number_warning').hide();
            } else {
                // if( country_reg_n.is_registration_number_required ) {
                $('#reg_number_warning')
                    .show()
                    .text(validation.message);
                // }
            }
        } else {
            $('#reg_number_warning').hide();
        }

        $('.error-confirm-order').hide();

        verifyCanProceed();
    });

    $("body").on("click", ".company-item", function(event) {
        var this_item = $(this);
        var company_reg_code = $(this).data('reg-number');
        var company_name = $(this).data('company-name');
        var country_code = $('#select_country_pay').val();
        $('.search-company-result').removeClass('search-company-result_loading').addClass('search-company-result_selected');
        $('.company-item').removeClass('active');
        $(this).addClass('active').siblings().remove();
        $(this).append('<div class="company-item__close"></div>');
        $('#company_name_pay').val(company_name);
        $('#billing_company').val(company_name);
        $('#reg_number_pay').val(company_reg_code);

        const isPolicyAccepted = $('#sprinque_agree_policy').prop('checked');

        $('#confirm-company-order').attr('data-company-selected', 1);

        if (isPolicyAccepted) {
            $('#confirm-company-order').prop('disabled', false);
        }

        $('#reg_number_pay').trigger('input');
        if( company_reg_code ) {
            $('#reg_number_pay').attr( 'disabled', true );
        }
    });

    $("body").on("input", '#sprinque_agree_policy', function () {
        verifyCanProceed();
    });

    $("body").on("click", ".company-item__close", function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).closest('.company-item').remove();
        $("#reg_number_pay").val('');
        $("#company_name_pay").val('');
        $('.search-company-result').removeClass('search-company-result_selected');
        clear_fields();
        clear_timeout();
        $('#reg_number_pay').attr( 'disabled', false );
    });

    function clear_fields() {
        $('#wpm-modal-form .company-item').remove();
        $("#wpm-modal-form #reg_number_pay").val('');
        $("#wpm-modal-form #company_name_pay").val('');
        $('#wpm-modal-form .search-company-result').removeClass('search-company-result_selected search-company-result_loading search-company-result_loaded');
    }

    function clear_timeout() {
        window.clearTimeout(timer);

        $('#confirm-company-order').removeAttr('data-company-selected');

        $('.search-company-result').removeClass('search-company-result_loading search-company-result_loaded').html('');

        if (!verifyCanProceed()) {
            $('#confirm-company-order').prop('disabled', true);
        }

        timer = window.setTimeout(function() {
            get_companies_list();
        },500);
    }


    $("body").on("click", ".to_select_companies", function(event) {
        $('.register_new_business').hide();
        $('.verifying_your_account').hide();
        $('.verify_your_email').hide();
        $('.search_already_added_company').show();
        $('#wpm-modal-form').removeClass('modal-middle');
    });

    $("body").on("click", "#register-company-tab, .company-item-404, .register-company-tab, .js-register-company-tab", function(event) {
        event.preventDefault();
        var searchCompanyRes = $( '.search-company-result' );
        searchCompanyRes.hide();
        $('#confirm-company-order').prop( 'disabled', false );
        $('#reg_number_pay')
          .prop('disabled', false);

        var reg_number = $('#reg_number_pay').val();
        var country_code = $('#select_country_pay').val();
        var company_name = $('#company_name_pay').val();

        const country = countries.find(country => country.code === country_code);
        const is_registration_number_value = country.is_registration_number_required ? reg_number.length > 0 : true;
        const is_policy_accepted = $('#sprinque_agree_policy').prop('checked');

        $('.error-confirm-order').hide();

        if(is_policy_accepted && is_registration_number_value && company_name.length > 1 && country_code.length > 0) {
            $('.register_new_business').show();
            $('.search_already_added_company').hide();
        } else {
            $('.error-confirm-order').show();
            if( ! is_registration_number_value ) {
                let language = getLang();
                const validation = Sprinque.checkRegNumber(reg_number, country_code, language);
                $('#reg_number_warning')
                    .show()
                    .text(validation.message);
            }
        }

    });

    $("body").on("click", "#register_buyer_company", function(event) {
        var business_name = $('#company_name_pay').val();
        var registration_number = $('#reg_number_pay').val();
        var country_code = $('#select_country_pay').val();

        var city = $('#city_company_pay').val();
        var address_line1 = $('#address_company_pay').val();
        var address_line2 = $('#apartment_company_pay').val();
        var zip_code = $('#zip_company_pay').val();
        var first_name = $('#billing_first_name').val();
        var last_name = $('#billing_last_name').val();
        var phone = $('#billing_phone').val();
        var email = $('#billing_email').val();
        var billing_email = $('#billing_or_accounts_payable_email').val();

        const $form = $('form.woocommerce-checkout');
        let initial_shipping_address_line1 = '';
        let initial_shipping_address_line2 = '';
        let initial_shipping_city = '';
        let initial_shipping_zip_code = '';
        let initial_shipping_country_code = '';

        if ($form.find('#ship-to-different-address-checkbox').is(':checked')) {
            const house_number = $form.find('#shipping_house_number').length > 0
                ? $form.find('#shipping_house_number').val()
                : '';
            initial_shipping_address_line1 = $form.find('#shipping_address_1').val() + ' ' + house_number;
            initial_shipping_address_line1 = initial_shipping_address_line1.trim();

            initial_shipping_address_line2 = $form.find('#shipping_address_2').val();
            initial_shipping_city = $form.find('#shipping_city').val();
            initial_shipping_zip_code = $form.find('#shipping_postcode').val();
            initial_shipping_country_code = $form.find('#shipping_country').val();
        } else {
            const house_number = $form.find('#billing_house_number').length > 0
                ? $form.find('#billing_house_number').val()
                : '';
            initial_shipping_address_line1 = $form.find('#billing_address_1').val() + ' ' + house_number;
            initial_shipping_address_line1 = initial_shipping_address_line1.trim();

            initial_shipping_address_line2 = $form.find('#billing_address_2').val();
            initial_shipping_city = $form.find('#billing_city').val();
            initial_shipping_zip_code = $form.find('#billing_postcode').val();
            initial_shipping_country_code = $form.find('#billing_country').val();
        }

        const country = countries.find(country => country.code === country_code);
        const is_registration_number_value = country.is_registration_number_required ? registration_number.length > 0 : true;

        // Here the problem on js layer
        $('.error-register-fields').hide();

        if(business_name.length > 1 && is_registration_number_value && country_code.length > 0 && zip_code.length > 0 && city.length > 0
            && address_line1.length > 0 && first_name.length > 0 && last_name.length > 0 && email.length > 0) {
            sendFullStoryEvent('Business confirmed', 2, {
                is_search_used_bool: false,
                buyer_str: business_name,
            });
            sendFullStoryEvent('Address completed', 2);
            $.ajax({
                url: admin.ajaxurl,
                data: {
                    'action': 'sprinque_register_buyer',
                    'business_name': business_name,
                    'registration_number': registration_number,
                    'country_code': country_code,
                    'city': city,
                    'address_line1': address_line1,
                    'address_line2': address_line2,
                    'zip_code': zip_code,
                    'first_name': first_name,
                    'last_name': last_name,
                    'phone': phone,
                    'email': email,
                    'billing_email': billing_email,
                    'nonce': admin.nonce,
                    'initial_shipping_address_line1': initial_shipping_address_line1,
                    'initial_shipping_address_line2': initial_shipping_address_line2,
                    'initial_shipping_city': initial_shipping_city,
                    'initial_shipping_zip_code': initial_shipping_zip_code,
                    'initial_shipping_country_code': initial_shipping_country_code,
                    'metadata': { ...metadata, privacyPolicyConfirmed: $('#sprinque_agree_policy').prop('checked') }
                },
                type: 'POST',
                dataType: 'json',
                success: function (response) {
                    if(response.status === 'true') {
                        if(response.otp_validated === 'false') {
                            $('.register_new_business').hide();
                            $('.verify_your_email').show();
                            $('#email-otp-send').html(email);
                            buyer_email = email;
                            merchant_buyer_id = response.result.merchant_buyer_id;

                            sendFullStoryEvent('Buyer created', 3, {
                                buyer_id_str: merchant_buyer_id,
                                buyer_name_str: response.result.business_name,
                            });
                            sprinque_send_otp_verification();
                        } else {
                            showTab('.verifying_your_account');
                            verify_company();
                        }
                    } else {
                        let errorMessages = response.message;
                        if ('response' in response && 'errors' in response.response) {
                            errorMessages += searchAdditionalErrorHandler(response.response.errors)
                        }

                        $('.error-confirm-order').html(errorMessages).show();
                        $('.error-register-fields').html(errorMessages).show();
                    }
                },
                error: function (response) {
                    if( response.status === 403 ) {
                        let language = getLang();

                        const $currentError = 'message' in response.responseJSON ? response.responseJSON.message : '';
                        const $newBusinessContainer = $('.search_already_added_company');
                        const $errorsContainer = $('.verifying_your_account');
                        const $spinner = $errorsContainer.find('.wpm-loader');
                        const $errorsList = $errorsContainer.find('.cant-complete-autorization');
                        const $errorMessageElement = $errorsContainer.find('.verify-error');
                        const errorMessage = Sprinque.getTranslatedApiError(language, $currentError);

                        if($currentError.length) {
                            showTab('.verifying_your_account');
                            $('.verifying_your_account .verify-error-title').hide();
                            $newBusinessContainer.hide();
                            $spinner.hide();
                            $errorsList.show();
                            $errorsContainer.show();
                            $errorMessageElement.show().html(errorMessage);
                        }
                    }
                },
            });


        } else {
            $('.error-register-fields').html(admin.fields_not_filled).show();
        }
    });

    $("body").on("click", "#confirm-email-code", function(event) {
        var button = $(this);
        button.attr('disabled', 'disabled');

        var send_code = $('#confirm-code-1').val()+$('#confirm-code-2').val()+$('#confirm-code-3').val()+$('#confirm-code-4').val()+$('#confirm-code-5').val();

        $('.otp-error-code').hide();

        $.ajax({
            url: admin.ajaxurl,
            data: {
                'action': 'sprinque_verify_otp_code',
                'email': buyer_email,
                'merchant_buyer_id': merchant_buyer_id,
                'send_code': send_code,
                'nonce': admin.nonce
            },
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                if(response.status === 'true') {
                    showTab('.verifying_your_account');
                    verify_company();
                } else {
                    $('.otp-error-code').show();
                }
                
                button.removeAttr('disabled');
            }
        });
    });

    function sprinque_send_otp_verification()
    {
        $('.otp-error-code').hide();
        startResendTimer();

        $.ajax({
            url: admin.ajaxurl,
            data: {
                'action': 'sprinque_send_otp_verification',
                'email': buyer_email,
                'merchant_buyer_id': merchant_buyer_id,
                'nonce': admin.nonce
            },
            type: 'POST',
            dataType: 'json',
            success: function (response) {

            }
        });
    }

    let resendTimer = null;
    const link = document.querySelector('#resend-code-otp');
    const textElement = link.querySelector('#resend-timer-otp');
    const timerText = textElement.innerText;
    function startResendTimer() {
        let seconds = 30;
        textElement.innerText = timerText.replace(/:sec/, seconds);
        link.classList.add('wpm-modal-form-tab__resend--disabled');

        clearInterval(resendTimer);
        resendTimer = window.setInterval(() => {
            seconds--;
            textElement.innerText = timerText.replace(/:sec/, seconds);
            if(seconds <= 0) {
                clearInterval(resendTimer);
                link.classList.remove('wpm-modal-form-tab__resend--disabled');
            }
        }, 1000);
    }

    $("body").on("click", "#resend-code-otp", function(event) {
        event.preventDefault();
        if (!$(event.target).closest('.wpm-modal-form-tab__resend--disabled').length) {
            sprinque_send_otp_verification();
            $('#confirm-code-1').val('');
            $('#confirm-code-2').val('');
            $('#confirm-code-3').val('');
            $('#confirm-code-4').val('');
            $('#confirm-code-5').val('');
        }
    });

    $("body").on("click", "#confirm-company-order", function(event) {
        var business_name = $('#company_name_pay').val();
        var registration_number = $('#reg_number_pay').val();
        var country_code = $('#select_country_pay').val();

        var city = $('#sprinque_city').html();
        var address_line1 = $('#sprinque_address_line1').html();
        var address_line2 = $('#billing_address_2').val();
        var zip_code = $('#sprinque_zip_code').html();
        var first_name = $('#billing_first_name').val();
        var last_name = $('#billing_last_name').val();
        var phone = $('#billing_phone').val();
        var email = $('#billing_email').val();
        var billing_email = $('#billing_or_accounts_payable_email').val();

        const $form = $('form.woocommerce-checkout');
        let initial_shipping_address_line1 = '';
        let initial_shipping_address_line2 = '';
        let initial_shipping_city = '';
        let initial_shipping_zip_code = '';
        let initial_shipping_country_code = '';

        if ($form.find('#ship-to-different-address-checkbox').is(':checked')) {
            const house_number = $form.find('#shipping_house_number').length > 0
                ? $form.find('#shipping_house_number').val()
                : '';
            initial_shipping_address_line1 = $form.find('#shipping_address_1').val() + ' ' + house_number;
            initial_shipping_address_line1 = initial_shipping_address_line1.trim();

            initial_shipping_address_line2 = $form.find('#shipping_address_2').val();
            initial_shipping_city = $form.find('#shipping_city').val();
            initial_shipping_zip_code = $form.find('#shipping_postcode').val();
            initial_shipping_country_code = $form.find('#shipping_country').val();
        } else {
            const house_number = $form.find('#billing_house_number').length > 0
                ? $form.find('#billing_house_number').val()
                : '';
            initial_shipping_address_line1 = $form.find('#billing_address_1').val() + ' ' + house_number;
            initial_shipping_address_line1 = initial_shipping_address_line1.trim();

            initial_shipping_address_line2 = $form.find('#billing_address_2').val();
            initial_shipping_city = $form.find('#billing_city').val();
            initial_shipping_zip_code = $form.find('#billing_postcode').val();
            initial_shipping_country_code = $form.find('#billing_country').val();
        }

        const $selectedCompany = $('#select-your-business .company-item.active');

        if ($selectedCompany.length < 1 && canProceedWithoutCompany()) {
            $('.company-item-404').click();
            return ;
        }

        const default_registration_number = $selectedCompany.data('reg-number').toString();
        const credit_bureau_id = $selectedCompany.data('credit-bureau-id').toString();

        const country = countries.find(country => country.code === country_code);
        const is_registration_number_value = country.is_registration_number_required ? registration_number.length > 0 : true;

        $('.error-confirm-order').hide();

        if(business_name.length > 1 && is_registration_number_value && country_code.length > 0 && zip_code.length > 0 && city.length > 0
            && address_line1.length > 0 && first_name.length > 0 && last_name.length > 0 && email.length > 0) {

            sendFullStoryEvent('Business confirmed', 2, {
                is_search_used_bool: true,
                buyer_str: business_name,
            });

            var button = $(this);
            button.attr('disabled', 'disabled');
            const data = {
                'action': 'sprinque_register_buyer',
                'business_name': business_name,
                'registration_number': registration_number,
                'country_code': country_code,
                'city': city,
                'address_line1': address_line1,
                'address_line2': address_line2,
                'zip_code': zip_code,
                'first_name': first_name,
                'last_name': last_name,
                'phone': phone,
                'email': email,
                'billing_email': billing_email,
                'nonce': admin.nonce,
                'initial_shipping_address_line1': initial_shipping_address_line1,
                'initial_shipping_address_line2': initial_shipping_address_line2,
                'initial_shipping_city': initial_shipping_city,
                'initial_shipping_zip_code': initial_shipping_zip_code,
                'initial_shipping_country_code': initial_shipping_country_code,
                'metadata': { ...metadata, privacyPolicyConfirmed: $('#sprinque_agree_policy').prop('checked') }
            };

            if (registration_number == default_registration_number) {
                data['credit_bureau_id'] = credit_bureau_id;
            }

            $.ajax({
                url: admin.ajaxurl,
                data,
                type: 'POST',
                dataType: 'json',
                success: function (response) {
                    button.removeAttr('disabled');

                    if(response.status === 'true') {
                        sendFullStoryEvent('Address completed', 2);
                        if(response.otp_validated === 'false') {
                            $('.search_already_added_company').hide();
                            $('.verify_your_email').show();
                            $('#email-otp-send').html(email);
                            buyer_email = email;
                            merchant_buyer_id = response.result.merchant_buyer_id;
                            sprinque_send_otp_verification();
                        } else {
                            showTab('.verifying_your_account');
                            verify_company();
                            sendFullStoryEvent('Buyer created', 3, {
                                buyer_id_str: response.result.merchant_buyer_id,
                                buyer_name_str: response.result.business_name,
                            });
                            sendFullStoryEvent('OTP skipped', 4);
                        }
                    } else {
                        let errorMessages = response.message;
                        if ('response' in response && 'errors' in response.response) {
                            errorMessages += searchAdditionalErrorHandler(response.response.errors)
                        }

                        $('.error-confirm-order').show().html(errorMessages);
                    }
                },
                error: function (response) {
                    if( response.status === 403 ) {

                        let language = getLang();

                        const $currentError = 'message' in response.responseJSON ? response.responseJSON.message : '';
                        const $newBusinessContainer = $('.search_already_added_company');
                        const $errorsContainer = $('.verifying_your_account');
                        const $spinner = $errorsContainer.find('.wpm-loader');
                        const $errorsList = $errorsContainer.find('.cant-complete-autorization');
                        const $errorMessageElement = $errorsContainer.find('.verify-error');
                        const errorMessage = Sprinque.getTranslatedApiError(language, $currentError);

                        if($currentError.length) {
                            $newBusinessContainer.hide();
                            $spinner.hide();
                            $errorsList.show();
                            $errorsContainer.show();
                            $errorMessageElement.show().html(errorMessage);
                        }
                    }
                },
            });
        } else if (
            business_name.length > 1 &&
            registration_number.length > 0 &&
            country_code.length > 0 &&
            first_name.length > 0 &&
            last_name.length > 0 &&
            email.length > 0 &&
            (
                address_line1.length === 0 ||
                zip_code.length === 0 ||
                city.length === 0
            )
        ) {
            const $tabsContainer = $('#select-your-business');
            const $tabSearch = $tabsContainer.find('.search_already_added_company');
            const $tabRegNew = $tabsContainer.find('.register_new_business');

            $tabSearch.hide();
            $tabRegNew.show();
        } else {
            $('.error-confirm-order').show().html(admin.fields_not_filled);
        }
    });

    function searchAdditionalErrorHandler(data) {
        let resultHtml = '';

        try {
            for (let key in data) {
                data[key].forEach(errors => {
                    for (let field in errors) {
                        errors[field].forEach(message => {
                            resultHtml += '<p>' + message + '</p>';
                        });
                    }
                });
            }
        } catch (e) {
            console.log(e);
        }

        return resultHtml;
    }

    function verify_company() {
        $.ajax({
            url: admin.ajaxurl,
            data: {
                'action': 'sprinque_get_buyer_details',
                'nonce': admin.nonce
            },
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                if(response.status === true) {
                    if (response.eligible_payment_terms.length > 1) {
                        selectPaymentTerm.setEligiblePaymentTerms(response.eligible_payment_terms);
                        selectPaymentTerm.setAmount(Number(response.total));
                        selectPaymentTerm.update();

                        showTab('.select_payment_term');
                    } else {

                        showTab('.placing_your_order');
                        setTimeout(function() {
                            $('#days-review').html(response.days);
                            const paymentTerm = response.eligible_payment_terms[0];
                            $('.approve-place-order').attr('data-term', paymentTerm);
                            showTab('.purchase_approved');
                        }, 1000);
                    }
                    sendFullStoryEvent('OTP verified', 4);
                } else if(response.status === false) {
                    if(response.credit_decision === 'MANUAL_REVIEW' || response.credit_decision === 'PENDING') {
                        showTab('.placing_your_order');
                        setTimeout(function() {
                            showTab('.purchase_under_review');
                        }, 1000);
                    } else {
                        $('.verify-error').show().html(response.message);

                        var modal_class = 'modal-middle';

                        $('.cant-complete-autorization').show();
                        $('.verifying_your_account .wpm-loader_my1').hide();
                        $('.verify-error-explanation, .verify-error').hide();

                        if (response.credit_decision === 'REJECTED') {
                            $('.auth-credit-rejected-error').show();
                        } else if (response.credit_decision === 'BLOCKED') {
                            $('.auth-buyer-blocked-error').show();
                        } else {
                            modal_class = '';
                        }

                        if (modal_class.length > 0) {
                            $('#wpm-modal-form').addClass(modal_class);
                        }
                    }
                }
            }
        });
    }

    function authorize_company_payment(callback, params = {})
    {
        var address_line1 = $('#billing_address_1').val();
        var city = $('#billing_city').val();
        var zip_code = $('#billing_postcode').val();
        var country_code = $('#select_country_pay').val();
        var email = $('#billing_email').val();

        $('.cant-complete-autorization').hide();
        $('.error-confirm-order').hide();
        $('.verifying_your_account .wpm-loader_my1').show();

        if(address_line1.length > 0 && city.length > 0 && zip_code.length > 0 && country_code.length > 0) {
            $.ajax({
                url: admin.ajaxurl,
                data: {
                    'action': 'sprinque_authorize_company_order',
                    'address_line1': address_line1,
                    'city': city,
                    'zip_code': zip_code,
                    'country_code': country_code,
                    'email': email,
                    'nonce': admin.nonce,
                    'payment_terms': typeof params.payment_terms !== "undefined" ? params.payment_terms : null,
                    'metadata': metadata
                },
                type: 'POST',
                dataType: 'json',
                success: function (response) {

                    sendFullStoryEvent('Order Completed', 5, {
                        orderId_str: response.result.merchant_order_id,
                        transactionId_str: response.result.transaction_id,
                    });

                    if(response.status === 'true') {
                        callback();
                    } else if(response.status === 'false') {
                        if(response.result.error_code === 'auth-buyer-under-review') {
                            showTab('.placing_your_order');
                            setTimeout(function() {
                                showTab('.purchase_under_review');
                            }, 1000);
                        } else {
                            showTab('.verifying_your_account');
                            $('.cant-complete-autorization').show();
                            $('.placing_your_order').hide();
                            $('.verifying_your_account .wpm-loader_my1').hide();
                            $('.verify-error-explanation, .verify-error').hide();

                            const is_error_by_code = typeof response.result.error_code !== "undefined" && response.result.error_code.length > 0;

                            let language = getLang();

                            const modal_class = is_error_by_code ? 'modal-middle' : '';
                            if (is_error_by_code) {
                                const errorsTitles = [];
                                const errors = [];
                                for (let key in response.result.errors) {
                                    errorsTitles.push(Sprinque.getTranslatedText( language, 'insufficient-acl-title' ))
                                    errors.push(Sprinque.getTranslatedText(language, 'insufficient-acl-body-v2'));
                                    // errors.push(Sprinque.getTranslatedApiError(language, key));
                                }
                                title = errorsTitles.join("<br>");
                                message = errors.join("<br>");
                            } else {
                                message = response.message;
                            }
                            if ( title.length ) {
                                $('.verify-error-title').html(title);
                            }
                            $( '.modal-form__logo-image' ).hide();
                            $( '.modal-form__error-icon' ).show();
                            $('.verify-error').show().html(message);

                            if (modal_class.length > 0) {
                                $('#wpm-modal-form').addClass(modal_class);
                            }
                        }
                    }
                }
            });
        } else {
            $('.error-confirm-order').show();
        }
    }

    function mark_for_review(callback) {
        $.ajax({
            url: admin.ajaxurl,
            data: {
                'action': 'sprinque_mark_for_review_and_wait',
                'nonce': admin.nonce,
                'metadata': metadata
            },
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                callback();
            }
        });
    }

    $("body").on("click", ".approve-place-order", function(event) {
        showTab('.placing_your_order');
        const paymentTerm = $(this).attr('data-term');
            setTimeout(function() {
            authorize_company_payment(function () {
                showTab('.finalizing-order');
                orderPayed = true;
                $('#place_order').trigger( "click" );
            }, { payment_terms: paymentTerm });
        }, 1000);
    });

    $("body").on("click", ".continue-with-review", function (event) {
        showTab('.placing_your_order');
        setTimeout(function() {
            mark_for_review(function () {
                showTab('.finalizing-order');
                orderPayed = true;
                $('#place_order').trigger( "click" );
            });
        }, 1000);
    });

    function get_countries() {
        $.ajax({
            url: admin.ajaxurl,
            data: {
                'action': 'sprinque_get_countries_api',
                'nonce': admin.nonce
            },
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                if ('errors' in response) {
                    let resultHtml = '';
                    const errors = response.errors;
                    const $errorsContainer = $('.search_already_added_company .error-confirm-order');
                    for (let key in errors) {
                        errors[key].forEach(message => resultHtml += '<p>' + message + '</p>');
                    }
                    $errorsContainer.html(resultHtml).show();
                } else {
                    countries = response;
                    toggle_radio_buttons();
                    updateRegistrationNumberRequiredMark();
                }
            }
        });
    }

    function toggle_radio_buttons() {
        if (countries.length < 1) {
            return ;
        }

        var country_code = $('#select_country_pay').val();
        var country = null;
        for (var i = 0; i < countries.length; i++) {
            if (countries[i].code === country_code) {
                country = countries[i];
            }
        }

        var is_search_by_vat_available = country.is_search_by_vat_available;
        if (is_search_by_vat_available) {
            $('#search-by').show();
            $('#company-name-label').hide();
        } else {

            $('#search-by').hide();
            $('#company-name-label').show();
        }


        $('#search-by input[name="search_by"][value="name"]').prop('checked', true);
        var placeholder = $('#search-by input[name="search_by"][value="name"]').data('placeholder');
        $('#company_name_pay').attr('placeholder', placeholder);
    }

    function get_companies_list() {
        var country_code = $('#select_country_pay').val();
        var company_name = $('#company_name_pay').val();
        var search_by = $('input[name="search_by"]:checked').val();

        if(country_code.length > 0 && company_name.length > 2 && !orderPayed) {

            $('.search-company-result').show();
            $('.search-company-result').addClass('search-company-result_loading');
            $('.search-company-result').removeClass('search-company-result_selected');
            $('.search-company-result').html('<div class="wpm-preloader">'+admin.loading+'</div>');

            $.ajax({
                url: admin.ajaxurl,
                data: {
                    'action': 'sprinque_search_business_api',
                    'country_code': country_code,
                    'company_name': company_name,
                    'search_by': search_by,
                    'locale': admin.locale,
                    'nonce': admin.nonce
                },
                type: 'POST',
                dataType: 'json',
                success: function (response) {
                    if(response.status === 'true') {
                        $('.search-company-result').html(response.html);
                        $('.search-company-result').addClass('search-company-result_loaded');
                        sprinque_translate();
                    }
                }
            });
        }
    }

    if($('#select_country_pay').length && $('#company_name_pay').length) {
        get_companies_list();
    }
});


window.addEventListener('DOMContentLoaded', sprinque_translate);
function sprinque_translate() {
    // TODO: Remove in future versions
    const $method_label = jQuery('label[for="payment_method_wpm_srinque_pay"]');
    if($method_label.length && $method_label.html() !== admin.method_title) {
        $method_label.html(admin.method_title);
    }

    const $method_text = jQuery('.payment_box.payment_method_wpm_srinque_pay p');
    if($method_text.length && $method_text.html() !== admin.method_description + admin.method_description_addition ) {
        $method_text.html(admin.method_description + admin.method_description_addition );
    }

    const $company_not_found = jQuery('.company-not-found');
    if($company_not_found.length && $company_not_found.html() !== admin.not_found_companies) {
        $company_not_found.html(admin.not_found_companies);
    }

    const $cant_find_business = jQuery('#cant-find-business');
    if($cant_find_business.length && $cant_find_business.html() !== admin.cant_find_business) {
        $cant_find_business.html(admin.cant_find_business);
    }

    const $add_manually_business = jQuery('#add-manually-business');
    if($add_manually_business.length && $add_manually_business.html() !== admin.add_manually_business) {
        $add_manually_business.html(admin.add_manually_business);
    }

    // Translates the country select
    const paymentCountrySelect = document.querySelector('#select_country_pay');
    const paymentCountryOptions = paymentCountrySelect ? paymentCountrySelect.querySelectorAll('option') : [];
    const billingCountrySelect = document.querySelector('#billing_country');

    if(paymentCountryOptions.length && billingCountrySelect) {
        paymentCountryOptions.forEach(option => {
            const relatedCountry = billingCountrySelect.querySelector('option[value="' + option.value + '"]');
            if(relatedCountry && relatedCountry.innerText) {
                option.innerText = relatedCountry.innerText;
            }
        });
    }
}
