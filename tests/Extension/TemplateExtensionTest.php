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
use Sonata\Doctrine\Adapter\AdapterInterface;
use Sonata\Twig\Extension\TemplateExtension;

final class TemplateExtensionTest extends TestCase
{
    /**
     * NEXT_MAJOR: Remove this test.
     *
     * @psalm-suppress DeprecatedMethod
     *
     * @group legacy
     */
    public function testSafeUrl(): void
    {
        $adapter = $this->createMock(AdapterInterface::class);
        $adapter->expects(static::once())->method('getUrlsafeIdentifier')->willReturn('safe-parameter');

        $extension = new TemplateExtension(true, $adapter);

        static::assertSame('safe-parameter', $extension->getUrlsafeIdentifier(new \stdClass()));
    }
}
