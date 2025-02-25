<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php $module_info = false;
    if (isset($params['module'])): ?>
        <?php $module_info = mw()->modules->get('one=1&ui=any&module=' . $params['module']); ?>
    <?php endif; ?>

    <script type="text/javascript" src="<?php print(mw()->template->get_apijs_settings_url()); ?>"></script>
    <script type="text/javascript" src="<?php print(mw()->template->get_apijs_url()); ?>"></script>
    <script src="<?php print mw_includes_url(); ?>api/jquery-ui.js"></script>

    <?php template_stack_display('default'); ?>





    <?php






    template_stack_add(mw_includes_url().'default.css');
    template_stack_add(mw_includes_url().'css/components.css');
    template_stack_add(mw_includes_url().'css/admin.css');
    template_stack_add(mw_includes_url().'css/admin-new.css');
    template_stack_add(mw_includes_url().'css/fade-window.css');
    template_stack_add(mw_includes_url().'css/popup.css');



    template_stack_add(mw_includes_url().'api/instruments.js');
    template_stack_add(mw_includes_url().'api/events.js');
    template_stack_add(mw_includes_url().'api/url.js');
    template_stack_add(mw_includes_url().'api/tools.js');
    template_stack_add(mw_includes_url().'api/admin.js');
    template_stack_add(mw_includes_url().'api/dialog.js');
    template_stack_add(mw_includes_url().'api/liveadmin.js');
    template_stack_add(mw_includes_url().'api/wysiwyg.js');
    template_stack_add(mw_includes_url().'css/wysiwyg.css');
    template_stack_add(mw_includes_url().'api/options.js');

    ?>



    <?php if (isset($params['live_edit_sidebar'])): ?>

        <script type="text/javascript">
            window.live_edit_sidebar = true;
        </script>
    <?php endif; ?>


    <script type="text/javascript">
        liveEditSettings = true;
