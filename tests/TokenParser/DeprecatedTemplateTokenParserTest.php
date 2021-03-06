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

namespace Sonata\Twig\Tests\TokenParser;

use PHPUnit\Framework\TestCase;
use Sonata\Twig\Node\DeprecatedTemplateNode;
use Sonata\Twig\TokenParser\DeprecatedTemplateTokenParser;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Node\Expression\ConstantExpression;
use Twig\Node\Node;
use Twig\Parser;
use Twig\Source;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 *
 * NEXT_MAJOR: Remove this class.
 *
 * @group legacy
 *
 * @psalm-suppress DeprecatedClass
 */
final class DeprecatedTemplateTokenParserTest extends TestCase
{
    public function testCompileValid(): void
    {
        $source = new Source('{% sonata_template_deprecate "new.html.twig" %}', 'test');
        $expected = new DeprecatedTemplateNode(
            new ConstantExpression('new.html.twig', 1),
            1,
            'sonata_template_deprecate'
        );

        $actual = $this->compile($source);

        static::assertSame($expected->getTemplateLine(), $actual->getTemplateLine());
        static::assertCount($expected->count(), $actual);
    }

    public function testCompileException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $source = new Source('{% sonata_template_deprecate %}', 'test');

        $this->compile($source);
    }

    private function compile(Source $source): Node
    {
        $env = new Environment(new ArrayLoader([]), ['cache' => false, 'autoescape' => false, 'optimizations' => 0]);
        $env->addTokenParser(new DeprecatedTemplateTokenParser());

        $stream = $env->tokenize($source);
        $parser = new Parser($env);

        // "0" is passed as string due an issue with the allowed node name types.
        // @see https://github.com/twigphp/Twig/issues/3294
        return $parser->parse($stream)->getNode('body')->getNode('0');
    }
}
