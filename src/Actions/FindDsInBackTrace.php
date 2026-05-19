<?php

namespace LaraDumps\LaraDumpsCore\Actions;

final class FindDsInBackTrace
{
    /**
     *
     * @param array $trace
     * @return object{has_ds: bool, line_number: int, filepath: string}
     */
    public static function handle(array $trace): object
    {
        $result = (object) ['has_ds' => false, 'line_number' => 0, 'filepath' => ''];

        foreach ($trace as $frame) {
            if (empty($frame['function']) || empty($frame['file']) || empty($frame['line'])) {
                continue;
            }

            if ((strtolower((string) $frame['function'])) === 'ds') {
                $result->has_ds      = true;
                $result->filepath    = $frame['file'];
                $result->line_number = (int) intval($frame['line']) > 1 ? $frame['line'] - 1 : $frame['line'];
                $result->line_number = intval($frame['line']);

                return $result;
            }
        }

        return $result;
    }
}
