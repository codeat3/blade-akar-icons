<?php

use Codeat3\BladeIconGeneration\IconProcessor;

class BladeAkarIcons extends IconProcessor
{
    public function postOptimization()
    {
        $this->svgLine = preg_replace('/\<\?xml.*\?\>/', '', $this->svgLine);
        $this->svgLine = str_replace('stroke="black"', 'stroke="currentColor"', $this->svgLine);
        $this->svgLine = str_replace('fill="black"', 'fill="currentColor"', $this->svgLine);

        return $this;
    }

    public function optimize()
    {
        return parent::optimize();
    }
}

$svgNormalization = static function (string $tempFilepath, array $iconSet) {

    // perform generic optimizations
    $iconProcessor = new BladeAkarIcons($tempFilepath, $iconSet);
    $iconProcessor
        ->optimize()
        ->postOptimization()
        ->save();
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

        'custom-attributes' => [
            'stroke' => 'currentColor'
        ]
    ],
];
