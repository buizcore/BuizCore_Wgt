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

/** Form Class
 *
 * @package net.buizcore.wgt
 */
class WgtFormBuilder
{
/*////////////////////////////////////////////////////////////////////////////*/
// public interface attributes
/*////////////////////////////////////////////////////////////////////////////*/

    /**
    * Die Id des Formulars
    * @var string $keyName
    */
    public $id = null;
    
    /**
    * in Standard Prefix für Input Ids
    * @var string $inpIdPrefix
    */
    public $inpIdPrefix = null;
    
    /**
    * Data Key
    * @var string $dKey
    */
    public $dKey = null;
    
    /**
    * Die Action des Formulars
    * @var string
    */
    public $action = null;
    
    /**
    * Der Domainkey des Elements
    * @var string
    */
    public $domainKey = null;
    
    /**
    * Methodes des Formulars
    * @var string
    */
    public $method = null;
    
    /**
    * Flag ob das Formular direkt ausgegeben werden soll
    * oder zurückgegeben werden soll
    * @var boolean
    */
    public $cout = true;
    
    /**
    * @var LibDbConnection
    */
    public $db = null;
    
    /**
    * @var TFlag
    */
    public $defParams = null;
    
    /**
    * Check ob das Formular per Ajax verschickt wird
    * @var boolean
    */
    public $ajax = true;
    
    /**
    * Liste der I18n Languages
    * @var array
    */
    public $i18nLanguages = array(
        array('id' => 'de', 'value' => 'german'),
        array('id' => 'en', 'value' => 'english'  )
    );
    
    /**
    * @var LibTemplate
    */
    public $view = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Constructor
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $view
   * @param string $action
   * @param string $domainKey
   * @param string $method
   * @param boolean $cout
   */
  public function __construct(
    $view,
    $action,
    $domainKey,
    $method = 'post',
    $cout = true
  ) {

    $this->view = $view;
    $this->action = $action;


    if ('wgt-form-'==substr($domainKey,0,9)){
      $this->id = $domainKey;
      $this->domainKey = substr($domainKey,10);
    } else {
      $this->id = 'wgt-form-'.$domainKey;
      $this->domainKey = $domainKey;
    }
    
    $this->inpIdPrefix = $domainKey.'-';

    $this->dKey = 'asgd-'.$this->id;
    $this->method = $method;
    $this->cout = $cout;

    $this->defParams = new TFlag();

    $this->defParams->plain = false;
    $this->defParams->size = 'medium';
    $this->defParams->appendText = null;
    $this->defParams->helpText = null;

  }//end public function __construct */

/*////////////////////////////////////////////////////////////////////////////*/
// Helper Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $code
   */
  public function out($code)
  {

    if ($this->cout)
      echo $code;

    return $code;

  }//end public function out */

  /**
   * @param string $key
   * @return LibSqlQuery
   */
  public function loadQuery($key)
  {

    if (!$this->db)
      $this->db = BuizCore::$env->getDb();

    return $this->db->newQuery($key);

  }//end public function loadQuery */

/*////////////////////////////////////////////////////////////////////////////*/
// Form Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function form()
  {

    $code = <<<CODE
<form method="{$this->method}" action="{$this->action}" id="{$this->id}" accept-charset="utf-8" >
CODE;

    if ($this->ajax)
      $code .= '</form>';

    return $this->out($code);

  }//end public static function form */

  /**
   * @return string
   */
  public function close()
  {

    return $this->out('</form>');

  }//end public static function close */
  
  
  /**
   * @param [] $attributes
   * @return string
   */
  public function searchForm($attributes)
  {
  
      $code = <<<CODE
<form method="{$this->method}" action="{$this->action}" id="{$this->id}" accept-charset="utf-8" ></form>

CODE;

      
      $urlParam = $this->urlParam();
      
      foreach ($attributes as $name => $attribute) {
          
          $id = "wgt-input-".str_replace(['[',']'], ['-',''], $this->inpIdPrefix.$name);
        
          $code .= <<<CODE
    <input type="hidden" class="{$urlParam}" name="{$name}" id="{$id}" value="{$attribute}"  />

CODE;
          
          
      }
  
      return $this->out($code);
  
  }//end public static function form */
  

  /**
   * rückgabe der assign klasse für das form
   * @return string
   */
  public function asgd()
  {
    return 'dp-'.$this->id;
  }//end public function asgd */
  
  /**
   * id zur suche
   * @return string
   */
  public function dataParam()
  {
      return 'dp-'.$this->id;
  }//end public function urlParam */

  /**
   * id zur suche
   * @return string
   */
  public function urlParam()
  {
    return 'up-'.$this->id;
  }//end public function urlParam */
  
  /**
   * @param string $name
   * @return string
   */
  public function getIdByName($name)
  {
      
      $tmp = explode(',', $name);
      
      if (count($tmp) > 1) {
          $id = $this->inpIdPrefix.$tmp[0]."-".$tmp[1];
      } else {
          $id = str_replace(['[',']'], ['-',''], $this->inpIdPrefix.$tmp[0]);
      }
      
      return 'wgt-input-'.$id;
      
  }//end public function getIdByName */

  /**
   * Einfaches Inputfeld
   * @param string $label
   * @param string $name
   * @param string $value
   * @param array $attributes
   * @param array $params
   */
  public function input(
    $label,
    $name,
    $value = null,
    $attributes = [],
    $params = null
  ) {

    $pNode = $this->prepareParams($params);

    if (isset($attributes['id'])) {
      $id = $this->inpIdPrefix.$attributes['id'];
      $inpName = $name;
    } else {

      $tmp = explode(',', $name);

      if (count($tmp) > 1) {
        $id = $this->inpIdPrefix.$tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id = str_replace(['[',']'], ['-',''], $this->inpIdPrefix.$tmp[0]);
        $inpName = $tmp[0];
      }

      $attributes['id'] = "wgt-input-{$id}";
    }

    $attributes['type'] = $pNode->inp_type;

    if (!isset($attributes['class']))
      $attributes['class'] = $pNode->size;

    if ($this->id && !isset($params['un_assigned']))
      $attributes['class']  .= ' asgd-'.$this->id;

    if (!isset($attributes['name']))
      $attributes['name'] = $inpName;

    $attributes['value'] = str_replace('"', '\"', $value);
    $attributes['data-def-value'] = $attributes['value'];
    
    if ($pNode->inp_only && !isset($attributes['placeholder'])) {
        $attributes['placeholder'] = $label;
    }

    $codeAttr = Wgt::asmAttributes($attributes);

    $helpIcon = '';
    $helpText = '';
    if ($pNode->helpText) {
       $helpIcon = '<span class="help" onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" ><i class="fa fa-question-sign" ></i></span> ';
       $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$pNode->helpText.'</div>';
    }

    $appendButton = null;
    if (isset($params['append_button'])) {
    
        $appendButton = <<<CODE
<var>{"button":"wgt-input-{$id}-ap-button"}</var>
        <button
          id="wgt-input-{$id}-ap-button"
          class="wgt-button append-inp"
          tabindex="-1"  >
          <i class="{$params['append_button']}" ></i>
        </button>
CODE;
    
    }
    
    
    if ($pNode->plain) {
      $html = <<<CODE

<input {$codeAttr} />{$appendButton}

CODE;

    } else if ($pNode->inp_only) {
        
      $html = <<<CODE
<div id="wgt_box_{$id}" class="box-form-node is-standalone has-clearfix" >
    <div class="box-form-node-element {$pNode->size}" >
        <input placeholder="{$label}" {$codeAttr} />{$appendButton}
    </div>
</div>
CODE;

    } else {
        

      $html = <<<CODE

<div id="wgt_box_{$id}" class="box-form-node has-clearfix" >
  
    <label 
        for="wgt-input-{$id}" 
        class="box-form-node-label"  >{$helpIcon}{$label}{$pNode->requiredText}</label>
    {$helpText}
    
    <div class="box-form-node-element {$pNode->size}" >
        <input {$codeAttr} />{$appendButton}{$pNode->appendText}
    </div>
        
</div>

CODE;
    }

    return $this->out($html);

  }//end public function input */

