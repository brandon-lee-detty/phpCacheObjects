<?php

function formatBytes($bytes)
{
    return str_pad(
        round($bytes / (1024 ** 2), 2),
        9,
        ' ',
        STR_PAD_LEFT
    ) . ' MiB';
}

function checkedStr(bool $prop, string $label): string
{
    return '[' . ($prop ? 'X' : ' ') . "] $label" . PHP_EOL;
}

function displayTimeDiff(int $start_time): void
{
    echo '      in '
        . round((hrtime(true) - $start_time) / 10 ** 9, 3)
        . ' seconds' . PHP_EOL;
}
