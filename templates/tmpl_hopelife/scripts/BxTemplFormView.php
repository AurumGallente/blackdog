<?php

require_once( BX_DIRECTORY_PATH_ROOT . "templates/base/scripts/BxBaseFormView.php" );

class BxTemplFormView extends BxBaseFormView
{
    public $isBlockBasedForm = false;
    
    function BxTemplFormView($aInfo)
    {
        if(isset($aInfo['type']) && $aInfo['type'] == 'block')
            $this->isBlockBasedForm = true;
        BxBaseFormView::BxBaseFormView($aInfo);
    }
    
    /**
     * Generate Table HTML code
     *
     * @return string
     */
    function genTable()
    {
        if(!$this->isBlockBasedForm)
            return parent::genTable ();
        // add default className to attributes
        $this->aTableAttrs['class'] = 'form_advanced_table' . (isset($this->aTableAttrs['class']) ? (' ' . $this->aTableAttrs['class']) : '');

        // default cellpadding
        if (!isset($this->aTableAttrs['cellpadding']))
            $this->aTableAttrs['cellpadding'] = 0;

        // default cellspacing
        if (!isset($this->aTableAttrs['cellspacing']))
            $this->aTableAttrs['cellspacing'] = 0;

        $sTableAttrs = $this->convertArray2Attrs($this->aTableAttrs);

        // add CSRF token if it's needed.
        if($GLOBALS['MySQL']->getParam('sys_security_form_token_enable') == 'on' && (!isset($this->aParams['csrf']['disable']) || (isset($this->aParams['csrf']['disable']) && $this->aParams['csrf']['disable'] !== true)) && ($mixedCsrfToken = BxDolForm::getCsrfToken()) !== false)
            $this->aInputs['csrf_token'] = array(
                'type' => 'hidden',
                'name' => 'csrf_token',
                'value' => $mixedCsrfToken,
                'db' => array (
                    'pass' => 'Xss',
                )
            );

        // generate table contents
        $sTableCont = '';
        foreach ($this->aInputs as $aInput)
            $sTableCont .= $this->genRow($aInput);

        $this->addCssJs($this->_isDateControl, $this->_isDateTimeControl);

        return $sTableCont;
    }
    
    /**
     * Generate Table Headers row
     *
     * @param  array  $aInput
     * @return string
     */
    function genRowHeaders(&$aInput)
    {
        if(!$this->isBlockBasedForm)
            return parent::genRowHeaders ($aInput);
        
        $sTrClass = 'headers' . (isset($aInput['tr_class']) ? (' ' . $aInput['tr_class']) : '');

        $sCode = '';

        $sCode .= $this->getCloseTbody();

        $sCode .= <<<BLAH
                <div class="form-header $sTrClass">
                    <div class="header first">
                        {$aInput[0]}
                    </div>

                    <div class="header second">
                        {$aInput[1]}
                    </div>
                </div>
            </div>
BLAH;

        $sCode .= $this->getOpenTbody();

        return $sCode;
    }
    
    /**
     * Generate Block Headers row
     *
     * @param  array  $aInput
     * @return string
     */
    function genRowBlockHeader(&$aInput)
    {
        if(!$this->isBlockBasedForm)
            return parent::genRowBlockHeader ($aInput);
        $aTrAttrs = empty($aInput['attrs']) ? '' : $aInput['attrs'];
        $aNextTbodyAdd = false; // need to have some default

        if (isset($aInput['collapsable']) and $aInput['collapsable']) {
            $sTheadClass = 'collapsable';

            if (isset($aInput['collapsed']) and $aInput['collapsed']) {
                $sTheadClass .= ' collapsed';
                $aNextTbodyAdd = array(
                    'style' => 'display: none;',
                );
            }
        } else {
            $sTheadClass = '';
            $aNextTbodyAdd = false;
        }

        $aTrAttrs['class'] = "headers" . (isset($aTrAttrs['class']) ? (' ' . $aTrAttrs['class']) : '');

        $sTrAttrs = $this->convertArray2Attrs($aTrAttrs);

        $sCode = '';

        $sCode .= <<<BLAH
                <div class="form-block-header">
                        {$aInput['caption']}
                </div>
BLAH;

        return $sCode;
    }
    
    function genBlockEnd()
    {
        if(!$this->isBlockBasedForm)
            return parent::genBlockEnd ();
    }
    
