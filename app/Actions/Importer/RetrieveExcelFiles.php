<?php


namespace App\Actions\Importer;

use App\Actions\Importer\Crawler\Crawler;
use DOMDocument;
use DOMElement;
use DOMXPath;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RetrieveExcelFiles
{
    protected $baseUrl = 'https://www.moh.gov.cy';
    private $startUrl = 'https://www.moh.gov.cy/moh/phs/phs.nsf/dmlovernight_gr/dmlovernight_gr?OpenDocument';

    public function handle()
    {
        $html = $this->getHTML($this->startUrl);

        libxml_use_internal_errors(true);

        $doc = new DOMDocument;

        $doc->strictErrorChecking = false;
        $doc->recover             = true;

        $doc->loadHTML($html);

        /** @var DOMElement[] $linklist */
        $linklist = (new DOMXpath($doc))->query('//table//a[@class[contains(.,"simpletitle")]]');

        if (is_null($linklist)) {
            throw new \Exception('Something bad happened dude!');
        }

        collect($linklist)
            ->filter(function (DOMElement $element) {
                return Str::contains($element->nodeValue, 'Διημερεύοντα Φαρμακεία');
            })
            ->map(function (DOMElement $element) {
                $city = last(array_filter(explode(' ', $element->nodeValue)));
                $link = $element->getAttribute('href');
                $this->downloadExcelFile($city, $link);
            });
    }

    /**
     * @return false|string
     */
    private function getHTML($url)
    {
        $html = Crawler::get($url);
        $html = mb_convert_encoding($html, 'UTF-8', 'auto');
        $html = mb_convert_encoding($html, "HTML-ENTITIES", "UTF-8");
        return $html;
    }

    protected function downloadExcelFile($city, string $link)
    {
        $html = $this->getHTML($this->baseUrl . $link);

        $doc = new DOMDocument;

        $doc->strictErrorChecking = false;
        $doc->recover             = true;
        $doc->loadHTML($html);

        /** @var DOMElement[] $linklist */
        $linklist = (new DOMXpath($doc))->query('//a[@class[contains(.,"simplelinks")]]');

        $link = 'https://www.moh.gov.cy/moh/phs/phs.nsf/All/' . $linklist[0]->getAttribute('href');

        $CurlConnect = curl_init();
        curl_setopt($CurlConnect, CURLOPT_URL, $link);
        curl_setopt($CurlConnect, CURLOPT_POST, 1);
        curl_setopt($CurlConnect, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($CurlConnect, CURLOPT_POSTFIELDS, []);
        $result = curl_exec($CurlConnect);

        $filename = $city . '-' . now()->toDateString() . '.xls'; // format 2020-12-25

        Storage::put('app/mohfiles/' . $filename, $result);

    }
}
