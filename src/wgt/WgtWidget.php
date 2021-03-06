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
 *
 * @package net.buizcore.wgt
 */
abstract class WgtWidget extends PBase
{
/*
 * //////////////////////////////////////////////////////////////////////////////
 * // Attributes
 * //////////////////////////////////////////////////////////////////////////////
 */
    
    /**
     * sub Modul Extention
     * 
     * @var array
     */
    protected $models = array();

    /**
     * Javascript Code
     * 
     * @var string
     */
    protected $jsCode = null;

    /**
     * Der ID key des elements
     * 
     * @var string
     */
    public $idKey = null;

/*
 * //////////////////////////////////////////////////////////////////////////////
 * // Constructor and other Magics
 * //////////////////////////////////////////////////////////////////////////////
 */
    
    /**
     * 
     */
    public function __construct()
    {
        $this->init();
    }//end public function __construct */
    
    /**
     *
     * @return string
     */
    public function getIdKey()
    {

        if (is_null($this->idKey))
            $this->idKey = BuizCore::uniqKey();
        
        return $this->idKey;
    
    } // end public function getIdKey */

    /**
     *
     * @param string $idKey            
     */
    public function setIdKey($idKey)
    {

        $this->idKey = $idKey;
    
    } // end public function setIdKey */

    /**
     * request the default action of the ControllerClass
     *
     * @param string $modelKey            
     * @param string $key            
     *
     * @return Model
     */
    protected function loadModel($modelKey, $key = null)
    {

        if (! $key)
            $key = $modelKey;
        
        $modelName = $modelKey . '_Model';
        
        if (! isset($this->models[$key])) {
            if (! BuizCore::classExists($modelName)) {
                throw new Controller_Exception('Internal Error', 'Failed to load Submodul: ' . $modelName);
            }
            
            $this->models[$key] = new $modelName($this);
        }
        
        return $this->models[$key];
    
    } // end protected function loadModel */

    /**
     * Getter für die in dem Widget vorhandenen Models
     *
     * @param string $key            
     * @return Model
     */
    protected function getModel($key)
    {

        if (isset($this->models[$key]))
            return $this->models[$key];
        else
            return null;
    
    } // protected function getModel */

    /**
     * Methode wir beim initialisieren des Widgest aufgerufen
     */
    public function getJscode()
    {

        return $this->jsCode;
    
    } // end public function getJscode */

    /**
     *
     * @param LibTemplate $view            
     */
    public function injectJsCode($view)
    {

        if ($this->jsCode) {
            
            $view->addJsCode($this->jsCode);
        }
    
    } // end public function injectJsCode */
    
   /**
     */
    public function startTplMode()
    {
        ob_start();
    }//end public function startTplMode */
    
   /**
    * @return string
    */
    public function getTplContent()
    {
        $templateData = ob_get_contents();
        ob_end_clean();
        
        return $templateData;
        
    }//end public function getTplContent */
    
    /**
     *
     */
    public function sendAsArea($selector, $action)
    {
    
        $tpl = $this->getTpl();
    
        $area = $tpl->newArea($selector);
        
        if(is_null($selector)){
            $selector = '#'.$this->id;
        }
    
        $area->position = $selector;
        $area->action = $action;
        $area->setContent( $this->renderWidget() );
    
    }//end public function sendAsArea */
    
    /**
     * kann implementiert werden, hat keine parameter
     * Daten in dem fall vorher auf dem objekt setzen
     *
     * @return string
     */
    public function renderWidget()
    {
        return '';
    }//end public function renderItem */
    


    /**
     * Methode wir beim initialisieren des Widgest aufgerufen
     */
    public function init()
    {
        
        $this->getI18n();

        return true;
    
    } // end public function init */

    /**
     * Methode wird nach dem Rendern des Widgets aufgerufen
     */
    public function shutdown()
    {

    }

} // end abstract class WgtWidget

