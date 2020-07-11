<?php

namespace Tests\Commands\Json;

use Helldar\LaravelLangPublisher\Facades\Locale;
use Helldar\LaravelLangPublisher\Services\Processors\DeleteJson;
use Symfony\Component\Console\Exception\RuntimeException;
use Tests\TestCase;

class UninstallTest extends TestCase
{
    protected $processor = DeleteJson::class;

    protected $is_json = true;

    public function testWithoutLanguageAttributeFromCommand()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "locales")');

        $this->artisan('lang:uninstall', ['--json' => true]);
    }

    public function testUninstall()
    {
        $locales = ['bg', 'da', 'gl', 'is'];

        foreach ($locales as $locale) {
            $path = $this->path->target($locale);

            $this->localization()
                ->setPath($this->getPath())
                ->setProcessor($this->getProcessor())
                ->run($locale, true);

            method_exists($this, 'assertFileDoesNotExist')
                ? $this->assertFileDoesNotExist($path)
                : $this->assertFileNotExists($path);
        }
    }

    public function testUninstallDefaultLocale()
    {
        $locale = Locale::getDefault();
        $path   = $this->path->target($locale);

        $this->localization()
            ->setPath($this->getPath())
            ->setProcessor($this->getProcessor())
            ->run($locale, true);

        $this->assertFileExists($path);
    }
}