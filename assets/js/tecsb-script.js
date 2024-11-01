/*jslint this*/
/*jslint browser:true */
/*global jQuery*/
/*global define */
/*global window */
/*global tecsb_ajax*/
/**
 * ADMIN jQuery functions
 */
jQuery(document).ready(function ($) {
    "use strict";
    $('body').on('click', '.tecsb-fe-manage-btn', function (e) {
        e.preventDefault();
        var $form = $(this).closest('.tecsb_subscription_manager_form');
        var $page = $(this).closest('.tecsb-subscriber-page-container');
        var $working = $page.find('.tecsb-working');
        var $msgbox = $form.find('.tecsb-manager-container');
        var $emailSub = $form.find('#tecsb-subform-submit-email');
        var $manageSub = $form.find('#tecsb-subform-manage-sub');
        var email = $form.find('input[name="tecsb_email"]').val();
        if (email === '') {
            $form.find('input[name="tecsb_email"]').select().focus();
            return;
        }
        var ajaxdata = {};
        ajaxdata.email = email;
        ajaxdata.action = 'tecsb_generate_subscription_manager';
        ajaxdata.tecsb_nonce = tecsb_ajax.ajax_nonce;
        $.ajax({
            beforeSend: function () {
                $working.addClass('show');
                $msgbox.fadeOut();
            },
            type: 'POST',
            dataType: 'json',
            url: tecsb_ajax.ajaxurl,
            data: ajaxdata,
            success: function (data) {
                if ('ede' === data.status) {
                    $msgbox.find('p').html(data.msg);
                    $msgbox.fadeIn();
                    $form.find('input[name="tecsb_email"]').select().focus();
                } else if ('good' === data.status) {
                    $manageSub.html(data.html);
                    $emailSub.fadeOut();
                    $manageSub.fadeIn();
                }
            },
            complete: function () {
                $working.removeClass('show');
            }
        });
    });
    $('body').on('click', '.tecsb_modify_subscribe_fe_btn', function (e) {
        e.preventDefault();
        var $btn = $(this);
        var $form = $btn.closest('.tecsb_subscription_manager_form');
        var $page = $btn.closest('.tecsb-subscriber-page-container');
        var $working = $page.find('.tecsb-working');
        var $msgbox = $form.find('.tecsb-manager-container');
        var ajaxdata = {};
        ajaxdata.category = [];
        var $category = $form.find('.tecsb_modify_form_category');
        $category.find(":input[type='checkbox']").each(function () {
            if ($(this).prop('checked')) {
                ajaxdata.category.push($(this).attr('name'));
            }
        });
        var email = $btn.data('email');
        var ukey = $btn.data('ukey');
        var sid = $btn.data('sid');
        ajaxdata.email = email;
        ajaxdata.ukey = ukey;
        ajaxdata.sid = sid;
        ajaxdata.action = 'tecsb_modify_subscription_categories';
        ajaxdata.tecsb_nonce = tecsb_ajax.ajax_nonce;
        $.ajax({
            beforeSend: function () {
                $working.addClass('show');
                $msgbox.fadeOut();
            },
            type: 'POST',
            dataType: 'json',
            url: tecsb_ajax.ajaxurl,
            data: ajaxdata,
            success: function (data) {
                if ('good' === data.status) {
                    $msgbox.find('p').html(data.msg);
                    $msgbox.fadeIn();
                }
            },
            complete: function () {
                $working.removeClass('show');
            }
        });
    });
    $('body').on('click', '#tecsb_subscribe_fe_btn', function (e) {
        e.preventDefault();
        var $btn = $(this);
        var $subscribeBox = $btn.closest('.tecsb_subscribe_box');
        var category = $subscribeBox.data('category');
        var $loading = $subscribeBox.find('.tecsb-loading');
        var email = $subscribeBox.find('input[name="tecsb_email"]').val();
        var $msgBox = $subscribeBox.find('.tecsb_sb_msg_box');
        if (email === ''){
            $subscribeBox.find('input[name="tecsb_email"]').select().focus();
            return;
        }
        var ajaxdata = {};
        if ('yes' === category) {
            ajaxdata.category = [];
            var $category = $subscribeBox.find('.tecsb_form_category');
            $category.find(":input[type='checkbox']").each(function () {
                if ($(this).prop('checked')) {
                    ajaxdata.category.push($(this).attr('name'));
                }
            });
        }
        ajaxdata.email = email;
        ajaxdata.action = 'tecsb_add_subscriber';
        ajaxdata.tecsb_nonce = tecsb_ajax.ajax_nonce;
        $.ajax({
            beforeSend: function () {
                $loading.css('display', 'block');
            },
            type: 'POST',
            dataType: 'json',
            url: tecsb_ajax.ajaxurl,
            data: ajaxdata,
            success: function (data) {
                if (data.status === 'bad') {
                    $msgBox.html(data.msg);
                    $msgBox.fadeIn('fast').delay(3000).fadeOut('slow');
                    $msgBox.addClass('normal');
                    $subscribeBox.find('input[name="tecsb_email"]').select().focus();
                } else {
                    if (data.mid === 2) {
                        $msgBox.html(data.msg);
                        $msgBox.addClass('fullscreen');
                        $msgBox.show();
                        setTimeout(function () {
                            $msgBox.hide();
                            $msgBox.removeClass('fullscreen');
                        }, 5000);
                    }
                }
            },
            complete: function () {
                $loading.css('display', 'none');
            }
        });
    });
    $('body').on('click', '.tecsb_form_select_category span', function (e) {
        var $btn = $(this);
        $(this).parent().siblings('.tecsb_form_category').slideToggle('fast', function () {
            $btn.toggleClass('radius', $btn.parent().siblings('.tecsb_form_category').not(':visible'));
        });
    });
});