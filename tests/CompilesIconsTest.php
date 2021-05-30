<?php

declare(strict_types=1);

namespace Tests;

use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Config;
use BladeUI\Icons\BladeIconsServiceProvider;
use Codeat3\BladeAkarIcons\BladeAkarIconsServiceProvider;

class CompilesIconsTest extends TestCase
{
    /** @test */
    public function it_compiles_a_single_anonymous_component()
    {
        $result = svg('akar-bluetooth')->toHtml();

        // Note: the empty class here seems to be a Blade components bug.
        $expected = <<<'SVG'
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor"><path d="M5 7L17 17L11 22V2L17 7L5 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            SVG;


        $this->assertSame($expected, $result);
    }

    /** @test */
    public function it_can_add_classes_to_icons()
    {
        $result = svg('akar-bluetooth', 'w-6 h-6 text-gray-500')->toHtml();
        $expected = <<<'SVG'
            <svg class="w-6 h-6 text-gray-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor"><path d="M5 7L17 17L11 22V2L17 7L5 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            SVG;
        $this->assertSame($expected, $result);
    }

    /** @test */
    public function it_can_add_styles_to_icons()
    {
        $result = svg('akar-bluetooth', ['style' => 'color: #555'])->toHtml();


        $expected = <<<'SVG'
            <svg style="color: #555" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor"><path d="M5 7L17 17L11 22V2L17 7L5 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            SVG;

        $this->assertSame($expected, $result);
    }

    /** @test */
    public function it_can_add_default_class_from_config()
    {
        Config::set('blade-akar-icons.class', 'awesome');

        $result = svg('akar-bluetooth')->toHtml();

        $expected = <<<'SVG'
            <svg class="awesome" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor"><path d="M5 7L17 17L11 22V2L17 7L5 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            SVG;

        $this->assertSame($expected, $result);

    }

    /** @test */
    public function it_can_merge_default_class_from_config()
    {
        Config::set('blade-akar-icons.class', 'awesome');

        $result = svg('akar-bluetooth', 'w-6 h-6')->toHtml();

        $expected = <<<'SVG'
            <svg class="awesome w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor"><path d="M5 7L17 17L11 22V2L17 7L5 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            SVG;

        $this->assertSame($expected, $result);

    }

    protected function getPackageProviders($app)
    {
        return [
            BladeIconsServiceProvider::class,
            BladeAkarIconsServiceProvider::class,
        ];
    }
}
