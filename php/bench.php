<?php

require __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/wasm.php';
require_once __DIR__ . '/twig.php';

/**
 * Class RenderingBench
 * @BeforeMethods({"init"})
 * Warmup(0)
 * Revs(0)
 * @Iterations(20)
 */
class RenderBench
{
    /** @var Wasm */
    private $wasm;

    /** @var Twig */
    private $twig;

    public function init()
    {
    }

    public function benchTwig()
    {
        $this->twig = new Twig();
        $this->twig->renderBench();
    }

    public function benchWasm()
    {
        $this->wasm = new Wasm();
        $this->wasm->renderBench();
    }
}
