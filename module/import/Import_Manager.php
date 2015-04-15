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
class Import_Manager extends Manager
{
    
    /**
     * Der Dateiname
     * @var string
     */
    public $importFile = null;
    
    /**
     * Datei Type
     * @var string
     */
    public $importFileType = null;

    /**
     * Die Columns wie sie sich in der Datei befinden
     * @var array
     */
    public $cols = [];

    /**
     * nicht gemappte fields
     * @var array
     */
    public $fields = [];

    /**
     * inverse fields
     * @var array
     */
    public $invFields = [];
    
    /**
     * Mapping der Columns auf die felder
     * @var array
     */
    public $colsMap = [];
    
    /**
     * Die vorhandene Datenbank Struktur
     * @var array
     */
    public $availableStructure = [];
    
    /**
     * die mapping datenstruktur (wurde wenn vorhanden aus der datenbank gelesen)
     * @var array
     */
    public $mapping = [];
    
    /**
     * Key für Temporäre Verzeichnisse etc
     * @var string
     */
    public $importKey = null;

    /**
     * @var LibFilereader
     */
    public $fileReader = null;
    
    /**
     * Statistische Daten zu den Imports
     * @var array
     */
    public $stats = [];
    
    /**
     * Liste mit den Warnungen
     * @var array
     */
    public $warnings = [];
    
    /**
     * Liste mit den Fehlern
     * @var array
     */
    public $errors = [];
    
    /**
     * @param LibHttpRequest $request
     */
    public function handleMapping($request)
    {
        
        $this->importFile = $request->param('file',Validator::CKEY);
        $this->importFileType = $request->param('type',Validator::CKEY);
        
        $cols = $request->data('col',Validator::TEXT);
        $fields = $request->data('field',Validator::TEXT);
        
        $this->cols = $cols;
        $this->fields = $fields;
        $this->invFields = array_flip($this->fields);
        
        foreach($fields as $colKey => $colVal){
            
            $tmp = explode('.',$colVal);
            $this->colsMap[$tmp[0]][$tmp[1]] = $fields[$colKey];
        }
        
        $this->saveMapping();
        
        
    }//end public function handleMapping */
    
    /**
     */
    public function loadMapping()
    {

        $orm = $this->getOrm();
        $key = md5(json_encode($this->cols));
        
        $settings = $orm->get(
            'SyncImportSettings',
            " id_import IN( SELECT rowid from sync_import sync where UPPER(sync.access_key) = UPPER('{$this->importKey}') ) 
                 AND UPPER(access_key) = UPPER('{$key}') " 
        );
        
        if($settings){
            $this->mapping = (array)json_decode($settings->jdata);
        }
    
    }//end public function loadMapping */
    
    /**
     * @param LibHttpRequest $request
     */
    public function saveMapping()
    {
        
        $orm = $this->getOrm();
        
        $importNode = $orm->getByKey('SyncImport',$this->importKey);
        
        if(!$importNode){
            $importNode = $orm->newEntity('SyncImport');
            $importNode->access_key = $this->importKey;
            $orm->save($importNode);
        }
        
        $serSet = json_encode($this->fields);
        $key = md5(json_encode($this->cols));
        
        $settings = $orm->get('SyncImportSettings',' id_import = '.$importNode." AND access_key = '".$key."'" );
        
        if(!$settings){
            $settings = $orm->newEntity('SyncImportSettings');
            $settings->access_key = $key;
            $settings->id_import = $importNode;
            $settings->jdata = $serSet;
            
            $orm->save($settings);
        }
    
    }//end public function handleMapping */
    

    /**
     * checken ob das mapping so ok ist
     */
    protected function checkMappingConsistency()
    {
    
    }// end protected function checkMappingConsistency
    
    
    /**
     * @param LibRequestHttp $request
     */
    public function handleUpload($request)
    {
        
        $importPath = PATH_GW.'app_data/imports/'.$this->importKey.'/';
        
        $uploadFile = $request->file('0',null,'file');
        
        if($uploadFile->error){
            throw new InvalidRequest_Exception($uploadFile->error);
        }
        
        $fileId = $this->getFileId();
        $ending = $uploadFile->getEnding();
        
        $uploadFile->copy($fileId.'.'.$ending, $importPath);
        
        $this->importFile = $fileId;
        $this->importFileType = $ending;
        
        $this->fileReader = new LibFilereaderCsv();
        $this->fileReader->delimiter = ',';
        $this->fileReader->open($importPath.$fileId.'.'.$ending);
        
        $this->cols = $this->fileReader->firstLine();
        
        $this->loadMapping();
        
    }//end public function handleUpload */
    
    /**
     * @throws Io_Exception
     */
    public function openImportFile()
    {
        $importPath = PATH_GW.'app_data/imports/'.$this->importKey.'/';
        
        $this->fileReader = new LibFilereaderCsv();
        $this->fileReader->delimiter = ',';
        $this->fileReader->open($importPath.$this->importFile.'.'.$this->importFileType);
    }
    
    /**
     * @param LibHttpRequest $request
     */
    public function executeImport($request)
    {
    
    
    }//end public function executeImport */
    
    /**
     * @return string
     */
    protected function getFileId()
    {
        return BuizCore::docTimestamp();
    }//end protected function getFileId */
    


    /**
     * @param array $row
     * @param string $key
     * @return string
     */
    protected function readColByKey($row, $key)
    {
        
        $pos = $this->invFields[$key];
        return $row[$pos];
        
    }//end protected function readColByKey */
    
    /**
     * @param array $row
     * @param string|array $key
     * @return string
     */
    protected function colExists($row, $key)
    {
        
        if(is_array($key)){
            
            foreach($key as $checkKey){
                if(isset($this->invFields[$checkKey]))
                    return true;
            }
            
            return true;
            
        } else {

            return isset($this->invFields[$key]);
        }
    
    
    }//end protected function colExists */

}//end Import_Manager

