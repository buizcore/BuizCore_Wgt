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
class BuizUser_Manager extends Manager
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

    /**
     * @param array $groups
     * 
     * @return array
     */
    public function getUserSyncdataByGroup(array $groups)
    {
        
        $db = $this->getDb();
        
        $upGroups = "UPPER('".implode( "'), UPPER('",$groups ). "')";
        
        $sql = <<<SQL
SELECT
    usr.rowid as user_id,
    usr.name as user_name,
    usr.password,
    person.rowid as person_id,
    person.lastname as lastname,
    person.firstname as firstname,
    addr_item.address_value as email
FROM 
    buiz_role_user_r usr
JOIN
    core_person_r person
        ON person.rowid = usr.id_person
LEFT JOIN
    buiz_address_item addr_item
        ON person.rowid = addr_item.vid
LEFT JOIN
    buiz_address_item_type addr_item_type
        ON addr_item.id_type = addr_item_type.rowid
        
JOIN buiz_group_users gru
    ON gru.id_user = usr.rowid AND gru.partial = 0 and gru.id_area is null
JOIN buiz_role_group grp
    ON gru.id_group = grp.rowid
    
WHERE 
    UPPER(grp.access_key) IN ({$upGroups})
    AND addr_item_type.access_key = 'mail';
    
SQL;
        
        return $db->select($sql)->getAll();
        
        
    }//end public function getUserSyncdataByGroup */
    
    
    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $userName
     * @param string $password
     * @param string $email
     * @param string $profile
     * @param string $level
     * @param string $roles
     * @param string $profiles
     * 
     * @return array
     * 
     * @throws InternalError_Exception
     * @throws LibDb_Exception
     */
    public function createUser(
        $firstName, 
        $lastName, 
        $userName, 
        $password, 
        $email, 
        $profile, 
        $level, 
        $roles, 
        $profiles
    ) {

        $orm = $this->getOrm();
        
        $user = $orm->getWhere('BuizRoleUser',"UPPER('username') = UPPER('{$orm->escape($userName)}')");
        
        if ($user) {
            throw new InternalError_Exception('the user: '.$userName.' allready exists');
        }
        
        $user = new BuizRoleUser_Entity(true);
        $person = new CorePerson_Entity(true);
        $user->id_person = $person;
        
        // person
        $person->firstname = $firstName;
        $person->lastname = $lastName;
        $person->type = EPersonType::HUMAN_PERSON;
        
        // user
        $user->name = $userName;
        $user->password = SEncrypt::passwordHash($password);
        $user->type = EUserType::USER;
        $user->profile = $profile;
        $user->level = $level;
        
        
        $orm->save($user);
        $userId = $user->getId();
        
        foreach ($roles as $role) {
            $this->addRole($role, $userId);
        }
        

        $this->addProfile($profile, $userId);
        
        foreach ($profiles as $profileKey) {
            $this->addProfile($profileKey, $userId);
        }
        
        
    }//end public function createUser */
    
    /**
     * @param string $roleName
     * @param int $userId
     * 
     * @return boolean true wenn erfolgreich hinzugefügt
     */
    public function addRole($roleName, $userId)
    {
        
        $orm = $this->getOrm();
        
        $roleId = $orm->getIdByKey('BuizRoleGroup',$roleName);
        
        if (!$roleId) {
            return false;
        }
        
        $assigned = $orm->getWhere(
            'BuizGroupUsers',
            "id_area is null and vid is null and partial = 0 and id_group = {$roleId} and id_user = {$userId}"
        );
        
        if ($assigned) {
            // assignment existiert... irgendwie is ja trotzdem alles ok
            return true;
        }
        
        $assignment = new BuizGroupUsers_Entity(true);
        $assignment->id_area = null;
        $assignment->vid = null;
        $assignment->partial = 0;
        $assignment->id_group = $roleId;
        $assignment->id_user = $userId;
        
        $orm->save($assignment);
        
        
        return true;
        
        
    }//end public function addRole */
    
    /**
     * @param string $profileName
     * @param int $userId
     */
    public function addProfile($profileName, $userId)
    {
        
        $orm = $this->getOrm();
        
        $profileId = $orm->getIdByKey('BuizProfile',$profileName);
        
        if (!$profileId) {
            return false;
        }
        
        $assigned = $orm->getWhere(
            'BuizUserProfiles',
            "id_profile = {$profileId} and id_user = {$userId}"
        );
        
        if ($assigned) {
            // assignment existiert... irgendwie is ja trotzdem alles ok
            return true;
        }
        
        $assignment = new BuizUserProfiles_Entity(true);
        $assignment->id_profile = $profileId;
        $assignment->id_user = $userId;
        
        $orm->save($assignment);
        
        return true;
    
    }//end public function addProfile */

} // end class BuizUser_Manager */

