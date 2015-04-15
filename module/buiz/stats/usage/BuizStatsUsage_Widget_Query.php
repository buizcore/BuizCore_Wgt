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
class BuizStatsUsage_Widget_Query extends LibSqlQuery
{
/*////////////////////////////////////////////////////////////////////////////*/
// query elements table
/*////////////////////////////////////////////////////////////////////////////*/

 /**
   * Loading the tabledata from the database
   * @param string $entityKey
   * @param date $start
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetch($entityKey, $start)
  {

    $db = $this->getDb();

    $matrix = [];

    $dateStart = new DateTime($start);
    $dateEnd = new DateTime($start);
    $dateEnd->add(new DateInterval('P1Y'));

    $interval = new DateInterval('P1M');
    $periods = new DatePeriod($dateStart, $interval , $dateEnd);

    // fillup
    foreach ($periods as $perPos) {
      $tmpDate = $perPos->format('Y-m').'-01';
      $matrix[$tmpDate] = array
      (
        'created' => 0,
        'changed' => 0
      );
    }

    $sql = <<<SQL
  select
    date_trunc('month', m_time_created)::date as period,
    count(m_time_created) as created
  from
    {$entityKey}
  where
    m_time_created >= '{$dateStart->format('Y-m-d')}'
    and m_time_created < '{$dateEnd->format('Y-m-d')}'
  group by
    date_trunc('month', m_time_created)::date
  ;
SQL;

    $data = $db->select($sql)->getAll();
    foreach ($data as $row) {
      $matrix[$row['period']]['created'] = $row['created'];
    }

    $sql = <<<SQL
  select
    date_trunc('month', m_time_changed)::date as period,
    count(m_time_changed) as changed
  from
    {$entityKey}
  where
    m_time_created >= '{$dateStart->format('Y-m-d')}'
    and m_time_created < '{$dateEnd->format('Y-m-d')}'
  group by
    date_trunc('month', m_time_changed)::date
  ;
SQL;

    $data = $db->select($sql)->getAll();
    foreach ($data as $row) {
      $matrix[$row['period']]['changed'] = $row['changed'];
    }

    return $matrix;

  }//end public function fetch */

  /**
   */
  public function fetchSelectbox()
  {

    $db = $this->getDb();

    $sql = <<<SQL
  select
    name as id,
    access_key as value
    from
      buiz_entity
    order by
      name;

SQL;

    return $db->select($sql)->getAll();

  }//end public function fetchSelectbox */

}// end class BuizStatsUsage_Widget_Query

