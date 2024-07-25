<?php

declare(strict_types=1);

class CacheFactory
{
    private Logger $logger;

    public function __construct(
        Logger $logger
    ) {
        $this->logger = $logger;
    }

    public function create(string $name = null): CacheInterface
    {
        $name ??= Configuration::getConfig('cache', 'type');
        if (!$name) {
            throw new \Exception(xlat('errors:cache:no_type'));
        }
        $cacheNames = [];
        foreach (scandir(PATH_LIB_CACHES) as $file) {
            if (preg_match('/^([^.]+)Cache\.php$/U', $file, $m)) {
                $cacheNames[] = $m[1];
            }
        }
        // Trim trailing '.php' if exists
        if (preg_match('/(.+)(?:\.php)/', $name, $matches)) {
            $name = $matches[1];
        }
        // Trim trailing 'Cache' if exists
        if (preg_match('/(.+)(?:Cache)$/i', $name, $matches)) {
            $name = $matches[1];
        }

        $index = array_search(strtolower($name), array_map('strtolower', $cacheNames));
        if ($index === false) {
            throw new \InvalidArgumentException(xlat('errors:cache:bad_name', $name));
        }

        $className = $cacheNames[$index] . 'Cache';
        if (!preg_match('/^[A-Z][a-zA-Z0-9-]*$/', $className)) {
            throw new \InvalidArgumentException(xlat('errors:cache:bad_classname', $className));
        }

        switch ($className) {
            case NullCache::class:
                return new NullCache();
            case FileCache::class:
                $fileCacheConfig = [
                    // Intentionally checking for truthy value because the historic default value is the empty string
                    'path' => Configuration::getConfig('FileCache', 'path') ?: PATH_CACHE,
                    'enable_purge' => Configuration::getConfig('FileCache', 'enable_purge'),
                ];
                if (!is_dir($fileCacheConfig['path'])) {
                    throw new \Exception(xlat('errors:cache:filecache_path_not_found', $fileCacheConfig['path']));
                }
                if (!is_writable($fileCacheConfig['path'])) {
                    throw new \Exception(xlat('errors:cache:filecache_not_writable', $fileCacheConfig['path']));
                }
                return new FileCache($this->logger, $fileCacheConfig);
            case SQLiteCache::class:
                if (!extension_loaded('sqlite3')) {
                    throw new \Exception(xlat('errors:cache:not_loaded', 'sqlite'));
                }
                if (!is_writable(PATH_CACHE)) {
                    throw new \Exception(xlat('errors:cache:path_not_writable'));
                }
                $file = Configuration::getConfig('SQLiteCache', 'file');
                if (!$file) {
                    throw new \Exception(xlat('errors:cache:config_missing', 'SQLiteCache'));
                }
                if (dirname($file) == '.') {
                    $file = PATH_CACHE . $file;
                } elseif (!is_dir(dirname($file))) {
                    throw new \Exception(xlat('errors:cache:config_invalid', 'SQLiteCache'));
                }
                return new SQLiteCache($this->logger, [
                    'file'          => $file,
                    'timeout'       => Configuration::getConfig('SQLiteCache', 'timeout'),
                    'enable_purge'  => Configuration::getConfig('SQLiteCache', 'enable_purge'),
                ]);
            case MemcachedCache::class:
                if (!extension_loaded('memcached')) {
                    throw new \Exception(xlat('errors:cache:not_loaded', 'memcached'));
                }
                $section = 'MemcachedCache';
                $host = Configuration::getConfig($section, 'host');
                $port = Configuration::getConfig($section, 'port');
                if (empty($host) && empty($port)) {
                    throw new \Exception(xlat('errors:cache:config_missing', $section));
                }
                if (empty($host)) {
                    throw new \Exception(xlat('errors:cache:param_not_set', 'host', $section));
                }
                if (empty($port)) {
                    throw new \Exception(xlat('errors:cache:param_not_set', 'port', $section));
                }
                if (!ctype_digit($port)) {
                    throw new \Exception(xlat('errors:cache:param_invalid', 'port', $section));
                }
                $port = intval($port);
                if ($port < 1 || $port > 65535) {
                    throw new \Exception(xlat('errors:cache:param_invalid', 'port', $section));
                }
                return new MemcachedCache($this->logger, $host, $port);
            default:
                if (!file_exists(PATH_LIB_CACHES . $className . '.php')) {
                    throw new \Exception(xlat('errors:cache:missing_file'));
                }
                return new $className();
        }
    }
}
