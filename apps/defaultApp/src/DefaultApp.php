<?php

declare(strict_types=1);

namespace Company\Apps\DefaultApp;

use Illuminate\Foundation\Application;
use RuntimeException;

final class DefaultApp extends Application
{
    const VERSION = '0.0.1';
    const APP_NAME = 'default';
    const APP_PREFIX = 'mcs/default';
    const BOUNDED_CONTEXTS = ['DefaultApp'];

    public function getNamespace(): int|string
    {
        if (!is_null($this->namespace)) {
            return $this->namespace;
        }

        $composer = json_decode(file_get_contents($this->basePath('../../composer.json')), true);

        foreach ((array)data_get($composer, 'autoload.psr-4') as $namespace => $path) {
            foreach ((array)$path as $pathChoice) {
                if (realpath($this->path()) === realpath($this->basePath($pathChoice))) {
                    return $this->namespace = $namespace;
                }
            }
        }

        throw new RuntimeException('Unable to detect application namespace.');
    }
}
