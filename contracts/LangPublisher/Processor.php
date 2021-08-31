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

namespace Helldar\Contracts\LangPublisher;

interface Processor
{
    public function provider(Provider $provider): self;

    public function locales(array $locales): self;

    public function hasForce(bool $force = false): self;

    public function hasLoad(bool $has_load = true): self;

    public function store(): void;
}
