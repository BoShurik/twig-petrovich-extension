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
use BoShurik\Petrovich\Twig\Extension\PetrovichExtensionException;
use PHPUnit\Framework\TestCase;
use Staticall\Petrovich\Petrovich;
use Staticall\Petrovich\Petrovich\Loader;

class PetrovichExtensionTest extends TestCase
{
    public function testPetrovichFactory()
    {
        $factory = function () {
            return new Petrovich(Loader::load(__DIR__.'/../vendor/cloudloyalty/petrovich-rules/rules.json'));
        };
        $extension = new PetrovichExtension($factory);
        $this->assertSame('Тестова Теста Тестовича', $extension->inflectFullName('Тестов Тест Тестович', Petrovich\Ruleset::CASE_GENITIVE));
    }

    public function testWrongPetrovichFactory()
    {
        $factory = function () {
            return null;
        };
        $extension = new PetrovichExtension($factory);
        $this->expectException(PetrovichExtensionException::class);
        $extension->inflectFullName('Тестов Тест Тестович', Petrovich\Ruleset::CASE_GENITIVE);
    }

    public function testCaseConvert()
    {
        $extension = new PetrovichExtension(new Petrovich(Loader::load(__DIR__.'/../vendor/cloudloyalty/petrovich-rules/rules.json')));
        $this->assertSame('Тестову Тесту Тестовичу', $extension->inflectFullName('Тестов Тест Тестович', Petrovich\Ruleset::CASE_DATIVE));
    }

    public function testWrongCase()
    {
        $extension = new PetrovichExtension(new Petrovich(Loader::load(__DIR__.'/../vendor/cloudloyalty/petrovich-rules/rules.json')));
        $this->expectException(PetrovichExtensionException::class);
        $extension->inflectFullName('Тестов Тест Тестович', 'foo');
    }
}
