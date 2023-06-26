<?php

declare(strict_types=1);
/**
 * This file is part of huangdijia/php-coding-standard.
 *
 * @link    https://github.com/huangdijia/php-coding-standard
 * @contact Deeka Wong <huangdijia@gmail.com>
 */
namespace Huangdijia\PhpCsFixer;

use PhpCsFixer\ConfigInterface;

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
                'list_syntax' => [
                    'syntax' => 'short',
                ],
                'concat_space' => [
                    'spacing' => 'one',
                ],
                'global_namespace_import' => [
                    'import_classes' => true,
                    'import_constants' => true,
                    'import_functions' => null,
                ],
                'blank_line_before_statement' => [
                    'statements' => [
                        'declare',
                    ],
                ],
                'general_phpdoc_annotation_remove' => [
                    'annotations' => [
                        'author',
                    ],
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
            ]);
    }

    public function setRule(string $rule, mixed $value): ConfigInterface
    {
        $rules = $this->getRules();
        $rules[$rule] = $value;
        return $this->setRules($rules);
    }

    /** @param array<string, mixed> $rules */
    public function addRules(array $rules): ConfigInterface
    {
        return $this->setRules(array_merge_recursive($this->getRules(), $rules));
    }

    public function setHeaderComment(string $projectName, string $projectLink, array $contacts = []): static
    {
        foreach ($contacts as $name => &$mail) {
            $mail = sprintf('@contact %s <%s>', $name, $mail);
        }

        $contacts = implode("\n", $contacts);
        $rules = $this->getRules();
        $rules['header_comment']['header'] = <<<TEXT
This file is part of {$projectName}.

@link    {$projectLink}
{$contacts}
TEXT;

        return $this->setRules($rules);
    }
}
