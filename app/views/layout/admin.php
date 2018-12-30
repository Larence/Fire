<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/19 0019
 * Time: 11:24
 */
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $title ?></title>
    <link type="text/css" rel="stylesheet" href="/public/css/admin.css">
</head>
<body>
<header class="header">
    <div class="entered">
        <div class="header-content flex">
            <div class="column">
                <a href="index.html" class="column-logo">
                    <img src="/public/images/ydc-logo.png" title="" about="" alt="">
                </a>
            </div>
            <div class="column">
                <div class="column-user">
                    <div class="user-photo">
                        <a href="javascript:;">
                            <img src="/public/images/photo.png" title="" about="" alt="">
                        </a>
                    </div>
                    <div class="user-info">
                        <div class="user-info-name">
                            <a href="info.html">一点车</a>
                        </div>
                        <div class="user-info-func flex">
                            <span class="tag">账号审核中</span>
                            <span class="mal"><i class="icon icon-mail fl"></i><em>12</em></span>
                            <a href="/site/logout">退出</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="content">
    <?php echo $content; ?>
</div>
<div class="footer"></div>
</body>
</html>
