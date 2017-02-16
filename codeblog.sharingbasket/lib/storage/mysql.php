<?
/**
 * Created by PhpStorm.
 * Date: 03.02.2017
 * Time: 19:30
 *
 * @author    Alexey Panov <panov@codeblog.pro>
 * @copyright Copyright © 2016, Alexey Panov
 */

namespace CodeBlog\SharingBasket\Storage;

use \CodeBlog\SharingBasket\Storage;
use CodeBlog\SharingBasket\Storage\Mysql\Connection;

class Mysql implements SaveAndRestore
{

    /**
     * @param $storageId
     *
     * @return  void
     */
    public static function deleteStorage($storageId)
    {

        $pdo = Storage\Mysql\Pdo::getDataBase();

        $pdo->exec("DROP TABLE codeblog_sharing_basket");
    }


    /**
     * @return bool
     */
    public function createStorage()
    {

        $pdo = Storage\Mysql\Pdo::getDataBase();

        $isCreate = false;

        if (!self::isStorageExist()) {
            $isCreate = ($pdo->exec("CREATE TABLE `" . Storage\Mysql\Connection::STORAGE_CODE . "`(
            id INT PRIMARY KEY AUTO_INCREMENT,
            basket_code VARCHAR(20) NOT NULL,
            basket_hash TEXT,
            basket_value MEDIUMTEXT,
            basket_date TIMESTAMP,
            user_id VARCHAR(20),
            NOTIFY_PHONE_VALUE TEXT,
            NOTIFY_EMAIL_VALUE TEXT,
            NOTIFY_QUANT_TO_PHONE INTEGER NOT NULL DEFAULT 0,
            NOTIFY_QUANT_TO_EMAIL INTEGER NOT NULL DEFAULT 0,
            NUMBER_OF_USES INTEGER NOT NULL DEFAULT 0
            )") !== false);
        }

        return $isCreate;

    }

    /**
     * @return int
     */
    public function getStorageId()
    {
        /**
         * Временный костыль. Т.к. id у таблицы в отличии от инфоблока нету,то
         * возвращаем положительнео число, если таблица существует и 0 в ином случае.
         */
        $storageId = (int)$this->isStorageExist();

        return (int)$storageId;

    }

    /**
     * @return bool
     */
    public function isStorageExist()
    {
        $pdo = Storage\Mysql\Pdo::getDataBase();

        $isExistsTable = Mysql\Helper::isExistsTable($pdo, Storage\Mysql\Connection::DATA_BASE_NAME,
            Storage\Mysql\Connection::STORAGE_CODE);

        return $isExistsTable;
    }


    protected function basketIsExistByHash($hash)
    {

        $baketCode = 0;

        return $baketCode;
    }


    /**
     * @param     $basketValue
     * @param     $basketHash
     * @param int $userId
     *
     * @return string
     */
    public function saveBasketToStorage($basketValue, $basketHash = '', $userId = 0)
    {

        global $USER;

        $iBlockId = $this->getStorageId();


        //return $propertyList['CODEBLOG_BASKET_CODE'];

    }

    /**
     * @param $basketId
     * @param $baketCountOfUses
     *
     * @return void
     */
    protected static function increaseTheCountOfUses($basketId, $baketCountOfUses)
    {

        $basketId            = (int)$basketId;
        $baketCountOfUses    = (int)$baketCountOfUses;
        $newBaketCountOfUses = $baketCountOfUses + 1;

    }

    /**
     * @param $basketId
     *
     * @return string
     */
    public function restoreBasketItemsListFromStorage($basketId)
    {

        $basketId = (int)$basketId;


        //return $baketValue;

    }

}