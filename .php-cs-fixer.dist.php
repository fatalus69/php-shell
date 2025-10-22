<?php

$rules = [
    '@PhpCsFixer' => true,
    'blank_lines_before_namespace' => true,
    'blank_line_after_namespace' => true,
    'single_line_after_imports' => true,
    'single_blank_line_at_eof' => true,
    'multiline_whitespace_before_semicolons' => false,
    'no_unused_imports' => true,
    'function_declaration' => [
        'closure_function_spacing' => 'one',
        'trailing_comma_single_line' => false,
    ],
    'cast_spaces' => [
        'space' => 'none',
    ],
    'type_declaration_spaces' => true,
    'control_structure_braces' => false,
    'concat_space' => ['spacing' => 'one'],
    'no_trailing_whitespace' => true,
    'no_whitespace_in_blank_line' => true,
    'statement_indentation' => true,
    'return_type_declaration' => ['space_before' => 'none'],
    'visibility_required' => ['elements' => ['property', 'method', 'const']],
    'yoda_style' => false,
    'single_quote' => false,
    'ordered_imports' => false,
    'trailing_comma_in_multiline' => false,
    'global_namespace_import' => [
        'import_classes'   => true,
        'import_functions' => false,
        'import_constants' => false,
    ],
    'fully_qualified_strict_types' => [
        'import_symbols' => true,
    ],
];

$config = new PhpCsFixer\Config();
// Use multiple cores to speed up process.
$config->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect());

$finder = PhpCsFixer\Finder::create()->exclude('examples')->in(__DIR__);

return $config->setRules($rules)->setFinder($finder);