  /**
   * Ok was genau soll richInput machen?
   * 
   * @param string $label
   * @param string $name
   * @param string $value
   * @param array $attributes
   * @param array $params
   */
  public function richInput(
    $type,
    $label,
    $name,
    $value = null,
    $attributes = [],
    $params = null
  ) {

    $pNode = $this->prepareParams($params);

    if (isset($attributes['id'])) {
      $id = $this->inpIdPrefix.$attributes['id'];
      $inpName = $name;
    } else {

      $tmp = explode(',', $name);

      if (count($tmp) > 1) {
        $id = $this->inpIdPrefix.$tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id = str_replace(['[',']'], ['-',''], $this->inpIdPrefix.$tmp[0]);
        $inpName = $tmp[0];
      }

      $attributes['id'] = "wgt-input-{$id}";
    }

    $attributes['type'] = 'text';

    if (!isset($attributes['class']))
      $attributes['class'] = 'wcm wcm_ui_'.$type;

    $attributes['class']  .= ' '.$pNode->size;

    if ($this->id)
      $attributes['class']  .= ' asgd-'.$this->id;

    if (!isset($attributes['name']))
      $attributes['name'] = $inpName;

    $attributes['value'] = str_replace('"', '\"', $value);
    $attributes['data-def-value'] = $attributes['value'];
    
    if ($pNode->inp_only && !isset($attributes['placeholder'])) {
        $attributes['placeholder'] = $label;
    }

    $codeAttr = Wgt::asmAttributes($attributes);

    $helpIcon = '';
    $helpText = '';
    if ($pNode->helpText) {
       $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" ><i class="fa fa-question-sign" ></i></span> ';
       $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$pNode->helpText.'</div>';
    }

    $appendButton = '';
    if (isset($params['button'])) {

      $appendButton = <<<BUTTON

 <var>{"button":"wgt-input-{$id}-ap-button"}</var>
  <button
    id="wgt-input-{$id}-ap-button"
    class="wgt-button append-inp"
    tabindex="-1"  >
      {$this->view->icon($params['button'], $label)}
  </button>

BUTTON;

    }

    if ($pNode->plain) {
      $html = <<<CODE

<input {$codeAttr} />

CODE;

    } else {
      $html = <<<CODE

<div id="wgt_box_{$id}" class="box-form-node is-standalone has-clearfix" >
  <label 
    for="wgt-input-{$id}" 
    class="box-form-node-label" >{$helpIcon}{$label}{$pNode->requiredText}</label>
  {$helpText}
  <div class="box-form-node-element {$pNode->size}" >
    <input {$codeAttr} />{$appendButton}{$pNode->appendText}
  </div>
</div>

CODE;
    }

    return $this->out($html);

  }//end public function richInput */


  /**
   * @param string $name
   * @param string $value
   * @param array $params
   */
  public function hidden
  (
    $name,
    $value = null,
    $attributes = [],
    $params = null
  ) {

    $pNode = $this->prepareParams($params);

    if (isset($attributes['id'])) {
      $id = $this->inpIdPrefix.$attributes['id'];
      $inpName = $name;
    } else {

      $tmp = explode(',', $name);

      if (count($tmp) > 1) {
        $id = $this->inpIdPrefix.$tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id = str_replace(['[',']'], ['-',''], $this->inpIdPrefix.$tmp[0]);
        $inpName = $tmp[0];
      }

      $attributes['id'] = "wgt-input-{$id}";
    }

    $attributes['type'] = 'hidden';

    if ($this->id)
      $attributes['class'] = ' asgd-'.$this->id;

    if (!isset($attributes['name']))
      $attributes['name'] = $inpName;

    $attributes['value'] = str_replace('"', '\"', $value);

    $codeAttr = Wgt::asmAttributes($attributes);

    $html = <<<CODE

<input {$codeAttr} />

CODE;

    return $this->out($html);

  }//end public function hidden */

