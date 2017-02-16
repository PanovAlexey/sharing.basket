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

class Helper
{
    private function __construct()
    {
    }

    /**
     * @param $pdo
     * @param $dbName
     * @param $tableName
     *
     * @return bool
     */
    public static function isExistsTable($pdo, $dbName, $tableName)
    {
        $tableName = htmlspecialchars(trim($tableName));

        return ($pdo->exec("SHOW INDEX FROM " . $dbName . "." . $tableName . ";") !== false);
    }

    public static function getListElements()
    {
    }

    public static function getElementById()
    {
    }

    public static function addElement()
    {
    }

    public static function updateElement()
    {
    }

    public static function deleteElement()
    {
    }

}