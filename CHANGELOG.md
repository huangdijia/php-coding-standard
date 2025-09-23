# 更新日志

项目的所有重要更改都将记录在此文件中。

格式基于 [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)，
本项目遵循 [语义化版本控制](https://semver.org/spec/v2.0.0.html)。

## [未发布]

### 新增
- 包含使用示例的全面文档
- 用于自动化测试和质量检查的 CI/CD 流水线
- 安全策略和漏洞报告指南
- 增强的 VSCode 配置，更好地支持 PHP
- 类型提示和 PHPDoc 改进

### 更改
- 更新了 PHP 版本要求文档
- 改进了包含安全检查的 GitHub Actions 工作流
- 增强了 README，包含详细的配置示例

### 修复
- 移除了 `setHeaderComment` 方法中未使用的变量赋值
- 修复了 VSCode PHP 版本配置以匹配项目要求
- 修正了发布工作流中已弃用的 GitHub Actions 语法

### 安全
- 添加了自动化安全漏洞扫描
- 改进了 VSCode 配置安全设置

## [2.0.0] - 2023-XX-XX

### 新增
- 初始稳定版本发布
- PHP CS Fixer 配置包装器
- 支持 PHP 8.1+
- 头部注释自动化
- 并行处理支持

### 安全
- 初始安全策略实现