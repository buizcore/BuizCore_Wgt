<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore.com <contact@buizcore.com>
* @project     : BuizCore platform
* @projectUrl  : http://buizcore.com
*
* @licence     : BuizCore.com internal only
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * @package com.buizcore
 * @author Dominik Bonsch <d.bonsch@buizcore.com>
 */
class LibRcs
{

  /**
   *
   * @var LibSystemProcess
   */
  public $exec = null;

  /**
   * @return LibSystemProcess
   */
  public function getExec()
  {
    if (!$this->exec)
      $this->exec = new LibSystemProcess();

    return $this->exec;

  }//end public function getExec */

} // end class LibRcs

