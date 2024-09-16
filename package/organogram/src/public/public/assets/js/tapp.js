$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function ajaxCallAsyncCallback(url, data, datatype, method, callback) {
    // KTApp.block('#kt_content');
    blockUi('#kt_content');
    // toastr.warning('অপেক্ষা করুন...', {"positionClass": "toast-top-center",});
    $.ajax({
        async: true, type: method, url: url, dataType: datatype, data: data, cache: false,

        success: function (data, textStatus) {
            callback(data);
            KTApp.unblock('#kt_content')
        }, error: function (data) {
            $('.save_btn').prop('disabled', false);
            var errors = data.responseJSON;
            $.each(errors.errors, function (k, v) {
                if (v !== '') {
                    toastr.error(v);
                }

            });
            KTApp.unblock('#kt_content')
        },

    });
}

function ajaxCallUnsyncCallback(url, data, datatype, method, callback) {
    $.ajax({
        async: false, type: method, url: url, dataType: datatype, data: data, cache: false, error: function (data) {
            var errors = data.responseJSON;
            $.each(errors.errors, function (k, v) {
                if (v !== '') {
                    toastr.error(v);
                }
            });
        }, success: function (data, textStatus) {
            callback(data);
        }
    });
}

function ajaxCallUnsyncCallbackBothDataType(url, data, method, callback) {
    $.ajax({
        async: false, type: method, url: url, data: data, cache: false, error: function (data) {
            var errors = data.responseJSON;
            $.each(errors.errors, function (k, v) {
                if (v !== '') {
                    toastr.error(v);
                }
            });
        }, success: function (data, textStatus) {
            callback(data);
        }
    });
}

function clearForm(form_id) {
    $(form_id).find('input:text, input:password, input:file, select, textarea').val('');
    $(form_id).find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
}


function isUnicode(string) {
    for (var i = 0; i < string.length; i++) {
        if (string.charCodeAt(i) > 127) return true;
    }
    return false;
}

function convertBanglaToEnglishNumber(str) {
    let banglaNumber = {
        '০': 0, '১': 1, '২': 2, '৩': 3, '৪': 4, '৫': 5, '৬': 6, '৭': 7, '৮': 8, '৯': 9
    }
    for (var x in banglaNumber) {
        str = str.replace(new RegExp(x, 'g'), banglaNumber[x]);
    }
    return str;
}

function isEmpty(value) {
    if (typeof (value) == 'undefined' || value == '' || value == null || value == 0) {
        return true;
    }
    return false;
}

function enTobn(input) {
    return BnFromEng(input);
}

function bnToen(input) {
    return EngFromBn(input);
}

function BntoEng(input) {
    return EngFromBn(input);
}

function BnFromEng(input) {
    var numbers = {
        0: '০', 1: '১', 2: '২', 3: '৩', 4: '৪', 5: '৫', 6: '৬', 7: '৭', 8: '৮', 9: '৯'
    };
    var output = '';

    if (typeof (input) == 'number') {
        input = input.toString();
    }
    if (isEmpty(input.length)) {
        return input;
    }
    for (var i = 0; i < input.length; ++i) {
        if (numbers.hasOwnProperty(input[i])) {
            output += numbers[input[i]];
        } else {
            output += input[i];
        }
    }
    return output;
}

function EngFromBn(input) {
    var numbers = {
        '০': 0,
        '১': 1,
        '২': 2,
        '৩': 3,
        '৪': 4,
        '৫': 5,
        '৬': 6,
        '৭': 7,
        '৮': 8,
        '৯': 9,
        '0': 0,
        '1': 1,
        '2': 2,
        '3': 3,
        '4': 4,
        '5': 5,
        '6': 6,
        '7': 7,
        '8': 8,
        '9': 9
    };
    var output = '';

    if (typeof (input) == 'number') {
        input = input.toString();
    }
    if (isEmpty(input)) {
        return input;
    }
    for (var i = 0; i < input.length; ++i) {
        if (numbers.hasOwnProperty(input[i])) {
            output += numbers[input[i]];
        } else {
            output += input[i];
        }
    }
    return output;
}

$('.bangla').bangla({ enable: true });

$('.english').on('blur', function () {
    var english = $(this).val();
    if (isUnicode(english) == true) {
        $(this).val('');
        toastr.warning('অনুগ্রহ করে ইংরেজি শব্দ ব্যবহার করুন |');
        return false
    }
});

$('.mobile_no_input_box').keyup(function () {
    this.value = this.value.replace(/[^০-৯0-9+]/gi, '');
})

function blockUi(elem = '#kt_wrapper', message = 'অপেক্ষা করুন ...') {
    KTApp.block(elem, {
        overlayColor: '#9b9999bf', type: 'v2', state: 'primary', message: message
    });
}

function unblockUi(elem = '#kt_wrapper') {
    KTApp.unblock(elem);
}

function str_pad(str, max) {
    return str.length < max ? str_pad("0" + str, max) : str;
}

function generate_full_name(prefix_elem, name_elem, surname_elem, full_name_elem) {
    prefix_name = $(prefix_elem).val() ? $(prefix_elem).val() + ' ' : '';
    prfile_name = $(name_elem).val();
    surname = $(surname_elem).val() ? ', ' + $(surname_elem).val() : '';
    full_name = prefix_name + prfile_name + surname;
    $(full_name_elem).text(full_name)
}

function dateEnToBn(createdDate) {
    currentDate = moment(createdDate).format('DD-MM-YYYY, hh:mm:ss A');
    if (currentDate.search("AM") == 21) {
        engDate = 'AM';
        bngDate = 'পূর্বাহ্ণ';
        convertDate = currentDate.replace(engDate, bngDate);
    }
    if (currentDate.search("PM") == 21) {
        engDate = 'PM';
        bngDate = 'অপরাহ্ন';
        convertDate = currentDate.replace(engDate, bngDate);
    }
    return enTobn(convertDate);
}


function jsTreeDisableNode(tree, node_id) {
    node = $(tree).jstree().get_node(node_id);
    $(tree).jstree().disable_node(node);
    node.children.forEach(function (child_id) {
        jsTreeDisableNode(child_id);
    })
}

function jsTreeEnableNode(tree, node_id) {
    node = $(tree).jstree().get_node(node_id);
    $(tree).jstree().enable_node(node);
    node.children.forEach(function (child_id) {
        jsTreeEnableNode(child_id);
    })
}

function removeFromSerializeArray(data, names) {
    $.each(names, function (index, name) {
        data = $.grep(data, function (e) {
            return e.name != name;
        });
    });
    return data;
}

function Server_Async(url, data, method) {
    return $.ajax({
        type: method,
        url: url,
        data: data
    });
}
