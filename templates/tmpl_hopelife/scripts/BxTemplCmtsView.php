<?php

require_once( BX_DIRECTORY_PATH_BASE . 'scripts/BxBaseCmtsView.php' );

/**
 * @see BxDolCmts
 */
class BxTemplCmtsView extends BxBaseCmtsView
{
    function BxTemplCmtsView( $sSystem, $iId, $iInit = 1 )
    {
        BxBaseCmtsView::BxBaseCmtsView( $sSystem, $iId, $iInit );
    }
    
    function _getBrowse()
    {
        return $GLOBALS['oSysTemplate']->parseHtmlByName('cmts_top_controls.html', array(
            'js_object' => $this->_sJsObjName,
            'sorting' => $this->_oPaginate->getSorting(array('trend' => 'Trending', 'desc' => 'Latest', 'asc' => 'Oldest' )),
            'expand_all' => _t('_expand all'),
            'pages' => $this->_oPaginate->getPages()
        ));
    }
}
