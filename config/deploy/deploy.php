<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// 设置Token，防止别人恶意触发更新
$secret_token = 'my_super_secret_token';
$project_path = '/srv/cpusers/u26s1188/dev';
$branch = 'dev';

if ($_GET['token'] !== $secret_token) {
    header('HTTP/1.1 403 Forbidden');
    die('Access Denied');
}
$branch = $_GET['branch'] ?? $branch;
$project_path = '/srv/cpusers/u26s1188/' . $branch;

// 执行拉取命令
$output = shell_exec("git -C $project_path pull origin $branch 2>&1");

echo "<h1>Deployment Log:</h1>";
echo "<h2>Project Path: $project_path</h2>";
echo "<h2>Branch: $branch</h2>";
echo "<pre>$output</pre>";
