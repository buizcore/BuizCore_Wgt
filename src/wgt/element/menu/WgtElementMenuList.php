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
class WgtElementMenuList extends WgtElementMenu
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

    $html = '<ul class="wgt-menu list wgt-space" >'.NL;

    if (isset($this->data->firstEntry) && $this->data->firstEntry) {
      $html .= $this->renderListEntry($this->data->firstEntry);
    }

    $pos = 0;

    // Generieren der Rows
    foreach ($folders as $entry) {
      $html .= $this->renderListEntry($entry, '&amp;mtype=list');
    }

    foreach ($files as $entry) {
      $html .= $this->renderListEntry($entry);
    }

    $html .= '</li>'.NL;

    $this->html = $html;

    return $html;

  } // end  public function build */

  /**
   * @param array $pic
   * @param string $append
   * @return
   */
  protected function renderListEntry($pic, $append = '')
  {

    if ($pic[WgtMenu::ICON] != '' || trim($pic[WgtMenu::TEXT]) != '') {

      $text = trim($pic[WgtMenu::TEXT]) != '' ? $pic[WgtMenu::TEXT].'<br />' : '';

      if (Wgt::ACTION == $pic[WgtMenu::TYPE]) {
        $link = $text.'<img class="icon xsmall cursor" '.
                    ' src="'.$this->baseFolder.$pic[WgtMenu::ICON].'" '.
                    ' onclick="'.$pic[WgtMenu::ACTION].'" '.
                    ' alt="'.$pic[WgtMenu::TITLE].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" />';
      } elseif (Wgt::URL == $pic[WgtMenu::TYPE]) {
        $icon = '<img class="icon xsmall" '.
                    ' src="'.$this->baseFolder.$pic[WgtMenu::ICON].'" '.
                    ' alt="'.$pic[WgtMenu::TITLE].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" />';

        $link = '<a  href="'.$pic[WgtMenu::ACTION].$append.'" >'.$icon.'<span>'.$text.'</span></a>';
      } elseif (Wgt::AJAX == $pic[WgtMenu::TYPE]) {
        $icon = '<img class="icon xsmall" '.
                    ' src="'.$this->baseFolder.$pic[WgtMenu::ICON].'" '.
                    ' alt="'.$pic[WgtMenu::TITLE].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" />';

        $link = '<a class="wcm wcm_req_ajax"  href="'.$pic[WgtMenu::ACTION].$append.'" >'.$icon.'<span>'.$text.'</span></a>';
      } elseif (Wgt::WINDOW == $pic[WgtMenu::TYPE]) {
        $icon = '<img class="icon xsmall" '.
                    ' src="'.$this->baseFolder.$pic[WgtMenu::ICON].'" '.
                    ' alt="'.$pic[WgtMenu::TITLE].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" />';

        $link = '<a class="wcm wcm_req_ajax"  href="'.$pic[WgtMenu::ACTION].$append.'" >'.$icon.'<span>'.$text.'</span></a>';
      } else {
        $icon = '<img class="icon xsmall" '.
                    ' src="'.$this->baseFolder.$pic[WgtMenu::ICON].'" '.
                    ' alt="'.$pic[WgtMenu::TITLE].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" />';

        $link = '<a class="wcm wcm_req_ajax"  href="'.$pic[WgtMenu::ACTION].$append.'" >'.$icon.'<span>'.$text.'</span></a>';
      }

    } else {
      $link =  '&nbsp;';
    }

    return '<li>'.$link.'</li>'.NL;

  }//end protected function renderListEntry */

} // end class WgtElementMenuList

