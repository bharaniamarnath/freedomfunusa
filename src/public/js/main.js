$(document).ready(function () {

    jQuery.validator.addMethod("nameformat", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9-\s]+$/.test(value);
    }, "Invalid name format");

    jQuery.validator.addMethod("zipcodeformat", function (value, element) {
        return this.optional(element) || /^\d{5}(?:[-\s]\d{4})?$/.test(value);
    }, "Invalid ZIP code format");

    //Category Register Form

    $("#categoryRegisterForm").validate({
        rules: {
            categoryName: {
                required: true,
                nameformat: true,
                rangelength: [1, 128]
            },
            categoryCode: {
                required: true,
                rangelength: [8, 16]
            },
            categoryAddress: {
                required: true,
                rangelength: [8, 128]
            },
            categoryPhone: {
                required: true,
                rangelength: [10, 16]
            },
            categoryEmail: {
                required: true,
                email: true,
                rangelength: [8, 128]
            },
            categoryWebsite: {
                url: true,
                rangelength: [8, 128]
            },
            categoryProfileImage: {
                accept: 'image/png',
                rangelength: [1, 64]
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "categoryPhoneNumber") {
                error.appendTo("#categoryPhoneError");
            }
            else if (element.attr("name") == "categoryStatus") {
                error.appendTo("#categoryStatusError");
            }
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            if ($(form).valid()) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#categoryRegisterSubmit').attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
                        $('.spinner-border').show();
                    },
                    success: function (res) {
                        console.log(res);
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.msg);
                        if (rjson.err == 0) {
                            $('#ajaxResponse .modal-body p').addClass('text-blue');
                            $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                            $(form)[0].reset();
                        }
                        else {
                            $('#ajaxResponse .modal-body p').addClass('text-red');
                            $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        }
                        $('#ajaxResponse').modal('show');
                    },
                    error: function (res) {
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.responseText);
                        $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        $('#ajaxResponse').modal('show');
                    },
                    complete: function () {
                        $('#categoryRegisterSubmit').attr('disabled', false).removeClass('disabled').attr('value', 'Register');
                        $('.spinner-border').hide();
                    }
                });
            }
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
            categoryCode: {
                required: true,
                rangelength: [8, 16]
            },
            categoryAddress: {
                required: true,
                rangelength: [8, 128]
            },
            categoryPhone: {
                required: true,
                rangelength: [10, 16]
            },
            categoryEmail: {
                required: true,
                email: true,
                rangelength: [8, 128]
            },
            categoryWebsite: {
                url: true,
                rangelength: [8, 128]
            },
            categoryProfileImage: {
                accept: 'image/png',
                rangelength: [1, 64]
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "categoryPhoneNumber") {
                error.appendTo("#categoryPhoneError");
            }
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            if ($(form).valid()) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#categoryEditSubmit').attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
                        $('.spinner-border').show();
                    },
                    success: function (res) {
                        console.log(res);
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.msg);
                        if (rjson.err == 0) {
                            $('#ajaxResponse .modal-body p').addClass('text-blue');
                            $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                        }
                        else {
                            $('#ajaxResponse .modal-body p').addClass('text-red');
                            $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        }
                        $('#ajaxResponse').modal('show');
                    },
                    error: function (res) {
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.responseText);
                        $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        $('#ajaxResponse').modal('show');
                    },
                    complete: function () {
                        $('#categoryEditSubmit').attr('disabled', false).removeClass('disabled').attr('value', 'Update');
                        $('.spinner-border').hide();
                    }
                });
            }
            return false;
        }
    });

    //Event Register Form

    $("#eventRegisterForm").validate({
        rules: {
            eventName: {
                required: true,
                rangelength: [1, 64]
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
                rangelength: [1, 64]
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
            if ($(form).valid()) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#eventRegisterSubmit').attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
                        $('.spinner-border').show();
                    },
                    success: function (res) {
                        console.log(res);
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.msg);
                        if (rjson.err == 0) {
                            $('#ajaxResponse .modal-body p').addClass('text-blue');
                            $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                            $(form)[0].reset();
                        }
                        else {
                            $('#ajaxResponse .modal-body p').addClass('text-red');
                            $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        }
                        $('#ajaxResponse').modal('show');
                    },
                    error: function (res) {
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.responseText);
                        $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        $('#ajaxResponse').modal('show');
                    },
                    complete: function () {
                        $('#eventRegisterSubmit').attr('disabled', false).removeClass('disabled').attr('value', 'Register');
                        $('.spinner-border').hide();
                    }
                });
            }
            return false;
        }
    });

    //Event Edit form

    $("#eventEditForm").validate({
        rules: {
            eventName: {
                required: true,
                rangelength: [1, 64]
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
                rangelength: [1, 64]
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
            if ($(form).valid()) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#eventEditSubmit').attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
                        $('.spinner-border').show();
                    },
                    success: function (res) {
                        console.log(res);
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.msg);
                        if (rjson.err == 0) {
                            $('#ajaxResponse .modal-body p').addClass('text-blue');
                            $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                            $(form)[0].reset();
                        }
                        else {
                            $('#ajaxResponse .modal-body p').addClass('text-red');
                            $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        }
                        $('#ajaxResponse').modal('show');
                    },
                    error: function (res) {
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.responseText);
                        $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        $('#ajaxResponse').modal('show');
                    },
                    complete: function () {
                        $('#eventEditSubmit').attr('disabled', false).removeClass('disabled').attr('value', 'Register');
                        $('.spinner-border').hide();
                    }
                });
            }
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
            if ($(form).valid()) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#gameRegisterSubmit').attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
                        $('.spinner-border').show();
                    },
                    success: function (res) {
                        console.log(res);
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.msg);
                        if (rjson.err == 0) {
                            $('#ajaxResponse .modal-body p').addClass('text-blue');
                            $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                            $(form)[0].reset();
                        }
                        else {
                            $('#ajaxResponse .modal-body p').addClass('text-red');
                            $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        }
                        $('#ajaxResponse').modal('show');
                    },
                    error: function (res) {
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.responseText);
                        $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        $('#ajaxResponse').modal('show');
                    },
                    complete: function () {
                        $('#gameRegisterSubmit').attr('disabled', false).removeClass('disabled').attr('value', 'Register');
                        $('.spinner-border').hide();
                    }
                });
            }
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
            if ($(form).valid()) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#gameEditSubmit').attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
                        $('.spinner-border').show();
                    },
                    success: function (res) {
                        console.log(res);
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.msg);
                        if (rjson.err == 0) {
                            $('#ajaxResponse .modal-body p').addClass('text-blue');
                            $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                            $(form)[0].reset();
                        }
                        else {
                            $('#ajaxResponse .modal-body p').addClass('text-red');
                            $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        }
                        $('#ajaxResponse').modal('show');
                    },
                    error: function (res) {
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.responseText);
                        $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        $('#ajaxResponse').modal('show');
                    },
                    complete: function () {
                        $('#gameEditSubmit').attr('disabled', false).removeClass('disabled').attr('value', 'Register');
                        $('.spinner-border').hide();
                    }
                });
            }
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
            if ($(form).valid()) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#eventGameRegisterSubmit').attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
                        $('.spinner-border').show();
                    },
                    success: function (res) {
                        console.log(res);
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.msg);
                        if (rjson.err == 0) {
                            $('#ajaxResponse .modal-body p').addClass('text-blue');
                            $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                            $(form)[0].reset();
                        }
                        else {
                            $('#ajaxResponse .modal-body p').addClass('text-red');
                            $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        }
                        $('#ajaxResponse').modal('show');
                    },
                    error: function (res) {
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.responseText);
                        $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        $('#ajaxResponse').modal('show');
                    },
                    complete: function () {
                        $('#eventGameRegisterSubmit').attr('disabled', false).removeClass('disabled').attr('value', 'Register');
                        $('.spinner-border').hide();
                    }
                });
            }
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
            if ($(form).valid()) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#eventGameEditSubmit').attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
                        $('.spinner-border').show();
                    },
                    success: function (res) {
                        console.log(res);
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.msg);
                        if (rjson.err == 0) {
                            $('#ajaxResponse .modal-body p').addClass('text-blue');
                            $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                            $(form)[0].reset();
                        }
                        else {
                            $('#ajaxResponse .modal-body p').addClass('text-red');
                            $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        }
                        $('#ajaxResponse').modal('show');
                    },
                    error: function (res) {
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.responseText);
                        $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        $('#ajaxResponse').modal('show');
                    },
                    complete: function () {
                        $('#eventGameEditSubmit').attr('disabled', false).removeClass('disabled').attr('value', 'Register');
                        $('.spinner-border').hide();
                    }
                });
            }
            return false;
        }
    });



    /*---------------------------------------------------------------------------------------------------------------*/

    //Delete Category

    $('.btn-del-category').click(function (e) {
        e.preventDefault();
        $(this).attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
        var categoryUID = $(this).attr("id");
        $.ajax({
            type: "POST",
            url: $(this).attr("href"),
            data: {
                categoryUID: categoryUID
            },
            cache: false,
            success: function (res) {
                $('#confirmAction').modal('hide');
                var rjson = $.parseJSON(res);
                console.log(rjson);
                $('#ajaxResponse .modal-body p').text(rjson.msg);
                $('#ajaxResponse').modal('show');
                if (rjson.err == 0) {
                    $('#ajaxResponse .modal-body p').addClass('text-blue');
                    $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                }
                else {
                    $('#ajaxResponse .modal-body p').addClass('text-red');
                    $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                }
            },
            error: function (req, status, res) {
                var rjson = $.parseJSON(res);
                console.log(rjson);
            }
        });
    });

    $('.btn-del-category-confirm').click(function (e) {
        e.preventDefault();
        var categoryUID = $(this).attr("id");
        $('.btn-del-category').attr('id', categoryUID);
        $('#confirmAction').modal('show');
    });

    //Delete Event

    $('.btn-del-event').click(function (e) {
        e.preventDefault();
        $(this).attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
        var eventUID = $(this).attr("id");
        $.ajax({
            type: "POST",
            url: $(this).attr("href"),
            data: {
                eventUID: eventUID
            },
            cache: false,
            success: function (res) {
                $('#confirmAction').modal('hide');
                var rjson = $.parseJSON(res);
                console.log(rjson);
                $('#ajaxResponse .modal-body p').text(rjson.msg);
                if (rjson.err == 0) {
                    $('#ajaxResponse .modal-body p').addClass('text-blue');
                    $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                }
                else {
                    $('#ajaxResponse .modal-body p').addClass('text-red');
                    $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                }
                $('#ajaxResponse').modal('show');
            },
            error: function (req, status, res) {
                var rjson = $.parseJSON(res);
                console.log(rjson);
            }
        });
    });

    $('.btn-del-event-confirm').click(function (e) {
        e.preventDefault();
        var eventUID = $(this).attr("id");
        $('.btn-del-event').attr('id', eventUID);
        $('#confirmAction').modal('show');
    });

    //Delete Event Game

    $('.btn-del-event-game').click(function (e) {
        e.preventDefault();
        $(this).attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
        var eventGameUID = $(this).attr("id");
        $.ajax({
            type: "POST",
            url: $(this).attr("href"),
            data: {
                eventGameUID: eventGameUID
            },
            cache: false,
            success: function (res) {
                $('#confirmAction').modal('hide');
                var rjson = $.parseJSON(res);
                console.log(rjson);
                $('#ajaxResponse .modal-body p').text(rjson.msg);
                if (rjson.err == 0) {
                    $('#ajaxResponse .modal-body p').addClass('text-blue');
                    $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                }
                else {
                    $('#ajaxResponse .modal-body p').addClass('text-red');
                    $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                }
                $('#ajaxResponse').modal('show');
            },
            error: function (req, status, res) {
                var rjson = $.parseJSON(res);
                console.log(rjson);
            }
        });
    });

    $('.btn-del-event-game-confirm').click(function (e) {
        e.preventDefault();
        var eventGameUID = $(this).attr("id");
        console.log(eventGameUID);
        $('.btn-del-event-game').attr('id', eventGameUID);
        $('#confirmAction').modal('show');
    });

    //Delete Game

    $('.btn-del-game').click(function (e) {
        e.preventDefault();
        $(this).attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
        var gameUID = $(this).attr("id");
        $.ajax({
            type: "POST",
            url: $(this).attr("href"),
            data: {
                gameUID: gameUID
            },
            cache: false,
            success: function (res) {
                $('#confirmAction').modal('hide');
                var rjson = $.parseJSON(res);
                console.log(rjson);
                $('#ajaxResponse .modal-body p').text(rjson.msg);
                if (rjson.err == 0) {
                    $('#ajaxResponse .modal-body p').addClass('text-blue');
                    $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                }
                else {
                    $('#ajaxResponse .modal-body p').addClass('text-red');
                    $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                }
                $('#ajaxResponse').modal('show');
            },
            error: function (req, status, res) {
                var rjson = $.parseJSON(res);
                console.log(rjson);
            }
        });
    });

    $('.btn-del-game-confirm').click(function (e) {
        e.preventDefault();
        var gameUID = $(this).attr("id");
        console.log(gameUID);
        $('.btn-del-game').attr('id', gameUID);
        $('#confirmAction').modal('show');
    });

    /*---------------------------------------------------------------------------------------------------------------*/


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
            if ($(form).valid()) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#adminRegisterSubmit').attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
                        $('.spinner-border').show();
                    },
                    success: function (res) {
                        console.log(res);
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.msg);
                        if (rjson.err == 0) {
                            $('#ajaxResponse .modal-body p').addClass('text-blue');
                            $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                        }
                        else {
                            $('#ajaxResponse .modal-body p').addClass('text-red');
                            $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        }
                        $('#ajaxResponse').modal('show');
                    },
                    error: function (res) {
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.responseText);
                        $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        $('#ajaxResponse').modal('show');
                    },
                    complete: function () {
                        $('#adminRegisterSubmit').attr('disabled', false).removeClass('disabled').attr('value', 'Register');
                        $('.spinner-border').hide();
                    }
                });
            }
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
            $.ajax({
                url: form.action,
                type: form.method,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $('#adminLoginSubmit').attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
                    $('.spinner-border').show();
                },
                success: function (res) {
                    console.log(res);
                    $(form)[0].reset();
                    var rjson = $.parseJSON(res);
                    if (rjson.err == 0) {
                        $('#ajaxResponse .modal-body p').addClass('text-blue');
                        $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                        window.location.href = rjson.redir;
                    }
                    else {
                        $('#ajaxResponse .modal-body p').addClass('text-red');
                        $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        $('#ajaxResponse .modal-body p').text(rjson.msg);
                        $('#ajaxResponse').modal('show');
                    }
                },
                error: function (req, status, res) {
                    var rjson = $.parseJSON(res);
                    $('#ajaxResponse .modal-body p').addClass('text-red');
                    $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                    $('#ajaxResponse .modal-body p').text(rjson);
                    $('#ajaxResponse').modal('show');
                },
                complete: function () {
                    $('#adminLoginSubmit').attr('disabled', false).removeClass('disabled').attr('value', 'Login');
                    $('.spinner-border').hide();
                }
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
            if ($(form).valid()) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#adminProfileEditSubmit').attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
                        $('.spinner-border').show();
                    },
                    success: function (res) {
                        console.log(res);
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.msg);
                        if (rjson.err == 0) {
                            $('#ajaxResponse .modal-body p').addClass('text-blue');
                            $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                        }
                        else {
                            $('#ajaxResponse .modal-body p').addClass('text-red');
                            $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        }
                        $('#ajaxResponse').modal('show');
                    },
                    error: function (res) {
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.responseText);
                        $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        $('#ajaxResponse').modal('show');
                    },
                    complete: function () {
                        $('#adminProfileEditSubmit').attr('disabled', false).removeClass('disabled').attr('value', 'Register');
                        $('.spinner-border').hide();
                    }
                });
            }
            return false;
        }
    });


    //Administrator Settings Form

    $("#adminSettingsEditForm").validate({
        rules: {
            adminEmail: {
                required: true,
                email: true,
                rangelength: [8, 128]
            },
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
            },
            adminTermsCheck: {
                required: true
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "adminTermsCheck") {
                error.appendTo("#adminTermsCheckError");
            }
            else if (element.attr("name") == "adminDepartment") {
                error.appendTo("#adminDepartmentError");
            }
            else if (element.attr("name") == "adminDesignation") {
                error.appendTo("#adminDesignationError");
            }
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            if ($(form).valid()) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#adminSettingsEditSubmit').attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
                        $('.spinner-border').show();
                    },
                    success: function (res) {
                        console.log(res);
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.msg);
                        if (rjson.err == 0) {
                            window.location.href = rjson.redir;
                        }
                        else {
                            $('#ajaxResponse .modal-body p').addClass('text-red');
                            $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        }
                        $('#ajaxResponse').modal('show');
                    },
                    error: function (res) {
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.responseText);
                        $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        $('#ajaxResponse').modal('show');
                    },
                    complete: function () {
                        $('#adminSettingsEditSubmit').attr('disabled', false).removeClass('disabled').attr('value', 'Register');
                        $('.spinner-border').hide();
                    }
                });
            }
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
            if ($(form).valid()) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#freeplayRegisterSubmit').attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
                        $('.spinner-border').show();
                    },
                    success: function (res) {
                        console.log(res);
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.msg);
                        if (rjson.err == 0) {
                            $('#ajaxResponse .modal-body p').addClass('text-blue');
                            $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                        }
                        else {
                            $('#ajaxResponse .modal-body p').addClass('text-red');
                            $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        }
                        $('#ajaxResponse').modal('show');
                    },
                    error: function (res) {
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.responseText);
                        $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        $('#ajaxResponse').modal('show');
                    },
                    complete: function () {
                        $('#freeplayRegisterSubmit').attr('disabled', false).removeClass('disabled').attr('value', 'Register');
                        $('.spinner-border').hide();
                    }
                });
            }
            return false;
        }
    });

    /*--------------------------------------------------------------------------------------------------------------------*/

    //Admin Adminstrator Edit Form

    $("#adminAdministratorEditForm").validate({
        rules: {
            adminStatus: {
                required: true
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "adminStatus") {
                error.appendTo("#adminStatusError");
            }
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            if ($(form).valid()) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#adminAdministratorEditSubmit').attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
                        $('.spinner-border').show();
                    },
                    success: function (res) {
                        console.log(res);
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.msg);
                        if (rjson.err == 0) {
                            $('#ajaxResponse .modal-body p').addClass('text-blue');
                            $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                        }
                        else {
                            $('#ajaxResponse .modal-body p').addClass('text-red');
                            $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        }
                        $('#ajaxResponse').modal('show');
                    },
                    error: function (res) {
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.responseText);
                        $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        $('#ajaxResponse').modal('show');
                    },
                    complete: function () {
                        $('#adminAdministratorEditSubmit').attr('disabled', false).removeClass('disabled').attr('value', 'Update');
                        $('.spinner-border').hide();
                    }
                });
            }
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
            if ($(form).valid()) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#eventGameAddSubmit').attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
                        $('.spinner-border').show();
                    },
                    success: function (res) {
                        console.log(res);
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.msg);
                        if (rjson.err == 0) {
                            $('#ajaxResponse .modal-body p').addClass('text-blue');
                            $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                        }
                        else {
                            $('#ajaxResponse .modal-body p').addClass('text-red');
                            $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        }
                        $('#ajaxResponse').modal('show');
                    },
                    error: function (res) {
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.responseText);
                        $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        $('#ajaxResponse').modal('show');
                    },
                    complete: function () {
                        $('#eventGameAddSubmit').attr('disabled', false).removeClass('disabled').attr('value', 'Add to Cart');
                        $('.spinner-border').hide();
                    }
                });
            }
            return false;
        }
    });

    //Event Game Sign Up Add Form

    $('.eventGameSignUpAddSubmit').click(function (e) {
        e.preventDefault();
        $(this).attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
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
            cache: false,
            success: function (res) {
                var rjson = $.parseJSON(res);
                console.log(rjson);
                $('#ajaxResponse .modal-body p').text(rjson.msg);
                if (rjson.err == 0) {
                    $('#ajaxResponse .modal-body p').addClass('text-blue');
                    $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                }
                else {
                    $('#ajaxResponse .modal-body p').addClass('text-red');
                    $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                }
                $('#ajaxResponse').modal('show');
            },
            error: function (req, status, res) {
                var rjson = $.parseJSON(res);
                console.log(rjson);
            }
        });
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

    //Event Participant Info Form

    $("#eventParticipantInfoForm").validate({
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
            if ($(form).valid()) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#eventParticipantInfoSubmit').attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
                        $('.spinner-border').show();
                    },
                    success: function (res) {
                        console.log(res);
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.msg);
                        if (rjson.err == 0) {
                            $('#ajaxResponse .modal-body p').addClass('text-blue');
                            $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                            window.location.href = rjson.redir;
                        }
                        else {
                            $('#ajaxResponse .modal-body p').addClass('text-red');
                            $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        }
                        $('#ajaxResponse').modal('show');
                    },
                    error: function (res) {
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.responseText);
                        $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        $('#ajaxResponse').modal('show');
                    },
                    complete: function () {
                        $('#eventParticipantInfoSubmit').attr('disabled', false).removeClass('disabled').attr('value', 'Proceed');
                        $('.spinner-border').hide();
                    }
                });
            }
            return false;
        }
    });


    /*--------------------------------------------------------------------------------------------------------------------*/
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
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            if ($(form).valid()) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#eventCheckoutSubmit').attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
                        $('.spinner-border').show();
                    },
                    success: function (res) {
                        console.log(res);
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.msg);
                        if (rjson.err == 0) {
                            $('#ajaxResponse .modal-body p').addClass('text-blue');
                            $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                            window.location.href = rjson.redir;
                        }
                        else {
                            $('#ajaxResponse .modal-body p').addClass('text-red');
                            $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        }
                        $('#ajaxResponse').modal('show');
                    },
                    error: function (res) {
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.responseText);
                        $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        $('#ajaxResponse').modal('show');
                    },
                    complete: function () {
                        $('#eventCheckoutSubmit').attr('disabled', false).removeClass('disabled').attr('value', 'Checkout');
                        $('.spinner-border').hide();
                    }
                });
            }
            return false;
        }
    });

    /*--------------------------------------------------------------------------------------------------------------------*/
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
            if ($(form).valid()) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#eventSignUpCheckoutSubmit').attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
                        $('.spinner-border').show();
                    },
                    success: function (res) {
                        console.log(res);
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.msg);
                        if (rjson.err == 0) {
                            $('#ajaxResponse .modal-body p').addClass('text-blue');
                            $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                            window.location.href = rjson.redir;
                        }
                        else {
                            $('#ajaxResponse .modal-body p').addClass('text-red');
                            $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        }
                        $('#ajaxResponse').modal('show');
                    },
                    error: function (res) {
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.responseText);
                        $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        $('#ajaxResponse').modal('show');
                    },
                    complete: function () {
                        $('#eventSignUpCheckoutSubmit').attr('disabled', false).removeClass('disabled').attr('value', 'Checkout');
                        $('.spinner-border').hide();
                    }
                });
            }
            return false;
        }
    });


    /*--------------------------------------------------------------------------------------------------------------------*/
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
            if ($(form).valid()) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#eventBillingInfoSubmit').attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
                        $('.spinner-border').show();
                    },
                    success: function (res) {
                        console.log(res);
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.msg);
                        if (rjson.err == 0) {
                            $('#ajaxResponse .modal-body p').addClass('text-blue');
                            $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                            window.location.href = rjson.redir;
                        }
                        else {
                            $('#ajaxResponse .modal-body p').addClass('text-red');
                            $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        }
                        $('#ajaxResponse').modal('show');
                    },
                    error: function (res) {
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.responseText);
                        $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        $('#ajaxResponse').modal('show');
                    },
                    complete: function () {
                        $('#eventBillingInfoSubmit').attr('disabled', false).removeClass('disabled').attr('value', 'Proceed');
                        $('.spinner-border').hide();
                    }
                });
            }
            return false;
        }
    });


    //Event Check In Form

    $("#eventCheckinForm").validate({
        rules: {
            eventCheckinOrderID: {
                required: true
            }
        },
        submitHandler: function (form) {
            if ($(form).valid()) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#eventCheckinSubmit').attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
                        $('.spinner-border').show();
                    },
                    success: function (res) {
                        console.log(res);
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.msg);
                        if (rjson.err == 0) {
                            $('#ajaxResponse .modal-body p').addClass('text-blue');
                            $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                            $(form)[0].reset();
                        }
                        else {
                            $('#ajaxResponse .modal-body p').addClass('text-red');
                            $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        }
                        $('#ajaxResponse').modal('show');
                    },
                    error: function (res) {
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.responseText);
                        $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        $('#ajaxResponse').modal('show');
                    },
                    complete: function () {
                        $('#eventCheckinSubmit').attr('disabled', false).removeClass('disabled').attr('value', 'Checkin');
                        $('.spinner-border').hide();
                    }
                });
            }
            return false;
        }
    });


    //Delete Checklist Event

    $('.btn-del-event-list').click(function (e) {
        e.preventDefault();
        $(this).attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
        var eventRemoveUID = $(this).attr("id");
        $.ajax({
            type: "POST",
            url: $(this).attr("href"),
            data: {
                eventRemoveUID: eventRemoveUID
            },
            cache: false,
            success: function (res) {
                $('#confirmAction').modal('hide');
                var rjson = $.parseJSON(res);
                console.log(rjson);
                $('#ajaxResponse .modal-body p').text(rjson.msg);
                if (rjson.err == 0) {
                    $('#ajaxResponse .modal-body p').addClass('text-blue');
                    $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                }
                else {
                    $('#ajaxResponse .modal-body p').addClass('text-red');
                    $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                }
                $('#ajaxResponse').modal('show');
            },
            error: function (req, status, res) {
                var rjson = $.parseJSON(res);
                console.log(rjson);
            }
        });
    });

    $('.btn-del-event-list-confirm').click(function (e) {
        e.preventDefault();
        var eventRemoveUID = $(this).attr("id");
        $('.btn-del-event-list').attr('id', eventRemoveUID);
        $('#confirmAction').modal('show');
    });


    /*--------------------------------------------------------------------------------------------------------------------*/
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


    /*--------------------------------------------------------------------------------------------------------------------*/
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
            },
            aboutInfoTermsCheck: {
                required: true
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "aboutInfoTermsCheck") {
                error.appendTo("#aboutInfoTermsCheckError");
            }
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            if ($(form).valid()) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#adminAboutInfoSubmit').attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
                        $('.spinner-border').show();
                    },
                    success: function (res) {
                        console.log(res);
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.msg);
                        if (rjson.err == 0) {
                            $('#ajaxResponse .modal-body p').addClass('text-blue');
                            $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                            $(form)[0].reset();
                        }
                        else {
                            $('#ajaxResponse .modal-body p').addClass('text-red');
                            $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        }
                        $('#ajaxResponse').modal('show');
                    },
                    error: function (res) {
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.responseText);
                        $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        $('#ajaxResponse').modal('show');
                    },
                    complete: function () {
                        $('#adminAboutInfoSubmit').attr('disabled', false).removeClass('disabled').attr('value', 'Register');
                        $('.spinner-border').hide();
                    }
                });
            }
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
            },
            constantInfoTermsCheck: {
                required: true
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "constantInfoTermsCheck") {
                error.appendTo("#constantInfoTermsCheckError");
            }
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            if ($(form).valid()) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#adminConstantInfoSubmit').attr('disabled', true).addClass('disabled').attr('value', 'Processing...');
                        $('.spinner-border').show();
                    },
                    success: function (res) {
                        console.log(res);
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.msg);
                        if (rjson.err == 0) {
                            $('#ajaxResponse .modal-body p').addClass('text-blue');
                            $('#ajaxResponse .modal-body i').addClass('fa-check-circle text-blue');
                            $(form)[0].reset();
                        }
                        else {
                            $('#ajaxResponse .modal-body p').addClass('text-red');
                            $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        }
                        $('#ajaxResponse').modal('show');
                    },
                    error: function (res) {
                        var rjson = $.parseJSON(res);
                        $('#ajaxResponse .modal-body p').text(rjson.responseText);
                        $('#ajaxResponse .modal-body i').addClass('fa-times-circle text-red');
                        $('#ajaxResponse').modal('show');
                    },
                    complete: function () {
                        $('#adminConstantInfoSubmit').attr('disabled', false).removeClass('disabled').attr('value', 'Register');
                        $('.spinner-border').hide();
                    }
                });
            }
            return false;
        }
    });

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
/*--------------------------------------------------------------------------------------------------------------------*/
/*--------------------------------------------------------------------------------------------------------------------*/
/*--------------------------------------------------------------------------------------------------------------------*/

// Canvas JS

$(document).ready(function () {
    totalAmountByDateChart(totalAmountByDateChartData);
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
