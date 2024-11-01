/** jslint this*/
/*jslint browser:true */
/*global jQuery*/
/*global define */
/*global window */
/**
 * ADMIN jQuery functions
 */
jQuery(document).ready(function ($) {
    "use strict";
    function changeAdminTab(hash) {
        var tecsbTable = $('.tecsb-admin-table');
        tecsbTable.find('.tecsb-admin-content.active').removeClass('active');
        var ul = tecsbTable.find('ul.tecsb-admin-tab');
        ul.find('li a').removeClass('active');
        $(ul).find('a[href*=\\' + hash + ']').addClass('active');
        tecsbTable.find(hash).addClass('active');
        $("html, body").animate({
            scrollTop: 0
        }, 1000);
    }
    function init() {
        var hash = window.location.hash;
        if (hash === '' || hash === 'undefined') {
        } else {
            changeAdminTab(hash);
        }

        var switches = document.querySelectorAll('input[type="checkbox"].tecsb-switch');
        for (var i=0, sw; sw = switches[i++]; ) {
            var div = document.createElement('div');
            div.className = 'switch';
            sw.parentNode.insertBefore(div, sw.nextSibling);
        }
    }
    init();
    $('.tecsb-onoff-switch').on('click', function (e) {
        var $checkbox = $(this).find('input');
        
    });
    $('.tecsb-admin-table').on('click', 'ul.tecsb-admin-tab li a', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        changeAdminTab(href);
        window.location.hash = href;
    });

    $('body').on('click', '.tecsb-admin-save, .tesb-sidebar-fbtn.save-settings-all', function (e) {
        e.preventDefault();
        var $parent = $(this).closest('form');
        var $loader = $parent.find('.tecsb-admin-saving');
        var data = {};
        $parent.find(":input[type='text']").each(function(){
            data[$(this).attr('name')] = $(this).val();
        });
        $parent.find(":input[type='radio']").each(function(){
            if($(this).prop('checked')){
                data[$(this).attr('name')] = $(this).val();
            }
        });
        $parent.find(":input[type='checkbox']").each(function(){
            if($(this).prop('checked')){
                data[$(this).attr('name')] = 'on';
            } else {
                data[$(this).attr('name')] = 'off';
            }
        });
        //console.log(data);
        var ajaxdata = {};
        ajaxdata.action = 'save_tecsb_options';
        ajaxdata.tecsb_nonce = tecsb_admin_ajax.ajax_nonce;
        ajaxdata.data = data;
        $.ajax({
            beforeSend: function () {
                $loader.addClass('show');
            },
            type: 'POST',
            dataType: 'json',
            url: tecsb_admin_ajax.ajaxurl,
            data: ajaxdata,
            success: function () {
                $loader.removeClass('show');
                location.reload();
            },
            complete: function () {
                $loader.removeClass('show');
                location.reload();
            },
            error: function (x,y,z) {
                console.log(x);
            }
        });
    });
    $('body').on('click', '.tecsb-accordion', function (e) {
        e.preventDefault();
        var $parent = $(this).closest('.tecsb-email-type-settings');
        $parent.find('.tecsb-accordion').each( function (e) {
            $(this).removeClass('active');
            $(this).next().removeClass('active').slideUp();
        })
        var $next = $(this).next();
        if( $next.hasClass('active') ) {
            $next.removeClass('active');
            $(this).removeClass('active');
            $next.slideUp();
        }else{
            $next.addClass('active');
            $(this).addClass('active');
            $next.slideDown();
        }
    });
    $('body').on('click', '.preview-email-body', function (e) {
        e.preventDefault();
        $('.tecsb-admin-popup-wrap').fadeIn(500);
        var type = $(this).data('type');
        var ajaxdata = {};
        ajaxdata.type = type;
        ajaxdata.action = 'tecsb_generate_email_preview_admin';
        ajaxdata.tecsb_nonce = tecsb_admin_ajax.ajax_nonce;
        $.ajax({
            beforeSend: function () {
                $('.tecsb-admin-popup-container').addClass('tecsb-admin-loading');
            },
            type: 'POST',
            dataType: 'json',
            url: tecsb_admin_ajax.ajaxurl,
            data: ajaxdata,
            success: function (data) {
                if('good' === data.status ){
                    var $content = $('.tecsb-admin-popup-container').find('.tecsb-admin-popup-content');
                    var $header = $('.tecsb-admin-popup-container').find('.tecsb-admin-popup-header');
                    $content.html(data.content.message);
                    $header.find('.from i').html(data.content.from);
                    $header.find('.to i').html(data.content.to);
                    $header.find('.subject i').html(data.content.subject);
                    $header.css('display', 'block');
                }
            },
            complete: function () {
                $('.tecsb-admin-popup-container').removeClass('tecsb-admin-loading');
            }
        });
    });
    $('.tecsb-admin-popup-close').click(function(e) {
        e.preventDefault();
        $('.tecsb-admin-popup-wrap').fadeOut(500);
        $('.tecsb-admin-popup-container').find('.tecsb-admin-popup-header').css('display', 'none');
    });
});