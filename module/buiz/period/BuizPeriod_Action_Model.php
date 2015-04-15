<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore, The core business application plattform
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
class BuizPeriod_Action_Model extends MvcModel
{
/*////////////////////////////////////////////////////////////////////////////*/
// Trigger Methodes
/*////////////////////////////////////////////////////////////////////////////*/

 
  /**
   * @param int $idType
   * @param int EBuizPeridEventType $type
   */
  public function getActionsByStatus($key, $type)
  {
    
    $sql = <<<SQL
SELECT 
  rowid,
  actions
FROM 
  buiz_period_task
JOIN
  buiz_period_type ON buiz_period_type.rowid = buiz_period_task.id_type
WHERE
  buiz_period_task.event_type = {$type}
  AND
    UPPER(buiz_period_type.access_key) = '{$key}';
SQL;

    return $this->getDb()->sql($sql);
    
  }//end public function getActionsByStatus */
  
  
}//end BuizPeriod_Action_Model

