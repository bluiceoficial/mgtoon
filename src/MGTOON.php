<?php

// Copyright (C) 2025-2026 Murilo Gomes Julio
// SPDX-License-Identifier: MIT

// Site: https://mugomes.github.io

namespace MGTOON;

class MGTOON
{
    private string $type;
    private array $fields = [];
    private array $records = [];
    private string $primaryKey;

    public function loadFile(string $filename, string $primaryKey = 'id') {
        $sTOON = file_get_contents($filename);
        $this->loadTOON($sTOON, $primaryKey);
    }

    public function loadTOON(string $toon, string $primaryKey = 'id') {
        $toon = self::parse($toon, $primaryKey);
        $this->type = $toon->type;
        $this->fields = $toon->fields;
        $this->records = $toon->records;
        $this->primaryKey = $toon->primaryKey;
    }

    public function create(string $type, array $fields = [], string $primaryKey = 'id')
    {
        try {
            $this->type = $type;
            $this->fields = $fields;
            $this->primaryKey = $primaryKey;

            if (!in_array($primaryKey, $fields)) {
                throw new \InvalidArgumentException("Campo primário '{$primaryKey}' não existe nos campos definidos.");
            }
        } catch (\InvalidArgumentException $ex) {
            if (ini_get('DISPLAY_ERRORS')) {
                echo $ex->__toString();
            } else {
                error_log($ex->__toString());
            }
        }
    }

    private static function parse(string $text, string $primaryKey = 'id'): ?self
    {
        try {
            $lines = array_values(array_filter(array_map('trim', explode("\n", $text))));
            if (count($lines) === 0) {
                throw new \InvalidArgumentException("TOON vazio.");
            }

            if (!preg_match('/^([a-zA-Z0-9_]+)\[([^\]]+)\]$/', $lines[0], $matches)) {
                throw new \InvalidArgumentException("Cabeçalho inválido em TOON.");
            }

            $type = $matches[1];
            $fields = array_map('trim', explode('|', $matches[2]));
            $toon = new self();
            $toon->create($type, $fields, $primaryKey);

            for ($i = 1; $i < count($lines); $i++) {
                $values = array_map('trim', explode('|', $lines[$i]));
                if (count($values) !== count($fields)) {
                    throw new \InvalidArgumentException("Linha $i inválida: número de colunas não corresponde ao cabeçalho.");
                }
                $record = array_combine($fields, $values);
                $toon->records[] = $record;
            }

            return $toon;
        } catch (\InvalidArgumentException $ex) {
            if (ini_get('DISPLAY_ERRORS')) {
                echo $ex->__toString();
            } else {
                error_log($ex->__toString());
            }
            return null;
        }
    }

    public function toString(): string
    {
        $lines[] = "{$this->type}[" . implode('|', $this->fields) . "]";
        foreach ($this->records as $record) {
            $values = [];
            foreach ($this->fields as $f) {
                $values[] = $record[$f] ?? '';
            }
            $lines[] = implode('|', $values);
        }
        return implode("\n", $lines);
    }

    public function add(array $record): array
    {
        try {
            $key = $this->primaryKey;
            if (empty($record[$key])) {
                throw new \InvalidArgumentException("Campo primário '{$key}' é obrigatório.");
            }

            if ($this->exists($record[$key])) {
                throw new \RuntimeException("Registro com {$key}='{$record[$key]}' já existe.");
            }

            $filtered = [];
            foreach ($this->fields as $f) {
                $filtered[$f] = $record[$f] ?? null;
            }

            $this->records[] = $filtered;
            return $filtered;
        } catch (\InvalidArgumentException | \RuntimeException $ex) {
            if (ini_get('DISPLAY_ERRORS')) {
                echo $ex->__toString();
            } else {
                error_log($ex->__toString());
            }
            return [];
        }
    }

    public function read(?string $keyValue = null): array
    {
        if ($keyValue === null) {
            return $this->records;
        }

        $key = $this->primaryKey;
        foreach ($this->records as $r) {
            if ((string)$r[$key] === (string)$keyValue) {
                return $r;
            }
        }
        return [];
    }

    public function update(string $keyValue, array $newData): bool
    {
        $key = $this->primaryKey;
        foreach ($this->records as &$r) {
            if ((string)$r[$key] === (string)$keyValue) {
                foreach ($newData as $k => $v) {
                    if (in_array($k, $this->fields)) {
                        $r[$k] = $v;
                    }
                }
                return true;
            }
        }
        return false;
    }

    public function delete(string $keyValue): bool
    {
        $key = $this->primaryKey;
        foreach ($this->records as $i => $r) {
            if ((string)$r[$key] === (string)$keyValue) {
                unset($this->records[$i]);
                $this->records = array_values($this->records);
                return true;
            }
        }
        return false;
    }

    private function exists(string $keyValue): bool
    {
        $key = $this->primaryKey;
        foreach ($this->records as $r) {
            if ((string)$r[$key] === (string)$keyValue) {
                return true;
            }
        }
        return false;
    }

    public function saveFile(string $filename) {
        file_put_contents($filename, $this->toString());
    }

    public function validate(string $text, string $primaryKey = 'id'): array
    {
        try {
            $toon = self::parse($text, $primaryKey);
        } catch (\Throwable $e) {
            return ['valid' => false, 'error' => $e->getMessage()];
        }

        // Checar duplicidade do campo primário
        $pk = $toon->primaryKey;
        $keys = array_column($toon->records, $pk);
        if (count($keys) !== count(array_unique($keys))) {
            return ['valid' => false, 'error' => "Valores duplicados no campo primário '{$pk}'."];
        }

        return [
            'valid' => true,
            'type' => $toon->type,
            'primaryKey' => $pk,
            'fields' => $toon->fields,
            'records' => count($toon->records)
        ];
    }
}
