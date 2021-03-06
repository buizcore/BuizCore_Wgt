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
class WgtElementMenuExplorer extends WgtElementMenu
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var int
   */
  const DEF_ROWS = 8;

/*////////////////////////////////////////////////////////////////////////////*/
// Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @return string
   */
  public function build()
  {

    $this->baseFolder = View::$iconsWeb.'/medium/';

    if ($this->sort) {

      $folders = array();
      $files = array();

      if (isset($this->data->folders) && $this->data->folders) {
        foreach ($this->data->folders as $entry) {
          $folders[$entry[2]] = $entry;
        }
        ksort($folders);
      }

      if (isset($this->data->files) && $this->data->files) {
        foreach ($this->data->files as $entry) {
          $files[$entry[2]] = $entry;
        }
        ksort($files);
      }

    } else {

      $folders = isset($this->data->folders)
        ? $this->data->folders
        : array();

      $files = isset($this->data->files)
        ? $this->data->files
        : array();
    }

    $html = '<div class="wgt-menu folder" >'.NL;

    if (isset($this->data->firstEntry) && $this->data->firstEntry) {
      $html .= $this->renderListEntry($this->data->firstEntry);
    }

    $pos = 0;

    // Generieren der Rows
    foreach ($folders as $entry) {
      $html .= $this->renderListEntry($entry);
    }

    foreach ($files as $entry) {
      $html .= $this->renderListEntry($entry);
    }

    $html .= '</div>'.NL;

    $this->html = $html;

    return $html;

  } // end  public function build */

  /**
   *
   * @return
   */
  protected function renderListEntry($pic, $append = '')
  {

    if ($pic[WgtMenu::ICON] != '' || trim($pic[WgtMenu::TEXT]) != '') {

      $text = trim($pic[WgtMenu::TEXT]) != '' ? $pic[WgtMenu::TEXT].'<br />' : '';

      if (Wgt::ACTION == $pic[WgtMenu::TYPE]) {
        $link = $text.'<i class="'.$pic[WgtMenu::ICON].' fa-3x cursor" '.
                    ' onclick="'.$pic[WgtMenu::ACTION].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" ></i>';
      } elseif (Wgt::URL == $pic[WgtMenu::TYPE]) {
        $icon = '<i class="'.$pic[WgtMenu::ICON].' fa-3x cursor" '.
                    ' onclick="'.$pic[WgtMenu::ACTION].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" ></i>';

        $link = '<a style="border:0px;" href="'.$pic[WgtMenu::ACTION].'" >'.$icon.'<p>'.$text.'</p></a>';
      } elseif (Wgt::AJAX == $pic[WgtMenu::TYPE]) {
        $icon = '<i class="'.$pic[WgtMenu::ICON].' fa-3x cursor" '.
                    ' onclick="'.$pic[WgtMenu::ACTION].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" ></i>';

        $link = '<a class="wcm wcm_req_ajax" style="border:0px;" href="'.$pic[WgtMenu::ACTION].'" >'.$icon.'<p>'.$text.'</p></a>';
      } elseif (Wgt::WINDOW == $pic[WgtMenu::TYPE]) {
        $icon = '<i class="'.$pic[WgtMenu::ICON].' fa-3x cursor" '.
                    ' onclick="'.$pic[WgtMenu::ACTION].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" ></i>';

        $link = '<a class="wcm wcm_req_ajax" style="border:0px;" href="'.$pic[WgtMenu::ACTION].'" >'.$icon.'<p>'.$text.'</p></a>';
      } else {
        $icon = '<i class="'.$pic[WgtMenu::ICON].' fa-3x cursor" '.
                    ' onclick="'.$pic[WgtMenu::ACTION].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" ></i>';

        $link = '<a class="wcm wcm_req_ajax" style="border:0px;" href="'.$pic[WgtMenu::ACTION].'" >'.$icon.'<p>'.$text.'</p></a>';
      }

    } else {
      $link =  '&nbsp;';
    }

    return '<div class="wgt-entry" >'.$link.'<div class="" > </div></div>'.NL;

  }//end protected function renderListEntry */

} // end class WgtElementMenuExplorer

