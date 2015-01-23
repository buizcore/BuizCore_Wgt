<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH
* @project     : BuizCore - The Business Core
* @projectUrl  : http://buizcore.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * @package net.buizcore.wgt
 * @since 2.0
 */
class LibViewMaintabTabbed extends LibViewMaintab
{

    /**
     *
     * @var WgtTabHead
     */
    public $tabs = [];
    
    /**
     * Tab Control ID
     * @var string
     */
    public $tabCId = null;
    
    /**
     * Icon
     * @var string
     */
    public $icon = null;

    /**
     * @var string
     */
    public $avatar = null;

    /**
     * @var string
     */
    public $headRow1 = null;
    
    /**
     * @var string
     */
    public $headRow2 = null;
    
    /** the buildr method
     * @return string
     */
    public function build()
    {
    
        $id = $this->getId();
        
        if (!$this->tabCId) {
            $this->tabCId = $id.'-acc';
        }
    
        $content = $this->includeTemplate($this->template);
    
        $jsCode = '';
        if ($this->jsCode) {
    
            $this->assembledJsCode = '';
    
            foreach ($this->jsCode as $jsCode) {
                if (is_object($jsCode))
                    $this->assembledJsCode .= $jsCode->getJsCode();
                else
                    $this->assembledJsCode .= $jsCode;
            }
    
            $jsCode = '<script><![CDATA['.NL.$this->assembledJsCode.']]></script>'.NL;
        }
    
        $closeAble = $this->closeable?' closeable="true" ':'';
    
        $buttons = '';
    
        foreach ($this->buttons as /* @var $button WgtButton */ $button)
            $buttons .= $button->buildMaintab();
    
        $maskActions = '';
    
        foreach ($this->maskActions as /* @var $maskAction WgtButton */ $maskAction)
            $maskActions .= $maskAction->buildAction();
    
        /* test code
         $this->rightPanel = new WgtPanelButtonLine_Dset($this);
        $this->rightPanel->flags->comments = true;
        $this->rightPanel->flags->history = true;
        $this->rightPanel->flags->tags = true;
        $this->rightPanel->flags->messages = true;
        */
    
        if ($this->rightPanel) {
    
            if ($this->var->entity)
                $this->rightPanel->entity = $this->var->entity;
    
            if ($this->rightPanel)
                $maskActions .= $this->rightPanel->render($this);
        }
    
    
        $tabs = '';
    
        $tabTitle = '';
        $tabSearch = '';
        if ($this->searchElement) {
            $tabSearch = '<div class="wgt-maintab-search-bar"  >'.$this->searchElement->render().'</div><!-- end wgt-panel left -->';
        }
    
        $buttonClose = '';
        if (!$this->closeCustom) {
            $buttonClose = <<<HTML
          <button
            class="wcm wcm_ui_tip-left wgt-button icon-only wgtac_close"
            tabindex="-1"
            tooltip="{$this->i18n->l('Close the active tab','wbf.label')}"  ><i class="fa fa-times" ></i></button>
HTML;
        }

        
        $tabsCode = '';
        
        $active = ' active ';
        if($this->tabs){
            foreach( $this->tabs as $tab ){
            
                $srcC = '';
                if($tab->src){
                    $srcC = ' data-src="'.$tab->src.'" ';
                }
            
                $tabClass = '';
                if($tab->class){
                    $tabClass = ' class="'.$tab->class.' tab" ';
                } else {
                    $tabClass = ' class="tab" ';
                }
        
            $tabsCode .= <<<CODE
    <li class="{$active}" ><a data-tab="{$tab->key}" {$tabClass} {$srcC} >{$tab->label}</a></li>

CODE;
            
                $active = '';
            }
        }
        
        $hideTabs = '';
        if(count($this->tabs)<2){
            $hideTabs = ' style="display:none" ';
        }
        
    $tabIcon = '';
        
    if ($this->icon) {
        $tabIcon = "<i class=\"{$this->icon}\" ></i>";
    }
    
    /* test code
    $this->avatar = new stdClass();
    $this->avatar->eid = 488342;
    $this->avatar->entity = 'core_person';
    $this->avatar->field = 'photo';
    $this->avatar->dKey = 'CorePerson';
   */
    
    $htmlAtavar = ''; 
    $headContent = '';
    
    if ($this->avatar) {
        $htmlAtavar = <<<HTML
<div class="left" style="width:75px;" >
    <img 
        src="thumb.php?i=1&f={$this->avatar->entity}-{$this->avatar->field}-{$this->avatar->eid}&s=xxsmall" 
        alt="Avatar"
        data-url="ajax.php?c=Buiz.Avatar.upload&objid={$this->avatar->eid}&ts={$this->avatar->entity}&tf={$this->avatar->field}&dkey={$this->avatar->dKey}"
        data-defname="thumb.php?i=1&f={$this->avatar->entity}-{$this->avatar->field}-{$this->avatar->eid}&s=xxsmall"
        id="{$this->tabCId}-avatar"
        name="image"
        data-dim="75-75"
        style="max-width:75px;max-height:75px;"
        class="wcm wcm_input_dropimg"  />
</div>

HTML;
        
    }
    
    if ($this->headRow1 || $this->headRow2) {
        $headContent = <<<HTML
    <div class="inline" style="width:280px;line-height:1.7;" >
        {$this->headRow1}<br />
        {$this->headRow2}
    </div>

HTML;
        
    }
    
    
    $headCode = '';
    
    if ($this->avatar) {
        
        $headCode = <<<HTML
    {$htmlAtavar}
    <div class="inline" style="width:250px;" >
        <h2 >{$tabIcon} {$this->title}</h2>
        {$headContent}
    </div>   
HTML;
        
    } else {
        
        $headCode = <<<HTML
    <h2>{$tabIcon} {$this->title}</h2>
    <div class="full" >
        {$headContent}
    </div>
HTML;
    
    }
    
    $subControls = $this->renderSubControls();
    
        
    $panel = <<<HTML
<div class="wgt-panel maintab" >
  <div class="wgt-panel crumb"  >
    <div class="left" style="width:96%;min-width:950px;" >
      {$this->crumbs->buildCrumbs()}
    </div>
  </div>
</div>
<div class="wgt-maintab-head">
    <div class="wgt-maintab-label"  >
        {$headCode}
    </div>
    <div class="wgt-maintab-subtabs-panel" >
        <ul
            id="{$this->tabCId}"
            data-tab-body="{$this->tabCId}-content"
            {$hideTabs}
            class="wcm wcm_ui_tab_head wgt-tab-head bottom-open" >
            {$tabsCode}
        </ul>
        <div class="tab-controls"  >
            {$buttons}
            {$subControls}
            
            <div class="right wgt-panel-menu"  style="min-width:400px;" >
              <div class="right wgt-panel-control c-set" >
                {$maskActions}
                {$buttonClose}
              </div>
            </div>
        </div>
        {$tabSearch}
    </div>

</div>
HTML;
    
    
              $bottom = <<<HTML
    <div class="wgt_footer maintab" >
      footer
    </div>
HTML;
    
      $bottom = '';
    
      ///TODO xml entitie replacement auslager
      $title = str_replace(array('&','<','>','"',"'"), array('&amp;','&lt;','&gt;','&quot;','&#039;'), strip_tags($this->title) );
      $label = str_replace(array('&','<','>','"',"'"), array('&amp;','&lt;','&gt;','&quot;','&#039;'), strip_tags($this->label) );
    
      $this->reportXMLErrors($panel, $content, $bottom);
    
      $subTab = '';
    
      if ($this->subTab) {
          $subTab = ' sub_tab="'.$this->subTab.'" ';
      }
    
      return <<<CODE
    
    <tab id="{$id}" label="{$label}" title="{$title}" {$closeAble} {$subTab} >
      <body><![CDATA[{$panel}<section class="wgt-content maintab p1" style="overflow-y:{$this->overflowY};" ><div class="wrapper" >{$content}</div><div class="do-clear" > </div></section>{$bottom}]]></body>
      {$jsCode}
    </tab>
    
CODE;
    
          //<body><![CDATA[{$panel}<div class="wgt-content maintab" ><div class="body" >{$content}</div></div>]]></body>
    
    }//end public function build */
    
    

    
    
} // end class LibViewMaintabTabbed

