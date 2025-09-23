<?php

declare(strict_types=1);
/**
 * This file is part of huangdijia/php-coding-standard.
 *
 * @link     https://github.com/huangdijia/php-coding-standard
 * @document https://github.com/huangdijia/php-coding-standard/blob/main/README.md
 * @contact  Deeka Wong <huangdijia@gmail.com>
 */

namespace Huangdijia\PhpCsFixer;

use PhpCsFixer\ConfigInterface;

use function array_is_list;
use function array_merge_recursive;

class Config extends \PhpCsFixer\Config
{
    public function __construct(string $name = 'default')
    {
        parent::__construct($name);
        $this->setUsingCache(false)
            ->setRiskyAllowed(true)
            ->setRules($this->getDefaultRules());
    }

    public function setRule(string $rule, mixed $value): static
    {
        $rules = $this->getRules();
        $rules[$rule] = $value;
        $this->setRules($rules);

        return $this;
    }

    /**
     * @param array<string, mixed> $rules
     */
    public function addRules(array $rules): static
    {
        $this->setRules(array_merge_recursive($this->getRules(), $rules));

        return $this;
    }

    /**
     * Enable caching for better performance in large projects.
     */
    public function enableCache(string $cacheFile = '.php-cs-fixer.cache'): static
    {
        $this->setUsingCache(true)->setCacheFile($cacheFile);

        return $this;
    }

    /**
     * Disable risky rules for safer automated fixes.
     */
    public function disableRiskyRules(): static
    {
        $rules = $this->getRules();

        // Remove some risky rules that might break functionality
        unset(
            $rules['php_unit_strict'],
            $rules['php_unit_test_class_requires_covers'],
            $rules['nullable_type_declaration_for_default_null_value']
        );

        $this->setRiskyAllowed(false)->setRules($rules);

        return $this;
    }

    /**
     * Configure for Laravel projects with specific optimizations.
     */
    public function forLaravel(): static
    {
        $this->addRules([
            'not_operator_with_successor_space' => false, // Laravel prefers !$var
            'php_unit_test_class_requires_covers' => false, // Laravel tests don't require @covers
            'single_line_comment_style' => [
                'comment_types' => ['hash'], // Allow # comments in Laravel
            ],
        ]);

        return $this;
    }

    /**
     * @param array<string, string>|array<int, string> $contacts
     */
    public function setHeaderComment(string $projectName, ?string $projectLink = null, ?string $projectDocument = null, array $contacts = []): static
    {
        $headers = [
            "This file is part of {$projectName}.",
            '',
        ];
        if ($projectLink) {
            $headers[] = "@link     {$projectLink}";
        }
        if ($projectDocument) {
            $headers[] = "@document {$projectDocument}";
        }
        if ($contacts) {
            $isList = array_is_list($contacts);
            array_walk($contacts, function ($email, $name) use ($isList, &$headers) {
                $headers[] = $isList ? sprintf('@contact  %s', $email) : sprintf('@contact  %s <%s>', $name, $email);
            });
        }
        $rules = $this->getRules();
        $rules['header_comment']['header'] = implode("\n", $headers);

        $this->setRules($rules);

        return $this;
    }

    /**
     * Get the default rules configuration.
     *
     * @return array<string, mixed>
     */
    private function getDefaultRules(): array
    {
        return [
            // Base rulesets
            '@PSR2' => true,
            '@Symfony' => true,
            '@DoctrineAnnotation' => true,
            '@PhpCsFixer' => true,

            // Header and documentation
            'header_comment' => [
                'comment_type' => 'PHPDoc',
                'separate' => 'none',
                'location' => 'after_declare_strict',
            ],
            'general_phpdoc_annotation_remove' => [
                'annotations' => ['author'],
            ],
            'phpdoc_align' => [
                'align' => 'left',
            ],
            'phpdoc_separation' => false,
            'phpdoc_types_order' => [
                'null_adjustment' => 'always_first',
                'sort_algorithm' => 'none',
            ],

            // Array and list syntax
            'array_syntax' => [
                'syntax' => 'short',
            ],
            'list_syntax' => [
                'syntax' => 'short',
            ],

            // Imports and namespaces
            'global_namespace_import' => [
                'import_classes' => true,
                'import_constants' => true,
                'import_functions' => null,
            ],
            'ordered_imports' => [
                'imports_order' => ['class', 'function', 'const'],
                'sort_algorithm' => 'alpha',
            ],
            'no_unused_imports' => true,

            // Code style and formatting
            'blank_line_before_statement' => [
                'statements' => ['declare'],
            ],
            'concat_space' => [
                'spacing' => 'one',
            ],
            'single_line_comment_style' => [
                'comment_types' => [],
            ],
            'yoda_style' => [
                'always_move_variable' => false,
                'equal' => false,
                'identical' => false,
            ],
            'multiline_whitespace_before_semicolons' => [
                'strategy' => 'no_multi_line',
            ],
            'single_quote' => true,
            'standardize_not_equals' => true,
            'multiline_comment_opening_closing' => true,

            // Type declarations and constants
            'constant_case' => [
                'case' => 'lower',
            ],
            'declare_strict_types' => true,
            'fully_qualified_strict_types' => [
                'import_symbols' => false,
                'phpdoc_tags' => [],
            ],
            'nullable_type_declaration_for_default_null_value' => true,
            'ordered_types' => [
                'null_adjustment' => 'always_first',
                'sort_algorithm' => 'none',
            ],

            // Class and method organization
            'class_attributes_separation' => true,
            'ordered_class_elements' => true,
            'single_line_empty_body' => false,

            // Control structures and operators
            'combine_consecutive_unsets' => true,
            'no_useless_else' => true,
            'not_operator_with_successor_space' => true,
            'not_operator_with_space' => false,

            // PHP-specific optimizations
            'linebreak_after_opening_tag' => true,
            'lowercase_static_reference' => true,

            // PHPUnit rules (disabled by default, can be enabled per project)
            'php_unit_strict' => false,
            'php_unit_test_class_requires_covers' => true,
            'php_unit_internal_class' => true,
        ];
    }
}
