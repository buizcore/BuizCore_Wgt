<?php
/**
 * Created by JetBrains PhpStorm.
 * User: enrico
 * Date: 20.08.14
 * Time: 12:18
 * To change this template use File | Settings | File Templates.
 */

namespace BuizCore\Lib\Sync\Calendar;
use Sabre\DAV\Client;

class CalDav
{

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return \SimpleXMLElement
     */
    private function getBaseRequest()
    {
        return new \SimpleXMLElement('<c:calendar-query xmlns:d="DAV:" xmlns:c="urn:ietf:params:xml:ns:caldav"/>');
    }

    /**
     * @return array
     */
    private function getBaseRequestHeader()
    {
        $headers = [];
        $headers['Depth'] = 1;
        $headers['Prefer'] = 'return-minimal';
        $headers['Content-Type'] = 'application/xml; charset=utf-8';
        return $headers;

    }

    private function getSettings()
    {
        $settings = array(
            'baseUri' => 'http://192.168.56.101/workspace/sabre/calendarserver.php/calendars/admin/default/',
            'baseUriHost' => 'http://192.168.56.101',
            'userName' => 'admin',
            'password' => 'admin',
        );
        return $settings;
    }


    public function storeItem($body, $ref = null, $version = null)
    {
        $client = new Client($this->getSettings());
        $params = array('Content-Type' => 'text/calendar; charset=utf-8');
        if (is_null($version) || is_null($version)) {
            echo "CREATE NEW EVENT";
        } else {
            echo "UPDATE EVENT";
            $params['If-Match'] = '"' . $version . '"';
            echo $this->getSettings()['baseUriHost'] . $ref;
            $response = $client->request('PUT', $this->getSettings()['baseUriHost'] . $ref, $body, $params);
            var_dump($response);
        }
    }

    public function deleteItem($ref, $version)
    {
        $client = new Client($this->getSettings());
        $params = array('Content-Type' => 'text/calendar; charset=utf-8');
        $params['If-Match'] = '"' . $version . '"';
        $client->request('DELETE', $this->getSettings()['baseUriHost'] . $ref, null, $params);
    }

    public function getItems($type = null)
    {
        $xml = $this->getBaseRequest();
        $ns = [];
        $ns['d'] = 'DAV:';
        $ns['c'] = 'urn:ietf:params:xml:ns:caldav';
        $prop = $xml->addChild('d:prop', null, $ns['d']);
        $prop->addChild('d:getetag', null, $ns['d']);
        $prop->addChild('c:calendar-data', null, $ns['c']);
        $filter = $xml->addChild('c:filter', null, $ns['c'])->addChild('c:comp-filter', null, $ns['c']);
        $filter->addAttribute('name', 'VCALENDAR');
        if (!is_null($type) && !empty($type))
            $filter->addChild('c:comp-filter', null, $ns['c'])->addAttribute('name', 'VEVENT');

        $request = $xml->saveXML();
        $client = new Client($this->getSettings());
        $response = $client->request('REPORT', $this->getSettings()['baseUri'], $request, $this->getBaseRequestHeader());
        $doc = new \DOMDocument();
        $doc->loadXML($response['body']);
        $xpath = new \DOMXPath($doc);
        $matches = $xpath->query('//d:multistatus/d:response/d:propstat/d:prop/cal:calendar-data');
        /** @var $match \DOMElement */
        $result = [];
        foreach ($matches as $match) {
            $item['body'] = $match->textContent;
            $item['ref'] = $match->parentNode->parentNode->parentNode->firstChild->textContent;
            $item['version'] = str_replace('"', '', $match->parentNode->firstChild->textContent);
            $result[] = $item;
        }
        return $result;
    }
}