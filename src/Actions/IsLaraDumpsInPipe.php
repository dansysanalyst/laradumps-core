<?php

namespace LaraDumps\LaraDumpsCore\Actions;

final class IsLaraDumpsInPipe
{
    public static function handle(): bool
    {
        $caller = FindDsInBackTrace::handle(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));

        if ($caller->has_ds) {
            $spl = new \SplFileObject($caller->filepath);
            $spl->seek($caller->line_number - 1);

            return is_string($spl->current()) && str_starts_with(trim($spl->current()), '|>');
        }

        return false;
    }
}
