<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/wasm.php';
require_once __DIR__ . '/twig.php';

class RenderTest extends TestCase
{
    /** @var Wasm */
    private $wasm;
    /** @var Twig */
    private $twig;

    protected function setUp(): void
    {
        $this->wasm = new Wasm();
        $this->twig = new Twig();
    }

    public function testRenderHello()
    {
        $wasm_html = $this->wasm->renderHello();
        $twig_html = $this->twig->renderHello();

        $this->assertSame($this->deleteWhiteSpace($wasm_html), $this->deleteWhiteSpace($twig_html));
    }

    public function testRenderBench()
    {
        $wasm_html = $this->wasm->renderBench();
        $twig_html = $this->twig->renderBench();

        $this->assertSame($this->deleteWhiteSpace($wasm_html), $this->deleteWhiteSpace($twig_html));
    }

    private function deleteWhiteSpace(string $str): string {
        return str_replace([PHP_EOL, ' '], '', $str);
    }
}