  /**
   * @param string $name
   * @param string $value
   * @param string $label
   * @param string $subName
   * @param array $attributes
   * @param array $params
   */
  public function autocomplete(
    $label,
    $name,
    $value = null,
    $loadUrl = null,
    $attributes = [],
    $params = null
  ) {

    $pNode = $this->prepareParams($params);

    if (isset($attributes['id'])) {
      $id = $this->inpIdPrefix.$attributes['id'];
      $inpName = $name;
    } else {

      $tmp = explode(',', $name);

      if (count($tmp) > 1) {
        $id = $this->inpIdPrefix.$tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id = str_replace(['[',']'], ['-',''], $this->inpIdPrefix.$tmp[0]);
        $inpName = $tmp[0];
      }

      $attributes['id'] = "wgt-input-{$id}";
    }

    $helpIcon = '';
    $helpText = '';
    if ($pNode->helpText) {
      $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" ><i class="fa fa-question-sign" ></i></span> ';
      $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$pNode->helpText.'</div>';
    }

    if ($pNode->entityMode) {

      if (!isset($attributes['class']))
        $class = 'wcm wcm_ui_autocomplete wgt-ignore '.$pNode->size.' asgd-'.$this->id;
      else
        $class = 'wcm wcm_ui_autocomplete wgt-ignore '.$pNode->size.' '.$attributes['class'].' asgd-'.$this->id;

      if ($this->id)
        $attributes['class'] = 'asgd-'.$this->id;
      else
        $attributes['class'] = '';
      
      if ($pNode->data_class) {
          $attributes['class'] .= ' '.$pNode->data_class;
      }

      if (!isset($attributes['name']))
        $attributes['name'] = $inpName;

      if (is_array($value))
        $attributes['value'] = isset($value[0])?$value[0]:'';


      $attributes['type'] = 'hidden';

      $hidenAttr = Wgt::asmAttributes($attributes);

      if (is_array($value))
        $attributes['value'] = isset($value[1])?$value[1]:$attributes['value'];

      $attributes['class'] = $class;
      $attributes['type'] = 'text';
      $attributes['id'] =  $attributes['id'].'-tostring';
      $attributes['name'] =  'tostring-'.$attributes['name'];
    
        if ($pNode->inp_only && !isset($attributes['placeholder'])) {
            $attributes['placeholder'] = $label;
        }

      $stringAttributes = Wgt::asmAttributes($attributes);

      
      if ($pNode->inp_only) {
          
          $html = <<<CODE

  <div id="wgt_box_{$id}" class="box-form-node is-standalone has-clearfix" >
    <input {$hidenAttr} />
    <input {$stringAttributes} /><var class="meta" >{"url":"{$loadUrl}","type":"entity"}</var>{$pNode->appendText}
  </div>
          
CODE;

      } else {
          $html = <<<CODE
          
<div id="wgt_box_{$id}" class="box-form-node has-clearfix" >
  <div class="box-form-node-label" >
    <label for="wgt-input-{$id}" >{$helpIcon}{$label}{$pNode->requiredText}</label>
  </div>
  {$helpText}
  <div class="box-form-node-element {$pNode->size}" >
    <input {$hidenAttr} />
    <input {$stringAttributes} /><var class="meta" >{"url":"{$loadUrl}","type":"entity"}</var>{$pNode->appendText}
  </div>
</div>
          
CODE;
 
      }
      


    } else {

      $attributes['type'] = 'text';

      if (!isset($attributes['class']))
        $attributes['class'] = 'wcm wcm_ui_autocomplete '.$pNode->size;
      else
        $attributes['class'] = 'wcm wcm_ui_autocomplete '.$pNode->size.' '.$attributes['class'];

      if ($this->id)
        $attributes['class']  .= ' asgd-'.$this->id;

      if (!isset($attributes['name']))
        $attributes['name'] = $inpName;

      $attributes['value'] = str_replace('"', '\"', $value);

      $codeAttr = Wgt::asmAttributes($attributes);

      $html = <<<CODE

<div id="wgt_box_{$id}" class="box-form-node has-clearfix" >
  <label for="wgt-input-{$id}" class="box-form-node-label">{$helpIcon}{$label}{$pNode->requiredText}</label>
  {$helpText}
  <div class="box-form-node-element {$pNode->size}" >
    <input {$codeAttr} /><var class="meta" >{"url":"{$loadUrl}"}</var>{$pNode->appendText}
  </div>
</div>

CODE;
    }

    return $this->out($html);

  }//end public function autocomplete */

  /**
   * @param string $label
   * @param string $id
   * @param string $element
   * @param array $attributes
   * @param array $params
   */
  public function startDecoration() {
  
    ob_start();
  
  }//end public function decorateInput */
  
  /**
   * @param string $label
   * @param string $id
   * @param array $attributes
   * @param array $params
   */
  public function decorateBuffer(
    $label,
    $id,
    $attributes = [],
    $params = null
  ) {
      
    $element = ob_get_contents();
    ob_end_clean();

    $pNode = $this->prepareParams($params);
    
    $id = $this->inpIdPrefix.$id;

    $helpIcon = '';
    $helpText = '';
    if ($pNode->helpText) {
      $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" ><i class="fa fa-question-sign" ></i></span> ';
      $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$pNode->helpText.'</div>';
    }

    $html = <<<CODE

<div id="wgt_box_{$id}" class="box-form-node has-clearfix" >
  <div class="box-form-node-label" >
    <label for="wgt-input-{$id}" class="box-form-node-label">{$helpIcon}{$label}{$pNode->requiredText}</label>
  </div>
  <div class="box-form-node-element inline {$pNode->size}" >
    {$element}
    {$pNode->appendText}
  </div>
</div>

CODE;

    return $this->out($html);

  }//end public function decorateInput */

  /**
   * @param string $label
   * @param string $id
   * @param string $element
   * @param array $attributes
   * @param array $params
   */
  public function decorateInput(
    $label,
    $id,
    $element,
    $attributes = [],
    $params = null
  ) {

    $pNode = $this->prepareParams($params);
    
    $id = str_replace(['[',']'], ['-',''], $this->inpIdPrefix.$id);

    $helpIcon = '';
    $helpText = '';
    if ($pNode->helpText) {
      $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" ><i class="fa fa-question-sign" ></i></span> ';
      $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$pNode->helpText.'</div>';
    }

    $html = <<<CODE

<div id="wgt_box_{$id}" class="box-form-node has-clearfix" >
  <div class="box-form-node-label" >
    <label for="wgt-input-{$id}" class="box-form-node-label">{$helpIcon}{$label}{$pNode->requiredText}</label>
  </div>
  <div class="box-form-node-element {$pNode->size}"  >
    {$element}
    {$pNode->appendText}
  </div>
</div>

CODE;

    return $this->out($html);

  }//end public function decorateInput */


  /**
   * @param string $name
   * @param string $value
   * @param string $label
   * @param array $attributes
   * @param array $params
   */
  public function wysiwyg(
    $label,
    $name,
    $value = null,
    $attributes = [],
    $params = null
  ) {

    $pNode = $this->prepareParams($params);

    if (isset($attributes['id'])) {
      $id = $this->inpIdPrefix.$attributes['id'];
      $inpName = $name;
    } else {

      $tmp = explode(',', $name);

      if (count($tmp) > 1) {
        $id = $this->inpIdPrefix.$tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id = str_replace(['[',']'], ['-',''], $this->inpIdPrefix.$tmp[0]);
        $inpName = $tmp[0];
      }

      $attributes['id'] = "wgt-wysiwyg-{$id}";
    }

    $attributes['style'] = "width:700px;height:220px;";
    $attributes['class'] = 'wcm wcm_ui_wysiwyg ';//.$pNode->size;

    if ($this->id)
      $attributes['class']  .= ' asgd-'.$this->id;

    if (!isset($attributes['name']))
      $attributes['name'] = $inpName;

    $codeAttr = Wgt::asmAttributes($attributes);

    $helpIcon = '';
    $helpText = '';
    if ($pNode->helpText) {
       $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" ><i class="fa fa-question-sign" ></i></span> ';
       $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$pNode->helpText.'</div>';
    }

    if ($pNode->plain) {
      $html = <<<CODE

<textarea {$codeAttr}>{$value}</textarea>

CODE;

      return $this->out($html);
    }

    $html = <<<CODE

<div id="wgt_box_{$id}" class="box-form-node has-clearfix" >
  <label for="wgt-input-{$id}" class="box-form-node-label">{$helpIcon}{$label}{$pNode->requiredText}</label>
  {$helpText}
  <div class="box-form-node-element {$pNode->size} left" >
    <textarea {$codeAttr}>{$value}</textarea>
  </div>
  {$pNode->appendText}
</div>

CODE;

  //<var id="{$id}-cfg-wysiwyg" >{"mode":"{$mode}"}</var>"
    return $this->out($html);

  }//end public function wysiwyg */


