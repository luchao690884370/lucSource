<?php

namespace plugin\lucSource\api;

use plugin\admin\api\Menu;
use plugin\lucSource\app\admin\controller\SettingController;
class Install
{
    /**
     * 安装
     *
     * @param $version
     * @return void
     */
    public static function install($version)
    {
        //导入sql
         self::importSql();
        // 导入其它菜单
        if($menus = static::getMenus()) {
            Menu::import($menus);
        }
        return true;
    }

    /**
     * 卸载
     *
     * @param $version
     * @return void
     */
    public static function uninstall($version)
    {
        // 删除菜单
        foreach (static::getMenus() as $menu) {
            Menu::delete($menu['key']);
        }
    }

    /**
     * 更新
     *
     * @param $from_version
     * @param $to_version
     * @param $context
     * @return void
     */
    public static function update($from_version, $to_version, $context = null)
    {
        // 删除不用的菜单
        if (isset($context['previous_menus'])) {
            static::removeUnnecessaryMenus($context['previous_menus']);
        }
        // 导入新菜单
        if ($menus = static::getMenus()) {
            Menu::import($menus);
        }
    }

    /**
     * 更新前数据收集等
     *
     * @param $from_version
     * @param $to_version
     * @return array|array[]
     */
    public static function beforeUpdate($from_version, $to_version)
    {
        // 在更新之前获得老菜单，通过context传递给 update
        return ['previous_menus' => static::getMenus()];
    }

    /**
     * 获取菜单
     *
     * @return array|mixed
     */
    public static function getMenus()
    {
        clearstatcache();
        if (is_file($menu_file = __DIR__ . '/../config/menu.php')) {
            $menus = include $menu_file;
            return $menus ?: [];
        }
        return [];
    }

    /**
     * 删除不需要的菜单
     *
     * @param $previous_menus
     * @return void
     */
    public static function removeUnnecessaryMenus($previous_menus)
    {
        $menus_to_remove = array_diff(Menu::column($previous_menus, 'name'), Menu::column(static::getMenus(), 'name'));
        foreach ($menus_to_remove as $name) {
            Menu::delete($name);
        }
    }



    public static  function importSql(){
        $database_config_file = base_path() . '/plugin/admin/config/database.php';
        clearstatcache();
        if (!is_file($database_config_file)) {
            echo "管理后台未安装,请安装管理后台" . PHP_EOL;
            return;
        }
        //链接数据库
        $database=config('plugin.admin.database.connections.mysql');

        try {
            $db = self::getPdo($database['host'], $database['username'], $database['password'], $database['port']);
            $db->exec("use ".$database['database']);
            $smt = $db->query("show tables");
            $tables = $smt->fetchAll();

        } catch (\Throwable $e) {
            if (stripos($e, 'Access denied for user')) {
                echo "数据库用户名或密码错误,请安装管理后台" . PHP_EOL;return false;
            }
            if (stripos($e, 'Connection refused')) {
                echo "Connection refused. 请确认数据库IP端口是否正确，数据库已经启动" . PHP_EOL;return false;
            }
            if (stripos($e, 'timed out')) {
                echo "数据库连接超时，请确认数据库IP端口是否正确，安全组及防火墙已经放行端口" . PHP_EOL;return false;
            }
            throw $e;
        }


        $sql_file = base_path() . '/plugin/lucSource/install.sql';
        if (!is_file($sql_file)) {
            echo "数据库SQL文件不存在" . PHP_EOL;return false;
        }
        $sql_query = file_get_contents($sql_file);
        $sql_query = self::removeComments($sql_query);
        $sql_query =self::splitSqlFile($sql_query, ';');
        foreach ($sql_query as $sql) {
            $db->exec($sql);
        }
        return true;
    }
    /**
     * 获取pdo连接
     * @param $host
     * @param $username
     * @param $password
     * @param $port
     * @param $database
     * @return \PDO
     */
    protected static function getPdo($host, $username, $password, $port, $database = null): \PDO
    {
        $dsn = "mysql:host=$host;port=$port;";
        if ($database) {
            $dsn .= "dbname=$database";
        }
        $params = [
            \PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8mb4",
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::ATTR_TIMEOUT => 5,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        ];
        return new \PDO($dsn, $username, $password, $params);
    }

    /**
     * 去除sql文件中的注释
     * @param $sql
     * @return string
     */
    protected static function removeComments($sql): string
    {
        return preg_replace("/(\n--[^\n]*)/","", $sql);
    }

    /**
     * 分割sql文件
     * @param $sql
     * @param $delimiter
     * @return array
     */
    protected static function  splitSqlFile($sql, $delimiter): array
    {
        $tokens = explode($delimiter, $sql);
        $output = array();
        $matches = array();
        $token_count = count($tokens);
        for ($i = 0; $i < $token_count; $i++) {
            if (($i != ($token_count - 1)) || (strlen($tokens[$i] > 0))) {
                $total_quotes = preg_match_all("/'/", $tokens[$i], $matches);
                $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);
                $unescaped_quotes = $total_quotes - $escaped_quotes;

                if (($unescaped_quotes % 2) == 0) {
                    $output[] = $tokens[$i];
                    $tokens[$i] = "";
                } else {
                    $temp = $tokens[$i] . $delimiter;
                    $tokens[$i] = "";

                    $complete_stmt = false;
                    for ($j = $i + 1; (!$complete_stmt && ($j < $token_count)); $j++) {
                        $total_quotes = preg_match_all("/'/", $tokens[$j], $matches);
                        $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);
                        $unescaped_quotes = $total_quotes - $escaped_quotes;
                        if (($unescaped_quotes % 2) == 1) {
                            $output[] = $temp . $tokens[$j];
                            $tokens[$j] = "";
                            $temp = "";
                            $complete_stmt = true;
                            $i = $j;
                        } else {
                            $temp .= $tokens[$j] . $delimiter;
                            $tokens[$j] = "";
                        }

                    }
                }
            }
        }

        return $output;
    }


}