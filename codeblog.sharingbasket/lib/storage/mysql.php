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

        $pdo->exec("DROP TABLE " . Connection::STORAGE_CODE);
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
         * @Todo Переделать более красиво: Т.к. id у таблицы в отличии от инфоблока нету,то
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


    /**
     *
     * @param $hash
     *
     * @return int
     */
    protected function basketIsExistByHash($hash)
    {
        $hash = htmlspecialchars($hash);

        $pdo = Storage\Mysql\Pdo::getDataBase();

        if (!empty($hash)) {

            $filter = ['basket_hash' => $hash];
            $select = ['basket_code'];

            $basketElementsListInStorage = Storage\Mysql\Helper::getList($pdo, $select, $filter);

            return $basketElementsListInStorage[0]['basket_code'];
        }
    }


    /**
     *
     * @param     $basketValue
     * @param     $basketHash
     * @param int $userId
     *
     * @return string
     */
    public function saveBasketToStorage($basketValue, $basketHash = '', $userId = 0)
    {

        $pdo = Storage\Mysql\Pdo::getDataBase();

        $timeCurrent = time();

        $basketCode = $this->basketIsExistByHash($basketHash);

        if (!empty($basketCode)) {
            return $basketCode;
        }

        $elementFields = [
            'basket_code'  => $timeCurrent,
            'basket_hash'  => $basketHash,
            'basket_value' => $basketValue,
            'user_id'      => $userId,
            'basket_date'  => $timeCurrent
        ];

        $element = Storage\Mysql\Helper::add($pdo, $elementFields);

        return $element['basket_code'];

    }

    /**
     *
     * @param $basketId
     * @param $baketCountOfUses
     *
     * @return void
     */
    protected static function increaseTheCountOfUses($basketId, $baketCountOfUses)
    {

        $pdo = Storage\Mysql\Pdo::getDataBase();

        $basketId            = (int)$basketId;
        $newBaketCountOfUses = (int)$baketCountOfUses + 1;

        Storage\Mysql\Helper::update($pdo, $basketId, ['NUMBER_OF_USES' => $newBaketCountOfUses]);
    }

    /**
     * @param int $basketId
     * @param string $emailValue
     *
     * @return $isEmailUpdate bool
     */
    public static function saveEmailValue($basketId, $emailValue) {
        $basketId      = (int)$basketId;
        $isEmailUpdate = false;

        $pdo = Storage\Mysql\Pdo::getDataBase();

        $basket = Storage\Mysql\Helper::getList(
            $pdo,
            $select = ['id','NOTIFY_EMAIL_VALUE'],
            $filter = ['basket_code' => $basketId]
        );

        if (!empty($basket[0]['NOTIFY_EMAIL_VALUE'])) {
            if (!in_array($emailValue, explode(',', $basket[0]['NOTIFY_EMAIL_VALUE']))) {
                $emailNewValue = trim($basket[0]['NOTIFY_EMAIL_VALUE']) . ',' . $emailValue;
                $isEmailUpdate = true;
            } else {
                $emailNewValue = $basket[0]['NOTIFY_EMAIL_VALUE'];
            }
        } else {
            $emailNewValue = $emailValue;
            $isEmailUpdate = true;
        }

        Storage\Mysql\Helper::update($pdo, $basket[0]['id'], ['NOTIFY_EMAIL_VALUE' => "'" . $emailNewValue . "'"]);


        return $isEmailUpdate;

    }

    /**
     * @param $basketId
     *
     * @return void
     */
    public static function increaseTheCountOfSending($basketId) {
        $basketId            = (int)$basketId;

        $pdo = Storage\Mysql\Pdo::getDataBase();

        $basket = Storage\Mysql\Helper::getList(
            $pdo,
            $select = ['id','NOTIFY_QUANT_TO_EMAIL'],
            $filter = ['basket_code' => $basketId]
        );

        $baketCountOfSending = $basket[0]['NOTIFY_QUANT_TO_EMAIL'];
        $newBaketCountOfSending = $baketCountOfSending + 1;

        Storage\Mysql\Helper::update($pdo, $basket[0]['id'], ['NOTIFY_QUANT_TO_EMAIL' => $newBaketCountOfSending]);

    }

    /**
     *
     * @param $basketId
     *
     * @return string
     */
    public function restoreBasketItemsListFromStorage($basketId)
    {

        $basketId = (int)$basketId;
        $pdo = Storage\Mysql\Pdo::getDataBase();

        $basket = Storage\Mysql\Helper::getList($pdo,$select=['id','basket_code','basket_value','NUMBER_OF_USES'],$filter=['basket_code'=>$basketId]);

        self::increaseTheCountOfUses( $basket[0]['id'], $basket[0]['UF_NUMBER_OF_USES']);

        return $basket[0]['basket_value'];

    }

}