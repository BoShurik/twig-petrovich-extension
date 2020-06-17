<?php

/*
 * This file is part of the twig-petrovich-extension.
 *
 * (c) Alexander Borisov <boshurik@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BoShurik\Petrovich\Twig\Extension;

use Staticall\Petrovich\Petrovich;
use Staticall\Petrovich\Petrovich\Ruleset;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class PetrovichExtension extends AbstractExtension
{
    private const CASES = [
        'nomenative' => Ruleset::CASE_NOMENATIVE, // именительный
        'genitive' => Ruleset::CASE_GENITIVE, // родительный
        'dative' => Ruleset::CASE_DATIVE, // дательный
        'accusative' => Ruleset::CASE_ACCUSATIVE, // винительный
        'instrumental' => Ruleset::CASE_INSTRUMENTAL, // творительный
        'prepositional' => Ruleset::CASE_PREPOSITIONAL, // предложный
    ];

    /**
     * @var Petrovich|callable
     */
    private $petrovich;

    /**
     * @param Petrovich|callable $petrovich
     */
    public function __construct($petrovich)
    {
        $this->petrovich = $petrovich;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('inflect_full_name', [$this, 'inflectFullName']),
            new TwigFunction('inflect_full_name_*_*', function (string $case, string $gender, string $value) {
                return $this->inflectFullName($value, $case, $gender);
            }),
            new TwigFunction('inflect_full_name_*', function (string $case, string $value) {
                return $this->inflectFullName($value, $case);
            }),
            new TwigFunction('inflect_first_name', [$this, 'inflectFirstName']),
            new TwigFunction('inflect_first_name_*_*'),
            new TwigFunction('inflect_first_name_*_*', function (string $case, string $gender, string $value) {
                return $this->inflectFirstName($value, $case, $gender);
            }),
            new TwigFunction('inflect_last_name', [$this, 'inflectLastName']),
            new TwigFunction('inflect_last_name_*_*', function (string $case, string $gender, string $value) {
                return $this->inflectLastName($value, $case, $gender);
            }),
            new TwigFunction('inflect_middle_name', [$this, 'inflectMiddleName']),
            new TwigFunction('inflect_middle_name_*_*', function (string $case, string $gender, string $value) {
                return $this->inflectMiddleName($value, $case, $gender);
            }),
            new TwigFunction('inflect_middle_name_*', function (string $case, string $value) {
                return $this->inflectMiddleName($value, $case);
            }),
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('inflect_full_name', [$this, 'inflectFullName']),
            new TwigFilter('inflect_full_name_*_*', function (string $case, string $gender, string $value) {
                return $this->inflectFullName($value, $case, $gender);
            }),
            new TwigFilter('inflect_full_name_*', function (string $case, string $value) {
                return $this->inflectFullName($value, $case);
            }),
            new TwigFilter('inflect_first_name', [$this, 'inflectFirstName']),
            new TwigFilter('inflect_first_name_*_*'),
            new TwigFilter('inflect_first_name_*_*', function (string $case, string $gender, string $value) {
                return $this->inflectFirstName($value, $case, $gender);
            }),
            new TwigFilter('inflect_last_name', [$this, 'inflectLastName']),
            new TwigFilter('inflect_last_name_*_*', function (string $case, string $gender, string $value) {
                return $this->inflectLastName($value, $case, $gender);
            }),
            new TwigFilter('inflect_middle_name', [$this, 'inflectMiddleName']),
            new TwigFilter('inflect_middle_name_*_*', function (string $case, string $gender, string $value) {
                return $this->inflectMiddleName($value, $case, $gender);
            }),
            new TwigFilter('inflect_middle_name_*', function (string $case, string $value) {
                return $this->inflectMiddleName($value, $case);
            }),
        ];
    }

    public function inflectFullName(string $value, string $case, string $gender = null): string
    {
        return $this->getPetrovich()->inflectFullName($value, $this->convertCase($case), $gender);
    }

    public function inflectFirstName(string $value, string $case, string $gender): string
    {
        return $this->getPetrovich()->inflectFirstName($value, $this->convertCase($case), $gender);
    }

    public function inflectLastName(string $value, string $case, string $gender): string
    {
        return $this->getPetrovich()->inflectLastName($value, $this->convertCase($case), $gender);
    }

    public function inflectMiddleName(string $value, string $case, string $gender = null): string
    {
        return $this->getPetrovich()->inflectMiddleName($value, $this->convertCase($case), $gender);
    }

    private function getPetrovich(): Petrovich
    {
        if ($this->petrovich instanceof Petrovich) {
            return $this->petrovich;
        }

        /** @var mixed $petrovich */
        $petrovich = \call_user_func($this->petrovich);
        if (!$petrovich instanceof Petrovich) {
            throw new PetrovichExtensionException(sprintf('Callable must return %s instance', Petrovich::class));
        }

        return $this->petrovich = $petrovich;
    }

    private function convertCase(string $case): int
    {
        if (isset(self::CASES[$case])) {
            return self::CASES[$case];
        }
        if (is_numeric($case)) {
            $case = (int) $case;
            if (\in_array($case, self::CASES)) {
                return $case;
            }
        }

        throw new PetrovichExtensionException(sprintf('Unknown case "%s"', $case));
    }
}
