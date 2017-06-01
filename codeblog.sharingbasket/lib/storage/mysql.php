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
use \CodeBlog\SharingBasket\Storage\Mysql\Connection;
use \CodeBlog\SharingBasket\Basket\Basket;

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
     * @param $basketCountOfUses
     *
     * @return void
     */
    protected static function increaseTheCountOfUses($basketId, $basketCountOfUses)
    {

        $pdo = Storage\Mysql\Pdo::getDataBase();

        $basketId            = (int)$basketId;
        $newBasketCountOfUses = (int)$basketCountOfUses + 1;

        Storage\Mysql\Helper::update($pdo, $basketId, ['NUMBER_OF_USES' => $newBasketCountOfUses]);
    }

    /**
     * @param int $basketCode
     * @param string $emailValue
     *
     * @return bool $isEmailUpdate
     */
    public static function saveEmailValue($basketCode, $emailValue) {

        $isEmailUpdate = false;

        $pdo = Storage\Mysql\Pdo::getDataBase();

        $basket = self::getBasketByCode($basketCode);

        if (!empty($basket->getNotifyEmailValue())) {
            if (!in_array($emailValue, explode(',', $basket->getNotifyEmailValue()))) {
                $emailNewValue = $basket->getNotifyEmailValue() . ',' . $emailValue;
                $isEmailUpdate = true;
            } else {
                $emailNewValue = $basket->getNotifyEmailValue();
            }
        } else {
            $emailNewValue = $emailValue;
            $isEmailUpdate = true;
        }

        Storage\Mysql\Helper::update($pdo, $basket->getId(), ['NOTIFY_EMAIL_VALUE' => "'" . $emailNewValue . "'"]);


        return $isEmailUpdate;

    }

    /**
     * @param int $basketCode
     *
     * @return void
     */
    public static function increaseTheCountOfSending($basketCode) {

        $pdo = Storage\Mysql\Pdo::getDataBase();

        $basket = self::getBasketByCode($basketCode);

        $basketCountOfSending = $basket->getNotifyQuantityToEmail();
        $newBasketCountOfSending = $basketCountOfSending + 1;

        Storage\Mysql\Helper::update($pdo, $basket->getId(), ['NOTIFY_QUANT_TO_EMAIL' => $newBasketCountOfSending]);

    }

    /**
     *
     * @param $basketCode
     *
     * @return string
     */
    public function restoreBasketItemsListFromStorage($basketCode)
    {

        $basket = self::getBasketByCode($basketCode);

        self::increaseTheCountOfUses($basket->getId(), $basket->getNumberOfUses());

        return $basket->getValue();

    }

    /**
     * @param int $basketCode
     *
     * @return \CodeBlog\SharingBasket\Basket\Basket Basket
     */
    public static function getBasketByCode($basketCode) {

        $pdo = Storage\Mysql\Pdo::getDataBase();

        $basketElement = Storage\Mysql\Helper::getList($pdo, $select = ['*'], $filter = ['basket_code' => $basketCode]);

        $basket = new Basket(
            $basketElement[0]['id'],
            $basketElement[0]['basket_code'],
            $basketElement[0]['basket_value'],
            $basketElement[0]['basket_hash'],
            $basketElement[0]['basket_date'],
            $basketElement[0]['user_id'],
            $basketElement[0]['NOTIFY_EMAIL_VALUE'],
            $basketElement[0]['NOTIFY_QUANT_TO_EMAIL'],
            $basketElement[0]['NUMBER_OF_USES']
        );

        return $basket;
    }

}