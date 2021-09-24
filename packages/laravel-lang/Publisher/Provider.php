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

namespace LaravelLang\Lang\Publisher;

use Helldar\LaravelLangPublisher\Plugins\BaseProvider;
use LaravelLang\Lang\Publisher\Plugins\Breeze;
use LaravelLang\Lang\Publisher\Plugins\Cashier;
use LaravelLang\Lang\Publisher\Plugins\Fortify;
use LaravelLang\Lang\Publisher\Plugins\Jetstream;
use LaravelLang\Lang\Publisher\Plugins\Laravel;
use LaravelLang\Lang\Publisher\Plugins\Lumen;
use LaravelLang\Lang\Publisher\Plugins\Nova;
use LaravelLang\Lang\Publisher\Plugins\SparkPaddle;
use LaravelLang\Lang\Publisher\Plugins\SparkStripe;

class Provider extends BaseProvider
{
    /**
     * Indicates the base path of the provider.
     *
     * @return string
     */
    public function basePath(): string
    {
        return base_path('vendor/laravel-lang/lang');
    }

    /**
     * @return \Helldar\Contracts\LangPublisher\Plugin[]
     */
    public function plugins(): array
    {
        return $this->resolvePlugins([
            Breeze::class,
            Cashier::class,
            Fortify::class,
            Jetstream::class,
            Laravel::class,
            Lumen::class,
            Nova::class,
            SparkPaddle::class,
            SparkStripe::class,
        ]);
    }
}