/*
        mw.require('<?php print mw_includes_url(); ?>default.css');
        mw.require('<?php print mw_includes_url(); ?>css/components.css');
        mw.require('<?php print mw_includes_url(); ?>css/admin.css');
        mw.require('<?php print mw_includes_url(); ?>css/admin-new.css');
        mw.require('<?php print mw_includes_url(); ?>css/fade-window.css');
        mw.require('<?php print mw_includes_url(); ?>css/popup.css');




        mw.require("events.js");
        mw.require("url.js");
        mw.require("tools.js");
        mw.require('admin.js');
        mw.require('dialog.js');


        mw.require("liveadmin.js");
        mw.require("forms.js");
        mw.require('wysiwyg.js');
        mw.require("wysiwyg.css")
        mw.require('options.js');    */

        <?php if(_lang_is_rtl()){ ?>
        mw.require('<?php print mw_includes_url(); ?>css/rtl.css');
        <?php } ?>

        mw.lib.require('font_awesome5');
    </script>




    <style>
        #settings-main {
            min-height: 200px;
            overflow-x: hidden;
        }

        #settings-container {
            overflow: hidden;
            position: relative;
            min-height: 200px;
        }

        #settings-container:after {
            content: ".";
            display: block;
            clear: both;
            visibility: hidden;
            line-height: 0;
            height: 0;
        }
    </style>

    <?php
    $autoSize = true;
    if (isset($_GET['autosize'])) {
        $autoSize = $_GET['autosize'];
    }

    $type = '';
    if (isset($_GET['type'])) {
        $type = $_GET['type'];
    }

    $mod_id = $mod_orig_id = false;
    $is_linked_mod = false;

    if (isset($params['id'])) {
        $mod_orig_id = $mod_id = $params['id'];
    }

    if (isset($params['data-module-original-id']) and $params['data-module-original-id']) {
        $mod_orig_id = $params['data-module-original-id'];
    }
    if ($mod_id != $mod_orig_id) {
        $is_linked_mod = true;
    }
    ?>

    <script type="text/javascript">
        addIcon = function () {
            if (window.thismodal && thismodal.main) {
                var holder = $(".mw_modal_toolbar", thismodal.main);
                if ($('.mw_modal_icon', holder).length === 0) {
                    holder.prepend('<span class="mw_modal_icon"><img src="<?php print $module_info['icon']; ?>"></span>')
                }
            }
        };
        addIcon();

        autoSize = <?php  print $autoSize; ?>;
        settingsType = '<?php print $type; ?>';

        window.onbeforeunload = function () {
            $(mwd.body).addClass("mw-external-loading")
            window.parent.$('.module-modal-settings-menu-holder').remove();
        };

        mw_module_settings_info = "";
        <?php if(is_array($module_info)): ?>

        mw_module_settings_info = <?php print json_encode($module_info); ?>
        <?php
            $mpar = $params;
            if (isset($mpar['module_settings'])) {
                unset($mpar['module_settings']);
            }
            ?>

            mw_module_params =
        <?php print json_encode($mpar); ?>

        <?php endif; ?>

        if (typeof thismodal === 'undefined' && self !== parent && typeof this.name != 'undefined' && this.name != '') {
            var frame = parent.mw.$('#' + this.name)[0];
            thismodal = parent.mw.tools.modal.get(mw.tools.firstParentWithClass(frame, 'mw_modal'));
        }





        //var the_module_settings_frame = parent.mw.$('#' + this.name)[0];

        if (typeof thismodal != 'undefined' && thismodal != false) {
            var modal_title_str = '';
            if (typeof(mw_module_settings_info.name) == "undefined") {
                modal_title_str = "<?php _e("Settings"); ?>"
            } else {
                modal_title_str = mw_module_settings_info.name;
            }

            var ex_title = $(thismodal.main).find(".mw_modal_title").html();

            if (ex_title == '') {
                $(thismodal.main).find(".mw_modal_title").html(modal_title_str + '');
            }
            if (thismodal.main && typeof thismodal.main.scrollTop == 'function') {
                thismodal.main.scrollTop(0);
            }

            var icon = '';
            if (mw_module_settings_info.icon) {
                modal_title_str = ('<img class="mw-module-dialog-icon" src="'+mw_module_settings_info.icon+'">' + modal_title_str)
            }

            if(thismodal.title) {
                thismodal.title(modal_title_str)
            }


            $(window).load(function () {
                if (thismodal.main && !!thismodal.main[0]) {

                    if (autoSize) {
                        parent.mw.tools.modal.resize("#" + thismodal.main[0].id, false, $('#settings-container').height() + 25, true);

                        $(window.parent.window).bind("resize", function () {
                            if (parent != null) {
                                parent.mw.tools.modal.center("#" + thismodal.main[0].id);
                            }
                        });
                    }
                }
            });
        }

        $(window).load(function () {
            $(mwd.body).removeClass('mw-external-loading');
            $(mwd.body).ajaxStop(function () {
                $(mwd.body).removeClass('mw-external-loading');
            });

            addIcon();
        });

        $(window).load(function () {
            // add dropdown


            if(!window.thismodal && window.top.module_settings_modal_reference_preset_editor_thismodal ){
                window.thismodal = window.top.module_settings_modal_reference_preset_editor_thismodal

            }

            if (window.thismodal) {

                var toolbar = thismodal.dialogHeader;

                var dd = mwd.createElement('div');
                dd.className = 'mw-presets-dropdown module-modal-settings-menu-holder';
                $(toolbar).append(dd);

                mw.module_preset_linked_dd_menu_show_icon = function () {

                    var is_module_preset_tml_holder = $(".module-modal-preset-linked-icon", toolbar);

                    if (is_module_preset_tml_holder.length == 0) {
                        var linked_dd = window.parent.mwd.createElement('div');
                        // linked_dd.id = 'module-modal-preset-linked-icon';
                        linked_dd.class = 'module-modal-preset-linked-icon';
                        linked_dd.style.display = "none";
                        $(toolbar).prepend(linked_dd);

                    }

                    is_module_preset_tml_holder = window.parent.$(".module-modal-preset-linked-icon");
                    <?php if($is_linked_mod){  ?>
                    $(".module-modal-preset-linked-icon", toolbar).addClass('is-linked').show();
                    <?php  } else { ?>
                    $(".module-modal-preset-linked-icon", toolbar).removeClass('is-linked').hide();

                    <?php  } ?>
                }


                $(document).ready(function () {


                    //   window.top.module_settings_modal_reference = thismodal;
                    <?php if(is_array($module_info)): ?>

                    <?php $mod_adm = admin_url('load_module:') . module_name_encode($module_info['module']); ?>

                    var is_module_tml_holder = $(toolbar).find(".module-modal-settings-menu-holder");
                    if (is_module_tml_holder.length > 0) {
                        is_module_tml_holder.empty();


                        var holder = mwd.createElement('div');
                        holder.className = 'mw-module-presets-content';

                        var html = ""
                            + "<div id='module-modal-settings-menu-items<?php print $params['id'] ?>' module_id='<?php print $params['id'] ?>' module_name='<?php print $module_info['module'] ?>'>"
                            + "</div>"
                            + "<hr>"
                            + "<div class='module-modal-settings-menu-holder-2<?php print $params['id'] ?>'>"
                            + "<a href='<?php print $mod_adm  ?>'><?php _e("Go to admin"); ?></a></div>";

                            window.parent.modal_preset_manager_html_placeholder_for_reload = function () {
                           modal_preset_manager_html_placeholder_for_reload_content = ""
                                + "<div id='module-modal-settings-menu-items-presets-holder<?php print $params['id'] ?>' module_id='<?php print $params['id'] ?>' module_name='<?php print $module_info['module'] ?>'>"
                                + "</div>";

                            var presetsthismodalid = thismodal.id;




                            // window.parent.module_settings_modal_reference_preset_editor_modal_id = presetsthismodalid;
                            // window.parent.module_settings_modal_reference_window = top;

                                window.top.module_settings_modal_reference_preset_editor_modal_id = presetsthismodalid;
                                window.top.module_settings_modal_reference_preset_editor_thismodal = window.thismodal;
                                window.top.module_settings_modal_reference_window = window;



                              //  alert(presetsthismodalid);



                                window.parent.$('#module-modal-settings-menu-holder-open-presets').html('');
                                window.parent.$('.module-modal-settings-menu-holder-open-presets').html('');

                            // HERE FOR DROPDOWN
                            window.parent.$('.module-modal-settings-menu-holder-open-presets', toolbar).html(modal_preset_manager_html_placeholder_for_reload_content);
                        };

                        var html = ""
                            + "<div class='mw-ui-btn-nav module-modal-settings-menu-content'>" +
                            "<a class='mw-ui-btn mw-ui-btn-medium' href='javascript:window.parent.mw.tools.confirm_reset_module_by_id(\"<?php print $params['id'] ?>\");'>Reset module</a>" +

                            "<a class='mw-ui-btn mw-ui-btn-medium' disabled-href='javascript:window.parent.modal_preset_manager_html_placeholder_for_reload();'>Presets</a>" +


                            "</div>"
                            + "<div class='module-modal-settings-menu-holder-open-presets' ></div>";





                        var dropdown = document.createElement('div');
                        var dropdownContent = document.createElement('div');
                        dropdownContent.className ='mw-dropdown-content';
                        dropdownContent.innerHTML ='<ul></ul>';
                        dropdown.className = 'mw-dropdown mw-dropdown-default';
                        dropdown.innerHTML = '<span class="mw-dropdown-value mw-ui-btn mw-ui-btn-small mw-ui-btn-outline mw-dropdown-val">Options</span>';
                        var btn = document.createElement('li');
                        var btn2 = document.createElement('li');
                        btn2.innerHTML = 'Reset module';
                       // btn2.innerHTML = 'Reset module' +"<br><small><?php print $params['id'] ?></small>";

                        btn2.onclick = function (ev) {
                            window
                                .parent
                                .mw.tools.confirm_reset_module_by_id("<?php print $params['id'] ?>");
                        };
                        dropdown.appendChild(dropdownContent);
                        $('ul', dropdownContent)
                            .append(btn)
                            .append(btn2);


                        btn.className = 'mw-module-presets-opener';
                        btn.dataset.tipposition = 'bottom-right';
                        //btn.innerHTML = '<svg class="icon" height="30" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M736 576c-89.6 0-160 70.4-160 160s70.4 160 160 160 160-70.4 160-160-70.4-160-160-160z m96 192h-64v64h-64v-64h-64v-64h64v-64h64v64h64v64z" fill="white" /><path d="M256 291.2h384v64H256zM256 419.2h384v64H256zM640 550.4V544H256v64h313.6c19.2-22.4 44.8-41.6 70.4-57.6z" fill="white" /><path d="M531.2 768H192V192h512v339.2c9.6-3.2 22.4-3.2 32-3.2s22.4 0 32 3.2V160c0-19.2-12.8-32-32-32H160c-19.2 0-32 12.8-32 32v640c0 19.2 12.8 32 32 32h390.4c-9.6-19.2-16-41.6-19.2-64z" fill="white" /></svg>';
                        btn.innerHTML = 'Presets';
                        //$('.mw-module-presets-opener').on('click', function () {
                        $(btn).on('click', function () {
                            $(this).parent().toggleClass('active');


                            var presets_mod = {};

                            presets_mod.module_id = '<?php print $params['id'] ?>'
                            presets_mod.module_name = '<?php print $params['module'] ?>'
                            presets_mod.id = 'presets-<?php print $params['id'] ?>'
                            //   presets_mod.mod_orig_id='<?php print $mod_orig_id ?>'
                            //  var src = mw.settings.site_url + "api/module?" + json2url(presets_mod);
                            var src = mw.settings.site_url + 'editor_tools/module_presets?' + json2url(presets_mod);
                            var iframeid = 'frame-' + presets_mod.module_id;

                            var mod_presets_iframe_html_fr = '' +
                                '<div class="js-module-presets-edit-frame">' +
                                '<iframe id="' + iframeid + '" src="' + src + '" frameborder="0" scrolling="no" width="100%" onload="this.parentNode.classList.remove(\'loading\')"></iframe>' +
                                '</div>';

                            /*parent.mw.tooltip({
                                close_on_click_outside: false,
                                content: mod_presets_iframe_html_fr,
                                position: 'bottom-right',
                                element: parent.mw.$('#module-modal-settings-menu-items-presets-holder<?php print $params['id'] ?>')[0]
                            });*/

                            presetsDialogModal = top.mw.dialog({
                                content: holder,
                                width:400,
                                height:'auto',
                                id:'dialog-'+iframeid,
                                autoHeight:true,
                                title: 'Presets'
                            });
                            mw.tools.loading(presetsDialogModal.dialogContainer, 90);


                            $(presetsDialogModal.dialogContainer).html(mod_presets_iframe_html_fr);
                            top.$(".mw-presets-dropdown .module").removeClass('module');
                            var frame = presetsDialogModal.dialogContainer.querySelector('iframe');
                            mw.tools.iframeAutoHeight(frame);
                            $(frame).on('load', function(){
                                if(typeof(presetsDialogModal) !== 'undefined'){
                                    if(typeof(presetsDialogModal.center) !== 'undefined') {
                                        presetsDialogModal.center();
                                    }
                                    mw.tools.loading(presetsDialogModal.dialogContainer, false)
                                }
                            })

                        });




                        var module_has_editable_parent = window.parent.$('#<?php print $params['id'] ?>');

                        if (typeof(module_has_editable_parent[0]) != 'undefined' && window.parent.mw.tools.hasParentsWithClass(module_has_editable_parent[0], 'edit')) {
                            $(holder).append(html);
                         $(dd).prepend(dropdown);

                            is_module_tml_holder.append(holder);
                        }
                    }

                    window.parent.modal_preset_manager_html_placeholder_for_reload();
                    mw.module_preset_linked_dd_menu_show_icon();
                    mw.dropdown(top.document);
                    mw.dropdown();
                    <?php endif; ?>
                });
            }
        });



        var settingsAction = function(){
            var settings_container_mod_el = $('#settings-container');
            mw.options.form(settings_container_mod_el, function () {
                if (mw.notification) {
                    mw.notification.success('<?php _e('Settings are saved') ?>');
                 }
                mw.reload_module_parent('#<?php print $params['id']  ?>')

            });

            createAutoHeight()
        };

        var createAutoHeight = function() {
            if(window.thismodal && thismodal.iframe) {
                mw.tools.iframeAutoHeight(thismodal.iframe, 'now');
            }
            else if(window.top.frameElement && window.top.frameElement.contentWindow === window) {
                mw.tools.iframeAutoHeight(window.top.frameElement, 'now');
            } else if(window.top !== window) {
                top.mw.$('iframe').each(function(){
                    try{
                        if(this.contentWindow === window) {
                            mw.tools.iframeAutoHeight(this, 'now');
                        }
                    } catch(e){}
                })
            }
        };




    </script>

</head>
<body class="mw-external-loading loading">
<div id="settings-main">
    <div id="settings-container">
        <div class="mw-module-live-edit-settings <?php print $params['id'] ?>"
             id="module-id-<?php print $params['id'] ?>">{content}
        </div>
    </div>
</div>




<form method="get" id="mw_reload_this_module_popup_form" style="display:none">
    <?php $mpar = $params;
    if (isset($mpar['module_settings'])) {
        unset($mpar['module_settings']);
    }

    ?>
    <?php if (is_array($params)): ?>
        <?php foreach ($params as $k => $item): ?>
            <input type="text" name="<?php print $k ?>" value="<?php print $item ?>"/>
        <?php endforeach; ?>
        <input type="submit"/>
    <?php endif; ?>
</form>

<script>




    $(window).on('load', function () {

        settingsAction();

        mw.interval('_settingsAutoHeight', function(){
            if(document.querySelector('.mw-iframe-auto-height-detector') === null) {
                createAutoHeight();
            }
        });

        $(document).on('keyup', function(e){
            if(mw.event.is.escape(e) && !mw.event.targetIsField(e)){
                if(window.thismodal && thismodal.options.closeOnEscape) {
                    thismodal.remove()
                }
            }
        })
    });




</script>

</body>
</html>
