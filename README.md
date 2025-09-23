# PHP 代码规范

[![Latest Stable Version](https://poser.pugx.org/huangdijia/php-coding-standard/v)](//packagist.org/packages/huangdijia/php-coding-standard)
[![Total Downloads](https://poser.pugx.org/huangdijia/php-coding-standard/downloads)](//packagist.org/packages/huangdijia/php-coding-standard)
[![License](https://poser.pugx.org/huangdijia/php-coding-standard/license)](//packagist.org/packages/huangdijia/php-coding-standard)
[![PHP Version Require](https://poser.pugx.org/huangdijia/php-coding-standard/require/php)](//packagist.org/packages/huangdijia/php-coding-standard)
[![CI](https://github.com/huangdijia/php-coding-standard/workflows/CI/badge.svg)](https://github.com/huangdijia/php-coding-standard/actions)

基于 PHP CS Fixer 的全面 PHP 代码规范配置，适用于个人和团队使用。

## 特性

- 🚀 基于行业标准规则集（PSR-2、Symfony、PhpCsFixer）
- 🎯 针对现代 PHP 8.1+ 开发进行优化
- 🔧 轻松使用附加规则进行自定义
- 📝 自动头部注释生成
- ⚡ 支持并行处理，执行更快
- 🎨 预配置的 VSCode 集成

## 系统要求

- PHP 8.1 或更高版本
- Composer

## 安装

通过 composer 安装为开发依赖：

```bash
composer require huangdijia/php-coding-standard --dev
```

## 快速开始

### 选项 1：使用提供的模板文件

将配置模板复制到项目根目录：

```bash
cp vendor/huangdijia/php-coding-standard/.php-cs-fixer.php.stub .php-cs-fixer.php
```

编辑复制的 `.php-cs-fixer.php` 文件以匹配您的项目详情：

```php
<?php

use Huangdijia\PhpCsFixer\Config;
use PhpCsFixer\Runner\Parallel\ParallelConfig;

require __DIR__ . '/vendor/autoload.php';

return (new Config())
    ->setParallelConfig(new ParallelConfig(4, 20))
    ->setHeaderComment(
        projectName: 'your-vendor/your-package',
        projectLink: 'https://github.com/your-vendor/your-package',
        projectDocument: 'https://github.com/your-vendor/your-package/blob/main/README.md',
        contacts: [
            'Your Name' => 'your-email@example.com',
        ],
    )
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('public')
            ->exclude('runtime')
            ->exclude('vendor')
            ->in(__DIR__)
            ->append([
                __FILE__,
            ])
    )
    ->setUsingCache(false);
```

### 选项 2：替换现有的 php-cs-fixer

如果您的项目中已经有 `friendsofphp/php-cs-fixer`：

```bash
composer remove friendsofphp/php-cs-fixer --dev --no-update
composer require huangdijia/php-coding-standard --dev --no-update
composer update -o
cp vendor/huangdijia/php-coding-standard/.php-cs-fixer.php.stub .php-cs-fixer.php
```

## 使用方法

### 基本命令

修复代码风格问题：

```bash
vendor/bin/php-cs-fixer fix
```

试运行（预览更改而不应用）：

```bash
vendor/bin/php-cs-fixer fix --dry-run --diff
```

如果您配置了 composer 脚本：

```bash
composer cs-fix
composer cs-fix -- --dry-run --diff
```

## 高级配置

### 自定义规则

您可以使用流式 API 添加或覆盖规则：

```php
return (new Config())
    ->setHeaderComment(/* ... */)
    ->addRules([
        'strict_comparison' => true,
        'native_function_invocation' => ['include' => ['@all']],
    ])
    ->setRule('yoda_style', false)
    ->setFinder(/* ... */);
```

### 可用方法

- `setRule(string $rule, mixed $value)`：设置单个规则
- `addRules(array $rules)`：添加多个规则（与现有规则合并）
- `setHeaderComment(...)`：配置自动头部注释

### 头部注释配置

`setHeaderComment` 方法支持灵活的联系人格式：

```php
// 使用名称 => 邮箱的数组
->setHeaderComment(
    projectName: 'my-project',
    contacts: [
        'John Doe' => 'john@example.com',
        'Jane Smith' => 'jane@example.com',
    ]
)

// 使用邮箱地址的简单数组
->setHeaderComment(
    projectName: 'my-project', 
    contacts: ['john@example.com', 'jane@example.com']
)
```

### 排除目录

自定义要扫描的目录：

```php
->setFinder(
    PhpCsFixer\Finder::create()
        ->exclude('bootstrap')
        ->exclude('storage')
        ->exclude('vendor')
        ->exclude('node_modules')
        ->in(__DIR__)
        ->name('*.php')
        ->notPath('database/migrations')
)
```

## 集成

### VSCode

该包包含优化的 VSCode 设置。复制配置：

```bash
mkdir -p .vscode
cp vendor/huangdijia/php-coding-standard/.vscode/* .vscode/
```

### CI/CD

GitHub Actions 工作流示例：

```yaml
name: Code Style

on: [push, pull_request]

jobs:
  php-cs-fixer:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'
      - run: composer install
      - run: vendor/bin/php-cs-fixer fix --dry-run --diff
```

### 预提交钩子

添加到 `.git/hooks/pre-commit`：

```bash
#!/bin/sh
vendor/bin/php-cs-fixer fix --dry-run --diff --diff-format=udiff
```

## 包含的规则

此配置包含：

- **PSR-2**：基本编码标准
- **Symfony**：Symfony 编码标准
- **PhpCsFixer**：额外的现代 PHP 最佳实践
- **DoctrineAnnotation**：Doctrine 注释格式化
- **自定义优化**：性能和可读性改进

主要自定义：
- 短数组语法（`[]` 而不是 `array()`）
- 字符串使用单引号
- 优化的导入排序
- 适当的 PHPDoc 格式化
- 严格类型声明
- 现代 PHP 8.1+ 特性

## 贡献

1. Fork 仓库
2. 创建您的功能分支
3. 提交您的更改
4. 推送到分支
5. 创建 Pull Request

请确保所有代码都遵循既定的编码标准，运行：

```bash
composer cs-fix
composer json-fix
```

## 安全

如果您发现任何安全漏洞，请发送邮件到 [huangdijia@gmail.com](mailto:huangdijia@gmail.com)，而不要使用问题跟踪器。

## 更新日志

请参阅 [CHANGELOG](CHANGELOG.md) 了解最近的更改信息。

## 许可证

MIT 许可证。请参阅 [License File](LICENSE) 了解更多信息。
