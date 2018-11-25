#Rating
##五中人食堂窗口评价系统

------
##介绍

**食堂窗口评价系统包含以下功能：**

* 分三个维度（菜品、卫生、价格）为窗口打分
* 实时统计窗口总分，并按总分降序显示


##系统环境

* PHP >= 5.6
* MYSQL >= 5.5


##安装流程

 1. 将 `import.sql` 导入数据库
 2. 进入 `application/config` 目录，编辑 `database.php` 和 `config.php` 文件，分别配置数据库信息和网站地址
 3. 编辑 `application/models/User_model.php`，在 `getUserToken` 函数中修改 Oauth 相关信息
 3. （如使用 nginx）为 codeigniter 配置伪静态


##使用方法
1. 进入 `assets/img/shops` 上传窗口图片
2. 在数据库的 `shops` 表中存入窗口信息


##TODO

 - 增加管理模块（而不是现在通过数据库来管理）