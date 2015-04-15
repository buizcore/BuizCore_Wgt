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
class SetupDeploy_Controller extends Controller
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  protected $options = array(
    'syncmetadata' => array(
    ),
    'syncdatabase' => array(
    ),
    'syncdata' => array(
    ),
  );

/*////////////////////////////////////////////////////////////////////////////*/
//Logic: Meta Model
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * sync the metadata inside of the database
   */
  public function service_syncMetadata($request, $respsonse)
  {

    $model = new SetupDeployDatabase_Manager($this);

    $respsonse->addMessage('Start Metadata Sync: '.date('Y-m-d H:i:s'));

    $rootPath = $request->param('root_path', Validator::FOLDERNAME)?:PATH_ROOT;
    $respsonse->addMessage("Using Rootpath ".$rootPath);

    $type = $request->param('type', Validator::CNAME);
    $db = $model->getDb();
    $db->begin();
    $model->syncMetadata($rootPath, $type);
    $db->commit();

    $respsonse->addMessage('Sucessfully synced Metadata '.date('Y-m-d H:i:s'));

  }//end public function service_syncMetadata */


  /**
   * synchronize the database structure
   */
  public function service_syncDatabase($request, $respsonse)
  {
    
    $model = new SetupDeployDatabase_Manager($this);

    $syncCol = $request->param('sync_col', Validator::BOOLEAN);
    $deleteCol = $request->param('delete_col', Validator::BOOLEAN);
    $syncTable = $request->param('sync_table', Validator::BOOLEAN);
    $rootPath = $request->param('root_path', Validator::FOLDERNAME)?:PATH_ROOT;

    if ($deleteCol)
      $model->forceColSync(true);

    $model->syncCol($syncCol);
    $model->syncTable($syncTable);

    $respsonse->addMessage("Start Database Sync");

    if ($syncTable) {
      $respsonse->addMessage("Try to Sync Tables");
    }

    if ($syncCol) {
      $respsonse->addMessage("Try to Sync Cols");
    }

    $respsonse->addMessage('Start Table Sync: '.date('Y-m-d H:i:s'));
    
    //$db = $model->getDb();
    //$db->begin();
    $model->syncDatabase($rootPath);
    //$db->commit();
    $respsonse->addMessage('Sucessfully sychronised Tables '.date('Y-m-d H:i:s'));

  }//end public function service_syncDatabase */

  /**
   * synchronize with the data from the modell
   */
  public function service_syncData($request, $respsonse)
  {

    $rootPath = $request->param('root_path', Validator::FOLDERNAME)?:PATH_ROOT;

    $model = new SetupDeployDatabase_Manager($this);

    $respsonse->addMessage('Start Model / Data Sync: '.date('Y-m-d H:i:s'));
    $db = $model->getDb();
    $db->begin();
    $model->syncData($rootPath);
    $db->commit();
    $respsonse->addMessage('Sucessfully sychronized Data from the Model '.date('Y-m-d H:i:s'));

  }//end public function service_syncData */

/*////////////////////////////////////////////////////////////////////////////*/
//Logic: Meta Model
/*////////////////////////////////////////////////////////////////////////////*/

}//end class SetupDeploy_Controller

