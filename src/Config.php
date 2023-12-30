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
            ->setRules([
                '@PSR2' => true,
                '@Symfony' => true,
                '@DoctrineAnnotation' => true,
                '@PhpCsFixer' => true,
                'header_comment' => [
                    'comment_type' => 'PHPDoc',
                    'separate' => 'none',
                    'location' => 'after_declare_strict',
                ],
                'array_syntax' => [
                    'syntax' => 'short',
                ],
                'blank_line_before_statement' => [
                    'statements' => [
                        'declare',
                    ],
                ],
                'list_syntax' => [
                    'syntax' => 'short',
                ],
                'concat_space' => [
                    'spacing' => 'one',
                ],
                'general_phpdoc_annotation_remove' => [
                    'annotations' => [
                        'author',
                    ],
                ],
                'global_namespace_import' => [
                    'import_classes' => true,
                    'import_constants' => true,
                    'import_functions' => null,
                ],
                'ordered_imports' => [
                    'imports_order' => [
                        'class', 'function', 'const',
                    ],
                    'sort_algorithm' => 'alpha',
                ],
                'single_line_comment_style' => [
                    'comment_types' => [
                    ],
                ],
                'yoda_style' => [
                    'always_move_variable' => false,
                    'equal' => false,
                    'identical' => false,
                ],
                'phpdoc_align' => [
                    'align' => 'left',
                ],
                'multiline_whitespace_before_semicolons' => [
                    'strategy' => 'no_multi_line',
                ],
                'constant_case' => [
                    'case' => 'lower',
                ],
                'class_attributes_separation' => true,
                'combine_consecutive_unsets' => true,
                'declare_strict_types' => true,
                'linebreak_after_opening_tag' => true,
                'lowercase_static_reference' => true,
                'no_useless_else' => true,
                'no_unused_imports' => true,
                'not_operator_with_successor_space' => true,
                'not_operator_with_space' => false,
                'ordered_class_elements' => true,
                'php_unit_strict' => false,
                'phpdoc_separation' => false,
                'single_quote' => true,
                'standardize_not_equals' => true,
                'multiline_comment_opening_closing' => true,
                'php_unit_test_class_requires_covers' => true,
                'php_unit_internal_class' => true,
                'ordered_types' => [
                    'null_adjustment' => 'always_last',
                    'sort_algorithm' => 'none',
                ],
                'phpdoc_types_order' => [
                    'null_adjustment' => 'always_last',
                    'sort_algorithm' => 'none',
                ],
                'single_line_empty_body' => false,
                'fully_qualified_strict_types' => [
                    'import_symbols' => false,
                ],
            ]);
    }

    public function setRule(string $rule, mixed $value): ConfigInterface
    {
        $rules = $this->getRules();
        $rules[$rule] = $value;
        return $this->setRules($rules);
    }

    /**
     * @param array<string, mixed> $rules
     */
    public function addRules(array $rules): ConfigInterface
    {
        return $this->setRules(array_merge_recursive($this->getRules(), $rules));
    }

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
        $contacts = implode("\n", $contacts);
        $rules = $this->getRules();
        $rules['header_comment']['header'] = implode("\n", $headers);

        return $this->setRules($rules);
    }
}
