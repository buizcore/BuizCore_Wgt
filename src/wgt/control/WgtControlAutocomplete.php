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
 */
class WgtControllAutcomplete
{
/*////////////////////////////////////////////////////////////////////////////*/
// attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Das Label des Autocomplete Elements
   * @var string
   */
  public $label = null;

  /**
   * Type des Autocomplete Controll Elements
   * Standard ist data
   *
   * @var string
   */
  public $type = 'data';

  /**
   * Size des Inputelements
   * @var string
   */
  public $size = 'medium';

  /**
   * Die Adresse des Services für den Autocomplete Call
   * @var string
   */
  public $service = null;

  /**
   * Die ID des Formulars bei der die Callback Action hinterlegt ist
   * @var string
   */
  public $formId = null;

  /**
   * Name des Inputelements, für den Fall, dass ein
   * @var string
   */
  public $inputName = null;

  /**
   * Die HTML ID des Controll Elements
   * @var string
   */
  public $id;

  /**
   * Icon des Button Elelements
   * @var string
   */
  public $icon;

  /**
   * Target Link / Action für den Button
   * @var string
   */
  public $buttonTarget;

/*////////////////////////////////////////////////////////////////////////////*/
// methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function render()
  {

    $button = null;
    if ($this->buttonTarget) {

      $icon = null;
      if ($this->icon) {
        $icon = '<i class="'.$this->icon.'" ></i>';
      }

      $button = <<<BUTTON
      <button
        id="{$this->id}-button"
        class="wgt-button append-inp"
        tabindex="-1"
        onclick="\$R.get('{$this->buttonTarget}');return false;"    >
        {$icon}
      </button>

BUTTON;

    }

    $input = null;
    if ($this->inputName) {

      $input = <<<BUTTON
      <input
        type="text"
        id="{$this->id}"
        name="{$this->inputName}"
        class="meta valid_required"  />

BUTTON;

    }

    $html = <<<HTML

    <div class="inline" style="margin-right:10px;" >
      <span>{$this->label}&nbsp;</span>
      <input
        type="text"
        id="{$this->id}-tostring"
        name="key"
        class="{$this->size} wcm wcm_ui_autocomplete wgt-ignore"  />
      <var class="wgt-settings" >
        {
          "url":"{$this->service}&amp;key=",
          "type":"{$this->type}",
          "formid":"{$this->formId}"
        }
      </var>
{$input}
{$button}
     </div>

HTML;

    return $html;

  }//end public function render */

}// end class WgtControllAutcomplete

