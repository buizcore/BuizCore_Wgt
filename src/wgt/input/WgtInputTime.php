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
class WgtInputTime extends WgtInput
{

  public $size = 'small';

  /**
   * @param array $attributes
   * @return unknown_type
   */
  public function build($attributes = array())
  {

    if ($attributes)
      $this->attributes = array_merge($this->attributes,$attributes);

    // ist immer ein text attribute
    $this->attributes['type']= 'text';

    // add the date validator for datepicker
    if (!isset($this->attributes['class'])) {
      $this->classes['wcm'] = 'wcm';
      $this->classes['wcm_ui_timepicker'] = 'wcm_ui_timepicker';
      $this->classes['valid_time'] = 'valid_time';
      $this->classes['ar'] = 'ar';
      $this->classes['has-button'] = 'has-button';
    } else {
      $this->classes['wcm'] = 'wcm';
      $this->classes['wcm_ui_timepicker'] = 'wcm_ui_timepicker';
      $this->classes['valid_time'] = 'valid_time';
      $this->classes['ar'] = 'ar';
      $this->classes['has-button'] = 'has-button';
    }

    $icon = View::$iconsWeb;

    $id = $this->getId();

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
                $this->classes['wcm_ui_timepicker'] = 'wcm_ui_timepicker';
                $this->classes['valid_time'] = 'valid_time';
                $this->classes['ar'] = 'ar';
                $this->classes['has-button'] = 'has-button';
            } else {
                $this->classes['wcm'] = 'wcm';
                $this->classes['wcm_ui_timepicker'] = 'wcm_ui_timepicker';
                $this->classes['valid_time'] = 'valid_time';
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
          <i class="fa fa-clock-o" ></i>
        </button>
HTML;
  
      } else {
  
          if(!isset($this->attributes['value'])){
              $this->attributes['value'] = '';
          }
  
          return '<span> '.$this->attributes['value'].'</span>';
      }
  
  
  
  }// end public function element */

  /**
   * Parser for the input field
   *
   * @return String
   */
  public function buildAjaxArea()
  {

    if (!isset($this->attributes['id']))
      return '';

    if (!isset($this->attributes['value']))
      $this->attributes['value'] = '';

    $html = '<htmlArea selector="input#'.$this->attributes['id'].'" action="value" ><![CDATA['
      .$this->attributes['value'].']]></htmlArea>'.NL;

    return $html;

  } // end public function buildAjaxArea */

} // end class WgtInputTime

