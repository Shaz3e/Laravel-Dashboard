/**
 * AdminLTE Demo Menu
 * ------------------
 * You should not use this file in production.
 * This file is for demo purposes only.
 */

/* eslint-disable camelcase */

(function($) {
    'use strict'

    // setTimeout(function () {
    //   if (window.___browserSync___ === undefined && Number(localStorage.getItem('AdminLTE:Demo:MessageShowed')) < Date.now()) {
    //     localStorage.setItem('AdminLTE:Demo:MessageShowed', (Date.now()) + (15 * 60 * 1000))
    //     // eslint-disable-next-line no-alert
    //     alert('You load AdminLTE\'s "demo.js", \nthis file is only created for testing purposes!')
    //   }
    // }, 1000)

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1)
    }

    function createSkinBlock(colors, callback, noneSelected) {
        let $block = $('<select />', {
            class: noneSelected ? 'custom-select mb-3 border-0' : 'custom-select mb-3 text-light border-0 ' + colors[0].replace(/accent-|navbar-/, 'bg-')
        })

        if (noneSelected) {
            let $default = $('<option />', {
                text: 'None Selected'
            })

            $block.append($default)
        }

        colors.forEach(function(color) {
            let $color = $('<option />', {
                class: (typeof color === 'object' ? color.join(' ') : color).replace('navbar-', 'bg-').replace('accent-', 'bg-'),
                text: capitalizeFirstLetter((typeof color === 'object' ? color.join(' ') : color).replace(/navbar-|accent-|bg-/, '').replace('-', ' '))
            })

            $block.append($color)
        })
        if (callback) {
            $block.on('change', callback)
        }

        return $block
    }

    let $sidebar = $('.control-sidebar')
    let $container = $('<form />', {
        class: 'p-3 control-sidebar-content',
    })

    $sidebar.append($container)
    $container.append('<h5>Customize Dashboard</h5><hr class="mb-2"/>');

    // Theme Settings
    $container.append('<h6>Theme Options</h6>');

    // Theme Colors
    let themeColorOptions = `
    <option class="bg-danger" value="danger">Danger</option>
    <option class="bg-fuchsia" value="fuchsia">Fuchsia</option>
    <option class="bg-indigo" value="indigo">Indigo</option>
    <option class="bg-info" value="info">Info</option>
    <option class="bg-lightblue" value="lightblue">Lightblue</option>
    <option class="bg-lime" value="lime">Lime</option>
    <option class="bg-maroon" value="maroon">Maroon</option>
    <option class="bg-navy" value="navy">Navy</option>
    <option class="bg-orange" value="orange">Orange</option>
    <option class="bg-olive" value="olive">Olive</option>
    <option class="bg-pink" value="pink">Pink</option>
    <option class="bg-primary" value="primary">Primary</option>
    <option class="bg-purple" value="purple">Purple</option>
    <option class="bg-success" value="success">Success</option>
    <option class="bg-teal" value="teal">Teal</option>
    <option class="bg-warning" value="warning">Warning</option>
    `;
    let themeColorSelect = $('<select />', {
        class: 'custom-select mb-1 border-0 btn-white',
        id: 'themeColorSettingsSelect',
    }).change(function(e) {
        themeColorSelect.removeClass('bg-white bg-danger bg-fuchsia bg-indigo bg-info bg-lightblue bg-lime bg-maroon bg-navy bg-orange bg-olive bg-pink bg-primary bg-purple bg-success bg-teal bg-warning');
        themeColorSelect.addClass(`bg-${$(this).val()}`);
        ApplyThemeColor($(this).val());
    });
    let themeColor = $('<div />', { class: 'mb-1' }).append(themeColorSelect.append(themeColorOptions));
    $container.append(themeColor)


    // Dark Mode
    let $dark_mode_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('body').hasClass('dark-mode'),
        class: 'mr-1',
        id: 'darkModeSettingsCheck',
    }).on('click', function() {
        if ($(this).is(':checked')) {
            SaveSettings('Dark-Mode', 1);
        } else {
            SaveSettings('Dark-Mode', 0);
        }
        ApplyDarkMode();
    })
    let $dark_mode_container = $('<div />', { class: 'mb-1' }).append($dark_mode_checkbox).append('<span>Dark Mode</span>')
    $container.append($dark_mode_container)


    // Body Small Text
    let $text_sm_body_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('body').hasClass('text-sm'),
        class: 'mr-1',
        id: 'bodyTextSettingsCheck',
    }).on('click', function() {
        if ($(this).is(':checked')) {
            SaveSettings('Body-Small-Text', 1)
        } else {
            SaveSettings('Body-Small-Text', 0)
        }
    })
    let $text_sm_body_container = $('<div />', { class: 'mb-4' }).append($text_sm_body_checkbox).append('<span>Small Text</span>')
    $container.append($text_sm_body_container)


    // Sidebar Nav Options
    $container.append('<h6>Sidebar Nav Options</h6>')

    // Nav Flat
    let $sidebar_collapsed_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('body').hasClass('sidebar-collapse'),
        class: 'mr-1',
        id: 'sideBarCollapsedSettingsCheck',
    }).on('click', function() {
        if ($(this).is(':checked')) {
            SaveSettings('Sidebar-Collapsed', 1);
        } else {
            SaveSettings('Sidebar-Collapsed', 0);
        }
    })
    let $sidebar_collapsed_container = $('<div />', { class: 'mb-1' }).append($sidebar_collapsed_checkbox).append('<span>Collapsed</span>')
    $container.append($sidebar_collapsed_container)


    // Nav Flat
    let $flat_sidebar_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('.nav-sidebar').hasClass('nav-flat'),
        class: 'mr-1',
        id: 'navFlatSettingsCheck',
    }).on('click', function() {
        if ($(this).is(':checked')) {
            SaveSettings('Nav-Flat', 1);
        } else {
            SaveSettings('Nav-Flat', 0);
        }
    })
    let $flat_sidebar_container = $('<div />', { class: 'mb-1' }).append($flat_sidebar_checkbox).append('<span>Nav Flat Style</span>')
    $container.append($flat_sidebar_container)


    // Nav Legacy
    let $legacy_sidebar_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('.nav-sidebar').hasClass('nav-legacy'),
        class: 'mr-1',
        id: 'navLegacySettingsCheck',
    }).on('click', function() {
        if ($(this).is(':checked')) {
            SaveSettings('Nav-Legacy', 1);
        } else {
            SaveSettings('Nav-Legacy', 0);
        }
    })
    let $legacy_sidebar_container = $('<div />', { class: 'mb-1' }).append($legacy_sidebar_checkbox).append('<span>Nav Legacy Style</span>')
    $container.append($legacy_sidebar_container)


    // Nav Compact
    let $compact_sidebar_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('.nav-sidebar').hasClass('nav-compact'),
        class: 'mr-1',
        id: 'navCompactSettingsCheck',
    }).on('click', function() {
        if ($(this).is(':checked')) {
            SaveSettings('Nav-Compact', 1);
        } else {
            SaveSettings('Nav-Compact', 0);
        }
    })
    let $compact_sidebar_container = $('<div />', { class: 'mb-1' }).append($compact_sidebar_checkbox).append('<span>Nav Compact</span>')
    $container.append($compact_sidebar_container)


    // Nav Child Indent
    let $child_indent_sidebar_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('.nav-sidebar').hasClass('nav-child-indent'),
        class: 'mr-1',
        id: 'navChildIndentSettingsCheck',
    }).on('click', function() {
        if ($(this).is(':checked')) {
            SaveSettings('Nav-Child-Indent', 1);
        } else {
            SaveSettings('Nav-Child-Indent', 0);
        }
    })
    let $child_indent_sidebar_container = $('<div />', { class: 'mb-1' }).append($child_indent_sidebar_checkbox).append('<span>Nav Child Indent</span>')
    $container.append($child_indent_sidebar_container)


    // Nav Child Hide on Collapse
    let $child_hide_sidebar_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('.nav-sidebar').hasClass('nav-collapse-hide-child'),
        class: 'mr-1',
        id: 'navCollapseHideChildSettingsCheck',
    }).on('click', function() {
        if ($(this).is(':checked')) {
            SaveSettings('Nav-Child-Hide-On-Collapse', 1);
        } else {
            SaveSettings('Nav-Child-Hide-On-Collapse', 0);
        }
    })
    let $child_hide_sidebar_container = $('<div />', { class: 'mb-1' }).append($child_hide_sidebar_checkbox).append('<span>Nav Child Hide on Collapse</span>')
    $container.append($child_hide_sidebar_container)


    // Side Bar No Expand On Hover
    let $no_expand_sidebar_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('.main-sidebar').hasClass('sidebar-no-expand'),
        class: 'mr-1',
        id: 'sideBarNoExpandSettingsCheck',
    }).on('click', function() {
        if ($(this).is(':checked')) {
            SaveSettings('Sidebar-No-Expand', 1);
        } else {
            SaveSettings('Sidebar-No-Expand', 0);
        }
    })
    let $no_expand_sidebar_container = $('<div />', { class: 'mb-4' }).append($no_expand_sidebar_checkbox).append('<span>Disable Hover/Focus Auto-Expand</span>')
    $container.append($no_expand_sidebar_container)


    $container.append('<h6>Footer Options</h6>')


    // Footer
    let $footer_fixed_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('body').hasClass('layout-footer-fixed'),
        class: 'mr-1',
        id: 'sideBarFooterFixedSettingsCheck',
    }).on('click', function() {
        if ($(this).is(':checked')) {
            SaveSettings('Sidebar-Footer-Fixed', 1)
        } else {
            SaveSettings('Sidebar-Footer-Fixed', 0)
        }
    })
    let $footer_fixed_container = $('<div />', { class: 'mb-4' }).append($footer_fixed_checkbox).append('<span>Fixed</span>')
    $container.append($footer_fixed_container)

})(jQuery)