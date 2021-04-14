<?php

namespace Tests\Support;

use Helldar\LaravelLangPublisher\Services\Missing;
use Tests\TestCase;

class MissingTest extends TestCase
{
    public function testMissing()
    {
        $locales = $this->service()->missing();

        $this->assertIsArray($locales);
        $this->assertEmpty($locales, $this->message($locales));
    }

    public function testUnnecessary()
    {
        $locales = $this->service()->unnecessary();

        $this->assertIsArray($locales);
        $this->assertEmpty($locales, $this->message($locales));
    }

    protected function service(): Missing
    {
        return new Missing();
    }

    protected function message(array $locales): string
    {
        return 'Locales: ' . $this->implode($locales);
    }

    protected function implode(array $array): string
    {
        return implode(', ', $array);
    }
}