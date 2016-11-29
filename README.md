# 大图书馆的牧羊人 & 禁书目录

在公司膜Ricter的时候想到的思路。


预期内的做法(general)：
  
  1. 信息泄漏
  2. CBC flip 或者 Padding Oracle 伪造管理员上线
  3. 了解epub文件，构造XXE任意文件读取flag.php


> 如果没有第一步，作为一道黑盒题目，你能够摸清套路吗？ ^_^


P.S. Aklis灵魂运维，在部署这道题目的时候忘了上vhost的配置了，导致可以在获得admin身份之后直接上传包含webshell的zip压缩包。
用 comm.php 的加解密伪造也是我的锅，密钥是23333，然后我忘了几个3，后来在第五层的禁书目录其实就多了两个3，Orz。
在第四层按我的出题思路怼的师傅可以瞬秒禁书目录。


通过php://filter构造
```XML
<!ENTITY payload SYSTEM "php://filter/read=convert.base64-encode/resource=/var/www/html/flag.php">
```

直接回显

```
<navPoint id="coverpage" playOrder="0">
<navLabel><text>&payload;</text></navLabel>
```

但这样的话，别人能看得到哦，自己忘了覆盖回去让其它选手捡了便宜 XD

> 更合适的作法是通过远程的XXE回显。




两题的flag

```php
<?php
$flag = "hctf{Serena_is_the_leading_role}";
```

```php
<?php

$flag = "hctf{Lillie_is_comming}";
```