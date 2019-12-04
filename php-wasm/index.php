<?php

declare(strict_types = 1);
require __DIR__ . '/vendor/autoload.php';

// Instantiate the module.
$instance = new Wasm\Instance('/Users/mkazutaka/src/github.com/mkazutaka/php-wasm-template-engine/target/wasm32-unknown-unknown/release/php_wasm_template_engine.wasm');

// Set the subject to greet.
$subject = 'Wasmer 🐘';
$length_of_subject = strlen($subject);

// Allocate memory for the subject, and get a pointer to it.
$input_pointer = $instance->allocate($length_of_subject);

// Write the subject into the memory.
$memory_buffer = $instance->getMemoryBuffer();
$memory = new Wasm\Uint8Array($memory_buffer, $input_pointer);
for ($nth = 0; $nth < $length_of_subject; ++$nth) {
    $memory[$nth] = ord($subject[$nth]);
}
// C-string terminates by NULL.
$memory[$nth] = 0;

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
$instance->deallocate($input_pointer, $length_of_subject);
$instance->deallocate($output_pointer, $length_of_output);

echo $output, "\n";