  /**
   * @param string $name
   * @param string $value
   * @param string $label
   * @param array $attributes
   * @param array $params
   */
  public function textarea(
    $label,
    $name,
    $value = null,
    $attributes = [],
    $params = null
  ) {

    $pNode = $this->prepareParams($params);

    if (isset($attributes['id'])) {

      $id = $this->inpIdPrefix.$attributes['id'];
      $inpName = $name;

    } else {

      $tmp = explode(',', $name);

      if (count($tmp) > 1) {
        $id = $this->inpIdPrefix.$tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id = str_replace(['[',']'], ['-',''], $this->inpIdPrefix.$tmp[0]);
        $inpName = $tmp[0];
      }

      $attributes['id'] = "wgt-input-{$id}";
    }
    
    if (!isset($attributes['class'])) {
        $attributes['class'] = '';
    }

    $attributes['class'] .= ' '.$pNode->size;

    if ($this->id)
      $attributes['class']  .= ' asgd-'.$this->id;

    if (!isset($attributes['name']))
      $attributes['name'] = $inpName;
    
    if ($pNode->inp_only && !isset($attributes['placeholder'])) {
        $attributes['placeholder'] = $label;
    }

    $codeAttr = Wgt::asmAttributes($attributes);

    $helpIcon = '';
    $helpText = '';
    if ($pNode->helpText) {
       $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" ><i class="fa fa-question-sign" ></i></span> ';
       $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$pNode->helpText.'</div>';
    }

    if ($pNode->plain) {
      return <<<CODE

<textarea {$codeAttr}>{$value}</textarea>

CODE;
    } else  if ($pNode->inp_only) {
        
        $html = <<<CODE
<div id="wgt_box_{$id}" class="box-form-node has-clearfix" >
  <div class="box-form-node-element is-standalone is-textarea {$pNode->size} " >
    <textarea {$codeAttr}>{$value}</textarea>
  </div>
</div>
CODE;
  
    } else {

        $html = <<<CODE

<div id="wgt_box_{$id}" class="box-form-node has-clearfix" >
  <label for="wgt-input-{$id}" class="box-form-node-label">{$helpIcon}{$label}{$pNode->requiredText}</label>
  {$helpText}
  <div class="box-form-node-element {$pNode->size} " >
    <textarea {$codeAttr}>{$value}</textarea>
  </div>
</div>

CODE;
  
    }

  //<var id="{$id}-cfg-wysiwyg" >{"mode":"{$mode}"}</var>"
    return $this->out($html);

  }//end public function textarea */

  /**
   * @param string $label
   * @param string $name
   * @param string $value
   * @param array $attributes
   * @param array $params
   */
  public function upload(
    $label,
    $name,
    $value = null,
    $attributes = [],
    $params = null
  ) {

    $pNode = $this->prepareParams($params);

    if (isset($attributes['id'])) {
      $id = $this->inpIdPrefix.$attributes['id'];
      $inpName = $name;
    } else {

      $tmp = explode(',', $name);

      if (count($tmp) > 1) {
        $id = $this->inpIdPrefix.$tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id = str_replace(['[',']'], ['-',''], $this->inpIdPrefix.$tmp[0]);
        $id = $this->inpIdPrefix.$tmp[0];
        $inpName = $tmp[0];
      }

      $attributes['id'] = "wgt-input-{$id}";
    }

    $attributes['type'] = 'file';

    if (!isset($attributes['class']))
      $attributes['class'] = $pNode->size;

    $attributes['class']    .= ' wgt-behind';

    if ($this->id)
      $attributes['class']  .= ' asgd-'.$this->id;

    $attributes['name'] = $inpName;
    
    if ($pNode->inp_only && !isset($attributes['placeholder'])) {
        $attributes['placeholder'] = $label;
    }

    $attributes['onchange'] = "\$S('input#wgt-input-{$id}-display').val(\$S(this).val());\$S(this).attr('title',\$S(this).val());";

    $codeAttr = Wgt::asmAttributes($attributes);


    $value = str_replace('"', '\"', $value);

    $icon = '<i class="fa fa-picture" ></i>';

    if ($pNode->clean) {
      return <<<CODE

  <div style="position:relative;overflow:hidden;" class="box-form-node-element  is-standalone {$pNode->size}" >
    <input {$codeAttr} />
    <input
      type="text"
      value="{$value}"
      class="medium wgt-ignore wgt-overlay"
      id="wgt-input-{$id}-display" name="{$id}-display" />
    <button
      class="wgt-button wgt-overlay append-inp {$pNode->size}"
      tabindex="-1" >
      {$icon}
    </button>
  </div>

CODE;
    }

    $helpIcon = '';
    $helpText = '';
    if ($pNode->helpText) {
      $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" ><i class="fa fa-question-sign" ></i></span> ';
      $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$pNode->helpText.'</div>';
    }

    $html = <<<CODE

<div id="wgt_box_{$id}" class="box-form-node has-clearfix" >
  <label for="wgt-input-{$id}" class="box-form-node-label">{$helpIcon}{$label}{$pNode->requiredText}</label>
  <div style="position:relative;" class="box-form-node-element {$pNode->size} inline" >
    <input {$codeAttr} />
    <input
      type="text"
      value="{$value}"
      class="{$pNode->size} wgt-ignore wgt-overlay"
      id="wgt-input-{$id}-display" name="{$id}-display" />
    <button
      class="wgt-button wgt-overlay append {$pNode->size}"
      tabindex="-1" >
      {$icon}
    </button>
      {$pNode->appendText}
  </div>
</div>

CODE;

    return $this->out($html);

  }//end public function upload */
  
