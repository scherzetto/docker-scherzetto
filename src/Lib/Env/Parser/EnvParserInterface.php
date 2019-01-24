<?php

declare(strict_types=1);

namespace Lib\Env\Parser;

interface EnvParserInterface
{
    public function parse(string $data): array;
}