    /**
     * Generate standard row
     *
     * @param  array  $aInput
     * @return string
     */
    function genRowStandard(&$aInput)
    {
        if(!$this->isBlockBasedForm)
            return parent::genRowStandard ($aInput);
        $sCaption   = (!empty($aInput['caption']))
            ? ($aInput['caption'] . ': ')
            : (!empty($aInput['colspan']) ? '' : '&nbsp;');

        $sRequired  = (!empty($aInput['required']))? '<span class="required">*</span>&#160;'  : '';

        $sClassAdd  = (!empty($aInput['error']))   ? ' error'                            : '';
        $sInfoIcon  = (!empty($aInput['info']))    ? $this->genInfoIcon($aInput['info']) : '';

        $sErrorIcon = $this->genErrorIcon(empty($aInput['error']) ? '' : $aInput['error']);

        $sTrAttrs = $this->convertArray2Attrs(empty($aInput['tr_attrs']) ? '' : $aInput['tr_attrs']);

        if (isset($aInput['attrs']) && isset($aInput['value']) && is_array ($aInput['value']) && $aInput['attrs']['multiplyable']) {
            $sValFirst = array_shift($aInput['value']);
            $aInputCopy = $aInput;
            $aInputCopy['value'] = $sValFirst;
            $sInputCopy = $this->genInput($aInputCopy);
            $sInputCode = $this->genWrapperInput($aInputCopy, $sInputCopy);
            $sInputCodeExtra = '';
            foreach ($aInput['value'] AS $v) {
                unset($aInputCopy['attrs']['multiplyable']);
                $aInputCopy['attrs']['deletable'] = 'true';
                $aInputCopy['value'] = $v;
                $sInputCopy = $this->genInput($aInputCopy);
                $sInputCodeExtra .= '<div class="clear_both"></div>' . $this->genWrapperInput($aInputCopy, $sInputCopy);
            }
        } else {
            $sInput     = $this->genInput($aInput);
            $sInputCode = $this->genWrapperInput($aInput, $sInput);
        }

        $sCode = '';
        $sInputCodeBottom = '';
        if (isset($aInput['html']) && $aInput['html_toggle'])
            $sInputCodeBottom = '<div class="form_input_toggle_html"><a href="javascript:void(0);" onclick="$(\'#' . $aInput['attrs']['id'] . '\').formsToggleHtmlEditor()">' . _t('_sys_txt_form_toggle_html_editor') . '</a></div>';

        if (!empty($aInput['colspan'])) { // colspan row
            if (empty($sButtonAdd)) $sButtonAdd = '';
            if (empty($sInputCode)) $sInputCode = '';
            if (empty($sInputCodeExtra)) $sInputCodeExtra = '';
            $sCode .= <<<BLAH
                    <div class="form-row">
                            <div class="clear_both"></div>
                            $sRequired
                            $sCaption
                            $sInputCode
                            $sButtonAdd
                            $sInfoIcon
                            $sErrorIcon
                            $sInputCodeExtra
                            <div class="clear_both"></div>
                            $sInputCodeBottom
                    </div>
BLAH;
        } else { // simple row
            if (empty($sInputCodeExtra)) $sInputCodeExtra = '';
            if (empty($sButtonAdd)) $sButtonAdd = '';
            if (empty($sInfoIcon)) $sInfoIcon = '';
            if (empty($sInputCode)) $sInputCode = '';
            if (empty($sErrorIcon)) $sErrorIcon = '';
            $sCode .= <<<BLAH
                <div class="form-row">
                    <div class="form-column caption">
                        $sRequired
                        $sCaption
                    </div>

                    <div class="form-column value$sClassAdd">
                        <div class="clear_both"></div>
                        $sInputCode
                        $sButtonAdd
                        $sInfoIcon
                        $sErrorIcon
                        $sInputCodeExtra
                        <div class="clear_both"></div>
                        $sInputCodeBottom
                    </div>
                </div>
BLAH;
        }

        return $sCode;
    }
    
    
    /**
     * Generate select_box row
     *
     * @param  array  $aInput
     * @return string
     */
    function genRowSelectBox(&$aInput)
    {
        if(!$this->isBlockBasedForm)
            return parent::genRowSelectBox ($aInput);
        $sCaption   = (!empty($aInput['caption'])) ? ($aInput['caption'] . ': ')         : '&nbsp;';
        $sRequired  = (!empty($aInput['required'])) ? '<span class="required">*</span>&#160;'  : '';

        $sClassAdd  = (!empty($aInput['error']))   ? ' error'                            : '';
        $sInfoIcon  = (!empty($aInput['info']))    ? $this->genInfoIcon($aInput['info']) : '';

        $sErrorIcon = $this->genErrorIcon(empty($aInput['error']) ? '' : $aInput['error']);
        $sInput     = $this->genInputSelectBox($aInput, $sInfoIcon, $sErrorIcon);

        $sTrAttrs = $this->convertArray2Attrs(empty($aInput['tr_attrs']) ? array() : $aInput['tr_attrs']);

        $sCode = '';

        $sCode .= $this->getOpenTbody();

        if (!empty($aInput['colspan'])) { // colspan row

            $sCode .= <<<BLAH
                <div class="form-row">
                        <div class="clear_both"></div>
                        $sInput
                        <div class="clear_both"></div>
                </div>
BLAH;
        } else { // simple row

            $sCode .= <<<BLAH
                <div class="form-row">
                    <div class="form-column caption">
                        $sRequired
                        $sCaption
                    </div>

                    <div class="form-column value$sClassAdd">
                        <div class="clear_both"></div>
                            $sInput
                        <div class="clear_both"></div>
                    </div>
                </div>
BLAH;
        }

        return $sCode;
    }
    
}
