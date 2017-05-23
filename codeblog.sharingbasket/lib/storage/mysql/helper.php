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

    /**
     * @param       $pdo
     * @param array $filter
     *
     * @return mixed
     */
    public static function getList($pdo, $select = [], $filter = [])
    {

        $filterString = '';
        $selectString = '';

        $paramCounter = 0;

        foreach ($filter as $key => $value) {

            if ($paramCounter > 0) {
                $filterString .= ' AND ';
            }

            $filterString .= $key . '=' . '"' . htmlspecialchars($value) . '"';

            $paramCounter++;
        }

        if (empty($select)) {
            $selectString = ' * ';
        } else {
            $selectString = implode(',', $select);
        }

        $elementsList = $pdo->query("SELECT " . $selectString . " FROM  " . Connection::STORAGE_CODE . " WHERE "
                                    . $filterString . ";")->FetchAll();

        return $elementsList;

    }

    /**
     * @param        $pdo
     * @param string $id
     *
     * @return array
     */
    public static function getElementById($pdo, $id)
    {
        $filter = ['id' => $id];

        $element = self::getList($pdo, $filter);

        return $element[0];
    }

    /**
     * @param       $pdo
     * @param array $elementFields
     *
     * @return array
     */
    public static function add($pdo, array $elementFields)
    {
        $fieldKeyList   = [];
        $fieldValueList = [];

        foreach ($elementFields as $key => $value) {
            $fieldKeyList[]   = $key;
            $fieldValueList[] = "'".$value."'";
        }

        $isElementAdd = (bool)$pdo->exec("INSERT INTO " . Connection::STORAGE_CODE . "(" . implode(',', $fieldKeyList). ") values (" . implode(',', $fieldValueList) . ")");

        if ( $isElementAdd) {
            return ['basket_code' => $elementFields['basket_code']];
        }

        return [];
    }

    /**
     * @param       $pdo
     * @param       $elementId
     * @param array $elementFields
     *
     * @return void
     */
    public static function update($pdo,$elementId, array $elementFields)
    {
        $elementId=(int)$elementId;
        $setString = '';
        $whereString = 'WHERE id='.$elementId;

        $countOfFields = count($elementFields);
        $numberOfField=0;

        foreach ($elementFields as $key=>$element) {

            $numberOfField++;
            $setString.=$key.'='.$element;

            if ($numberOfField<$countOfFields) {
                $setString.=',';
            }
        }

        $pdo->exec('UPDATE ' . Connection::STORAGE_CODE . ' SET '.$setString.' '.$whereString);

    }

    /**
     * @ToDo method
     */
    public static function delete()
    {
    }

}