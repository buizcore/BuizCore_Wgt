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
 * A Menu that looks like a filesystem folder
 *
 * @package net.buizcore.wgt
 */
class WgtControlCrumb
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  public $crumbs = array();

  /**
   * @var string
   */
  public $style = '';

  /**
   * Die Id des Parent Menus
   * @var string
   */
  public $parentMask = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtMenu#setData()
   */
  public function setData($data)
  {
    $this->data = $data;
  }//end public function setData */

  /**
   * @param array $crumb
   */
  public function addCrumb($crumb)
  {

    $this->data[] = $crumb;

  }//end public function addCrumb */

  /**
   * @param array $crumbs
   */
  public function setCrumbs($crumbs)
  {

    $this->data = $crumbs;

  }//end public function setCrumbs */

  /**
   * @param array $paths
   * @param string $url
   */
  public function setPathCrumb($paths, $url)
  {

    $this->data = array();

    foreach ($paths as $path => $label) {
      $this->data[] = array(
        $label,
        $url.$path,
        ''
      );
    }

  }//end public function setPathCrumb */

  /**
   * @return string
   */
  public function buildCrumbs()
  {

    $html = '<ul class="wcm wcm_crumb_menu wgt-menu crumb inline" style="'.$this->style.'" >';

    if ($this->parentMask) {
      $html .= '<li class="parent" parent="'.$this->parentMask.'" ></li>';
    }

    $entries = array();
    $i = 0;

    foreach ($this->data as $crumb) {

      $text = $crumb[0];
      $url = $crumb[1];
      $src = $crumb[2];
      $class = isset($crumb[3])?' '.$crumb[3]:'';
      $tab = isset($crumb[4])?$crumb[4]:'';
      $liClass = isset($crumb[5])?$crumb[5]:'';
      $icon = '';

      if ('' != trim($src)) {
        $icon = '<i class="'.$src.'" ></i> ';
      }

      if ($i == count($this->data) - 1) {
        $entries[] = '<li class="'.$liClass.'" ><a class="'.$class.'" href="'.$url.'" tab="'.$tab.'" >'.$icon.$text.'</a></li>';
      } else {
        $entries[] = '<li class="'.$liClass.'" ><a class="'.$class.'" href="'.$url.'" tab="'.$tab.'" >'.$icon.$text.'</a>&nbsp;&nbsp;/&nbsp;</li>';
      }

      $i++;
    }

    $html .= implode(NL, $entries);

    $html .= '</ul>';

    return $html;

  }//end public function buildCrumbs

} // end class WgtControlCrumb

