<?php

/*
 * This file is part of the "andrey-helldar/laravel-lang-publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/laravel-lang-publisher
 */

declare(strict_types=1);

namespace Tests;

use Helldar\LaravelLangPublisher\Concerns\Has;
use Helldar\LaravelLangPublisher\Constants\Config;
use Helldar\LaravelLangPublisher\Constants\Locales;
use Helldar\LaravelLangPublisher\Facades\Helpers\Config as ConfigSupport;
use Helldar\LaravelLangPublisher\ServiceProvider;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use Has;

    protected $default = Locales::ENGLISH;

    protected $fallback = Locales::KOREAN;

    protected $emulate = [
        'laravel/breeze',
        'laravel/fortify',
        'laravel/jetstream',
        'laravel/cashier',
        'laravel/nova',
        'laravel/spark-paddle',
        'laravel/spark-stripe',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->refreshLocales();

        $this->emulatePackages();
    }

    protected function getPackageProviders($app): array
    {
        return [ServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set('app.locale', $this->default);
        $config->set('app.fallback_locale', $this->fallback);

        $config->set(Config::PRIVATE_KEY . '.path.base', realpath(__DIR__ . '/../vendor'));

        $config->set(Config::PUBLIC_KEY . '.excludes', [
            'auth' => ['failed'],
            'json' => ['All rights reserved.', 'Baz'],
        ]);

        //$config->set(Config::PUBLIC_KEY . '.plugins', [
        //    'andrey-helldar/lang-translations',
        //]);
    }

    protected function copyFixtures(): void
    {
        $files = [
            'en.json',
            'auth.php',
            'validation.php',
        ];

        foreach ($files as $filename) {
            $from = realpath(__DIR__ . '/fixtures/' . $filename);

            $this->hasJson($filename)
                ? File::copy($from, resource_path('lang/' . $filename))
                : File::copy($from, resource_path('lang/' . $this->default . '/' . $filename));
        }
    }

    protected function refreshLocales(): void
    {
        $this->deleteLocales();
        $this->installLocales();
    }

    protected function deleteLocales(): void
    {
        $path = ConfigSupport::resources();

        Directory::ensureDelete($path);
    }

    protected function installLocales(): void
    {
        Artisan::call('lang:add', [
            'locales' => [$this->default, $this->fallback],
            '--force' => true,
        ]);
    }

    protected function emulatePackages(): void
    {
        foreach ($this->emulate as $package) {
            Directory::ensureDirectory($this->pathVendor($package));
        }
    }

    protected function removeEmulatedPackages(): void
    {
        foreach ($this->emulate as $package) {
            $path = $this->pathVendor($package);

            Directory::ensureDelete($path);
        }
    }

    protected function pathVendor(string $path): string
    {
        $vendor = ConfigSupport::vendor();

        $chars = '/\\';

        return rtrim($vendor, $chars) . '/' . ltrim($path, $chars);
    }
}
