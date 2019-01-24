<?php

declare(strict_types=1);

namespace Lib\Env\Parser;

use Lib\Env\Exception\FormatException;

class DotenvParser implements EnvParserInterface
{
    private const REGEX_VARNAME = '(export[ \t]++)?((?i:[A-Z][A-Z0-9_]*+))';
    private const REGEX_QUOTED = '/["\']+(?:.*)["\']+$/A';
    private const REGEX_EMPTY_OR_COMMENT = '(?:\s*+(?:#[^\n]*+)?+)++';

    public function parse(string $data): array
    {
        $values = [];
        $lines = explode("\n", $data);
        foreach ($lines as $line) {
            if ($this->emptyLine($line)) {
                continue;
            }
            [$name, $value] = explode('=', $line, 2);
            try {
                $this->lexName($name);
                $this->lexValue($value);
            } catch (\Exception $e) {
                throw $e;
            }
            $values[$name] = $value;
        }

        return $values;
    }

    private function emptyLine(string $line): bool
    {
        if (preg_match('/'.self::REGEX_EMPTY_OR_COMMENT.'/A', $line)) {
            return true;
        }

        return false;
    }

    private function lexName(string $name): string
    {
        if (!preg_match(self::REGEX_VARNAME, $name, $matches)) {
            throw new FormatException('name', $name);
        }

        return $matches[2];
    }

    private function lexValue(string $value): ?string
    {
        // strip inline comments on the right hand side
        $value = explode(' #', $value, 2)[0];

        if ($this->isQuoted($value)) {
            // strip quotes
            $value = mb_substr(mb_substr($value, 0, -1), 1);

            $pos = mb_strpos($value, '"');
            if (0 !== $pos && mb_strlen($value) - 1 !== $pos) {
                if ($value[$pos - 1] !== '\\') {
                    throw new FormatException('value', $value);
                }
            }
        }
    }

    private function isQuoted(string $value): bool
    {
        return (bool) preg_match(self::REGEX_QUOTED, $value);
    }
}