  /**
   * @param string $label
   * @param string $name
   * @param string $value
   * @param string $textValue
   * @param string $linkKey
   * @param array $attributes
   * @param array $params
   */
  public function window(
      $label,
      $name,
      $value = null,
      $textValue = null,
      $linkKey = null,
      $attributes = [],
      $params = null
  ) {
  
      $pNode = $this->prepareParams($params);
  
      if (isset($attributes['id'])) {
          $id = $this->inpIdPrefix.$attributes['id'];
          $inpName = $name;
      } else {
  
          $tmp = explode(',', $name);
  
          if (count($tmp) > 1) {
              $id = $this->inpIdPrefix.$tmp[0]."-".$tmp[1];
              $inpName = $tmp[0]."[{$tmp[1]}]";
          } else {
              $id = $this->inpIdPrefix.$tmp[0];
              $inpName = $tmp[0];
          }
  
          $attributes['id'] = "wgt-input-{$id}";
      }
  
      $attributes['type'] = 'file';
  
      if (!isset($attributes['class']))
          $attributes['class'] = $pNode->size;
  
      $attributes['class']    .= ' wgt-behind';
  
      if ($this->id)
          $attributes['class']  .= ' asgd-'.$this->id;
  
      $attributes['name'] = $inpName;
    
        if ($pNode->inp_only && !isset($attributes['placeholder'])) {
            $attributes['placeholder'] = $label;
        }
  
      $codeAttr = Wgt::asmAttributes($attributes);
  
  
      $value = str_replace('"', '\"', $value);
  
  
      if ($pNode->clean) {
          return <<<CODE
  
CODE;
      }
  
      $helpIcon = '';
      $helpText = '';
      if ($pNode->helpText) {
          $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" ><i class="fa fa-question-sign" ></i></span> ';
          $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$pNode->helpText.'</div>';
      }
  
      $html = <<<CODE
  
<div class="box-form-node has-clearfix" id="wgt-box-wgt-input-{$id}" >
    <label  
        for="wgt-input-{$id}" ><a 
            href="maintab.php?c={$linkKey}_Listing.mask" 
            class="wcm wcm_req_ajax"  
            tabindex="-1" >{$helpIcon}{$label}{$pNode->requiredText}</a></label>  

        
    <div class="box-form-node-element medium" >
        <div class="inline" >
            <input
                type="hidden" class="asgd-{$this->id}"
                value="{$value}"
                id="wgt-input-{$id}"
                name="{$inpName}" />
            <input 
                type="text" 
                name="" 
                readonly="readonly"
                id="wgt-input-{$id}-tostring" 
                class="wgt-ignore has-button" 
                value="{$textValue}" 
                type="hidden"  />
            <button
                class="wcm wcm_control_selection wgt-button append"
                tabindex="-1"
                id="wgt-input-{$id}-control"
                data-drop-box="wgt-input-{$id}-control-drop" ><i class="fa fa-edit" ></i></button>
    
            <var id="wgt-input-{$id}-control-cfg-selection" >{
                "element":"wgt-input-{$id}",
                "selection":"modal.php?c={$linkKey}_Selection.mask&input={$id}",
                "open":"maintab.php?c={$linkKey}.edit&input=wgt-input-{$id}&amp;objid=",
                "unset":"true"
            }</var>
        </div>
    </div>

    <div class="wgt-dropdownbox"  id="wgt-input-{$id}-control-drop" >
      <ul>
        <li class="add" ><a><i class="fa fa-plus-circle" ></i> Add</a></li>
        <li class="change" ><a><i class="fa fa-random" ></i> Change</a></li>            
        <li class="open" ><a><i class="fa fa-eye" ></i> Open</a></li>      
        <li class="unset" ><a><i class="fa fa-times" ></i> Unset</a></li>
      </ul>
    </div>
    
</div>
  
CODE;
  
        return $this->out($html);
  
  }//end public function window */

  /**
   * @param string $label
   * @param string $name
   * @param string $checked
   * @param array $attributes
   * @param array $params
   */
  public function checkbox(
    $label,
    $name,
    $checked,
    $attributes = [],
    $params = null
  ) {

    $pNode = $this->prepareParams($params);

    if (isset($attributes['id'])) {
      $id = $this->inpIdPrefix.$attributes['id'];
      $inpName = $name;
    } else {

      $tmp = explode(',', $name);

      if (count($tmp) > 1) {
        $id = $this->inpIdPrefix.$tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id = str_replace(['[',']'], ['-',''], $this->inpIdPrefix.$tmp[0]);
        $inpName = $tmp[0];
      }

      $attributes['id'] = "wgt-input-{$id}";
    }

    $attributes['type'] = 'checkbox';

    if ($checked && !('false' === $checked || 'f' === $checked))
      $attributes['checked'] = 'checked';

    if (!isset($attributes['class']))
      $attributes['class'] = '';

    if ($this->id)
      $attributes['class']  .= ' asgd-'.$this->id;

    if (!isset($attributes['name']))
      $attributes['name'] = $inpName;

    $codeAttr = Wgt::asmAttributes($attributes);

    if ($pNode->plain) {
      return "<input {$codeAttr} />";
    } else if ($pNode->inp_only) {
        
            return <<<CODE
<div id="wgt_box_{$id}" class="box-form-node is-standalone has-clearfix" >
    <div class="box-form-node-element {$pNode->size}" >
        <label><input {$codeAttr} /> {$label}</label>
    </div>
</div>
CODE;

    }

    $html = <<<CODE

<div id="wgt_box_{$id}" class="box-form-node has-clearfix" >
    <label for="wgt-input-{$id}" class="box-form-node-label">{$label}{$pNode->requiredText}</label>
    <div class="box-form-node-element"  >
        <input {$codeAttr} />
    </div>
</div>

CODE;

    return $this->out($html);

  }//end public function checkbox */


  /**
   * @param string $label
   * @param string $name
   * @param string $active
   * @param array $data
   * @param array $attributes
   * @param array $params
   */
  public function ratingbar(
    $label,
    $name,
    $active,
    $data = [],
    $attributes = [],
    $params = null
  ) {

    $pNode = $this->prepareParams($params);

    if (!$data) {
      $data = array(
        '0.5' => '0.5',
        '1' => '1',
        '1.5' => '1.5',
        '2' => '2',
        '2.5' => '2.5',
        '3' => '3',
        '3.5' => '3.5',
        '4' => '4',
        '4.5' => '4.5',
        '5' => '5',
      );
    }

    if (!$pNode->starParts)
      $pNode->starParts = 2;

    if (isset($attributes['id'])) {
      $id = $this->inpIdPrefix.$attributes['id'];
      $inpName = $name;
    } else {

      $tmp = explode(',', $name);

      if (count($tmp) > 1) {
        $id = $this->inpIdPrefix.$tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id = $this->inpIdPrefix.$tmp[0];
        $inpName = $tmp[0];
      }

      $attributes['id'] = "wgt-input-{$id}";
    }

    $attributes['type'] = 'checkbox';

    if (!isset($attributes['name']))
      $attributes['name'] = $inpName;

    if (!isset($attributes['class']))
      $attributes['class'] = '';

    $codeAttr = Wgt::asmAttributes($attributes);

    $helpIcon = '';
    $helpText = '';
    if ($pNode->helpText) {
       $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" ><i class="fa fa-question-sign" ></i></span> ';
       $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$pNode->helpText.'</div>';
    }


    $html = <<<HTML
    <div id="wgt_box_{$id}" class="box-form-node has-clearfix" >
      <label for="wgt-input-{$id}" class="box-form-node-label">{$helpIcon}{$label}{$pNode->requiredText}</label>
      {$helpText}
      <div id="{$id}" class="wcm wcm_ui_star_rating wgt-input {$pNode->size}" >
HTML;

    $activTitle = '&nbsp;';

    $splitClass = '';
    $splitKey = 'false';
    if (1 < (int) $pNode->starParts) {
      $splitClass = "{split:{$pNode->starParts}}";
      $splitKey = "true";
    }

    foreach ($data as $value => $title) {

      if ($active == $value) {
        $checked = ' checked="checked" ';
        $activTitle = $title;
      } else {
        $checked = '';
      }

      $html .= '<input title="'.$title.'" id="'.$id.'-'.$value.'" onclick="$S(\'div#'.$id.'_text\').text(\''.$title.'\');"'
        .' value="'.$value.'" class="'.$attributes['class'].' wgt_start_rating wgt_ignore '.$splitClass.'"  '
        .$checked.' name="_'.$attributes['name'].'" type="radio"  />'.NL;
    }

    $html .= <<<HTML


    <var id="{$id}-cfg-rating" >{"half":"{$splitKey}"}</var>
    <span id="{$id}_text" class="wgt_rating_text" style="white-space:nowrap;" >{$activTitle}</span>
    <input type="hidden" id="{$id}" class="asgd-{$this->id} wgt_value"  name="{$attributes['name']}" value="{$active}" />
  </div>
</div>



HTML;

    return $this->out($html);

  }//end public function ratingbar */


