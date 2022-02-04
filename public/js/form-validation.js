
/*global $, JQuery , alert*/
$(function () {
    'use strict';
    console.log('contact_validation');

    $("#contact_validation").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            name: {
                required: true,
            },
            messages: {
                required: true,
                minlength: 3
            }
        },
        messages: {
            email: {
                required: "Please enter your email",
                email: "Please enter a valid email"
            },
            name: {
                required: "Please enter your name"
            },
            messages: {
                required: "Please enter your messages",
                minlength: "Please enter message more than 3 char"
            }
        }
    });

    $("#leave-a-comment").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            name: {
                required: true,
            },
            messages: {
                required: true,
                minlength: 3
            }
        },
        messages: {
            email: {
                required: "Please enter your email",
                email: "Please enter a valid email"
            },
            name: {
                required: "Please enter your name"
            },
            messages: {
                required: "Please enter your messages",
                minlength: "Please enter message more than 3 char"
            }
        }
    });
});
