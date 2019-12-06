<?php

class Wasm
{
    const KEY = 'wasm';
    const WASM_PATH = '../wasm-template-engine/target/wasm32-unknown-unknown/release/wasm_template_engine.wasm';
    const CACHE_DIR = __DIR__ . "/module_caching";

    /** @var \Wasm\Cache\Filesystem */
    private $cache;

    private $wasm_instance;

    public function __construct()
    {
        $this->cache = new \Wasm\Cache\Filesystem(static::CACHE_DIR);

        if ($this->cache->has(static::KEY)) {
            $this->wasm_instance = $this->cache->get(static::KEY)->instantiate();
            return $this->wasm_instance;
        }
        $module = new \Wasm\Module(static::WASM_PATH);
        $this->cache->set(static::KEY, $module);
        $this->wasm_instance = $module->instantiate();
    }

    public function renderHello(): string
    {
        $wasm = $this->wasm_instance;
        $input_pointer = $wasm->allocate(1);
        $memory_buffer = $wasm->getMemoryBuffer();
        $output_pointer = $wasm->hello();
        $memory = new Wasm\Uint8Array($memory_buffer, $output_pointer);
        $output = '';
        $nth = 0;
        while (0 !== $memory[$nth]) {
            $output .= chr($memory[$nth]);
            ++$nth;
        }
        $length_of_output = $nth;
        return $output;
    }

    public function renderBench(): string
    {
        $wasm = $this->wasm_instance;
        $input_pointer = $wasm->allocate(1);
        $memory_buffer = $wasm->getMemoryBuffer();
        $output_pointer = $wasm->bench();
        $memory = new Wasm\Uint8Array($memory_buffer, $output_pointer);
        $output = '';
        $nth = 0;
        while (0 !== $memory[$nth]) {
            $output .= chr($memory[$nth]);
            ++$nth;
        }
        $length_of_output = $nth;
        return $output;
    }
}
