# PHP Coding Standard

PHP Coding Standard is a PHP package that provides custom coding standards configuration for PHP CS Fixer. It extends friendsofphp/php-cs-fixer with opinionated rules and includes the ergebnis/composer-normalize tool for JSON formatting.

Always reference these instructions first and fallback to search or bash commands only when you encounter unexpected information that does not match the info here.

## Working Effectively

### Environment Requirements
- PHP 8.1 or higher (tested with PHP 8.3.6)
- Composer package manager

### Bootstrap and Dependencies
- Install dependencies: `composer install --no-interaction`
  - Takes approximately ~38 seconds. NEVER CANCEL. Set timeout to 90+ seconds.
  - May show GitHub authentication warnings but will complete successfully using fallback methods.
  - Creates vendor/ directory and composer.lock file.

### Core Operations
- Format PHP code: `composer cs-fix` (fixes all files) or `composer cs-fix --dry-run` (preview changes only)
  - Takes less than 1 second for small codebases. Set timeout to 30+ seconds for safety.
  - Uses parallel processing (4 cores, 20 files per process) for performance.
  - Applies 39 predefined rules including PSR2, Symfony, DoctrineAnnotation, and PhpCsFixer standards.
- Normalize composer.json: `composer json-fix` or `composer json-fix --dry-run`
  - Takes less than 1 second. Set timeout to 15+ seconds.
- Check PHP syntax: `php -l <file.php>`
- Test direct functionality: `php -r "require 'vendor/autoload.php'; use Huangdijia\PhpCsFixer\Config; echo 'Config works: ' . count((new Config())->getRules()) . ' rules\n';"`

### File Validation and Linting
- ALWAYS run `composer cs-fix --dry-run` before committing changes to preview formatting.
- ALWAYS run `composer json-fix --dry-run` before committing changes to verify composer.json.
- ALWAYS run `php -l` on any modified PHP files to check syntax.
- The CI build will fail if code formatting is not applied.

## Validation

### Manual Testing Scenarios
- Create a test PHP file with intentionally poor formatting:
  ```bash
  echo '<?php
  function      test(  $a,$b  )
  {
  return$a+$b;
  }' > /tmp/test.php
  ```
- Run `vendor/bin/php-cs-fixer fix /tmp/test.php --dry-run --diff` to verify the formatter works.
- Expected: File should be reformatted with proper spacing, strict types declaration, and header comment.

### Configuration Testing
- Test Config class instantiation: `php -r "require 'vendor/autoload.php'; new Huangdijia\PhpCsFixer\Config();"`
- Verify rule count: Should return 39 rules with cache disabled and risky rules allowed.

### Integration Testing
- Copy `.php-cs-fixer.php.stub` to a new project and update the configuration.
- Verify the stub file works as a starting template for new projects.

## Common Tasks

### Repository Structure
```
.
├── .github/             # GitHub workflows and configurations
│   └── workflows/
│       └── release.yaml # Automated release workflow
├── .vscode/             # VS Code settings and extensions
│   ├── extensions.json  # Recommends intelephense and php-cs-fixer
│   ├── settings.json    # PHP formatting configuration
│   └── cspell.json     # Spell check configuration
├── src/
│   └── Config.php      # Main configuration class
├── .php-cs-fixer.php   # Active project configuration
├── .php-cs-fixer.php.stub # Template for end users
├── composer.json       # Package definition and scripts
├── README.md           # Usage documentation
└── LICENSE            # MIT license
```

### Key Files and Purpose
- `src/Config.php`: Main class extending PhpCsFixer\Config with custom rules
- `.php-cs-fixer.php`: Project's own formatting configuration
- `.php-cs-fixer.php.stub`: Template configuration file for end users
- `composer.json`: Defines package dependencies and custom scripts (cs-fix, json-fix)

### Package Scripts (defined in composer.json)
- `composer cs-fix`: Alias for `vendor/bin/php-cs-fixer fix`
- `composer json-fix`: Alias for `composer normalize --no-update-lock`

### Development Workflow
1. Make code changes to `src/Config.php`
2. Run syntax check: `php -l src/Config.php`
3. Test functionality: `php -r "require 'vendor/autoload.php'; new Huangdijia\PhpCsFixer\Config();"`
4. Format code: `composer cs-fix --dry-run` (preview) then `composer cs-fix` (apply)
5. Normalize JSON: `composer json-fix --dry-run` (preview) then `composer json-fix` (apply)
6. Commit changes

### No Test Suite
- This package does not have unit tests or PHPUnit configuration.
- Validation is done through manual testing and syntax checking.
- Focus on ensuring the Config class can be instantiated and exports valid rules.

### VS Code Integration
- Recommended extensions: bmewburn.vscode-intelephense-client, junstyle.php-cs-fixer
- Automatic formatting on save is configured
- Uses .php-cs-fixer.php configuration file
- PHP version set to 8.0+ in settings

### Common Debugging
- If composer install fails with GitHub authentication, add `--no-interaction` flag
- If php-cs-fixer doesn't run, ensure `vendor/bin/php-cs-fixer` exists after composer install
- Config class issues: Verify vendor/autoload.php exists and all dependencies are installed
- Always check PHP syntax with `php -l` before testing functionality

### Release Process
- Uses GitHub Actions for automated releases on version tags
- Release workflow: `.github/workflows/release.yaml`
- No manual build process required