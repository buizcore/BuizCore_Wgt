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
class WgtButton
{
/*////////////////////////////////////////////////////////////////////////////*/
// Constantes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * de:
   * type des buttons
   * @var unknown_type
   */
  const TYPE = 0;

/*////////////////////////////////////////////////////////////////////////////*/
// attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var string
   */
  public $type;

  /**
   *
   * @var string
   */
  public $name;

  /**
   *
   * @var string
   */
  public $text;

  /**
   *
   * @var string
   */
  public $class;

  /**
   *
   * @var string
   */
  public $icon;

  /**
   *
   * @var string
   */
  public $action;

/*////////////////////////////////////////////////////////////////////////////*/
// methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function build()
  {

    $class = $this->class
      ? ' class="'.$this->class.'" '
      : '';

    $icon = $this->icon
      ? ' icon="'.$this->icon.'" '
      : '';

    $type = $this->type
      ? ' type="'.$this->type.'" '
      : ' type="button" ';

    return '<button '.$type.$icon.$class.' >'.$this->text.'</button>';

  }//end public function build */

  /**
   * @return string
   * /
  public function buildSubwindow()
  {

    $class = $this->class
      ? ' class="'.$this->class.'" '
      : '';

    $icon = $this->icon
      ? ' icon="'.$this->icon.'" '
      : '';

    $type = $this->type
      ? ' type="'.$this->type.'" '
      : ' type="button" ';

    return '<button '.$type.$icon.$class.' >'.$this->text.'</button>';

  }//end public function build */

  /**
   * @return string
   */
  public function buildMaintab()
  {

    $class = $this->class
      ? ' class="wgt-button '.$this->class.'" '
      : ' class="wgt-button" ';

    $icon = $this->icon
      ? Wgt::icon($this->icon, 'xsmall', $this->text)
      : '';

    return '<button '.$class.' tabindex="-1" >'.$icon.$this->text.'</button>';

  }//end public function buildMaintab */

  /**
   * @return string
   */
  public function buildAction()
  {

    $class = $this->class
      ? ' class="wgt-button '.$this->class.'" '
      : ' class="wgt-button" ';

    $icon = $this->icon
      ? Wgt::icon($this->icon, 'xsmall', $this->text)
      : '';

    return '<button '.$class.' tabindex="-1" >'.$icon.'</button>';

  }//end public function buildAction */

}// end class WgtButton

