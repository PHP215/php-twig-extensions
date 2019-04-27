<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\Twig\Tests\Extension;

use PHPUnit\Framework\TestCase;
use Sonata\Twig\Extension\FormTypeExtension;

class FormTypeExtensionTest extends TestCase
{
    public function testGetName(): void
    {
        $extension = new FormTypeExtension(true);
        $this->assertSame('sonata_twig_wrapping', $extension->getName());
    }

    public function testGetGlobals(): void
    {
        $extension = new FormTypeExtension(true);

        $this->assertArrayHasKey(
            'wrap_fields_with_addons',
            $globals = $extension->getGlobals()
        );
        $this->assertTrue($globals['wrap_fields_with_addons']);

        $extension = new FormTypeExtension(false);

        $this->assertArrayHasKey(
            'wrap_fields_with_addons',
            $globals = $extension->getGlobals()
        );
        $this->assertFalse($globals['wrap_fields_with_addons']);
    }
}
