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
class BuizTextBlock_Provider extends Provider
{

    /**
     * @param array $types
     * @return array
     */
    public function getBlocksByType($types)
    {
        
        $db = $this->getDb();
        
        $whereTypes = "'".implode("', '",$types)."'";
        
        $sql = <<<SQL
SELECT
    block.rowid,
    block.title,
    block.content
FROM
    buiz_text_block block
JOIN
    buiz_text_block_type type
        ON block.id_type = type.rowid
WHERE
    type.access_key IN({$whereTypes});

SQL;
        
        return $db->select($sql)->getAll();
        
        
    }//end public function getBlocksByType */
    
    /**
     * @param array $sortedIds
     * @return array
     */
    public function getSortedTexts($sortedIds)
    {
    
        $db = $this->getDb();
    
        $whereIds = implode(", ",$sortedIds);
    
        $sql = <<<SQL
SELECT
    block.rowid,
    block.content
FROM
    buiz_text_block block
WHERE
    block.rowid IN({$whereIds});
    
SQL;
        
        $result =  $db->select($sql)->getAll();
        
        $unsored = [];
        $sorted = [];
        
        foreach ($result as $res) {
            $unsored[$res['rowid']] = $res['content'];
        }
        
        foreach ($sortedIds as $id) {
            if (isset($unsored[$id])) {
                $sorted[] = $unsored[$id];
            }
        }
        
        
        return $sorted;
    
    }//end public function getBlocksByType */
    
    
    

    
} //end class BuizTextBlock_Provider */

