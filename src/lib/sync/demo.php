<?php
/**
 * Created by JetBrains PhpStorm.
 * User: enrico
 * Date: 20.08.14
 * Time: 22:02
 * To change this template use File | Settings | File Templates.
 */

header("Content-Type: text/plain");
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Datum in der Vergangenheit

/* Autoloader SabreDAV LIB */
include '/var/www/workspace/sabre/vendor/autoload.php';

require_once('./Calendar/Ical/Event.php');
require_once('./Calendar/Ical/Calendar.php');
require_once('./Calendar/CalDav.php');


$dav = new \BuizCore\Lib\Sync\Calendar\CalDav();
/**
 * Events eines Kalenders auslesen
 */
$response = $dav->getItems('VEVENT');
$calendar = new \BuizCore\Lib\Sync\Calendar\Ical\Calendar();
foreach ($response as $item) {
    $calendar->parse($item);
}

/**
 * Manipulieren von Objekten
 */
$vobjects = $calendar->toVObject();
foreach ($vobjects as $vobject) {
    /**
     * create,update
     */
    //$dav->storeItem($vobject['body'],$vobject['ref'],$vobject['version']);

    /**
     * delete
     */
    //$dav->deleteItem($vobject['ref'],$vobject['version']);
    break;
}


echo $calendar->toJson();