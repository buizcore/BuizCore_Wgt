<?php
/**
 * Created by JetBrains PhpStorm.
 * User: enrico
 * Date: 20.08.14
 * Time: 12:18
 * To change this template use File | Settings | File Templates.
 */

namespace BuizCore\Lib\Sync\Calendar\Ical;


class Event
{
    private $tz = 'Berlin/Europe';
    private $uid;
    private $ref;
    private $version;
    private $location;
    private $summary;
    private $description;
    private $start;
    private $end;

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }

    /**
     * @return mixed
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $summary
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    /**
     * @return mixed
     */
    public function getSummary()
    {
        return $this->summary;
    }


    /**
     * @param mixed $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    public function __toString()
    {
        $result = '';
        $result .= 'UID: ' . $this->getUid() . PHP_EOL;
        $result .= 'LOCTION: ' . $this->getLocation() . PHP_EOL;
        $result .= 'SUMMARY: ' . $this->getLocation() . PHP_EOL;
        $result .= 'DESCRIPTION: ' . $this->getDescription() . PHP_EOL;
        $result .= 'START: ' . $this->getStart() . PHP_EOL;
        $result .= 'END: ' . $this->getEnd() . PHP_EOL;

        return $result;
    }

    public function to[]
    {
        $array = [];
        if (!empty($this->uid))
            $array['id'] = $this->getUid();

        if (!empty($this->summary))
            $array['title'] = $this->getSummary();

        if (!empty($this->start))
            $array['start'] = $this->getStart();

        if (!empty($this->end))
            $array['end'] = $this->getEnd();

        if (!empty($this->ref))
            $array['ref'] = $this->getRef();
        if (!empty($this->location))
            $array['location'] = $this->getLocation();
        if (!empty($this->version))
            $array['version'] = $this->getVersion();

        return $array;
    }

    public function toVObject()
    {
        $data = 'BEGIN:VEVENT' . PHP_EOL;
        if (!empty($this->uid))
            $data .= 'UID:' . $this->getUid() . PHP_EOL;
        if (!empty($this->summary))
            $data .= 'SUMMARY:' . $this->getSummary() . PHP_EOL;
        if (!empty($this->start))
            $data .= 'DTSTART;TZID=' . $this->getTz() . ':' . date('Ymd\THis', strtotime($this->getStart())) . PHP_EOL;
        if (!empty($this->end))
            $data .= 'DTEND;TZID=' . $this->getTz() . ':' . date('Ymd\THis', strtotime($this->getStart())) . PHP_EOL;
        if (!empty($this->location))
            $data .= 'LOCATION:' . $this->getLocation() . PHP_EOL;
        $data .= 'END:VEVENT' . PHP_EOL;
        return $data;
    }

    /**
     * @return mixed
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param mixed $ref
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
    }

    /**
     * @param string $tz
     */
    public function setTz($tz)
    {
        $this->tz = $tz;
    }

    /**
     * @return string
     */
    public function getTz()
    {
        return $this->tz;
    }

    /**
     * @param mixed $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }
}