  /**
   * @param string $label
   * @param string $name
   * @param string $value
   * @param array $attributes
   * @param string $formId
   * @param string $appendText
   * @param string $size
   */
  public function password
  (
    $label,
    $name,
    $value = null,
    $attributes = [],
    $params = null,
    $check = true
  ) {


    $pNode = $this->prepareParams($params);

    if (is_string($attributes)) {
      $size = $attributes;
      $attributes = array();
    }


    if (isset($attributes['id'])) {
      $id = $this->inpIdPrefix.$attributes['id'];
      $inpName = $name;

      $tmp = explode('[', $inpName, 2);

      if (1 == count($tmp))
        $inpNameCheck = $inpName.'_check';
      else
        $inpNameCheck = $tmp[0].'_check['.$tmp[1];

    } else {

      $tmp = explode(',', $name);

      if (count($tmp) > 1) {
        $id = $this->inpIdPrefix.$tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
        $inpNameCheck = $tmp[0]."-check[{$tmp[1]}]";
      } else {
        $id = $this->inpIdPrefix.$tmp[0];
        $inpName = $tmp[0];

        $tmp2 = explode('[', $inpName, 2);

        if (1 == count($tmp2))
          $inpNameCheck = $inpName.'_check';
        else
          $inpNameCheck = $tmp2[0].'_check['.$tmp2[1];
      }

      $attributes['id'] = "wgt-input-{$id}";
    }

    $attributes['type'] = 'password';

    if (!isset($attributes['class']))
      $attributes['class'] = $size;

    if ($this->id)
      $attributes['class']  .= ' asgd-'.$this->id;

    if (!isset($attributes['name']))
      $attributes['name'] = $inpName;

    $attrCheck = $attributes;
    $attrCheck['id'] = $attributes['id'].'-check';
    $attrCheck['name'] = $inpNameCheck;

    $codeAttrCheck = Wgt::asmAttributes($attrCheck);

    $attributes['value'] = str_replace('"', '\"', $value);

    $codeAttr = Wgt::asmAttributes($attributes);

    $helpIcon = '';
    $helpText = '';
    if (is_array($label)) {
       $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" ><i class="fa fa-question-sign" ></i></span> ';
       $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$label[1].'</div>';
       $label = $label[0];
    }

    $html = <<<CODE

<div id="wgt_box_{$id}" class="box-form-node has-clearfix" >
  <label for="wgt-input-{$id}" class="box-form-node-label">{$helpIcon}{$label}{$pNode->requiredText}</label>
  {$helpText}
  <div class="box-form-node-element {$size}" >
    <input {$codeAttr} />{$pNode->appendText}
  </div>
</div>

CODE;

    if ($check) {
      $html .= <<<CODE

<div id="wgt_box_{$id}-check" class="box-form-node-element has-clearfix" >
  <label for="wgt-input-{$id}" class="box-form-node-label">{$helpIcon}{$label} Check{$pNode->requiredText}</label>
  <div class="box-form-node-element {$size}" >
    <input {$codeAttrCheck} />
  </div>
</div>

CODE;

    }

    return $this->out($html);

  }//end public static function password */


  /**
   * @param string $label
   * @param string $name
   * @param string $value
   * @param array $attributes
   * @param array $params
   */
  public function sumField
  (
    $label,
    $name,
    $value = null,
    $attributes = array(),
    $params = null
  )
  {

    $pNode = $this->prepareParams($params);

    if (isset($attributes['id'])) {
      $id = $this->inpIdPrefix.$attributes['id'];
      $inpName = $name;
    } else {

      $tmp = explode(',', $name);

      if (count($tmp) > 1) {
        $id = $this->inpIdPrefix.$tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id = $this->inpIdPrefix.$tmp[0];
        $inpName = $tmp[0];
      }

      $attributes['id'] = "wgt-input-{$id}";
    }

    $attributes['type'] = 'text';

    if (!isset($attributes['class']))
      $attributes['class'] = $pNode->size;

    if ($this->id)
      $attributes['class']  .= ' asgd-'.$this->id;

    if (!isset($attributes['name']))
      $attributes['name'] = $inpName;

    $attributes['value'] = str_replace('"', '\"', $value);

    $codeAttr = Wgt::asmAttributes($attributes);

    $helpIcon = '';
    $helpText = '';
    if ($pNode->helpText) {
      $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" ><i class="fa fa-question-sign" ></i></span> ';
      $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$pNode->helpText.'</div>';
    }

    $html = <<<CODE

<div id="wgt_box_{$id}" class="box-form-node" >
  <label for="wgt-input-{$id}" class="box-form-node-label">{$helpIcon}{$label}{$pNode->requiredText}</label>
  {$helpText}
  <div class="box-form-node-element {$pNode->size}" >
    <input {$codeAttr} />{$pNode->appendText}
  </div>
  <div class="do-clear tiny" ></div>
</div>

CODE;

    return $this->out($html);

  }//end public function input */

  /**
   * @param string $name
   * @param string $value
   * @param string $data
   * @param string $active
   * @param array $attributes
   * @param array $params
   */
  public function selectbox
  (
      $label,
      $name,
      $data,
      $active = null,
      $attributes = [],
      $params = null
  ) {
  
      $pNode = $this->prepareParams($params);
  
      if (isset($attributes['id'])) {
          
          $id = $this->inpIdPrefix.$attributes['id'];
          $inpName = $name;
          
      } else {
  
          $tmp = explode(',', $name);
          $tmpId = str_replace(array('[',']'), array('-',''), $tmp[0]);
  
          if (count($tmp) > 1) {
  
              $id = $this->inpIdPrefix.$tmpId."-".$tmp[1];
              $inpName = $tmp[0]."[{$tmp[1]}]";
          } else {
              $id = $this->inpIdPrefix.$tmpId;
              $inpName = $tmp[0];
          }
  
          $attributes['id'] = "wgt-input-{$id}";
      }
  
      if (!isset($attributes['name'])) {
          $attributes['name'] = $name;
      }
  
      if (!isset($attributes['class'])) {
          $attributes['class'] = 'asgd-'.$this->id;
      } else {
          $attributes['class'] .= ' asgd-'.$this->id;
      }
  
      if ($pNode->inp_only) {
          $attributes['class'] .= ' is-standalone ';
      }

      $selectBoxNode = new WgtSelectbox();
  
  
      if ($pNode->inp_only && !isset($attributes['placeholder'])) {
          $attributes['placeholder'] = $label;
          $selectBoxNode->setFirstFree($label);
      }
  
      $selectBoxNode->addAttributes($attributes);
  
      $selectBoxNode->assignedForm = $this->id;
  
      $selectBoxNode->setActive($active);
  
      $selectBoxNode->setReadonly($pNode->readonly);
      $selectBoxNode->setRequired($pNode->required);
  
      if ($data) {
          $selectBoxNode->setData($data);
      }
  
      $selectBoxNode->setLabel($label);
  
      $selectBoxNode->inpOnly = $pNode->inp_only;
  
      // set an empty first entry
      if (!is_null($pNode->firstFree))
          $selectBoxNode->setFirstFree($pNode->firstFree);
  
      return $this->out($selectBoxNode->build());
  
  }//end public function selectbox */
  

