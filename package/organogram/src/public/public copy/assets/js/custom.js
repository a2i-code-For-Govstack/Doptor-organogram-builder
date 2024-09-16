$(document).ready(function () {
    if ($('.select-select2').length > 0) {
        $('.select-select2').select2();
    }
});
$(document).ajaxComplete(function () {
    $('.select-select2').select2();
});

function pad(str, max) {
    str = str.toString();
    return str.length < max ? pad("0" + str, max) : str;
}

function getUsername(value) {
    var inputVal = value;
    var firstPart = inputVal.substr(0, 1);
    var username = pad(inputVal.substr(1, inputVal.length), 11);
    username = firstPart + username;
    return username;
}

$(document).on('blur', "input[name=username]", function () {
    if ($.isNumeric($(this).val())) {
        $(this).val(getUsername($(this).val()));
    }
})

///check password strength

function getPassword(elem) {
    var text = $(elem).val();

    var length = $('#pass_strength_length');
    var lowercase = $('#pass_strength_lowercase');
    var uppercase = $('#pass_strength_uppercase');
    var number = $('#pass_strength_number');
    var special = $('#pass_strength_special');
    var submitBtn = $('#submitBtnP');


    if (checkIfEightChar(text)) {
        length.removeClass('text-danger').addClass('text-success')
        length.find('i').removeClass('fa-times text-danger').addClass('fa-check text-success')
    } else {
        length.removeClass('text-success').addClass('text-danger');
        length.find('i').removeClass('fa-check text-success').addClass('fa-times text-danger')
    }
    if (checkIfOneLowercase(text)) {
        lowercase.removeClass('text-danger').addClass('text-success')
        lowercase.find('i').removeClass('fa-times text-danger').addClass('fa-check text-success')
    } else {
        lowercase.removeClass('text-success').addClass('text-danger');
        lowercase.find('i').removeClass('fa-check text-success').addClass('fa-times text-danger')
    }
    if (checkIfOneUppercase(text)) {
        uppercase.removeClass('text-danger').addClass('text-success')
        uppercase.find('i').removeClass('fa-times text-danger').addClass('fa-check text-success')
    } else {
        uppercase.removeClass('text-success').addClass('text-danger');
        uppercase.find('i').removeClass('fa-check text-success').addClass('fa-times text-danger')
    }
    if (checkIfOneDigit(text)) {
        number.removeClass('text-danger').addClass('text-success')
        number.find('i').removeClass('fa-times text-danger').addClass('fa-check text-success')
    } else {
        number.removeClass('text-success').addClass('text-danger');
        number.find('i').removeClass('fa-check text-success').addClass('fa-times text-danger')
    }
    if (checkIfOneSpecialChar(text)) {
        special.removeClass('text-danger').addClass('text-success')
        special.find('i').removeClass('fa-times text-danger').addClass('fa-check text-success')
    } else {
        special.removeClass('text-success').addClass('text-danger');
        special.find('i').removeClass('fa-check text-success').addClass('fa-times text-danger')
    }

    let regx = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*\.]{8,}$/;
    if (text.match(regx)) {
        submitBtn.prop('disabled', false);
    } else {
        submitBtn.prop('disabled', true);
    }
}

function checkIfEightChar(text) {
    return text.length >= 8;
}

function checkIfOneLowercase(text) {
    return /[a-z]/.test(text);
}

function checkIfOneUppercase(text) {
    return /[A-Z]/.test(text);
}

function checkIfOneDigit(text) {
    return /[0-9]/.test(text);
}

function checkIfOneSpecialChar(text) {
    return /[~`!#@$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/g.test(text);
}

function togglePassword(elem) {
    var passInput = $(elem).prev('input');
    var togglePW = $(elem).find('i');

    passInput.attr('type') === "password" ? passInput.attr('type', "text") : passInput.attr('type', "password");
    togglePW.hasClass('fa-eye') === true ? togglePW.removeClass('fa-eye').addClass('fa-eye-slash') : togglePW.removeClass('fa-eye-slash').addClass('fa-eye');
}

///end check password strength


function makeAreaResizable(element) {
    var resizeOpts = {
        handles: 'e, w'
    };

    $(`${element}`).css("overflow-x", 'hidden');
    $(`${element}`).resizable(resizeOpts);
    $(`${element}`).removeClass('ui-resizable');
    $(`${element}`).resize(function () {
        $(`${element}`).css("left", 'auto');
        $(`${element}`).css("overflow-x", 'hidden');
        $(`${element}`).css("min-width", '500px !important');
    });
}

function jsTreeExpandNode(jstreeElement, nodeID) {
    // Expand all nodes up to the root (the id of the root returns as '#')
    while (nodeID != '#') {
        // Open this node
        $(jstreeElement).jstree("open_node", nodeID)
        // Get the jstree object for this node
        var thisNode = $(jstreeElement).jstree("get_node", nodeID);
        // Get the id of the parent of this node
        if (thisNode) {
            nodeID = $(jstreeElement).jstree("get_parent", thisNode);
        } else {
            nodeID = "#";
        }
    }
}

function clearAlertNotification() {
    ajaxCallAsyncCallback("clear-alert-notification", {}, 'json', 'post', function (response) {
        if (response.status == 'success') {
            $(".alert_notification_area").html('');
        }
    });
}
