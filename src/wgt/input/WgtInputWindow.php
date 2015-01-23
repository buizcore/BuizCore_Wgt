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
 * Objekt zum generieren einer Inputbox
 * @package net.buizcore.wgt
 */
class WgtInputWindow extends WgtInput
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var string
   */
  public $refValue = '';

  /**
   *
   * @var string
   */
  public $selectionUrl = '';

  /**
   *
   * @var string
   */
  public $listIcon = 'control/link.png';

  /**
   *
   * @var string
   */
  public $showUrl = '';

  /**
   * @var Entity
   */
  public $conEntity = null;

  /**
   * @var die connection ID
   */
  public $conId = null;

  /**
   * the activ view object
   * @var LibTemplate
   */
  public $view = null;

  /**
   *
   * @var string
   */
  public $uniqueKey = '';

  /**
   * Daten für einen Automcomplete Zugriff
   * Wenn gesetzt ist das Inputelement nichtmehr Readonly
   * Sondern in Autocomplete Feld
   *
   * @var string
   */
  public $autocomplete = null;

  /**
   * Filter Fields
   * @var string
   */
  public $filterFields = array();

  /**
   * Die Url über welche die Datenquelle der Selectbox verwaltet werden kann
   * @var string
   */
  public $editUrl = null;

  /**
   * Der Wert der angezeigt wird
   * @var string
   */
  public $displayValue = null;


/*////////////////////////////////////////////////////////////////////////////*/
// Getter + Setter
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param string $url
   * @return void
   */
  public function setListUrl($url)
  {
    $this->selectionUrl = $url;
  }//end public function setListUrl */

  /**
   * @param string $icon
   * @return void
   */
  public function setListIcon($icon)
  {
    $this->listIcon = $icon;
  }//end public function setListIcon */

  /**
   * @param string $url
   * @return void
   */
  public function setEntityUrl($url)
  {
    $this->showUrl = $url;
  }//end public function setEntityUrl */

  /**
   *
   * @param $value
   * @return void
   */
  public function setRefValue($value)
  {
    $this->refValue = $value;
  }//end public function setRefValue */

  /**
   *
   * @param string $value
   * @return void
   */
  public function setAutocomplete($autocomplete)
  {
    $this->autocomplete = $autocomplete;
  }//end public function setAutocomplete */

  /**
   *
   * @param boolean $hide
   * @return void
   */
  public function setHide($hide = true)
  {
    $this->hide = $hide;
  }//end public function setHide */

