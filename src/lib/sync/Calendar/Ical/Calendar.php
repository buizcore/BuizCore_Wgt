<?php
/**
 * Created by JetBrains PhpStorm.
 * User: enrico
 * Date: 20.08.14
 * Time: 12:58
 * To change this template use File | Settings | File Templates.
 */

namespace BuizCore\Lib\Sync\Calendar\Ical;
use Sabre\VObject;
use Sabre\VObject\Component\VEvent;

class Calendar
{

    /**
     * @var Event[]
     */
    private $events;

    /**
     * @param \BuizCore\Lib\Sync\Calendar\Ical\Event[] $events
     */
    public function setEvents($events)
    {
        $this->events = $events;
    }

    /**
     * @return \BuizCore\Lib\Sync\Calendar\Ical\Event[]
     */
    public function getEvents()
    {
        return $this->events;
    }


    /**
     * @param Event $event
     * @param string $key
     */
    public function addEvent($event, $key)
    {
        $this->events[$key] = $event;
    }

    /**
     * @param string $key
     */
    public function deleteEvent($key)
    {
        unset($this->events[$key]);
    }

    /**
     * @param $key
     * @return Event
     */
    public function getEvent($key)
    {
        return $this->events[$key];
    }

    /**
     * @param array $vobject
     */
    public function parse($vobject)
    {
        $vcard = VObject\Reader::read($vobject['body']);
        foreach ($vcard->children as $item) {
            if ($item instanceof VEvent) {
                $event = new Event();
                $event->setRef($vobject['ref']);
                $event->setVersion($vobject['version']);
                $event->setUid((string)$item->UID);
                $event->setSummary((string)$item->SUMMARY);
                $event->setStart(date('Y-m-d', strtotime((string)$item->DTSTART)));
                $end = (string)$item->DTEND;
                if (!empty($end))
                    $event->setEnd(date('Y-m-d', strtotime($end)));
                $location = (string)$item->LOCATION;
                if (!empty($location))
                    $event->setLocation($location);
                $this->addEvent($event, $event->getUid());
            }
        }
    }

    /**
     * @return string
     */
    public function toJson()
    {
        $array = [];
        foreach ($this->events as $event) {
            $array[] = $event->to[];
        }
        return json_encode($array);
    }


    /**
     * @return array
     */
    public function toVObject()
    {
        $array = [];

        foreach ($this->events as $event) {
            $data = 'BEGIN:VCALENDAR' . PHP_EOL
                . 'VERSION:2.0' . PHP_EOL
                . 'BEGIN:VTIMEZONE' . PHP_EOL
                . 'TZID:Europe/Berlin' . PHP_EOL
                . 'X-LIC-LOCATION:Europe/Berlin' . PHP_EOL
                . 'END:VTIMEZONE' . PHP_EOL;
            $data .= $event->toVObject();
            $data .= 'END:VCALENDAR' . PHP_EOL;
            $item = array('ref' => $event->getRef(), 'body' => $data,'version' => $event->getVersion());
            $array[] = $item;
        }
        return $array;
    }
}