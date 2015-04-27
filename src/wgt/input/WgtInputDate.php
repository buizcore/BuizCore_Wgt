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
 *
 * @package net.buizcore.wgt
 */
class WgtInputDate extends WgtInput
{

    /**
     * @var string die id für das Start feld
     */
    public $isEndFor = null;
    
    /**
     * @var string die id für das End feld
     */
    public $isStartFor = null;
    
    /**
     * @var int Die Anzahl Monate die angezeigt werden sollen (am besten irgendetwas zwischen 1 und 3)
     */
    public $numMonth = 1;

    /**
     * @var Die Range der Jahre
     */
    public $yearRange = null;
    
  /**
   * @param array $attributes
   * @return string
   */
  public function build($attributes = array())
  {

    $id = $this->getId();

    if ($attributes) {
      $this->attributes = array_merge($this->attributes,$attributes);
    }

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
        
        
        
        
        $settings = [];
        $settings["button"] = "{$id}-ap-button";
        
        if ($this->isStartFor) {
            $settings["min_field_for"] = $this->isStartFor;
        }
        
        if ($this->isEndFor) {
            $settings["max_field_for"] = $this->isEndFor;
        }
        
        $jsonSettings = json_encode($settings);
        
        
        return <<<HTML
      <input {$this->asmAttributes($attributes)} />
        <var>{$jsonSettings}</var>
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

