$(document).ready(function () {

    jQuery.validator.addMethod("nameformat", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9-\s]+$/.test(value);
    }, "Invalid name format");

    jQuery.validator.addMethod("strongPassword", function (value, element) {
        return this.optional(element) || (/[a-z]/.test(value) && /[A-Z]/.test(value) && /\d/.test(value));
    }, "Invalid password format");

    jQuery.validator.addMethod("zipcodeformat", function (value, element) {
        return this.optional(element) || /^\d{5}(?:[-\s]\d{4})?$/.test(value);
    }, "Invalid ZIP code format");

    /*--------------------------------------------------------------------------------------------------------------------*/

    //Category Register Form

    $("#categoryRegisterForm").validate({
        rules: {
            categoryName: {
                required: true,
                nameformat: true,
                rangelength: [1, 128]
            },
            categoryEvent: {
                required: true
            },
            categoryDescription: {
                required: true,
                rangelength: [8, 16384]
            },
            categoryProfileImage: {
                accept: 'image/png',
                rangelength: [1, 1024]
            }
        },
        submitHandler: function (form) {
          
            if (!$(form).valid()) return false;

            const $submit = $('#categoryRegisterSubmit');
            const $modal = $('#ajaxResponse');
            
            configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });

            $.ajax({
                url: form.action,
                type: form.method,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                form.reset();
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });
            
            return false;
        }
    });

    //Category Edit Form

    $("#categoryEditForm").validate({
        rules: {
            categoryName: {
                required: true,
                nameformat: true,
                rangelength: [1, 128]
            },
            categoryEvent: {
                required: true
            },
            categoryDescription: {
                required: true,
                rangelength: [8, 16384]
            },
            categoryProfileImage: {
                accept: 'image/png',
                rangelength: [1, 1024]
            }
        },
        submitHandler: function (form) {
  
            if (!$(form).valid()) return false;

            const $submit = $('#categoryEditSubmit');
            const $modal = $('#ajaxResponse');
            
            configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });
                
            $.ajax({
                url: form.action,
                type: form.method,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                form.reset();
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });

            return false;
        }
    });

    //Event Register Form

    $("#eventRegisterForm").validate({
        rules: {
            eventName: {
                required: true,
                rangelength: [1, 128]
            },
            eventCategory: {
                required: true
            },
            eventStartDate: {
                required: true,
                date: true
            },
            eventEndDate: {
                required: true,
                date: true
            },
            eventDescription: {
                required: true,
                rangelength: [8, 16384]
            },
            eventProfileImage: {
                required: true,
                accept: 'image/png',
                rangelength: [1, 1024]
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "eventCategory") {
                error.appendTo("#eventCategoryError");
            }
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {

            if (!$(form).valid()) return false;

            const $submit = $('#eventRegisterSubmit');
            const $modal = $('#ajaxResponse');
            
            configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });
            
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                form.reset();
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });

            return false;
        }
    });

    //Event Edit form

    $("#eventEditForm").validate({
        rules: {
            eventName: {
                required: true,
                rangelength: [1, 128]
            },
            eventCategory: {
                required: true
            },
            eventStartDate: {
                required: true,
                date: true
            },
            eventEndDate: {
                required: true,
                date: true
            },
            eventDescription: {
                required: true,
                rangelength: [8, 16384]
            },
            eventProfileImage: {
                accept: 'image/png',
                rangelength: [1, 1024]
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "eventCategory") {
                error.appendTo("#eventCategoryError");
            }
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {

            const $submit = $('#eventEditSubmit');
            const $modal = $('#ajaxResponse');
            
            configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });
                
            $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                form.reset();
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });

            return false;
        }
    });

    //Game Register Form

    $("#gameRegisterForm").validate({
        rules: {
            gameName: {
                required: true,
                rangelength: [1, 64]
            },
            gamePrice: {
                required: true,
                number: true,
                rangelength: [1, 16]
            },
            gameDescription: {
                required: true,
                rangelength: [8, 16384]
            },
            gameProfileImage: {
                required: true,
                accept: 'image/png',
                rangelength: [1, 64]
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "gameCategory") {
                error.appendTo("#gameCategoryError");
            }
            else if (element.attr("name") == "gamePrice") {
                error.appendTo("#gamePriceError");
            }
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {

            const $submit = $('#gameRegisterSubmit');
            const $modal = $('#ajaxResponse');
            
            configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                form.reset();
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });

            return false;
        }
    });

    $("#gameEditForm").validate({
        rules: {
            gameName: {
                required: true,
                rangelength: [1, 64]
            },
            gamePrice: {
                required: true,
                number: true,
                rangelength: [1, 16]
            },
            gameDescription: {
                required: true,
                rangelength: [8, 16384]
            },
            gameProfileImage: {
                accept: 'image/png',
                rangelength: [1, 64]
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "gameCategory") {
                error.appendTo("#gameCategoryError");
            }
            else if (element.attr("name") == "gamePrice") {
                error.appendTo("#gamePriceError");
            }
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {

            const $submit = $('#gameEditSubmit');
            const $modal = $('#ajaxResponse');
            
            configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                form.reset();
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });

            return false;
        }
    });

    //Event Game Register Form

    $("#eventGameRegisterForm").validate({
        rules: {
            eventGameName: {
                required: true
            },
            eventGameDate: {
                required: true,
                date: true
            },
            eventGameDuration: {
                required: true,
                number: true,
                min: 5,
                max: 60
            },
            eventGameSession: {
                required: true,
                number: true,
                min: 1,
                max: 2
            },
            eventGameSlots: {
                required: true,
                digits: true
            },
            eventGameAvailability: {
                required: true,
                number: true
            },
            eventGameDescription: {
                required: true,
                rangelength: [8, 16384]
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "eventGameName") {
                error.appendTo("#eventGameNameError");
            }
            else if (element.attr("name") == "eventGameDuration") {
                error.appendTo("#eventGameDurationError");
            }
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {

            const $submit = $('#eventGameRegisterSubmit');
            const $modal = $('#ajaxResponse');
            
            configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });

            $.ajax({
                url: form.action,
                type: form.method,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                form.reset();
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });

            return false;
        }
    });

    //Event Game Edit Form

    $("#eventGameEditForm").validate({
        rules: {
            eventGameName: {
                required: true
            },
            eventGameDate: {
                required: true,
                date: true
            },
            eventGameDuration: {
                required: true,
                number: true
            },
            eventGameSession: {
                required: true,
                number: true
            },
            eventGameSlots: {
                required: true,
                digits: true
            },
            eventGameAvailability: {
                required: true,
                number: true
            },
            eventGameDescription: {
                required: true,
                rangelength: [8, 16384]
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "eventGameName") {
                error.appendTo("#eventGameNameError");
            }
            else if (element.attr("name") == "eventGameDuration") {
                error.appendTo("#eventGameDurationError");
            }
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {

            const $submit = $('#eventGameEditSubmit');
            const $modal = $('#ajaxResponse');
            
            configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });

            $.ajax({
                url: form.action,
                type: form.method,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                form.reset();
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });
            
            return false;
        }
    });

    //Administrator Register Form

    $("#adminRegisterForm").validate({
        rules: {
            adminName: {
                required: true,
                nameformat: true,
                rangelength: [1, 28]
            },
            adminEmail: {
                required: true,
                email: true,
                rangelength: [8, 128]
            },
            adminPwd: {
                required: true,
                strongPassword: true,
                rangelength: [8, 28]
            },
            adminRepeatPwd: {
                required: true,
                equalTo: "#adminPwd"
            },
            adminProfileImage: {
                accept: 'image/png',
                rangelength: [1, 64]
            },
            adminReCaptcha: {
                required: true,
                equalTo: "#adminReCaptchaVal"
            },
            adminTermsCheck: {
                required: true
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "adminTermsCheck") {
                error.appendTo("#adminTermsCheckError");
            }
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {

            const $submit = $('#adminRegisterSubmit');
            const $modal = $('#ajaxResponse');
            
            configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });

            $.ajax({
                url: form.action,
                type: form.method,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                form.reset();
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });

            return false;
        }
    });

    //Administrator Login Form

    $("#adminLoginForm").validate({
        rules: {
            adminLoginEmail: {
                required: true,
                email: true,
                rangelength: [8, 128]
            },
            adminLoginPwd: {
                required: true,
                rangelength: [8, 64]
            }
        },
        submitHandler: function (form) {

            const $submit = $('#adminLoginSubmit');
            const $modal = $('#ajaxResponse');
            
            configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });

            $.ajax({
                url: form.action,
                type: form.method,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                form.reset();
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });

            return false;
        }
    });

    //Administrator Profile Edit Form

    $("#adminProfileEditForm").validate({
        rules: {
            adminName: {
                required: true,
                nameformat: true,
                rangelength: [1, 28]
            },
            adminEmail: {
                required: true,
                email: true,
                rangelength: [8, 128]
            },
            adminDepartment: {
                required: true
            },
            adminDesignation: {
                required: true
            },
            adminProfileImage: {
                accept: 'image/png',
                rangelength: [1, 64]
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "adminUsername") {
                error.appendTo("#adminUsernameError");
            }
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {

            const $submit = $('#adminProfileEditSubmit');
            const $modal = $('#ajaxResponse');
            
            configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });

            $.ajax({
                url: form.action,
                type: form.method,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                form.reset();
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });

            return false;
        }
    });


    //Administrator Password Form

    $("#adminPasswordEditForm").validate({
        rules: {
            adminPwd: {
                required: true,
                rangelength: [8, 64]
            },
            adminNewPwd: {
                required: true,
                rangelength: [8, 64]
            },
            adminRepeatNewPwd: {
                required: true,
                equalTo: "#adminNewPwd"
            },
            adminReCaptcha: {
                required: true,
                equalTo: "#adminReCaptchaVal"
            }
        },
        submitHandler: function (form) {
            
            const $submit = $('#adminPasswordEditSubmit');
            const $modal = $('#ajaxResponse');
            
            configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });

            $.ajax({
                url: form.action,
                type: form.method,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                form.reset();
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });

            return false;
        }
    });


    /*--------------------------------------------------------------------------------------------------------------------*/

    //Event Participant Register Form

    $("#eventParticipantRegisterForm").validate({
        rules: {
            eventParticipantFirstName: {
                required: true,
                nameformat: true,
                rangelength: [1, 128]
            },
            eventParticipantLastName: {
                required: true,
                nameformat: true,
                rangelength: [1, 128]
            },
            eventParticipantEmail: {
                required: true,
                email: true,
                rangelength: [8, 128]
            },
            eventParticipantPassword: {
                required: true,
                strongPassword: true,
                rangelength: [8, 28]
            },
            eventParticipantPhoneCode: {
                required: true
            },
            eventParticipantPhoneNumber: {
                required: true,
                phoneUS: true,
                rangelength: [10, 16]
            },
            eventParticipantZip: {
                required: true,
                zipcodeformat: true,
                rangelength: [5, 10]
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "eventParticipantPhoneNumber") {
                error.appendTo("#eventParticipantPhoneNumberError");
            }
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {

            const $submit = $('#eventParticipantRegisterSubmit');
            const $modal = $('#ajaxResponse');
            
            configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });

            $.ajax({
                url: form.action,
                type: form.method,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                form.reset();
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                console.log(jqXHR);
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });

            return false;
        }
    });


    //Participant Login Form

    $("#participantLoginForm").validate({
        rules: {
            participantLoginEmail: {
                required: true,
                email: true,
                rangelength: [8, 128]
            },
            participantLoginPwd: {
                required: true,
                rangelength: [8, 28]
            }
        },
        submitHandler: function (form) {

            const $submit = $('#participantLoginSubmit');
            const $modal = $('#ajaxResponse');
            
            configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });

            $.ajax({
                url: form.action,
                type: form.method,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                form.reset();
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });

            return false;
        }
    });


    /*--------------------------------------------------------------------------------------------------------------------*/

    //Event Checkout Form

    $("#eventCheckoutForm").validate({
        rules: {
            eventCheckoutSubtotal: {
                required: true
            },
            eventCheckoutTax: {
                required: true
            },
            eventCheckoutShipping: {
                required: true
            },
            eventCheckoutTotal: {
                required: true
            },
            eventCheckoutPaymentMethod: {
                required: true
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "eventCheckoutSubtotal") {
                error.appendTo("#eventCheckoutError");
            }
            else if (element.attr("name") == "eventCheckoutTax") {
                error.appendTo("#eventCheckoutError");
            }
            else if (element.attr("name") == "eventCheckoutShipping") {
                error.appendTo("#eventCheckoutError");
            }
            else if (element.attr("name") == "eventCheckoutTotal") {
                error.appendTo("#eventCheckoutError");
            }
            else if (element.attr("name") == "eventCheckoutPaymentMethod") {
                error.appendTo("#eventCheckoutError");
            }
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            
            const $submit = $('#eventCheckoutSubmit');
            const $modal = $('#ajaxResponse');
            
            configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                     dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                form.reset();
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });

            return false;
        }
    });

    /*--------------------------------------------------------------------------------------------------------------------*/

    //Freeplay Register Form

    $("#freeplayRegisterForm").validate({
        rules: {
            freeplayName: {
                required: true,
                nameformat: true,
                rangelength: [1, 28]
            },
            freeplayEmail: {
                required: true,
                email: true,
                rangelength: [8, 128]
            },
            freeplayPhone: {
                required: true,
                phoneUS: true,
                rangelength: [10, 16]
            },
            freeplayDOB: {
                required: true,
                date: true
            },
            freeplayGuardianName: {
                required: true,
                nameformat: true,
                rangelength: [1, 28]
            },
            freeplayAddress: {
                required: true,
                rangelength: [1, 128]
            },
            freeplayReCaptcha: {
                required: true,
                equalTo: "#freeplayReCaptchaVal"
            },
            freeplayTermsCheck: {
                required: true
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "freeplayTermsCheck") {
                error.appendTo("#freeplayTermsCheckError");
            }
            else if (element.attr("name") == "freeplayPhone") {
                error.appendTo("#freeplayPhoneError");
            }
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {

            const $submit = $('#freeplayRegisterSubmit');
            const $modal = $('#ajaxResponse');
            
            configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });

            $.ajax({
                url: form.action,
                type: form.method,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                form.reset();
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });

            return false;
        }
    });

    /*--------------------------------------------------------------------------------------------------------------------*/

    //Event Game Add Form

    $("#eventGameAddForm").validate({
        rules: {
            eventGameSlots: {
                required: true,
                digits: true,
                min: 1
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "eventGameAmount") {
                error.appendTo("#eventGameAmountError");
            }
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            
            const $submit = $('#eventGameAddSubmit');
            const $modal = $('#ajaxResponse');
            
            configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });

            $.ajax({
                url: form.action,
                type: form.method,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                form.reset();
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });

            return false;
        }
    });

    //Event Game Sign Up Add Form

    $(document).on('click', '.eventGameSignUpAddSubmit', function (e) {

        e.preventDefault();

        const $submit = $(this);
        const $modal = $('#ajaxResponse');
            
        configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });

        var eventSignUpAddUID = $(this).attr("id");
        var eventSignUpAddForm = $('#eventGameSignUpAddForm' + eventSignUpAddUID);
        var eventGameUID = $(eventSignUpAddForm).find('#eventGameUID').val();
        var eventGamePrice = $(eventSignUpAddForm).find('#eventGamePrice').val();
        var eventGameSlots = $(eventSignUpAddForm).find('#eventGameSlots').val();
        var eventGameType = $(eventSignUpAddForm).find('#eventGameType').val();
        var eventGameSlotsLimit = $(eventSignUpAddForm).find('#eventGameSlotsLimit').val();

        $.ajax({
            type: 'POST',
            url: $(this).attr("href"),
            data: {
                eventSignUpAddUID: eventSignUpAddUID,
                eventGameUID: eventGameUID,
                eventGamePrice: eventGamePrice,
                eventGameSlots: eventGameSlots,
                eventGameType: eventGameType,
                eventGameSlotsLimit: eventGameSlotsLimit
            },
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                form.reset();
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });

            return false;
    });

    //Event Payment Cash Form

    $("#eventPaymentCashForm").validate({
        submitHandler: function (form) {
            if ($(form).valid()) {
                $('#eventPayButton').attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
                $("#payment-loader").fadeIn();
                form.submit();
            }
        }
    });

    /*--------------------------------------------------------------------------------------------------------------------*/

    //Event Sign Up Checkout Form

    $("#eventSignUpCheckoutForm").validate({
        ignore: '',
        rules: {
            eventParticipantFirstName: {
                required: true,
                nameformat: true,
                rangelength: [1, 28]
            },
            eventParticipantLastName: {
                required: true,
                nameformat: true,
                rangelength: [1, 28]
            },
            eventParticipantEmail: {
                required: true,
                email: true,
                rangelength: [8, 128]
            },
            eventParticipantPhoneCode: {
                required: true
            },
            eventParticipantPhoneNumber: {
                required: true,
                phoneUS: true,
                rangelength: [10, 16]
            },
            eventParticipantZip: {
                required: true,
                zipcodeformat: true,
                rangelength: [5, 10]
            },
            eventCheckoutPaymentMethod: {
                required: true
            },
            eventCheckoutSubtotal: {
                required: true
            },
            eventCheckoutTax: {
                required: true
            },
            eventCheckoutShipping: {
                required: true
            },
            eventCheckoutTotal: {
                required: true
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "eventParticipantPhoneNumber") {
                error.appendTo("#eventParticipantPhoneNumberError");
            }
            else if (element.attr("name") == "eventCheckoutPaymentMethod") {
                error.appendTo("#eventCheckoutPaymentMethodError");
            }
            else if (element.attr("name") == "eventCheckoutSubtotal") {
                error.appendTo("#eventCheckoutError");
            }
            else if (element.attr("name") == "eventCheckoutTax") {
                error.appendTo("#eventCheckoutError");
            }
            else if (element.attr("name") == "eventCheckoutShipping") {
                error.appendTo("#eventCheckoutError");
            }
            else if (element.attr("name") == "eventCheckoutTotal") {
                error.appendTo("#eventCheckoutError");
            }
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {

            const $submit = $('#eventSignUpCheckoutSubmit');
            const $modal = $('#ajaxResponse');
            
            configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });

            $.ajax({
                url: form.action,
                type: form.method,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                form.reset();
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });

            return false;
        }
    });


    /*--------------------------------------------------------------------------------------------------------------------*/

    //Event Billing Information Form

    $("#eventBillingInfoForm").validate({
        rules: {
            eventBillingFirstName: {
                required: true,
                nameformat: true,
                rangelength: [1, 28]
            },
            eventBillingLastName: {
                required: true,
                nameformat: true,
                rangelength: [1, 28]
            },
            eventBillingEmail: {
                required: true,
                email: true,
                rangelength: [8, 128]
            },
            eventBillingPhoneCode: {
                required: true
            },
            eventBillingPhoneNumber: {
                required: true,
                phoneUS: true
            },
            eventBillingZip: {
                required: true,
                zipcodeformat: true,
                rangelength: [5, 10]
            },
            eventBillingPaymentMethod: {
                required: true
            },
            eventBillingReCaptcha: {
                required: true,
                equalTo: "#eventBillingReCaptchaVal"
            },
            eventBillingTermsCheck: {
                required: true
            },
            eventBillingWaiverCheck: {
                required: true
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "eventBillingTermsCheck") {
                error.appendTo("#eventBillingTermsCheckError");
            }
            else if (element.attr("name") == "eventBillingWaiverCheck") {
                error.appendTo("#eventBillingWaiverCheckError");
            }
            else if (element.attr("name") == "eventBillingPhoneNumber") {
                error.appendTo("#eventBillingPhoneError");
            }
            else if (element.attr("name") == "eventBillingPaymentMethod") {
                error.appendTo("#eventBillingPaymentMethodError");
            }
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {

            const $submit = $('#eventBillingInfoSubmit');
            const $modal = $('#ajaxResponse');
            
            configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });

            $.ajax({
                url: form.action,
                type: form.method,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                form.reset();
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });

            return false;
        }
    });

    /*--------------------------------------------------------------------------------------------------------------------*/

    //Edit About Information Form

    $("#adminAboutInfoForm").validate({
        rules: {
            aboutInfoYear: {
                required: true
            },
            aboutInfoVenue: {
                required: true
            },
            aboutInfoDates: {
                required: true
            },
            aboutInfoEventTime: {
                required: true
            },
            aboutInfoEventEmail: {
                required: true
            },
            aboutInfoEventTags: {
                required: true
            },
            aboutInfoEventCopyrights: {
                required: true
            },
            aboutInfoEventSiteTitle: {
                required: true
            },
            aboutInfoEventSiteDesc: {
                required: true
            },
            aboutInfoEventKeywords: {
                required: true
            },
            aboutInfoEventEmailEventDate: {
                required: true
            },
            aboutInfoEventEmailEventTime: {
                required: true
            },
            aboutInfoReCaptcha: {
                required: true,
                equalTo: "#aboutInfoReCaptchaVal"
            }
        },
        submitHandler: function (form) {

            const $submit = $('#adminAboutInfoSubmit');
            const $modal = $('#ajaxResponse');
            
            configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });

            $.ajax({
                url: form.action,
                type: form.method,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                form.reset();
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });

            return false;
        }
    });

    //Constants Update Form

    $("#adminConstantInfoForm").validate({
        rules: {
            constantInfoTaxRate: {
                required: true
            },
            constantInfoAdminEmail: {
                required: true
            },
            constantInfoBaseURL: {
                required: true
            },
            constantInfoReCaptcha: {
                required: true,
                equalTo: "#constantInfoReCaptchaVal"
            }
        },
        submitHandler: function (form) {

            const $submit = $('#adminConstantInfoSubmit');
            const $modal = $('#ajaxResponse');
            
            configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });

            $.ajax({
                url: form.action,
                type: form.method,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                form.reset();
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });

            return false;
        }
    });

    /*--------------------------------------------------------------------------------------------------------------------*/

    //Event Check In Form

    $("#eventCheckinForm").validate({
        rules: {
            eventCheckinOrderID: {
                required: true
            }
        },
        submitHandler: function (form) {

            const $submit = $('#eventCheckinSubmit');
            const $modal = $('#ajaxResponse');
            
            configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });

            $.ajax({
                url: form.action,
                type: form.method,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                form.reset();
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });

            return false;
        }
    });

     /*---------------------------------------------------------------------------------------------------------------*/

    // Confirm Process

    $(document).on('click', '.btn-confirm', function (e) {

        e.preventDefault();

        const $submit = $(this);
        const $confirmModal = $('#confirmAction');
        const $modal = $('#ajaxResponse');

        $(this).attr('disabled', true).addClass('disabled').attr('value', 'Processing...');

        var itemUID = $(this).attr("id");
        const itemData = new FormData();
        itemData.append('itemUID', itemUID);
        if($(this).attr('data-content')){
            var itemContent = $(this).attr('data-content');
            itemData.append('itemContent', itemContent);
        }

        configureModal($submit, $confirmModal, { disableSubmit: false, spinner: false, footer: false, msg: 'Confirmed', icon: 'ok', show: false });     
        configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });
        
        $.ajax({
            type: "POST",
            url: $submit.attr("href"),
            data: itemData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json'
            })
            .done(function (data) {
                const msg = data && data.msg ? data.msg : 'No response';
                const redir = data && data.redir ? data.redir : null;
                if (data && data.err === 0) {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'ok', show: true, redirect: redir });
                } else {
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true, redirect: redir });
                }
            })
            .fail(function (jqXHR, textStatus) {
                const msg = jqXHR.responseText || textStatus || 'Request failed';
                configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg, icon: 'err', show: true });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('disabled');
            });
            return false;
    });

    // Confirm Delete

    $(document).on('click', '.btn-del-confirm', function (e) {

        e.preventDefault();

        const $submit = $(this);
        const $modal = $('#confirmAction');
        const $action = $('.btn-confirm');

        configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });

        var deleteUID = $submit.attr("id");
        var deleteLink = $submit.attr("data-link");

        const data = { msg: "Confirm delete?", redir: null };
        $action.attr({'id': deleteUID, 'href': deleteLink});
            
        configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg: data.msg, icon: 'wrn', show: true, redirect: data.redir });
    });

    // Confirm Update

    $(document).on('click', '.btn-upd-confirm', function (e) {

        e.preventDefault();

        const $submit = $(this);
        const $modal = $('#confirmAction');
        const $action = $('.btn-confirm');

        configureModal($submit, $modal, { disableSubmit: true, spinner: true, footer: false, msg: 'Processing...', show: true });

        var updateUID = $submit.attr("id");
        var updateContent = $submit.closest('.row').find('input[type="number"]').val();
        var updateLink = $submit.attr("data-link");

        const data = { msg: "Confirm update?", redir: null };
        $action.attr({'id': updateUID, 'data-content': updateContent, 'href': updateLink});
            
        configureModal($submit, $modal, { disableSubmit: false, spinner: false, footer: true, msg: data.msg, icon: 'wrn', show: true, redirect: data.redir });
    });

    /*--------------------------------------------------------------------------------------------------------------------*/

    //Register Event Start Date

    $("#eventRegisterForm").find("#eventStartDate").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        minDate: new Date(),
        maxDate: '+6m',
        onSelect: function (selected) {
            var date = new Date(selected);
            date.setMonth(date.getMonth() + 1);
            $("#eventRegisterForm").find("#eventEndDate").datepicker("option", {
                minDate: selected,
                "maxDate": date
            });
        }
    });

    //Register Event End Date

    $("#eventRegisterForm").find("#eventEndDate").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true
    });

    //Edit Event Start Date

    $("#eventEditForm").find("#eventStartDate").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        minDate: new Date(),
        maxDate: '+6m',
        onSelect: function (selected) {
            var date = new Date(selected);
            date.setMonth(date.getMonth() + 1);
            $("#eventEditForm").find("#eventEndDate").datepicker("option", {
                minDate: selected,
                "maxDate": date
            });
        }
    });

    //Edit Event End Date

    $("#eventEditForm").find("#eventEndDate").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true
    });

    //Register Event Game Date

    $("#eventGameRegisterForm").find("#eventGameDate").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        minDate: new Date(
            new Date($("#eventGameRegisterForm").find("#eventGameEventStartDate").val()).getFullYear(),
            new Date($("#eventGameRegisterForm").find("#eventGameEventStartDate").val()).getMonth(),
            new Date($("#eventGameRegisterForm").find("#eventGameEventStartDate").val()).getDate()
        ),
        maxDate: new Date(
            new Date($("#eventGameRegisterForm").find("#eventGameEventEndDate").val()).getFullYear(),
            new Date($("#eventGameRegisterForm").find("#eventGameEventEndDate").val()).getMonth(),
            new Date($("#eventGameRegisterForm").find("#eventGameEventEndDate").val()).getDate()
        )
    });

    //Edit Event Game Date

    $("#eventGameEditForm").find("#eventGameDate").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        minDate: new Date(
            new Date($("#eventGameEditForm").find("#eventGameEventStartDate").val()).getFullYear(),
            new Date($("#eventGameEditForm").find("#eventGameEventStartDate").val()).getMonth(),
            new Date($("#eventGameEditForm").find("#eventGameEventStartDate").val()).getDate()
        ),
        maxDate: new Date(
            new Date($("#eventGameEditForm").find("#eventGameEventEndDate").val()).getFullYear(),
            new Date($("#eventGameEditForm").find("#eventGameEventEndDate").val()).getMonth(),
            new Date($("#eventGameEditForm").find("#eventGameEventEndDate").val()).getDate()
        )
    });

    //Freeplay Participant Date of Birth

    $("#freeplayRegisterForm").find("#freeplayDOB").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        minDate: new Date(1900, 1 - 1, 1),
        maxDate: new Date(),
        defaultDate: new Date(2000, 1 - 1, 1),
        changeMonth: true,
        changeYear: true
    });


    //Disable AJAX Modal Close on Clicking in Background

    $('#ajaxResponse').modal({ backdrop: 'static', keyboard: false });

    //Bootstrap - Enable Tooltip

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });


    //Hero Background Animation

    $(function () {
    const $container = $("#snowfall");
    const snowflakeCount = 35;

    const snowflakeTypes = ["❄", "❅", "❆", "✳"];

    function createSnowflake() {
        const containerWidth = $container.innerWidth();
        const containerHeight = $container.innerHeight();

        const symbol =
        snowflakeTypes[
            Math.floor(Math.random() * snowflakeTypes.length)
        ];

        const $flake = $("<span>", {
        class: "snow-particle",
        text: symbol
        });

        const startLeft = Math.random() * containerWidth;
        const endLeft = startLeft + (Math.random() * 80 - 40);
        const size = 10 + Math.random() * 18;
        const duration = 5000 + Math.random() * 5000;

        $flake.css({
        position: "absolute",
        zIndex: 1,
        left: startLeft + "px",
        top: "-30px",
        fontSize: size + "px",
        color: "#fff",       // Change the flake color here
        opacity: 0.5 + Math.random() * 0.5,
        lineHeight: "1",
        background: "transparent",
        textShadow: "none",
        boxShadow: "none",
        filter: "none",
        WebkitFilter: "none",
        pointerEvents: "none",
        userSelect: "none"
        });


        $container.append($flake);

        $flake.animate(
        {
            top: containerHeight + 30 + "px",
            left: endLeft + "px"
        },
        duration,
        "linear",
        function () {
            $(this).remove();
            createSnowflake();
        }
        );
    }

    for (let i = 0; i < snowflakeCount; i++) {
        setTimeout(function () {
        createSnowflake();
        }, i * 250);
    }
    });


    /*--------------------------------------------------------------------------------------------------------------------*/
    /*--------------------------------------------------------------------------------------------------------------------*/

    $(".event-gallery-carousel").owlCarousel({
        loop: true,
        autoplay: true,
        autoplayTimeout: 2000,
        margin: 10,
        nav: false,
        dots: false,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    });

    /*--------------------------------------------------------------------------------------------------------------------*/
    /*--------------------------------------------------------------------------------------------------------------------*/

    $('#gameRegisterForm').find('#gameDescription').trumbowyg({
        btns: [
            ['viewHTML'],
            ['undo', 'redo'],
            ['formatting'],
            ['strong', 'em', 'del'],
            ['link'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['removeformat']
        ]
    });

    $('#gameEditForm').find('#gameDescription').trumbowyg({
        btns: [
            ['viewHTML'],
            ['undo', 'redo'],
            ['formatting'],
            ['strong', 'em', 'del'],
            ['link'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['removeformat']
        ]
    });

    $('#eventGameRegisterForm').find('#eventGameDescription').trumbowyg({
        btns: [
            ['viewHTML'],
            ['undo', 'redo'],
            ['formatting'],
            ['strong', 'em', 'del'],
            ['link'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['removeformat']
        ]
    });

    $('#eventGameEditForm').find('#eventGameDescription').trumbowyg({
        btns: [
            ['viewHTML'],
            ['undo', 'redo'],
            ['formatting'],
            ['strong', 'em', 'del'],
            ['link'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['removeformat']
        ]
    });

    $('#eventRegisterForm').find('#eventDescription').trumbowyg({
        btns: [
            ['viewHTML'],
            ['undo', 'redo'],
            ['formatting'],
            ['strong', 'em', 'del'],
            ['link'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['removeformat']
        ]
    });

    $('#eventEditForm').find('#eventDescription').trumbowyg({
        btns: [
            ['viewHTML'],
            ['undo', 'redo'],
            ['formatting'],
            ['strong', 'em', 'del'],
            ['link'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['removeformat']
        ]
    });


    $('#categoryRegisterForm').find('#categoryDescription').trumbowyg({
        btns: [
            ['viewHTML'],
            ['undo', 'redo'],
            ['formatting'],
            ['strong', 'em', 'del'],
            ['link'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['removeformat']
        ]
    });

    $('#categoryEditForm').find('#categoryDescription').trumbowyg({
        btns: [
            ['viewHTML'],
            ['undo', 'redo'],
            ['formatting'],
            ['strong', 'em', 'del'],
            ['link'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['removeformat']
        ]
    });

});

/*--------------------------------------------------------------------------------------------------------------------*/

// Response Modal

function configureModal($submit, $modal, { disableSubmit = false, spinner = false, footer = false, msg = '', icon = null, show = false, redirect = null } = {}) {
    
    const $p = $modal.find('.modal-body p');
    const $icon = $modal.find('.modal-body i');
    const $spinner = $modal.find('.modal-body .spinner-border');
    const $footer = $modal.find('.modal-footer');
    const $footerBtn = $footer.find('button');

    const resetIcon = () => $icon.removeClass().hide();
    const setIcon = (type) => {
        resetIcon();
        if (type === 'ok') $icon.addClass('fa fa-5x fa-check-circle text-blue mb-3').show();
        if (type === 'err') $icon.addClass('fa fa-5x fa-times-circle text-red mb-3').show();
        if (type === 'wrn') $icon.addClass('fa fa-5x fa-exclamation-circle text-red mb-3').show();
    }; 
    
    $submit.prop('disabled', disableSubmit).toggleClass('disabled', disableSubmit);
    $spinner.toggle(spinner);
    $p.text(msg).toggleClass('text-gray', !!msg);
    if (icon) setIcon(icon); else resetIcon();
    $footer.toggle(footer);
    // attach one-time namespaced handler to avoid stacking
    $footerBtn.off('click.redirect').on('click.redirect', function () {
    if (redirect) window.location.href = redirect;
    });
    if (show) $modal.modal('show'); else $modal.modal('hide');
};

/*--------------------------------------------------------------------------------------------------------------------*/
/*--------------------------------------------------------------------------------------------------------------------*/
/*--------------------------------------------------------------------------------------------------------------------*/
/*--------------------------------------------------------------------------------------------------------------------*/

// Canvas JS

$(document).ready(function () {
    if(window.totalAmountByDateChartData){
        totalAmountByDateChart(totalAmountByDateChartData);
    }
    
});

function totalAmountByDateChart(totalAmountByDateChartData) {

    var chart = new CanvasJS.Chart("totalAmountByDateChart", {
        title: {
            text: "Total order amount by last 5 dates",
            fontSize: 16,
            fontColor: "#03668d",
            fontFamily: "Poppins",
        },
        axisY: {
            title: "Order Amount"
        },
        data: [{
            type: "line",
            lineColor: "#c53637",
            indexLabelFontFamily: "Poppins",
            dataPoints: totalAmountByDateChartData
        }]
    });
    chart.render();

}

// Page Loader

$(window).on("load", function () {
    $('#page-loader').delay(1000).fadeOut();
});

$(window).on("load", function () {

    //Check all DOM elements extending over container margin
    var docWidth = document.documentElement.offsetWidth;

    [].forEach.call(
        document.querySelectorAll('*'),
        function (el) {
            if (el.offsetWidth > docWidth) {
                console.log(el);
            }
        }
    );
});

// Image Loading

window.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('img').forEach(img => {
    if (img.complete && img.naturalWidth) {
      img.dataset.loaded = 'true';
    } else {
      img.addEventListener('load', () => img.dataset.loaded = 'true', { once: true });
      img.addEventListener('error', () => img.dataset.loaded = 'true', { once: true });
    }
  });
});
