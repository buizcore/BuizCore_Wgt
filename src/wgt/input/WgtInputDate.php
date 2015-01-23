<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
* @date        :
* @copyright   : Webfrap Developer Network <contact@webfrap.net>
* @project     : Webfrap Web Frame Application
* @projectUrl  : http://webfrap.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 *
 * @package net.webfrap.wgt
 */
class WgtInputDate extends WgtInput
{

  /**
   * @param array $attributes
   * @return string
   */
  public function build($attributes = array())
  {

    $id = $this->getId();

    if ($attributes)
      $this->attributes = array_merge($this->attributes,$attributes);

    // add the date validator for datepicker
    if (!isset($this->attributes['class'])) {
      $this->classes['wcm'] = 'wcm';
      $this->classes['wcm_ui_date'] = 'wcm_ui_date';
      $this->classes['ar'] = 'ar';
      $this->classes['has-button'] = 'has-button';
    } else {
      $this->classes['wcm'] = 'wcm';
      $this->classes['wcm_ui_date'] = 'wcm_ui_date';
      $this->classes['ar'] = 'ar';
      $this->classes['has-button'] = 'has-button';
    }



    return parent::build();

  } // end public function build */
  
  
  /**
   * @param array $attributes
   * @return string
   */
  public function element($attributes = array())
  {
      
      
    if ($this->renderInput) {
        $id = $this->getId();
        
        // add the date validator for datepicker
        if (!isset($this->attributes['class'])) {
            $this->classes['wcm'] = 'wcm';
            $this->classes['wcm_ui_date'] = 'wcm_ui_date';
            $this->classes['ar'] = 'ar';
            $this->classes['has-button'] = 'has-button';
        } else {
            $this->classes['wcm'] = 'wcm';
            $this->classes['wcm_ui_date'] = 'wcm_ui_date';
            $this->classes['ar'] = 'ar';
            $this->classes['has-button'] = 'has-button';
        }
        
        return <<<HTML
      <input {$this->asmAttributes($attributes)} />
        <var>{"button":"{$id}-ap-button"}</var>
        <button
          id="{$id}-ap-button"
          class="wgt-button append-inp"
          tabindex="-1"  >
          <i class="fa fa-calendar" ></i>
        </button>
HTML;
        
    } else {
        
        if(!isset($this->attributes['value'])){
            $this->attributes['value'] = '';
        }
        
        return '<span> '.$this->attributes['value'].'</span>';
    }
      

      
  }// end public function element */

} // end class WgtInputDate

