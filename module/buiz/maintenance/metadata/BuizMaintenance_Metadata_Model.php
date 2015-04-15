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
class BuizMaintenance_Metadata_Model extends MvcModel
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  public $tableList = array(
    "buiz_module" => array(false),
    "buiz_module_category" => array(false),
    "buiz_entity" => array(false),
    //"buiz_entity_alias" => array(false), // lassen wir so, kann auch von hand erweitert werden
    "buiz_entity_attribute" => array(false),
    "buiz_entity_category" => array(false),
    "buiz_entity_reference" => array(false),
    "buiz_management" => array(false),
    "buiz_management_element" => array(false),
    "buiz_management_reference" => array(false),
    "buiz_mask" => array(false),
    //"buiz_mask_form_settings" => array(true),
    //"buiz_mask_list_settings" => array(true),
    //"buiz_item" => array(false),
    "buiz_desktop" => array(false),
    "buiz_service" => array(false),
    "buiz_widget" => array(false),
    "buiz_process" => array(false),
    "buiz_process_phase" => array(false),
    "buiz_process_node" => array(false),
    "buiz_security_area" => array(false),
  );

  /**
   * @var array
   */
  public $statsData = [];

  /**
   * @var array
   */
  public $cleanLog = [];

/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function loadStats()
  {

    /* @var $db LibDbPostgresql */
    $db = $this->getDb();

    $this->statsData = [];

    $deplVal = $db->sequenceValue('buiz_deploy_revision');

    foreach ($this->tableList as $key => $data) {

      $sql = <<<SQL
SELECT
  count(rowid) as num_old
  FROM {$key}
  WHERE
    revision < {$deplVal} or revision is null


SQL;
  
      $sqlAll = <<<SQL
SELECT
  count(rowid) as num_all
  FROM {$key}
      
      
SQL;
  
      $this->statsData[] = array
      (
        'id'=> $key,
        'access_key'=> $key,
        'label'=> $key,
        'num_old' =>  $db->select($sql)->getField('num_old'),
        'num_all' =>  $db->select($sqlAll)->getField('num_all')
      );

    }

  }//end public function loadStats */

  /**
   * @return void
   */
  public function cleanAllMetadata()
  {

    /* @var $db LibDbPostgresql */
    $db = $this->getDb();

    $deplVal = $db->sequenceValue('buiz_deploy_revision');


    foreach ($this->tableList as $key => $data) {

      $sql = <<<SQL
DELETE
  FROM {$key}
  WHERE
    revision < {$deplVal} or revision is null;

SQL;


      $this->cleanLog[] = array('table' => $key, 'num_del' => $db->delete($sql)  );

    }

    $sql = <<<SQL
  DELETE FROM buiz_security_access where NOT id_area IN(select distinct rowid from  buiz_security_area);
SQL;

    $this->cleanLog[] = array('table' => 'Area acess missing area', 'num_del' => $db->delete($sql)  );

    $sql = <<<SQL
  DELETE FROM buiz_security_access where NOT id_group IN(select distinct rowid from  buiz_role_group);
SQL;

    $this->cleanLog[] = array('table' => 'Area acess missing group', 'num_del' => $db->delete($sql)  );

    // buiz_group_users
    $sql = <<<SQL
  DELETE FROM buiz_group_users where NOT id_group IN(select distinct rowid from  buiz_role_group);
SQL;

    $this->cleanLog[] = array('table' => 'Group User missing group', 'num_del' => $db->delete($sql)  );

    $sql = <<<SQL
  DELETE FROM buiz_group_users where NOT id_user IN(select distinct rowid from  buiz_role_user);
SQL;

    $this->cleanLog[] = array('table' => 'Group User missing user', 'num_del' => $db->delete($sql)  );

    $sql = <<<SQL
  DELETE FROM buiz_group_users where NOT id_area IN(select distinct rowid from  buiz_security_area);
SQL;

    $this->cleanLog[] = array('table' => 'Group User missing area', 'num_del' => $db->delete($sql)  );

    // sec path
    $sql = <<<SQL
  DELETE FROM buiz_security_path where NOT id_group IN(select distinct rowid from  buiz_role_group);
SQL;

    $this->cleanLog[] = array('table' => 'Sec Path missing group', 'num_del' => $db->delete($sql)  );

    $sql = <<<SQL
  DELETE FROM buiz_security_path where NOT id_area IN(select distinct rowid from  buiz_security_area);
SQL;

    $this->cleanLog[] = array('table' => 'Sec Path missing area', 'num_del' => $db->delete($sql)  );

    $sql = <<<SQL
  DELETE FROM buiz_security_path where NOT id_reference IN(select distinct rowid from  buiz_security_area);
SQL;

    $this->cleanLog[] = array('table' => 'Sec Path missing reference', 'num_del' => $db->delete($sql)  );

    $sql = <<<SQL
  DELETE FROM buiz_security_path where NOT id_root IN(select distinct rowid from  buiz_security_area);
SQL;

    $this->cleanLog[] = array('table' => 'Sec Path missing root', 'num_del' => $db->delete($sql)  );

    $sql = <<<SQL
  DELETE FROM buiz_security_path where NOT m_parent IN(select distinct rowid from  buiz_security_path);
SQL;

    $this->cleanLog[] = array('table' => 'Sec Path missing parent', 'num_del' => $db->delete($sql)  );

  }//end public function cleanAllMetadata */

}//end class BuizMaintenance_Metadata_Model */

