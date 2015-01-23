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
class LibTemplateDocument extends LibTemplate
{

    /**
     * content type is undefined
     * must be set in the system
     * 
     * @var string
     */
    public $contentType = null;

    /**
     * what type of view ist this object, html, ajax, document...
     * 
     * @var string
     */
    public $type = 'document';

    /**
     * the activ index template
     * 
     * @var string
     */
    public $indexTemplate = 'document';

    /**
     *
     * @var boolean
     */
    public $compressed = false;

    /**
     *
     * @return LibTemplateDataFile
     */
    public function sendFile()
    {
        if (!$this->file)
            $this->file = new LibTemplateDataFile();
        
        return $this->file;
    } // end public function sendFile
    
    /**
     *
     * @return LibTemplateDataFile
     */
    public function getFile()
    {
        return $this->file;
    } // end public function getFile */
    
    /**
     * Einfaches bauen der Seite ohne Caching oder sonstige Rücksicht auf
     * Verluste
     *
     * @return void
     */
    public function buildPage()
    {
        if (trim($this->compiled) != '')
            return;
            
            // Parsing Data
        $this->buildBody();
        
        $this->compiled = $this->assembledBody . NL;
    } // end public function buildPage */
    
    /**
     * Einfaches bauen der Seite ohne Caching oder sonstige Rücksicht auf
     * Verluste
     *
     * @return void
     */
    protected function buildMessages()
    {
        
        // ignore messages
        return '';
    } // end public function buildMessages */
    
    /**
     * Ausgabe Komprimieren
     */
    public function compress()
    {
        
        if ($this->file)
            return;
        
        $this->compressed = true;
        $this->output = gzencode($this->output);
        
    } // end public function compress */
    
    /**
     * ETag für den Content berechnen
     * 
     * @return string
     */
    public function getETag()
    {
        if ($this->file) {
            
            return $this->file->getEtag();
        } else {
            
            return md5($this->output);
        }
    } // end public function getETag */
    
    /**
     * Länge des Contents berechnen
     * 
     * @return int
     */
    public function getLength()
    {
        if ($this->file) {
            return $this->file->getLength();
        } else {
            if ($this->compressed)
                return strlen($this->output);
            else
                return mb_strlen($this->output);
        }
    } // end public function getLength */
    
    /**
     * flush the page
     *
     * @return void
     */
    public function compile()
    {
        
        if (! $this->file) {
            $this->buildPage();
            $this->output = $this->compiled;
        }
        
    } // end public function compile */
    
} // end class LibTemplateDocument

