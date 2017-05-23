<?
/**
 * Created by PhpStorm.
 * Date: 02.02.2017
 * Time: 17:00
 *
 * @author    Alexey Panov <panov@codeblog.pro>
 * @copyright Copyright © 2016, Alexey Panov
 */

namespace CodeBlog\SharingBasket\Storage\Mysql;


final class Pdo
{
    private static $pdo;

    public static function getDataBase()
    {

        self::$pdo = new \PDO('mysql:host=' . Connection::HOST . ';dbname=' . Connection::DATA_BASE_NAME,
            Connection::LOGIN, Connection::PASSWORD);

        return self::$pdo;
    }

    private function __construct()
    {

    }

}