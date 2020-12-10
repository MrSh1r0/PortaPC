<?php

$finder = PhpCsFixer\Finder::create()
    //->exclude('somedir')
    //->notPath('src/Symfony/Component/Translation/Tests/fixtures/resources.php'
    ->in(__DIR__)
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        'strict_param' => false,
        'array_syntax' => ['syntax' => 'long'],
        'no_spaces_around_offset' => [
          'positions' => [ "inside", "outside" ]
        ],
        'no_spaces_inside_parenthesis' => true,
        'array_indentation' => true,
        'no_extra_blank_lines' => true,
        'object_operator_without_whitespace' => true,
        'no_multiline_whitespace_before_semicolons' => true,
        'switch_case_space' => true,
        'indentation_type' => true,
        'blank_line_after_namespace' => true,
        "no_break_comment"=> true,
        "no_closing_tag"=> true,
        'switch_case_semicolon_to_colon' => true,
        "no_spaces_after_function_name"=> true,
        "no_trailing_whitespace"=> true,
        "no_trailing_whitespace_in_comment"=> true,
        'no_whitespace_before_comma_in_array'=> true,
        'braces' => [
            'allow_single_line_closure' => true,
            'position_after_functions_and_oop_constructs' => 'same'],
    ])
    ->setFinder($finder)
;
