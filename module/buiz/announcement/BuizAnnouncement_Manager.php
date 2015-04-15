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
class BuizAnnouncement_Manager extends Manager
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

    /**
     * Kunden announcement erstellen und hinzufügen
     * 
     * @param string $title
     * @param string $message
     * @param array $customers
     * @param string $importance
     * @param string $start
     * @param string $end
     */
    public function createCustomerAnnouncement( $title, $message, $customers, $importance = 30,  $start = null, $end = null )
    {
        
        $orm = $this->getOrm();
        
        $announcement = new BuizAnnouncement_Entity(true);
        $announcement->title = $title;
        $announcement->message = $message;
        $announcement->importance = $importance;
        $announcement->date_start = $start;
        $announcement->date_end = $end;
        $announcement->type = 3;
        
        $orm->insert($announcement);
        
        foreach ($customers as $personId) {
            $orm->insert('BuizPersonAnnouncement',array(
            	'id_announcement' => $announcement->getId(),
            	'id_person' => $personId,
            	'm_version' => 1,
            ));
        }
        
    }//end public function createCustomerAnnouncement */
    
    /**
     * Kunden announcement erstellen und hinzufügen
     *
     * @param int $customer
     * @param int $vid
     * @param boolean $lastOnly
     * @return array
     */
    public function getCustomerAnnouncements( $customer, $vid = null, $lastOnly = false )
    {
    
        $db = $this->getDb();
        
        
        $where = '';
        
        if ($vid) {
            $where .= <<<SQL
 AND an.vid = {$vid}
SQL;
        } 
        
        if ($lastOnly) {
            $where .= <<<SQL
 ORDER BY an.m_time_created desc
 LIMIT 1
SQL;
        }
    
        $sql = <<<SQL
SELECT
    an.rowid,
    an.title,
    an.message,
    an.importance,
    an.type,
    an.date_end,
    an.date_start,
    an.m_time_created,
    person.rowid as ref_id,
    person.id_person
FROM buiz_announcement an
    JOIN buiz_person_announcement person
    ON an.rowid = person.id_announcement
WHERE
    person.id_person = {$customer} {$where};   
    
SQL;
        
        return $db->select($sql)->getAll();
    
    }//end public function getCustomerAnnouncements */

    /**
     * Kunden announcement erstellen und hinzufügen
     *
     * @param int $customer
     * @param int $vid
     * @return int
     */
    public function countCustomerAnnouncements($customer, $vid = null)
    {
    
        $db = $this->getDb();
        
        $where = '';
        
        if ($vid) {
            $where .= <<<SQL
 AND an.vid = {$vid}
SQL;
        } 

    
        $sql = <<<SQL
SELECT
    count(an.rowid) num
FROM buiz_announcement an
    JOIN buiz_person_announcement person
    ON an.rowid = person.id_announcement
WHERE
    person.id_person = {$customer} {$where};

SQL;
        
        return $db->select($sql)->getField('num');
    
    }//end public function countCustomerAnnouncements */
    

    
} // end class BuizAnnouncement_Manager

