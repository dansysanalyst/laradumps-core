<?php

use LaraDumps\LaraDumpsCore\LaraDumps;
use LaraDumps\LaraDumpsCore\Payloads\{DumpPayload};

it('should return the correct payload to dump', function () {
    if (isPhp85OrHigher()) {
        require_once(__DIR__ . '/../Concerns/CodeWithPipeOperator.php85');
    }

    $laradumps = new LaraDumps();
    $payload   = new DumpPayload($name);
    $payload->setFrame([
        'file' => 'Test',
        'line' => 1,
    ]);

    $payload = $laradumps->send($payload, withFrame: false)->toArray();

    expect($payload)
        ->id->toBeUuid()
        ->request_id->toBeUniqId()
        ->type->toBe('dump')
        ->code_snippet->toBeArray()
        ->and($payload['ide_handle']['real_path'])
        ->toBe('Test')
        ->and($payload['ide_handle']['line'])
        ->toBe('1')
        ->and($payload['dump']['dump'])->toBe('LARADUMPS');
})->skipOnPhp('<8.5.0');
