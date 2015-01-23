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
 * class WgtItemInput
 * Objekt zum generieren einer Inputbox
 * @package net.buizcore.wgt
 */
class WgtInputCheckbox extends WgtInput
{
/*////////////////////////////////////////////////////////////////////////////*/
// Getter and Setter
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string
   */
  public function setActive($activ = true)
  {

    if ($activ) {
      $this->attributes['checked'] = "checked";
    } else {
      if (isset($this->attributes['checked'])) {
        unset($this->attributes['checked']);
      }
    }

  }//end public function setActive */

/*////////////////////////////////////////////////////////////////////////////*/
// Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param array
   * @return string
   */
  public function build($attributes = array())
  {

    if ($this->renderMode && method_exists($this, 'render'.$this->renderMode)) {
        return $this->{'render'.$this->renderMode}($attributes);
    }
    
    if (!$this->renderInput) {
    
        return $this->render_show($attributes);
    } 
    
    return $this->render_default($attributes);

  }//end public function build */
  
  /**
   * @param array $attributes
   * @return string
   */
  public function render_default($attributes = array())
  {
      
      if ($attributes)
          $this->attributes = array_merge($this->attributes,$attributes);
      
      // ist immer ein text attribute
      $this->attributes['type'] = 'checkbox';
      
      $id = $this->getId();
      
      $required = $this->required?'<span class="wgt-required">*</span>':'';
      $helpIcon = $this->renderDocu($id);
      
      $styleHidden = '';
      if ($this->isHidden) {
          $styleHidden = ' style="display:none;" ';
      }
      
      $boxClasses = implode(' ',$this->boxClasses);
      
      $html = <<<HTML
    <div class="wgt-box input has-clearfix {$boxClasses}" id="wgt-box-{$id}" >
      {$this->texts->topBox}
      <div class="wgt-label" ><label
        for="{$id}" >{$this->texts->beforeLabel}{$this->label}{$this->texts->afterLabel} {$required}{$this->texts->endLabel}
      </label>{$helpIcon}</div>
      {$this->texts->middleBox}
      <div class="wgt-input {$this->width}" >{$this->texts->beforInput}{$this->element()}{$this->texts->afterInput}</div>
      {$this->texts->bottomBox}
    </div>
      
HTML;
      
      return $html;
      
  }//end public function render_default */
  
  /**
   * @param array $attributes
   * @return string
   */
  public function render_show($attributes = array())
  {
      
      if ($attributes)
          $this->attributes = array_merge($this->attributes,$attributes);
      
      // ist immer ein text attribute
      $this->attributes['type'] = 'checkbox';
      
      $id = $this->getId();
      
      $required = $this->required?'<span class="wgt-required">*</span>':'';
      $helpIcon = $this->renderDocu($id);
      
      $styleHidden = '';
      if ($this->isHidden) {
          $styleHidden = ' style="display:none;" ';
      }
      
      $boxClasses = implode(' ',$this->boxClasses);
      
      $html = <<<HTML
    <div class="wgt-box kv {$boxClasses}" id="wgt-box-{$id}" {$styleHidden} >
      {$this->texts->topBox}
      <label
        for="{$id}" >{$this->texts->beforeLabel}{$this->label} {$this->texts->afterLabel}
      </label>
      {$this->texts->middleBox}
      <div>{$this->texts->beforInput}{$this->element()}{$this->texts->afterInput}</div>
      {$this->texts->bottomBox}
      <div class="do-clear tiny" >&nbsp;</div>
    </div>
    <div class="do-clear tiny" >&nbsp;</div>
    
HTML;
    
      return $html;
      
  }//end public function render_show */
  
  /**
   * @param array $attributes
   * @return string
   */
  public function render_cluster($attributes = array())
  {
  
      if ($attributes)
          $this->attributes = array_merge($this->attributes,$attributes);
      
      // ist immer ein text attribute
      $this->attributes['type'] = 'checkbox';
      
      $id = $this->getId();
      
      $required = $this->required?'<span class="wgt-required">*</span>':'';
      $helpIcon = $this->renderDocu($id);
      
      $styleHidden = '';
      if ($this->isHidden) {
          $styleHidden = ' style="display:none;" ';
      }
      
      $boxClasses = implode(' ',$this->boxClasses);
      
      $html = <<<HTML
    <div id="wgt-box-{$id}" {$styleHidden} >
      <div class="wgt-label" ><label
        for="{$id}" >{$this->texts->beforeLabel}{$this->label}{$this->texts->afterLabel} {$required}{$this->texts->endLabel}
      </label>{$helpIcon}</div>
      <div class="wgt-input" >{$this->element()}</div>
      <div class="do-clear tiny" >&nbsp;</div>
    </div>
      
HTML;
      
      return $html;
      
  }//end public function render_cluster
  
  /**
   * @param array $attributes
   * @return string
   */
  public function element($attributes = array())
  {
  
      if ($this->renderInput) {
  
          return '<input '.$this->asmAttributes($attributes).' />';
          
      } else {
  
          if (!isset($this->attributes['value'])) {
              $this->attributes['value'] = '';
          }
  
          return '<span> '.(isset($this->attributes['checked'])?'<i class="fa fa-check-square-o" ></i>':'<i class="fa fa-square-o" ></i>') .'</span>';
      }
  
  } // end public function element */

}//end class WgtInputCheckbox

