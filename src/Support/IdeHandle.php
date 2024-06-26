<?php

namespace LaraDumps\LaraDumpsCore\Support;

use LaraDumps\LaraDumpsCore\Actions\MakeFileHandler;
use Spatie\Backtrace\Frame;

class IdeHandle
{
    public function __construct(
        public ?Frame $frame = null,
    ) {
    }

    public function make(): array
    {
        if (empty($this->frame)) {
            return [];
        }

        $path = $this->frame->file;
        $line = strval($this->frame->lineNumber);

        $fileHandle = MakeFileHandler::handle($this->frame);

        if (str_contains($path, 'Laravel Kit')) {
            $fileHandle = '';
            $path       = 'Laravel Kit';
            $line       = '';
        }

        if (str_contains($path, 'eval()')) {
            $fileHandle = '';
            $path       = 'Tinker';
            $line       = '';
        }

        $path = str_replace(appBasePath() . DIRECTORY_SEPARATOR, '', strval($path));

        if (str_contains($path, 'resources')) {
            $path = str_replace('resources/views/', '', strval($path));
        }

        $className = explode('/', $path);
        $className = end($className);

        return [
            'handler'    => $fileHandle,
            'path'       => $path,
            'class_name' => $className,
            'line'       => $line,
        ];
    }
}
