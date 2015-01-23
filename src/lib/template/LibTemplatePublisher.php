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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 */
abstract class LibTemplatePublisher extends LibTemplate
{

  /**
   * @var array
   */
  protected $cookies = array();

  /**
   * de:
   * Dropmenu builder für die Maintab, Subwindow etc View Elemente
   * @var WgtDropmenu
   */
  public $menu = null;

  /**
   * Main Context id
   * @var string
   */
  public $mainContext = null;
  
/*////////////////////////////////////////////////////////////////////////////*/
// Getter and Setter Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * (non-PHPdoc)
   * @see src/lib/LibTemplate::setModel()
   */
  public function setModel($model)
  {
    $this->model = $model;
  }//end public function setModel */

/*////////////////////////////////////////////////////////////////////////////*/
// small html helper methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * request an icon
   * @param string $name
   * @param string $alt
   * @return string
   */
  public function icon($name , $alt)
  {
    return Wgt::icon($name, 'xsmall', $alt);
  }//end public function icon */

  /**
   *
   * @param string $active
   * @param string $value
   */
  public function isChecked($active , $value)
  {
    return $active === $value? ' checked="checked" ':'';
  }
  
  /**
   * request an icon
   * @param string $name
   * @param string $alt
   * @return string
   */
  public function htmlSafe($content)
  {
      return htmlentities($content, ENT_QUOTES, 'utf-8');
  }//end public function htmlSafe */
  

  /**
   *
   * @param string $active
   * @param string $value
   */
  public function isSelected($active , $value)
  {
    return $active === $value? ' selected="selected" ':'';
  }


  /**
   * @param string $active
   * @param string $value
   */
  public function isActive($active, $value)
  {
    return $active === $value? ' wgt-active ':'';
  }//end public function isActive
  
  /**
   *
   * @param string $pre
   * @param string $post
   */
  public function contextId($pre, $post = null, $out = true)
  {
      if ($out) {
        echo $pre.'-'.$this->mainContext.($post?'-'.$post:'');
      } else {
        return $pre.'-'.$this->mainContext.($post?'-'.$post:'');
      }
      
  }//end public function contextId


} // end class LibTemplateHtml

