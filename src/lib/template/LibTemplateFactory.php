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
class LibTemplateFactory
{

  /**
   *
   */
  public function item($className, $key)
  {

    if (!BuizCore::classExists($className)) {
      throw new WgtItemNotFound_Exception('Class '.$className.' was not found');
    } else {

      $object = new $className($key);
      $object->view = $this; // add back reference to the owning view
      $object->i18n = $this->i18n;

      $this->object->content[$key] = $object;

      if (DEBUG)
        Debug::console('Created Item: '.$className .' key: '.$key);

      return $object;
    }

  }

} // end class LibTemplateAjax */

