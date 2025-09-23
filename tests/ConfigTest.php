<?php

declare(strict_types=1);
/**
 * This file is part of huangdijia/php-coding-standard.
 *
 * @link     https://github.com/huangdijia/php-coding-standard
 * @document https://github.com/huangdijia/php-coding-standard/blob/main/README.md
 * @contact  Deeka Wong <huangdijia@gmail.com>
 */

namespace Huangdijia\PhpCsFixer\Tests;

use Huangdijia\PhpCsFixer\Config;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ConfigTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config();
    }

    public function testConstructorSetsDefaultConfiguration(): void
    {
        $config = new Config('test');

        // Test cache is disabled by default
        $this->assertFalse($config->getUsingCache());

        // Test risky rules are enabled by default
        $this->assertTrue($config->getRiskyAllowed());

        // Test default rules are loaded
        $rules = $config->getRules();
        $this->assertIsArray($rules);
        $this->assertArrayHasKey('@PSR2', $rules);
        $this->assertArrayHasKey('@Symfony', $rules);
        $this->assertArrayHasKey('@DoctrineAnnotation', $rules);
        $this->assertArrayHasKey('@PhpCsFixer', $rules);
        $this->assertTrue($rules['@PSR2']);
        $this->assertTrue($rules['@Symfony']);
        $this->assertTrue($rules['@DoctrineAnnotation']);
        $this->assertTrue($rules['@PhpCsFixer']);
    }

    public function testSetRule(): void
    {
        $this->config->setRule('yoda_style', false);
        $rules = $this->config->getRules();

        $this->assertFalse($rules['yoda_style']);
    }

    public function testSetRuleReturnsConfigInstance(): void
    {
        $result = $this->config->setRule('yoda_style', false);

        $this->assertSame($this->config, $result);
    }

    public function testAddRules(): void
    {
        $customRules = [
            'array_syntax' => ['syntax' => 'long'],
            'strict_comparison' => true,
        ];

        $this->config->addRules($customRules);
        $rules = $this->config->getRules();

        $this->assertEquals(['syntax' => 'long'], $rules['array_syntax']);
        $this->assertTrue($rules['strict_comparison']);
    }

    public function testAddRulesReturnsConfigInstance(): void
    {
        $result = $this->config->addRules(['strict_comparison' => true]);

        $this->assertSame($this->config, $result);
    }

    public function testAddRulesMergesWithExistingRules(): void
    {
        // First set some rules
        $this->config->setRule('test_rule', 'initial_value');

        // Then add more rules
        $this->config->addRules(['additional_rule' => 'new_value']);

        $rules = $this->config->getRules();
        $this->assertEquals('initial_value', $rules['test_rule']);
        $this->assertEquals('new_value', $rules['additional_rule']);
    }

    public function testEnableCache(): void
    {
        $this->config->enableCache('.custom-cache');

        $this->assertTrue($this->config->getUsingCache());
        $this->assertEquals('.custom-cache', $this->config->getCacheFile());
    }

    public function testEnableCacheWithDefaultFile(): void
    {
        $this->config->enableCache();

        $this->assertTrue($this->config->getUsingCache());
        $this->assertEquals('.php-cs-fixer.cache', $this->config->getCacheFile());
    }

    public function testEnableCacheReturnsConfigInstance(): void
    {
        $result = $this->config->enableCache();

        $this->assertSame($this->config, $result);
    }

    public function testDisableRiskyRules(): void
    {
        $this->config->disableRiskyRules();

        $this->assertFalse($this->config->getRiskyAllowed());

        $rules = $this->config->getRules();
        $this->assertArrayNotHasKey('php_unit_strict', $rules);
        $this->assertArrayNotHasKey('php_unit_test_class_requires_covers', $rules);
        $this->assertArrayNotHasKey('nullable_type_declaration_for_default_null_value', $rules);
    }

    public function testDisableRiskyRulesReturnsConfigInstance(): void
    {
        $result = $this->config->disableRiskyRules();

        $this->assertSame($this->config, $result);
    }

    public function testForLaravel(): void
    {
        $this->config->forLaravel();

        $rules = $this->config->getRules();
        $this->assertFalse($rules['not_operator_with_successor_space']);
        $this->assertFalse($rules['php_unit_test_class_requires_covers']);
        $this->assertEquals(['comment_types' => ['hash']], $rules['single_line_comment_style']);
    }

    public function testForLaravelReturnsConfigInstance(): void
    {
        $result = $this->config->forLaravel();

        $this->assertSame($this->config, $result);
    }

    public function testSetHeaderCommentWithAllParameters(): void
    {
        $this->config->setHeaderComment(
            'test/project',
            'https://github.com/test/project',
            'https://github.com/test/project/blob/main/README.md',
            ['John Doe' => 'john@example.com', 'Jane Smith' => 'jane@example.com']
        );

        $rules = $this->config->getRules();
        $expectedHeader = "This file is part of test/project.\n\n"
                         . "@link     https://github.com/test/project\n"
                         . "@document https://github.com/test/project/blob/main/README.md\n"
                         . "@contact  John Doe <john@example.com>\n"
                         . '@contact  Jane Smith <jane@example.com>';

        $this->assertEquals($expectedHeader, $rules['header_comment']['header']);
    }

    public function testSetHeaderCommentWithProjectNameOnly(): void
    {
        $this->config->setHeaderComment('simple/project');

        $rules = $this->config->getRules();
        $expectedHeader = "This file is part of simple/project.\n";

        $this->assertEquals($expectedHeader, $rules['header_comment']['header']);
    }

    public function testSetHeaderCommentWithArrayOfEmails(): void
    {
        $this->config->setHeaderComment(
            'test/project',
            null,
            null,
            ['john@example.com', 'jane@example.com']
        );

        $rules = $this->config->getRules();
        $expectedHeader = "This file is part of test/project.\n\n"
                         . "@contact  john@example.com\n"
                         . '@contact  jane@example.com';

        $this->assertEquals($expectedHeader, $rules['header_comment']['header']);
    }

    public function testSetHeaderCommentReturnsConfigInstance(): void
    {
        $result = $this->config->setHeaderComment('test/project');

        $this->assertSame($this->config, $result);
    }

    public function testDefaultRulesConfiguration(): void
    {
        $rules = $this->config->getRules();

        // Test some key default rules
        $this->assertTrue($rules['declare_strict_types']);
        $this->assertEquals(['syntax' => 'short'], $rules['array_syntax']);
        $this->assertEquals(['syntax' => 'short'], $rules['list_syntax']);
        $this->assertTrue($rules['single_quote']);
        $this->assertTrue($rules['combine_consecutive_unsets']);
        $this->assertTrue($rules['no_useless_else']);
        $this->assertTrue($rules['linebreak_after_opening_tag']);
        $this->assertTrue($rules['lowercase_static_reference']);

        // Test header comment default configuration
        $this->assertArrayHasKey('header_comment', $rules);
        $this->assertEquals('PHPDoc', $rules['header_comment']['comment_type']);
        $this->assertEquals('none', $rules['header_comment']['separate']);
        $this->assertEquals('after_declare_strict', $rules['header_comment']['location']);

        // Test phpdoc configuration
        $this->assertEquals(['annotations' => ['author']], $rules['general_phpdoc_annotation_remove']);
        $this->assertEquals(['align' => 'left'], $rules['phpdoc_align']);
        $this->assertFalse($rules['phpdoc_separation']);

        // Test import configuration
        $this->assertEquals([
            'import_classes' => true,
            'import_constants' => true,
            'import_functions' => null,
        ], $rules['global_namespace_import']);

        $this->assertEquals([
            'imports_order' => ['class', 'function', 'const'],
            'sort_algorithm' => 'alpha',
        ], $rules['ordered_imports']);

        // Test PHPUnit rules
        $this->assertFalse($rules['php_unit_strict']);
        $this->assertTrue($rules['php_unit_test_class_requires_covers']);
        $this->assertTrue($rules['php_unit_internal_class']);
    }

    public function testChainingMethods(): void
    {
        $result = $this->config
            ->setRule('yoda_style', false)
            ->addRules(['strict_comparison' => true])
            ->enableCache()
            ->setHeaderComment('chained/project');

        $this->assertSame($this->config, $result);

        $rules = $this->config->getRules();
        $this->assertFalse($rules['yoda_style']);
        $this->assertTrue($rules['strict_comparison']);
        $this->assertTrue($this->config->getUsingCache());
        $this->assertStringContainsString('chained/project', $rules['header_comment']['header']);
    }
}
