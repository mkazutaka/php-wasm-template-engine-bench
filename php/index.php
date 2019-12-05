<?php

require __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class RenderingBench
{
    public function benchTwig()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $twig = new Environment($loader);
        $twig->render('index.html.twig',
            [
                'year' => 'test',
                'teams' => [
                    [
                        'name' => "test",
                        'score' => 100
                    ],
                    [
                        'name' => "test",
                        'score' => 100
                    ],
                ]
            ]
        );
    }

    public function benchWasm()
    {
        // Instantiate the module.
        $instance = new Wasm\Instance('../wasm-template-engine/target/wasm32-unknown-unknown/release/wasm_template_engine.wasm');

        // Set the subject to greet.
        $subject = 'Wasmer 🐘';
        $length_of_subject = strlen($subject);

        // Allocate memory for the subject, and get a pointer to it.
        $input_pointer = $instance->allocate(100);
        // Write the subject into the memory.
        $memory_buffer = $instance->getMemoryBuffer();
//        $memory = new Wasm\Uint8Array($memory_buffer, $input_pointer);
//        for ($nth = 0; $nth < $length_of_subject; ++$nth) {
//            $memory[$nth] = ord($subject[$nth]);
//        }
        // C-string terminates by NULL.
//        $memory[$nth] = 0;
//        $memory[0] = 0;

        // Run the `greet` function. Give the pointer to the subject.
        $output_pointer = $instance->hello();
        // Read the result of the `greet` function.
        $memory = new Wasm\Uint8Array($memory_buffer, $output_pointer);
        $output = '';
        $nth = 0;
        while (0 !== $memory[$nth]) {
            $output .= chr($memory[$nth]);
            ++$nth;
        }
        $length_of_output = $nth;

        // Deallocate the subject, and the output.
        //$instance->deallocate($input_pointer, $length_of_subject);
        $instance->deallocate($output_pointer, $length_of_output);

        //echo $output, "\n";
    }
}
