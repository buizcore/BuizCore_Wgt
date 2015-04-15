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
class Buiz_File_Manager extends Manager
{

    /**
     * @param string $key         
     * @param string $forceDownload            
     * @param string $fileName            
     */
    public function readFile($key, $forceDownload = false, $fileName = null)
    {
        $orm = $this->getOrm();
        
        
        $tmp = explode('-', $key);
        $id = (int)$tmp[2];
        
        $file = $orm->get('BuizFile', $id);
        
        if (!$file) {
            $this->error404();
            return;
        }
        
        if ($fileName) {
            $name = base64_decode($fileName);
        } else {
            $name = $file->name;
        }
        
        $fileName = PATH_UPLOADS.'attachments/'.$tmp[0].'/'.$tmp[1].SParserString::idToPath($id).'/'.$id;
        
        $this->sendFile($fileName, $file, $name, $forceDownload);
        
    } // end protected function readFile */
    
    
    /**
     * Den Pfad der Datei über einen Router auslesen
     * 
     * @param string $routeKey
     * @param int $fileId
     * @param array $params
     * @param boolean $forceDownload
     * @param string $name
     */
    public function readFileByRoute($routeKey, $fileId, $params, $forceDownload, $fileName)
    {
        $orm = $this->getOrm();
        
        $className = $routeKey.'_Download';
        
        if(BuizCore::classExists($className)){
            $router = new $className($this);
        }
    
        /* @var $router LibDownload  */
        $file = $router->getFileNode($fileId, $params);
        
        if (!$file) {
            $this->error404();
            return;
        }
        
        $id = $file->getId();
    
    
        if ($fileName) {
            $name = base64_decode($fileName);
        } else {
            $name = $file->name;
        }
    
        $filePath = PATH_UPLOADS.'attachments/'.$router->table.'/'.$router->attr.SParserString::idToPath($id).'/'.$id;
        
        $this->sendFile($filePath, $file, $name, $forceDownload);

    
    } // end protected function readFileByRoute */
    
    /**
     *
     * @param int $fileId            
     * @param int $mandatId            
     * @param string $basePath            
     */
    public function getFilepath($fileId, $mandatId, $basePath = null)
    {
        if (! $basePath)
            $basePath = PATH_UPLOADS.'attachments/';
        
        return $basePath.SParserString::idPath($fileId);
    } // end public function getDmsFilepath */
    
    /**
     *
     * @param int $fileId
     * @param int $mandatId
     * @param string $basePath
     */
    protected function error404()
    {
        header("HTTP/1.0 404 Not Found");
        header('Content-Type: text/html');
        echo <<<ERROR
<html>
<head><title>Missing File</title></head>
<body>
<h1>Sorry, can't find this file.</h1>
</body>
</html>
ERROR;
        return;
    } // end public function getDmsFilepath */
    
    /**
     * @param string $filePath
     * @param BuizFile_Entity $fileData
     * @param string $fileName
     * @param boolean $forceDownload
     */
    protected function sendFile($filePath, $fileData, $fileName, $forceDownload )
    {
        if ($forceDownload) {
    
            $contentType = 'application/octet-stream';
        } else {
    
            if ($fileData->mimetype) {
                $contentType = $fileData->mimetype; // 'application/octet-stream' ;
            } else {
                $contentType = 'application/octet-stream';
            }
        }
    
        // dummdämliche Fehlermeldung abfagen, dass der buffer leer ist
        if (BUFFER_OUTPUT) {
            // error handling
            $errors = ob_get_contents();
            
            if('' != $errors){
                Log::error($errors);
            }
            ob_end_clean();
        }
    
        if (! file_exists($filePath)) {
            $this->error404();
            return;
        }
    
        if ($forceDownload) {
    
            header('Content-Type: application/force-download');
            header('Content-Type: application/octet-stream', false);
            header('Content-Type: application/download', false);
            if($contentType != 'application/octet-stream'){
                header('Content-Type: '.$contentType, false);
            }
    
            header('Content-Disposition: attachment;filename="'.urlencode($fileName).'"');
    
        } else {
            header('Content-Type: '.$contentType);
            header('Content-Disposition: inline;filename="'.urlencode($fileName).'"');
        }
    
        header('ETag: '.$fileData->file_hash);
        header('Content-Length: '.$fileData->file_size);
    
        readfile($filePath);
        
    } // end public function sendFile */
    
} // end class BuizFile_Model