  /**
   * @param string $name
   * @param string $value
   * @param string $elementKey
   * @param string $data
   * @param string $value
   * @param array $attributes
   * @param array $params
   */
  public function selectboxByKey
  (
    $label,
    $name,
    $elementKey,
    $data,
    $value = null,
    $attributes = [],
    $params = null
  ) {

    $pNode = $this->prepareParams($params);

    if (isset($attributes['id'])) {
      $id = $this->inpIdPrefix.$attributes['id'];
      $inpName = $name;
    } else {

      $tmp = explode(',', $name);
      $tmpId = str_replace(array('[',']'), array('-',''), $tmp[0]);

      if (count($tmp) > 1) {

        $id = $this->inpIdPrefix.$tmpId."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id = $this->inpIdPrefix.$tmpId;
        $inpName = $tmp[0];
      }

      $attributes['id'] = "wgt-input-{$id}";
    }

    if (!isset($attributes['name'])) {
    	$attributes['name'] = $name;
    }

    if (!isset($attributes['class'])) {
    	$attributes['class'] = 'asgd-'.$this->id;
    } else {
    	$attributes['class'] .= ' asgd-'.$this->id;
    }
    
    if ($pNode->inp_only) {
        $attributes['class'] .= ' is-standalone ';
    }

    if (!BuizCore::classExists($elementKey))
      return '<!-- Missing '.$elementKey.' -->';

    $selectBoxNode = new $elementKey();


    if ($pNode->inp_only && !isset($attributes['placeholder'])) {
        $attributes['placeholder'] = $label;
        $selectBoxNode->setFirstFree($label);
    }

    $selectBoxNode->addAttributes($attributes);

    $selectBoxNode->assignedForm = $this->id;

    $selectBoxNode->setActive($value);

    $selectBoxNode->setReadonly($pNode->readonly);
    $selectBoxNode->setRequired($pNode->required);

    if ($data) {
        $selectBoxNode->setData($data);
    }

    $selectBoxNode->setLabel($label);

    $selectBoxNode->inpOnly = $pNode->inp_only;
    
    // set an empty first entry
    if (!is_null($pNode->firstFree))
        $selectBoxNode->setFirstFree($pNode->firstFree);

    return $this->out($selectBoxNode->build());

  }//end public function selectboxByKey */

  /**
   * @param string $label
   * @param string $name
   * @param string $elementKey
   * @param string $data
   * @param string $value
   * @param array $attributes
   * @param array $params
   */
  public function multiSelectByKey(
    $label,
    $name,
    $elementKey,
    $data,
    $value = null,
    $attributes = [],
    $params = null
  ) {

    $pNode = $this->prepareParams($params);

    if (!$pNode->exists('firstFree'))
      $pNode->firstFree = ' ';

    if (isset($attributes['id'])) {
          
          $id = $this->inpIdPrefix.$attributes['id'];
          $inpName = $name;
          
      } else {
  
          $tmp = explode(',', $name);
          $tmpId = str_replace(array('[',']'), array('-',''), $tmp[0]);
  
          if (count($tmp) > 1) {
  
              $id = $this->inpIdPrefix.$tmpId."-".$tmp[1];
              $inpName = $tmp[0]."[{$tmp[1]}]";
          } else {
              $id = $this->inpIdPrefix.$tmpId;
              $inpName = $tmp[0];
          }
  
          $attributes['id'] = "wgt-input-{$id}";
      }
    
    if ($pNode->inp_only && !isset($attributes['placeholder'])) {
        $attributes['placeholder'] = $label;
    }

    if (!BuizCore::classExists($elementKey))
      return '<!-- Missing '.$elementKey.' -->';

    $selectBoxNode = new $elementKey();

    $selectBoxNode->addAttributes([
        'name' => $name,
        'id' => $id,
        'class' => 'asgd-'.$this->id,
      ]
    );
    $selectBoxNode->setWidth('small');

    $selectBoxNode->assignedForm = $this->id;

    $selectBoxNode->setActive($value);

    //$selectBoxNode->setReadonly($readOnly);
    //$selectBoxNode->setRequired($required);

    $selectBoxNode->setData($data);
    $selectBoxNode->setLabel($label);

    // set an empty first entry
    //if (!is_null($firstFree))
      //$selectBoxNode->setFirstFree($firstFree);
    return $this->out($selectBoxNode->build());

  }//end public function multiSelectByKey */


/*////////////////////////////////////////////////////////////////////////////*/
// title
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $label
   * @param string $nodeKey
   * @param array $labels
   */
  public function i18nLabel($label, $nodeKey, $labels)
  {

    $iconAdd = '<i class="fa fa-plus-circle" ></i>';
    $iconDel = '<i class="fa fa-times-sign" ></i>';

    $addInput = WgtForm::input(
      'Label',
      $this->domainKey.'-label-text',
      '',
      array(
        'name' => 'label[text]',
        'class' => 'medium wgte-text'
      )
    );

    $langSelector = WgtForm::decorateInput(
        'Lang',
        'wgt-select-'.$this->domainKey.'-label-lang',
        <<<HTML
<select
      id="wgt-select-{$this->domainKey}-label-lang"
      name="label[lang]"
      data_source="select_src-{$this->domainKey}-lang"
      class="wcm wcm_widget_selectbox wgte-lang"
        >
        <option>Select a language</option>
    </select>
HTML
    );

    $listLabels = '';

    foreach ($labels as $lang => $label) {
      $listLabels .= '<li class="lang-'.$lang.'" >'. WgtForm::input(
        'Lang '.Wgt::icon('flags/'.$lang.'.png', 'xsmall', [], ''),
        $this->domainKey.'-label-'.$lang,
        $label, array(
          'name' => $nodeKey.'[label]['.$lang.']',
          'class' => 'medium lang-'.$lang
        ),
        $this->id,
        '<button class="wgt-button wgta-drop" wgt_lang="'.$lang.'" tabindex="-1" >'.$iconDel.'</button>'
      ).'</li>';
    }

    $html = <<<CODE
<fieldset class="wgt-space bw61" >
  <legend>{$label}</legend>

  <div id="wgt-i18n-list-{$this->domainKey}-label" class="wcm wcm_widget_i18n-input-list bw6" >

  <div class="left bw3" >
    {$addInput}
    {$langSelector}

    <button class="wgt-button wgta-append" tabindex="-1" ><i class="fa fa-plus-circle" ></i> Add Language</button>
  </div>

  <div class="right bw3" >
    <ul class="wgte-list"  >
    {$listLabels}
    </ul>
  </div>

  <var id="wgt-i18n-list-{$this->domainKey}-label-cfg-i18n-input-list" >
  {
    "key":"{$this->domainKey}-label",
    "inp_prefix":"{$nodeKey}[label]",
    "form_id":"{$this->id}"
  }
  </var>

  </div>

</fieldset>
CODE;

    return $this->out($html);

  }//end public function i18nLabel */

