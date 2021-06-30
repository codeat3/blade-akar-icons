<?php

use Codeat3\BladeIconGeneration\IconProcessor;

class BladeAkarIcons extends IconProcessor {

}

$svgNormalization = static function (string $tempFilepath, array $iconSet) {

    $doc = new DOMDocument();
    $doc->formatOutput = false;
    $doc->load($tempFilepath);

    /**
     * @var DOMElement $svgElement
     */
    $svgElement = $doc->getElementsByTagName('svg')[0];

    // Remove all the attributes to control order of them on output
    $svgElement->removeAttribute('width');
    $svgElement->removeAttribute('height');
    // $svgElement->removeAttribute('viewBox');
    $svgElement->removeAttribute('fill');
    // For some reason PHP's DOMElement likes to put xmlns first even if you don't touch it.
    $svgElement->removeAttributeNS('http://www.w3.org/2000/svg', null);
    // Add them back in the correct order to match current results...
    $svgElement->setAttribute('fill', 'none');
    $svgElement->setAttributeNS(null, 'xmlns', 'http://www.w3.org/2000/svg');
    $svgElement->setAttribute('stroke', 'currentColor');

    $doc->save($tempFilepath);

    $svgLine = str_replace(PHP_EOL, '', file_get_contents($tempFilepath));
    $svgLine = preg_replace('/\<\?xml.*\?\>/','',$svgLine);
    $svgLine = str_replace('stroke="black"', 'stroke="currentColor"', $svgLine);
    $svgLine = str_replace('fill="black"', 'fill="currentColor"', $svgLine);

    // changing the name
    $iconProcessor = new BladeAkarIcons($tempFilepath, $iconSet);
    $cleanPath = $iconProcessor->getDestinationFileName();

    rename($tempFilepath, $cleanPath);

    file_put_contents($cleanPath, $svgLine);
};

return [
    [
        // Define a source directory for the sets like a node_modules/ or vendor/ directory...
        'source' => __DIR__.'/../dist/src/svg',

        // Define a destination directory for your icons. The below is a good default...
        'destination' => __DIR__.'/../resources/svg',

        // Enable "safe" mode which will prevent deletion of old icons...
        'safe' => false,

        // Call an optional callback to manipulate the icon
        // with the pathname of the icon and the settings from above...
        'after' => $svgNormalization,
    ],
];
