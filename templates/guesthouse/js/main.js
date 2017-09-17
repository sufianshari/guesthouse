/**
 * Created by Kurma Sufi on 15/09/2017.
 */
jQuery(document).ready(function () {
    "use strict";

    // GO TOP
    //Show or hide "#go-top"
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 300) {

            jQuery('#go-top').fadeIn(200);

        } else {
            jQuery('#go-top').fadeOut(800);
        }
    });

    // Animate "#go-top"
    jQuery('#go-top').click(function (event) {
        event.preventDefault();
        jQuery('html, body').animate({
            scrollTop: 0
        }, '2000', 'swing');
    });

    // Reservation Form
    //jQueryUI - Datepicker
    if (jQuery().datepicker) {
        jQuery('#check_in').datepicker({
            showAnim: "drop",
            dateFormat: "yy/mm/dd",
            minDate: "-0D"
        });

        jQuery('#check_out').datepicker({
            showAnim: "drop",
            dateFormat: "yy/mm/dd",
            minDate: "-0D",
            beforeShow: function () {
                var a = jQuery("#check_in").datepicker('getDate');
                if (a) return {
                    minDate: a
                }
            }
        });
        jQuery('#check_in, #check_out').on('focus', function () {
            jQuery(this).blur();
        }); // Remove virtual keyboard on touch devices
    }



    //Popover
    jQuery('[data-toggle="popover"]').popover();

    // Guests
    // Show guestsblock onClick
    var guestsblock = jQuery(".guests");
    var guestsselect = jQuery(".guests-select");
    var save = jQuery(".button-save");
    guestsblock.hide();

    guestsselect.click(function () {
        guestsblock.show();
    });

    save.click(function () {
        guestsblock.fadeOut(120);
    });


    // Count guests script
    var opt1;
    var opt2;
    var total;
    jQuery('.adults select, .children select').change(

        function () {
            opt1 = jQuery('.adults').find('option:selected');
            opt2 = jQuery('.children').find('option:selected');

            total = +opt1.val() + +opt2.val();
            jQuery(".guests-select .total").html(total);
        });


});