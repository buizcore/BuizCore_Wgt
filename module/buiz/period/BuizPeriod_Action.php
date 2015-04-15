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
class BuizPeriod_Action extends Action
{
/*////////////////////////////////////////////////////////////////////////////*/
// Trigger Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param BaseChild $env
   */
  public function __construct($env)
  {

     $this->env = $env;

  }//end public function __construct */
  

  /**
   * @param Entity $entity
   * @param TFlag $params
   *
   * @throws LibActionBreak_Exception bei so schwerwiegenden Fehlern, dass
   *  der komplette Programmfluss abgebrochen werden sollte
   *
   * @throws LibAction_Exception Bei Fehlern die jedoch nicht so schwer sind
   *  um den Fortlauf des Programms zu gefährden
   *
   */
  public function initialize($entity, $params)
  {

    $message = $this->env->getMessage();
  
    try {
      
      $periodManager = new LibPeriodManager($this->env);
      $periodManager->initialize($entity);
        
      $message->addMessage( 'Successfully initialized the Period' );
      
    } catch (Exception $exc) {
      
      $message->addError( 'Failed to initialize the period' );
      
    }
  
  }//end public function initialize */
  
  /**
   * @param Entity $entity
   * @param TFlag $params
   *
   * @throws LibActionBreak_Exception bei so schwerwiegenden Fehlern, dass
   *  der komplette Programmfluss abgebrochen werden sollte
   *
   * @throws LibAction_Exception Bei Fehlern die jedoch nicht so schwer sind
   *  um den Fortlauf des Programms zu gefährden
   *
   */
  public function freeze($entity, $params)
  {
  
    
    $message = $this->env->getMessage();
    
    try {
    
      $periodManager = new LibPeriodManager($this->env);
      $periodManager->freeze($entity);
    
      $message->addMessage( 'Successfully frozen the atual Period' );
    
    } catch (Exception $exc) {
    
      $message->addError( 'Failed to freeze the actual period' );
    
    }
     
  }//end public function freeze */
  
  /**
   * @param Entity $entity
   * @param TFlag $params
   *
   * @throws LibActionBreak_Exception bei so schwerwiegenden Fehlern, dass
   *  der komplette Programmfluss abgebrochen werden sollte
   *
   * @throws LibAction_Exception Bei Fehlern die jedoch nicht so schwer sind
   *  um den Fortlauf des Programms zu gefährden
   *
   */
  public function next($entity, $params)
  {
  
  
    $message = $this->env->getMessage();
  
    try {
  
      $periodManager = new LibPeriodManager($this->env);
      $periodManager->next($entity);
  
      $message->addMessage( 'Successfully switched to the next Period' );
  
    } catch (Exception $exc) {
  
      $message->addError( 'Failed to switch to the next period' );
  
    }
     
  }//end public function next */
  
  /**
   * @param Entity $entity
   * @param TFlag $params
   *
   * @throws LibActionBreak_Exception bei so schwerwiegenden Fehlern, dass
   *  der komplette Programmfluss abgebrochen werden sollte
   *
   * @throws LibAction_Exception Bei Fehlern die jedoch nicht so schwer sind
   *  um den Fortlauf des Programms zu gefährden
   *
   */
  public function close($entity, $params)
  {
  
    $message = $this->env->getMessage();
    
    try {
    
      $periodManager = new LibPeriodManager($this->env);
      $periodManager->close($entity);
    
      $message->addMessage( 'Successfully closed the actual Period' );
    
    } catch (Exception $exc) {
    
      $message->addError( 'Failed to close the actual period' );
    
    }
     
  }//end public function close */

  /**
   * @param Entity $entity
   * @param TFlag $params
   *
   * @throws LibActionBreak_Exception bei so schwerwiegenden Fehlern, dass
   *  der komplette Programmfluss abgebrochen werden sollte
   *
   * @throws LibAction_Exception Bei Fehlern die jedoch nicht so schwer sind
   *  um den Fortlauf des Programms zu gefährden
   *
   */
  public function archive($entity, $params)
  {

     /* @var $model BuizPeriod_Action_Model */
     $model = $this->loadModel('BuizPeriod_Action');
     $actions = $model->getActionsByStatus($entity->getId(), EBuizPeriodEventType::ARCHIVE );
     
  }//end public function archive */

}//end BuizPeriod_Action

