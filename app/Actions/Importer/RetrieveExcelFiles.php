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

        return collect($linklist)
            ->filter(function (DOMElement $element) {
                return Str::contains($element->nodeValue, 'Διημερεύοντα Φαρμακεία');
                    //|| Str::contains($element->nodeValue, 'Kατάλογος Ιδωτικών Φαρμακείων');
            })
            ->map(function (DOMElement $element) {
//                if (Str::contains($element->nodeValue, 'Διημερεύοντα Φαρμακεία')) {
                    $filename = last(array_filter(explode(' ', $element->nodeValue)));
//                } else {
//                    $filename = 'Διημερεύοντα Φαρμακεία';
//                }
                $link = $element->getAttribute('href');
                $path = $this->downloadExcelFile($filename, $link);

                return $path;
            });
    }

    /**
     * @param $url
     * @return false|string
     */
    private function getHTML($url)
    {
        $html = Crawler::get($url);
        $html = mb_convert_encoding($html, 'UTF-8', 'auto');
        $html = mb_convert_encoding($html, "HTML-ENTITIES", "UTF-8");
        return $html;
    }

    protected function downloadExcelFile($filename, string $link)
    {
        $html = $this->getHTML($this->baseUrl . $link);

        $doc = new DOMDocument;

        $doc->strictErrorChecking = false;
        $doc->recover             = true;
        $doc->loadHTML($html);

        /** @var DOMElement[] $linklist */
        $linklist = (new DOMXpath($doc))->query('//a[@class[contains(.,"simplelinks")]]');

        $link = 'https://www.moh.gov.cy/moh/phs/phs.nsf/All/' . $linklist[0]->getAttribute('href');

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $userAgent = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';
        curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($curl, CURLOPT_REFERER, 'https://www.moh.gov.cy/');
        $result = curl_exec($curl);

//        if (Str::contains($filename, 'Διημερεύοντα Φαρμακεία')) {
            $filename = $filename . '-' . now()->toDateString() . '.xls'; // format 2020-12-25
//        } else {
//            $filename = '2020-2021 Φαρμακεία για διημερεύσεις.xls';
//        }

        $fullPath = 'mohfiles/' . $filename;

        Storage::put($fullPath, $result);

        return $fullPath;
    }
}