/*////////////////////////////////////////////////////////////////////////////*/
// Render Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * build all data to a ui element
   * @param array $attributes
   * @return string
   */
  public function build($attributes = array())
  {

    if ($this->html)
      return $this->html;
    
    $i18n = $this->getI18n();

    $boxClasses = implode(' ', $this->boxClasses);
    $id = $this->getId();
    
    $styleHidden = '';
    if ($this->isHidden) {
      $styleHidden = ' style="display:none;" ';
    }
    
    if ($this->editUrl) {
        $this->label =  '<a href="'.$this->editUrl.'" class="wcm wcm_req_ajax"  tabindex="-1" >'.$this->label.':</a>'.NL;
    } else {
        $this->label .= ': ';
    }
    

    if(!$this->renderInput){

        $value = $this->displayValue?:'';
        $html = <<<HTML
    <div class="wgt-box kv {$boxClasses}" id="wgt-box-{$id}" {$styleHidden} >
      {$this->texts->topBox}
      <label
        for="{$id}" >{$this->texts->beforeLabel}{$this->label} {$this->texts->afterLabel}
      </label>
      {$this->texts->middleBox}
      <div>{$this->texts->beforInput}<span>{$value}</span>{$this->texts->afterInput}</div>
      {$this->texts->bottomBox}
    </div>
    <div class="do-clear tiny" >&nbsp;</div>

HTML;


      $this->html = $html;
      return $html;
    }

    if ($attributes)
      $this->attributes = array_merge($this->attributes, $attributes);

    // ist immer ein text attribute
    $this->attributes['type'] = 'hidden';

    $attrHidden = array();
    
    if($this->conId){
        $attrHidden['value'] = $this->conId;
    } else {
        $attrHidden['value'] = $this->conEntity?$this->conEntity->getId():null;
    }
    $attrHidden['id'] = $id;
    $attrHidden['name'] = $this->attributes['name'];

    $attrHidden['class'] = $this->assignedForm
      ? 'asgd-'.$this->assignedForm
      : '';

    $showAttr = $this->attributes;
    $showAttr['id'] = $showAttr['id'].'-tostring';
    $showAttr['value'] = $this->displayValue?:null;
    $showAttr['name'] = substr($this->attributes['name'], 0, -1  ).'-tostring]';
    $showAttr['class']  .= ' wgt-ignore has-button';

    $codeAutocomplete = '';

    // nur readonly wenn autocomplete
    if (!$this->autocomplete || $this->readOnly) {

      $showAttr['readonly'] = 'readonly';
      $showAttr['class']  .= ' wgt-readonly';
    } else {

      $codeAutocomplete = '<var id="var-'.$showAttr['id'].'" >'.$this->autocomplete.'</var>';
      $showAttr['class']  .= ' wcm wcm_ui_autocomplete';
    }

    if ($this->readOnly) {
      
      $codeUnset = "";
      $entryUnset = "";
      
    } else {

      $codeUnset = ',
   "unset":"true"';

      $entryUnset = <<<HTML
      <li class="unset" ><a><i class="fa fa-times" ></i> {$i18n->l('Unset', 'wbf.label')}</a></li>
HTML;

    }

    $codeOpen = '';
    $entryOpen = '';

    if ($this->showUrl) {

      $codeOpen = <<<HTML
,
   "open":"{$this->showUrl}&amp;rqtby=inp&amp;input={$attrHidden['id']}&amp;objid="
HTML;


      $entryOpen = <<<HTML
            <li class="open" ><a><i class="fa fa-eye" ></i> {$i18n->l('Open', 'wbf.label')}</a></li>
HTML;

    }

    $codeSelection = '';
    $entrySelection = '';

    if ($this->selectionUrl) {

      $codeSelection = <<<HTML
,
   "selection":"{$this->selectionUrl}"
HTML;


      $entrySelection = <<<HTML
            <li class="add" ><a><i class="fa fa-plus-circle" ></i> {$i18n->l('Add', 'wbf.label')}</a></li>
            <li class="change" ><a><i class="fa fa-random" ></i> {$i18n->l('Change', 'wbf.label')}</a></li>
HTML;

    }

    $codeFilter = '';

    if ($this->filterFields) {

      $tmpStack = array();

      foreach( $this->filterFields as $key => $value ){
        $tmpStack[] = '"'.$key.'":"'.$value.'"';
      }

      $codeFilter = ",\"filter_fields\":{".implode(',',$tmpStack)."}";

    }

      $buttonAppend = <<<HTML
  <button
    class="wcm wcm_control_selection wgt-button append-inp"
    tabindex="-1"
    id="{$attrHidden['id']}-control"
    data-drop-box="{$attrHidden['id']}-control-drop" ><i class="fa fa-edit" ></i></button>

  <var id="{$attrHidden['id']}-control-cfg-selection" >{
   "element":"{$attrHidden['id']}"{$codeSelection}{$codeOpen}{$codeUnset}{$codeFilter}
  }</var>
HTML;

    unset($showAttr['type']);

    $htmlShowAttr = $this->asmAttributes($showAttr, false);
    $required = $this->required?'<span class="wgt-required">*</span>':'';

    $id = $this->attributes['id'];
    $helpIcon = $this->renderDocu($id);


    if (!$this->isHidden) {

      $html = '<div class="wgt-box input has-clearfix" id="wgt-box-'.$this->attributes['id'].'" >
        <div class="wgt-label" >
          <label  for="'.$this->attributes['id'].'" >'.$this->label.' '.$required.'</label>
          '.$helpIcon.'
        </div>
        <div class="wgt-input '.$this->width.'" >
          <div class="inline" >
          <input
            type="hidden" class="'.$attrHidden['class'].'"
            value="'.$attrHidden['value'].'"
            id="'.$attrHidden['id'].'"
            name="'.$attrHidden['name'].'" />
          <input type="text" '.$htmlShowAttr.' />'.$codeAutocomplete.'
          '.$buttonAppend.'
          </div>
        </div>

        <div class="wgt-dropdownbox"  id="'.$this->attributes['id'].'-control-drop" >
          <ul>
            '.$entrySelection.$entryOpen.$entryUnset.'
          </ul>
        </div>

      </div>'.NL;

    } else {

      $html = '<input
        type="hidden"
        class="'.$attrHidden['class'].'"
        value="'.$attrHidden['value'].'"
        id="'.$attrHidden['id'].'"
        name="'.$attrHidden['name'].'" />'.NL;
    }

    $this->html = $html;

    return $this->html;

  }//end public function build */

  /**
   * @param string $attrId
   */
  public function buildJavascript($attrId)
  {
    return '';

  }//end public function buildJavascript */

  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtAbstract#buildAjaxArea()
   */
  public function buildAjaxArea()
  {

    if (!isset($this->attributes['id']))
      return '';

    if (!isset($this->attributes['value']))
      $this->attributes['value'] = '';

    $this->editUrl = null;

    if ($this->serializeElement) {

      $html = '<htmlArea selector="input#'.$this->attributes['id'].'" action="thml" ><![CDATA['
        .$this->element().']]></htmlArea>'.NL;
    } else {

      $html = '<htmlArea selector="input#'.$this->attributes['id'].'" action="value" ><![CDATA['
        .$this->attributes['value'].']]></htmlArea>'.NL;

      $html .= '<htmlArea selector="input#'.$this->attributes['id'].'_tostring" action="value" ><![CDATA['
        .$this->displayValue.']]></htmlArea>'.NL;

    }

    return $html;

  }//end public function buildAjaxArea

}//end class WgtInputWindow