  /**
   * @param string $label
   * @param string $nodeKey
   * @param array $labels
   */
  public function i18nText($label, $nodeKey, $texts)
  {

    $iconAdd = '<i class="fa fa-plus-circle" ></i>';
    $iconDel = '<i class="fa fa-times-sign" ></i>';

    $i18nTexts = '';

    foreach ($texts as $lang => $text) {

      $innerWysiwyg = $this->wysiwyg(
        $lang,
        $this->domainKey.'-'.$nodeKey.'-'.$lang,
        $text,
        array(
          'name' => $nodeKey.'['.$lang.']'
         ),
        $this->id,
        null,
        true,
        true
      );

      $i18nTexts .= <<<HTML
    <div
      id="wgt-tab-{$this->domainKey}-{$nodeKey}-{$lang}"
      title="{$lang}" wgt_icon="xsmall/flags/{$lang}.png"
      class="wgt_tab wgt-tab-{$this->domainKey}_{$nodeKey}">
      <fieldset id="wgt-fieldset-{$this->domainKey}-{$nodeKey}-{$lang}"  class="wgt-space bw6 lang-{$lang}"  >
        <legend>Lang {$lang}</legend>
        {$innerWysiwyg}
      </fieldset>
    </div>
HTML;

    }


    $html = <<<CODE
<div
  id="wgt-tab-{$this->domainKey}_{$nodeKey}"
  class="wcm wcm_ui_tab wcm_widget_i18n-input-tab wgt-space wgt-border ui-corner-top bw62"  >
  <div id="wgt-tab-{$this->domainKey}_{$nodeKey}-head" class="wgt_tab_head ui-corner-top" >

    <div class="wgt-container-controls">
      <div class="wgt-container-buttons" >
        <h2 style="width:120px;float:left;text-align:left;" >{$label}</h2>
      </div>
      <div class="tab_outer_container">
        <div class="tab_scroll" >
          <div class="tab_container"></div>
        </div>
     </div>
    </div>
  </div>

  <div id="wgt-tab-{$this->domainKey}_{$nodeKey}-body" class="wgt_tab_body" >
{$i18nTexts}
  </div>

  <div class="wgt-panel" >
    <select
      id="wgt-select-{$this->domainKey}-new-lang"
      name="{$nodeKey}[lang]"
      data_source="select_src-{$this->domainKey}-lang"
      class="wcm wcm_widget_selectbox wgte-lang" >
      <option>Select a language</option>
    </select>

    <button class="wgt-button wgta-append" tabindex="-1" ><i class="fa fa-plus-circle" ></i> Add Language</button>
  </div>

  <div class="do-clear xxsmall" ></div>

  <var id="wgt-tab-{$this->domainKey}_{$nodeKey}-cfg-i18n-input-tab" >
  {
    "key":"{$this->domainKey}-{$nodeKey}",
    "inp_prefix":"{$nodeKey}",
    "form_id":"{$this->id}",
    "tab_id":"wgt-tab-{$this->domainKey}_{$nodeKey}"
  }
  </var>

</div>
CODE;

    return $this->out($html);

  }//end public function i18nText */

  /**
   *
   */
  public function i18nSelectSrc()
  {

    $langCode = array('{"i":"0","v":"Select a language"}');

    if ($this->i18nLanguages) {
      foreach ($this->i18nLanguages as $lang) {
        $langCode[] = '{"i":"'.$lang['id'].'","v":'.json_encode($lang['value']).'}';
      }
    }

    $langCode = implode(','.NL, $langCode  );

    $html = <<<HTML
    <var id="select_src-{$this->domainKey}-lang" >
    [
    {$langCode}
    ]
    </var>
HTML;

    return $this->out($html);

  }//end public function i18nSelectSrc */

/*////////////////////////////////////////////////////////////////////////////*/
// title
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $label
   * @return string
   */
  public function submit($label, $appendCode = null, $icon = null)
  {

    $codeIcon = '';

    if ($icon)
      $codeIcon = $this->view->icon($icon, $label).' ';
    
    $jsCode = '';
    
    if (!is_null($appendCode)) {
        
        if(false === $appendCode){
            $jsCode = '';
        } else {
            $jsCode = <<<CODE
onclick="\$R.form('{$this->id}');{$appendCode}"
CODE;
        }
        
    } else {
        $jsCode = <<<CODE
onclick="\$R.form('{$this->id}');{$appendCode}"
CODE;
    }
    


    $html = <<<CODE

<button 
    class="wgt-button bcs-d-submit" 
    id="wgt-button-{$this->inpIdPrefix}-submit"
    tabindex="-1" 
    {$jsCode}  >{$codeIcon}{$label}</button>

CODE;

    return $this->out($html);

  }//end public function input */
  
  /**
   * @param string $label
   * @return string
   */
  public function reset($label, $appendCode = null, $icon = null)
  {
  
      $codeIcon = '';
  
      if ($icon)
          $codeIcon = '<i class="'.$icon.'" ></i> ';
  
      $html = <<<CODE
  
<button
    class="wgt-button bcs-d-warn" tabindex="-1"
    onclick="\$D.resetForm('{$this->id}');{$appendCode}"  >{$codeIcon}{$label}</button>
  
CODE;
  
      return $this->out($html);
  
  }//end public function input */

  /**
   * @param array $params
   * @param string $size
   * @param string $appendText
   */
  public function prepareParams(
    $params,
    $size = 'medium',
    $appendText = ''
  ) {

    if (is_array($params)) {
      $pNode = new TFlag($params);
    } elseif (is_object($params)) {
      $pNode = $params;
    } else {
      $pNode = clone $this->defParams;
    }

    if (!$pNode->size)
      $pNode->size = $size;
    
    if (!$pNode->inp_type)
        $pNode->inp_type = 'text';

    if ($pNode->required)
      $pNode->requiredText = ' <span class="wgt-required" >*</span>';

    if (!$pNode->appendText)
      $pNode->appendText = $appendText;

    return $pNode;

  }//end public function prepareParams */

}//end class WgtFormBuilder
