"use strict";

var KTTreeview = function () {

    var demo1 = function () {
        $('#kt_tree_1').jstree({
            "core" : {
                "themes" : {
                    "responsive": false
                }
            },
            "types" : {
                "default" : {
                    "icon" : "fas fa-map-marker-alt"
                },
                "file" : {
                    "icon" : "fas fa-map-marker-alt"
                }
            },
            "plugins": ["types"]
        });
    }

    var demo2 = function () {
        $('#kt_tree_2').jstree({
            "core" : {
                "themes" : {
                    "responsive": false
                }
            },
            "types" : {
                "default" : {
                    "icon" : "fas fa-map-marker-alt"
                },
                "file" : {
                    "icon" : "fas fa-map-marker-alt"
                }
            },
            "plugins": ["types"]
        });

        // handle link clicks in tree nodes(support target="_blank" as well)
        $('#kt_tree_2').on('select_node.jstree', function(e,data) {
            // $("#kt_quick_panel").addClass('kt-quick-panel--on');
            // $("#kt_quick_panel").css('opacity', 1);
            // $("html").addClass("side-panel-overlay");
            var link = $('#' + data.selected).find('a');
            if (link.attr("href") != "#" && link.attr("href") != "javascript:;" && link.attr("href") != "") {
                if (link.attr("target") == "_blank") {
                    link.attr("href").target = "_blank";
                }
                document.location.href = link.attr("href");
                return false;
            }
        });
    }

    var demo3 = function () {
        $('#kt_tree_3').jstree({
            'plugins': ["wholerow", "checkbox", "types"],
            'core': {
                "themes" : {
                    "responsive": false
                },
                'data': [{
                        "text": "",
                        "children": [{
                            "text": "মন্ত্রণালয়ের কার্যালয়",
                            "icon": "fas fa-building",
                            "state": {
                                "selected": true
                            }
                        }, {
                            "text": "সরকারি যানবাহন অধিদপ্তর",
                            "icon": "fas fa-building"
                        }, {
                            "text": "বিভাগীয় কমিশনারের কার্যালয়",
                            "icon" : "fas fa-building kt-font-default",
                            "state": {
                                "opened": true
                            },
                        }]
                    },
                ]
            },
            "types" : {
                "default" : {
                    "icon" : "fas fa-building"
                },
                "file" : {
                    "icon" : "fas fa-building"
                }
            },
        });
        $('#kt_tree_3').on('select_node.jstree', function(e,data) {
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        });
    }

    var demo4 = function() {
        $("#kt_tree_4").jstree({
            "core" : {
                "themes" : {
                    "responsive": false
                },
                // so that create works
                "check_callback" : true,
                'data': [{
                        "text": "Parent Node",
                        "children": [{
                            "text": "Initially selected",
                            "state": {
                                "selected": true
                            }
                        }, {
                            "text": "Custom Icon",
                            "icon": "fa fa-warning kt-font-danger"
                        }, {
                            "text": "Initially open",
                            "icon" : "fa fa-folder kt-font-success",
                            "state": {
                                "opened": true
                            },
                            "children": [
                                {"text": "Another node", "icon" : "fa fa-file kt-font-waring"}
                            ]
                        }, {
                            "text": "Another Custom Icon",
                            "icon": "fa fa-warning kt-font-waring"
                        }, {
                            "text": "Disabled Node",
                            "icon": "fa fa-check kt-font-success",
                            "state": {
                                "disabled": true
                            }
                        }, {
                            "text": "Sub Nodes",
                            "icon": "fa fa-folder kt-font-danger",
                            "children": [
                                {"text": "Item 1", "icon" : "fa fa-file kt-font-waring"},
                                {"text": "Item 2", "icon" : "fa fa-file kt-font-success"},
                                {"text": "Item 3", "icon" : "fa fa-file kt-font-default"},
                                {"text": "Item 4", "icon" : "fa fa-file kt-font-danger"},
                                {"text": "Item 5", "icon" : "fa fa-file kt-font-info"}
                            ]
                        }]
                    },
                    "Another Node"
                ]
            },
            "types" : {
                "default" : {
                    "icon" : "fa fa-folder kt-font-brand"
                },
                "file" : {
                    "icon" : "fa fa-file  kt-font-brand"
                }
            },
            "state" : { "key" : "demo2" },
            "plugins" : [ "contextmenu", "state", "types" ]
        });
    }

    var demo5 = function() {
        $("#kt_tree_5").jstree({
            "core" : {
                "themes" : {
                    "responsive": false
                },
                // so that create works
                "check_callback" : true,
                'data': [{
                        "text": "স্তর ১",
                        "children": [{
                            "text": "স্তর ২",
                            "state": {
                                "opened": true
                            },
                            "children": [
                                {
                                    "text": "স্তর ৩",
                                    "icon" : "fas fa-building",
                                    "children": [
                                        {
                                            "text": "স্তর ৪",
                                            "icon" : "fas fa-building",
                                            "children": [
                                                {
                                                    "text": "স্তর ৫",
                                                    "icon" : "fas fa-building"
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ]
                        }]
                    }
                ]
            },
            "types" : {
                "default" : {
                    "icon" : "fas fa-building"
                },
                "file" : {
                    "icon" : "fas fa-building"
                }
            },
            "state" : { "key" : "demo2" },
            "plugins" : [ "dnd", "state", "types" ]
        });
    }

    var demo6 = function() {
        $("#kt_tree_6").jstree({
            "core" : {
                "themes" : {
                    "responsive": false
                },
                // so that create works
                "check_callback" : true,
                'data' : {
                    'url' : function (node) {
                      return 'https://keenthemes.com/metronic/tools/preview/api/jstree/ajax_data.php';
                    },
                    'data' : function (node) {
                      return { 'parent' : node.id };
                    }
                }
            },
            "types" : {
                "default" : {
                    "icon" : "fa fa-folder kt-font-brand"
                },
                "file" : {
                    "icon" : "fa fa-file  kt-font-brand"
                }
            },
            "state" : { "key" : "demo3" },
            "plugins" : [ "dnd", "state", "types" ]
        });
    }

    var demo10 = function() {
        $("#kt_tree_10").jstree({
            "core" : {
                "themes" : {
                    "responsive": false
                },
                // so that create works
                "check_callback" : true,
                'data': [{
                        "text": "স্তর ১",
                        "children": [{
                            "text": "স্তর ২",
                            "state": {
                                "opened": true
                            },
                            "children": [
                                {
                                    "text": "স্তর ৩",
                                    "icon" : "fas fa-building",
                                    "children": [
                                        {
                                            "text": "স্তর ৪",
                                            "icon" : "fas fa-building",
                                            "children": [
                                                {
                                                    "text": "স্তর ৫",
                                                    "icon" : "fas fa-building"
                                                },
                                                {"text": "নতুন যোগ করুন", "icon" : "fas fa-plus-circle", "class": "newSakha"}
                                            ]
                                        }
                                    ]
                                }
                            ]
                        }]
                    },

                ]
            },
            "types" : {
                "default" : {
                    "icon" : "fas fa-building"
                },
                "file" : {
                    "icon" : "fas fa-building"
                }
            },
            "state" : { "key" : "demo2" },
            "plugins" : [ "dnd", "state", "types" ]
        });
        $('#kt_tree_10').on('select_node.jstree', function(e,data) {
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        });
    }

    var demo7 = function () {
        $('#kt_tree_7').jstree({
            'plugins': ["wholerow", "checkbox", "types"],
            'core': {
                "themes" : {
                    "responsive": false
                },
                'data': [{
                        "text": "",
                        "children": [{
                            "text": "জনপ্রশাসন মন্ত্রণালয়",
                            "icon": "fas fa-building",
                            "state": {
                                "selected": true
                            }
                        }]
                    },
                ]
            },
            "types" : {
                "default" : {
                    "icon" : "fas fa-building"
                },
                "file" : {
                    "icon" : "fas fa-building"
                }
            },
        });
        $('#kt_tree_7').on('select_node.jstree', function(e,data) {
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        });
    }

    var demo20 = function () {
        $('#kt_tree_20').jstree({
            "core" : {
                "themes" : {
                    "responsive": false
                }
            },
            "types" : {
                "default" : {
                    "icon" : "fas fa-map-marker-alt"
                },
                "file" : {
                    "icon" : "fas fa-map-marker-alt"
                }
            },
            "plugins": ["types"]
        });

    }

    var demo21 = function () {
        $.each($('.kt_tree_21'),function (){
            $(this).jstree({
                "core" : {
                    "themes" : {
                        "responsive": false
                    }
                },
                "types" : {
                    "default" : {
                        "icon" : "fas fa-map-marker-alt"
                    },
                    "file" : {
                        "icon" : "fas fa-map-marker-alt"
                    }
                },
                'search': {
                    'case_insensitive': true,
                    'show_only_matches' : true
                },
                "plugins": ["types",'search']
            }).on('search.jstree', function (nodes, str, res) {
                if (str.nodes.length===0) {
                    $(this).jstree(true).hide_all();
                }
            })
        });
        $('.tree_search21').keyup(function(){
                $('.kt_tree_21').jstree(true).show_all();
                $('.kt_tree_21').jstree('search', $(this).val());
        });
    }
    var demo22 = function () {
        $.each($('.kt_tree_22'),function (){
            $(this).jstree({
                "core" : {
                    "themes" : {
                        "responsive": false
                    }
                },
                "types" : {
                    "default" : {
                        "icon" : "fa fa-home"
                    },
                    "file" : {
                        "icon" : "fas fa-map-marker-alt"
                    }
                },
                "plugins": ["types","checkbox"]
            });
        });
    }

    var demo23 = function () {
        $.each($('.kt_tree_23'),function (){
            $(this).jstree({
                "core" : {
                    "themes" : {
                        "responsive": false
                    }
                },
                "types" : {
                    "default" : {
                        "icon" : "fa fa-home"
                    },
                    "file" : {
                        "icon" : "fas fa-map-marker-alt"
                    }
                },
                'search': {
                    'case_insensitive': true,
                    'show_only_matches' : true
                },
                "plugins": ["types",'search']
            }).on('search.jstree', function (nodes, str, res) {
                if (str.nodes.length===0) {
                    $(this).jstree(true).hide_all();
                }
            })
        });
        $('.tree_search').keyup(function(){
                $('.kt_tree_23').jstree(true).show_all();
                $('.kt_tree_23').jstree('search', $(this).val());
        });
    }

    var demo24 = function () {
        $.each($('.kt_tree_24'),function (){
            $(this).jstree({
                "core" : {
                    "themes" : {
                        "responsive": false
                    }
                },
                "types" : {
                    "default" : {
                        "icon" : "fa fa-home"
                    },
                    "file" : {
                        "icon" : "fas fa-map-marker-alt"
                    }
                },
                'search': {
                    'case_insensitive': true,
                    'show_only_matches' : true
                },
                "plugins": ["types",'search']
            }).on('search.jstree', function (nodes, str, res) {
                if (str.nodes.length===0) {
                    $(this).jstree(true).hide_all();
                }
            })
        });
        $('.tree_search21').keyup(function(){
            $('.kt_tree_21').jstree(true).show_all();
            $('.kt_tree_21').jstree('search', $(this).val());
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            demo1();
            demo2();
            demo3();
            demo4();
            demo5();
            demo6();
            demo10();
            demo7();
            demo20();
            demo21();
            demo22();
            demo23();
            demo24();
        }
    };
}();

jQuery(document).ready(function() {
    KTTreeview.init();
});
