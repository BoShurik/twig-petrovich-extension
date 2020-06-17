<?php

/*
 * This file is part of the twig-petrovich-extension.
 *
 * (c) Alexander Borisov <boshurik@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BoShurik\Petrovich\Twig\Extension\Tests;

use BoShurik\Petrovich\Twig\Extension\PetrovichExtension;
use Staticall\Petrovich\Petrovich;
use Staticall\Petrovich\Petrovich\Loader;
use Twig\Test\IntegrationTestCase;

class IntegrationTest extends IntegrationTestCase
{
    protected function getExtensions()
    {
        return [
            new PetrovichExtension(new Petrovich(Loader::load(__DIR__.'/../vendor/cloudloyalty/petrovich-rules/rules.json'))),
        ];
    }

    protected function getFixturesDir()
    {
        return __DIR__.'/Fixtures/';
    }
}
