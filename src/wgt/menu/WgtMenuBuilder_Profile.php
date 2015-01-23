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
 * @package net.webfrap.wgt
 */
class WgtMenuBuilder_Profile
{
/*////////////////////////////////////////////////////////////////////////////*/
// attributes
/*////////////////////////////////////////////////////////////////////////////*/

  public $data = array();


  public function render()
  {

    $html = '';

    foreach ($this->data as $entry) {
      $html .= <<<HTML
<li>
  <a href="{$entry['http_url']}" class="wcm wcm_req_ajax" >
    <i class="{$entry['icon']}" ></i> {$entry['label']}
  </a>
</li>
HTML;
    }

    return $html;

  }

} // end class WgtMenuBuilder_Profile

