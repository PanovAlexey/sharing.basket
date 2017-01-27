<?
/**
 * Created by PhpStorm.
 * Date: 10.01.2017
 * Time: 12:00
 *
 * @author    Alexey Panov <panov@codeblog.pro>
 * @copyright Copyright © 2016, Alexey Panov
 */

namespace CodeBlog\SharingBasket\Storage;

use \Bitrix\Highloadblock\HighloadBlockTable;

\Bitrix\Main\Loader::includeModule('highloadblock');

class Highloadblock implements SaveAndRestore
{

    const STORAGE_NAME = 'CodeblogSharingBasketStorage';

    public static function deleteStorage($storageId) {
        HighloadBlockTable::delete($storageId);
    }

    /**
     * @return int
     */
    public function createStorage() {

        $highloadBlockParams = ['NAME'       => self::STORAGE_NAME,
                                'TABLE_NAME' => 'codeblog_sharing_basket_storage'];

        $highloadBlock = HighloadBlockTable::add($highloadBlockParams);
        if (!$highloadBlock->isSuccess()) {
            /**
             * @TODO: Добавить обоаботку ошибки создания хайлоадблока
             */
            //$errors = $highloadBlock->getErrorMessages();
        } else {
            $highblockId = $highloadBlock->getId();
        }

        $this->createPropertiesStorage($highblockId);

        return (int)$highblockId;

    }

    private function createPropertiesStorage($highblockId) {

        $propertyDataList['BASKET_CODE']['ENTITY_ID']                     = 'HLBLOCK_' . $highblockId;
        $propertyDataList['BASKET_CODE']['FIELD_NAME']                    = 'UF_BASKET_CODE';
        $propertyDataList['BASKET_CODE']['XML_ID']                        = 'XML_BASKET_CODE';
        $propertyDataList['BASKET_CODE']['MULTIPLE']                      = 'N';
        $propertyDataList['BASKET_CODE']['MANDATORY']                     = 'Y';
        $propertyDataList['BASKET_CODE']['SHOW_FILTER']                   = 'N';
        $propertyDataList['BASKET_CODE']['IS_SEARCHABLE']                 = 'N';
        $propertyDataList['BASKET_CODE']['USER_TYPE_ID']                  = 'string';
        $propertyDataList['BASKET_CODE']['SETTINGS']['DEFAULT_VALUE']     = '';
        $propertyDataList['BASKET_CODE']['SETTINGS']['SIZE']              = '40';
        $propertyDataList['BASKET_CODE']['SETTINGS']['ROWS']              = '1';
        $propertyDataList['BASKET_CODE']['SETTINGS']['SHOW_IN_LIST']      = '';
        $propertyDataList['BASKET_CODE']['SETTINGS']['EDIT_FORM_LABEL']   = ['ru' => 'Идентификационный код корзины',
                                                                             'en' => 'User field basket code',];
        $propertyDataList['BASKET_CODE']['SETTINGS']['LIST_COLUMN_LABEL'] = ['ru' => 'Идентификационный код корзины',
                                                                             'en' => 'User field basket code',];
        $propertyDataList['BASKET_CODE']['SETTINGS']['LIST_FILTER_LABEL'] = ['ru' => 'Пользовательское свойство идентификационный код корзины',
                                                                             'en' => 'User field basket code'];
        $propertyDataList['BASKET_CODE']['SETTINGS']['ERROR_MESSAGE']     = ['ru' => 'Ошибка при заполнении пользовательского свойства идентификационный код корзины',
                                                                             'en' => 'An error in completing the user field basket code'];
        $propertyDataList['BASKET_CODE']['SETTINGS']['HELP_MESSAGE']      = ['ru' => 'Пользовательское свойство Идентификационный код корзины',
                                                                             'en' => 'User field basket code'];

        $propertyDataList['BASKET_HASH']['ENTITY_ID']                     = 'HLBLOCK_' . $highblockId;
        $propertyDataList['BASKET_HASH']['FIELD_NAME']                    = 'UF_BASKET_HASH';
        $propertyDataList['BASKET_HASH']['XML_ID']                        = 'XML_BASKET_HASH';
        $propertyDataList['BASKET_HASH']['MULTIPLE']                      = 'N';
        $propertyDataList['BASKET_HASH']['MANDATORY']                     = 'Y';
        $propertyDataList['BASKET_HASH']['SHOW_FILTER']                   = 'N';
        $propertyDataList['BASKET_HASH']['IS_SEARCHABLE']                 = 'N';
        $propertyDataList['BASKET_HASH']['USER_TYPE_ID']                  = 'string';
        $propertyDataList['BASKET_HASH']['SETTINGS']['DEFAULT_VALUE']     = '';
        $propertyDataList['BASKET_HASH']['SETTINGS']['SIZE']              = '40';
        $propertyDataList['BASKET_HASH']['SETTINGS']['ROWS']              = '1';
        $propertyDataList['BASKET_HASH']['SETTINGS']['SHOW_IN_LIST']      = '';
        $propertyDataList['BASKET_HASH']['SETTINGS']['EDIT_FORM_LABEL']   = ['ru' => 'Уникальный код корзины',
                                                                             'en' => 'User field basket unique code',];
        $propertyDataList['BASKET_HASH']['SETTINGS']['LIST_COLUMN_LABEL'] = ['ru' => 'Уникальный код корзины',
                                                                             'en' => 'User field basket unique code',];
        $propertyDataList['BASKET_HASH']['SETTINGS']['LIST_FILTER_LABEL'] = ['ru' => 'Пользовательское свойство уникальный код корзины',
                                                                             'en' => 'User field  basket unique code'];
        $propertyDataList['BASKET_HASH']['SETTINGS']['ERROR_MESSAGE']     = ['ru' => 'Ошибка при заполнении пользовательского свойства уникальный код корзины',
                                                                             'en' => 'An error in completing the user field basket unique code'];
        $propertyDataList['BASKET_HASH']['SETTINGS']['HELP_MESSAGE']      = ['ru' => 'Пользовательское свойство уникальный код корзины',
                                                                             'en' => 'User field basket unique code'];

        $propertyDataList['BASKET_VALUE']['ENTITY_ID']                 = 'HLBLOCK_' . $highblockId;
        $propertyDataList['BASKET_VALUE']['FIELD_NAME']                = 'UF_BASKET_VALUE';
        $propertyDataList['BASKET_VALUE']['XML_ID']                    = 'XML_ID_BASKET_VALUE';
        $propertyDataList['BASKET_VALUE']['MULTIPLE']                  = 'N';
        $propertyDataList['BASKET_VALUE']['MANDATORY']                 = 'Y';
        $propertyDataList['BASKET_VALUE']['SHOW_FILTER']               = 'N';
        $propertyDataList['BASKET_VALUE']['IS_SEARCHABLE']             = 'N';
        $propertyDataList['BASKET_VALUE']['USER_TYPE_ID']              = 'string';
        $propertyDataList['BASKET_VALUE']['SETTINGS']['DEFAULT_VALUE'] = '';
        $propertyDataList['BASKET_VALUE']['SETTINGS']['SIZE']          = '40';
        $propertyDataList['BASKET_VALUE']['SETTINGS']['ROWS']          = '5';
        $propertyDataList['BASKET_VALUE']['SETTINGS']['SHOW_IN_LIST']  = '';

        $propertyDataList['BASKET_VALUE']['SETTINGS']['EDIT_FORM_LABEL']   = ['ru' => 'Пользовательское свойство',
                                                                              'en' => 'User field',];
        $propertyDataList['BASKET_VALUE']['SETTINGS']['LIST_COLUMN_LABEL'] = ['ru' => 'Пользовательское свойство',
                                                                              'en' => 'User field',];
        $propertyDataList['BASKET_VALUE']['SETTINGS']['LIST_FILTER_LABEL'] = ['ru' => 'Пользовательское свойство',
                                                                              'en' => 'User field'];
        $propertyDataList['BASKET_VALUE']['SETTINGS']['ERROR_MESSAGE']     = ['ru' => 'Ошибка при заполнении пользовательского свойства',
                                                                              'en' => 'An error in completing the user field'];
        $propertyDataList['BASKET_VALUE']['SETTINGS']['HELP_MESSAGE']      = ['ru' => 'Пользовательское свойство',
                                                                              'en' => 'User field'];


        $propertyDataList['USER_ID']['ENTITY_ID']                     = 'HLBLOCK_' . $highblockId;
        $propertyDataList['USER_ID']['FIELD_NAME']                    = 'UF_USER_ID';
        $propertyDataList['USER_ID']['XML_ID']                        = 'XML_ID_USER_ID';
        $propertyDataList['USER_ID']['MULTIPLE']                      = 'N';
        $propertyDataList['USER_ID']['MANDATORY']                     = 'Y';
        $propertyDataList['USER_ID']['SHOW_FILTER']                   = 'N';
        $propertyDataList['USER_ID']['IS_SEARCHABLE']                 = 'N';
        $propertyDataList['USER_ID']['USER_TYPE_ID']                  = 'integer';
        $propertyDataList['USER_ID']['SETTINGS']['DEFAULT_VALUE']     = 0;
        $propertyDataList['USER_ID']['SETTINGS']['SIZE']              = '40';
        $propertyDataList['USER_ID']['SETTINGS']['ROWS']              = '1';
        $propertyDataList['USER_ID']['SETTINGS']['SHOW_IN_LIST']      = '';
        $propertyDataList['USER_ID']['SETTINGS']['EDIT_FORM_LABEL']   = ['ru' => 'Пользовательское свойство',
                                                                         'en' => 'User field',];
        $propertyDataList['USER_ID']['SETTINGS']['LIST_COLUMN_LABEL'] = ['ru' => 'Пользовательское свойство',
                                                                         'en' => 'User field',];
        $propertyDataList['USER_ID']['SETTINGS']['LIST_FILTER_LABEL'] = ['ru' => 'Пользовательское свойство',
                                                                         'en' => 'User field'];
        $propertyDataList['USER_ID']['SETTINGS']['ERROR_MESSAGE']     = ['ru' => 'Ошибка при заполнении пользовательского свойства',
                                                                         'en' => 'An error in completing the user field'];
        $propertyDataList['USER_ID']['SETTINGS']['HELP_MESSAGE']      = ['ru' => 'Пользовательское свойство',
                                                                         'en' => 'User field'];


        $propertyDataList['BASKET_DATE']['ENTITY_ID']                     = 'HLBLOCK_' . $highblockId;
        $propertyDataList['BASKET_DATE']['FIELD_NAME']                    = 'UF_BASKET_DATE';
        $propertyDataList['BASKET_DATE']['XML_ID']                        = 'XML_ID_BASKET_DATE';
        $propertyDataList['BASKET_DATE']['MULTIPLE']                      = 'N';
        $propertyDataList['BASKET_DATE']['MANDATORY']                     = 'Y';
        $propertyDataList['BASKET_DATE']['SHOW_FILTER']                   = 'N';
        $propertyDataList['BASKET_DATE']['IS_SEARCHABLE']                 = 'N';
        $propertyDataList['BASKET_DATE']['USER_TYPE_ID']                  = 'string';
        $propertyDataList['BASKET_DATE']['SETTINGS']['DEFAULT_VALUE']     = '';
        $propertyDataList['BASKET_DATE']['SETTINGS']['SIZE']              = '40';
        $propertyDataList['BASKET_DATE']['SETTINGS']['ROWS']              = '1';
        $propertyDataList['BASKET_DATE']['SETTINGS']['SHOW_IN_LIST']      = '';
        $propertyDataList['BASKET_DATE']['SETTINGS']['EDIT_FORM_LABEL']   = ['ru' => 'Пользовательское свойство',
                                                                             'en' => 'User field',];
        $propertyDataList['BASKET_DATE']['SETTINGS']['LIST_COLUMN_LABEL'] = ['ru' => 'Пользовательское свойство',
                                                                             'en' => 'User field',];
        $propertyDataList['BASKET_DATE']['SETTINGS']['LIST_FILTER_LABEL'] = ['ru' => 'Пользовательское свойство',
                                                                             'en' => 'User field'];
        $propertyDataList['BASKET_DATE']['SETTINGS']['ERROR_MESSAGE']     = ['ru' => 'Ошибка при заполнении пользовательского свойства',
                                                                             'en' => 'An error in completing the user field'];
        $propertyDataList['BASKET_DATE']['SETTINGS']['HELP_MESSAGE']      = ['ru' => 'Пользовательское свойство',
                                                                             'en' => 'User field'];


        $propertyDataList['NOTIFY_PHONE_VALUE']['ENTITY_ID']                     = 'HLBLOCK_' . $highblockId;
        $propertyDataList['NOTIFY_PHONE_VALUE']['FIELD_NAME']                    = 'UF_NOTIFY_PHONE_VAL';
        $propertyDataList['NOTIFY_PHONE_VALUE']['XML_ID']                        = 'XML_ID_NOTIFY_PHONE_VAL';
        $propertyDataList['NOTIFY_PHONE_VALUE']['MULTIPLE']                      = 'N';
        $propertyDataList['NOTIFY_PHONE_VALUE']['MANDATORY']                     = 'N';
        $propertyDataList['NOTIFY_PHONE_VALUE']['SHOW_FILTER']                   = 'N';
        $propertyDataList['NOTIFY_PHONE_VALUE']['IS_SEARCHABLE']                 = 'N';
        $propertyDataList['NOTIFY_PHONE_VALUE']['USER_TYPE_ID']                  = 'string';
        $propertyDataList['NOTIFY_PHONE_VALUE']['SETTINGS']['DEFAULT_VALUE']     = '';
        $propertyDataList['NOTIFY_PHONE_VALUE']['SETTINGS']['SIZE']              = '40';
        $propertyDataList['NOTIFY_PHONE_VALUE']['SETTINGS']['ROWS']              = '1';
        $propertyDataList['NOTIFY_PHONE_VALUE']['SETTINGS']['SHOW_IN_LIST']      = '';
        $propertyDataList['NOTIFY_PHONE_VALUE']['SETTINGS']['EDIT_FORM_LABEL']   = ['ru' => 'Пользовательское свойство',
                                                                                    'en' => 'User field',];
        $propertyDataList['NOTIFY_PHONE_VALUE']['SETTINGS']['LIST_COLUMN_LABEL'] = ['ru' => 'Пользовательское свойство',
                                                                                    'en' => 'User field',];
        $propertyDataList['NOTIFY_PHONE_VALUE']['SETTINGS']['LIST_FILTER_LABEL'] = ['ru' => 'Пользовательское свойство',
                                                                                    'en' => 'User field'];
        $propertyDataList['NOTIFY_PHONE_VALUE']['SETTINGS']['ERROR_MESSAGE']     = ['ru' => 'Ошибка при заполнении пользовательского свойства',
                                                                                    'en' => 'An error in completing the user field'];
        $propertyDataList['NOTIFY_PHONE_VALUE']['SETTINGS']['HELP_MESSAGE']      = ['ru' => 'Пользовательское свойство',
                                                                                    'en' => 'User field'];

        $propertyDataList['NOTIFY_EMAIL_VALUE']['ENTITY_ID']                     = 'HLBLOCK_' . $highblockId;
        $propertyDataList['NOTIFY_EMAIL_VALUE']['FIELD_NAME']                    = 'UF_NOTIFY_MAIL_VAL';
        $propertyDataList['NOTIFY_EMAIL_VALUE']['XML_ID']                        = 'XML_ID_NOTIFY_MAIL_VAL';
        $propertyDataList['NOTIFY_EMAIL_VALUE']['MULTIPLE']                      = 'N';
        $propertyDataList['NOTIFY_EMAIL_VALUE']['MANDATORY']                     = 'N';
        $propertyDataList['NOTIFY_EMAIL_VALUE']['SHOW_FILTER']                   = 'N';
        $propertyDataList['NOTIFY_EMAIL_VALUE']['IS_SEARCHABLE']                 = 'N';
        $propertyDataList['NOTIFY_EMAIL_VALUE']['USER_TYPE_ID']                  = 'string';
        $propertyDataList['NOTIFY_EMAIL_VALUE']['SETTINGS']['DEFAULT_VALUE']     = '';
        $propertyDataList['NOTIFY_EMAIL_VALUE']['SETTINGS']['SIZE']              = '40';
        $propertyDataList['NOTIFY_EMAIL_VALUE']['SETTINGS']['ROWS']              = '1';
        $propertyDataList['NOTIFY_EMAIL_VALUE']['SETTINGS']['SHOW_IN_LIST']      = '';
        $propertyDataList['NOTIFY_EMAIL_VALUE']['SETTINGS']['EDIT_FORM_LABEL']   = ['ru' => 'Пользовательское свойство',
                                                                                    'en' => 'User field',];
        $propertyDataList['NOTIFY_EMAIL_VALUE']['SETTINGS']['LIST_COLUMN_LABEL'] = ['ru' => 'Пользовательское свойство',
                                                                                    'en' => 'User field',];
        $propertyDataList['NOTIFY_EMAIL_VALUE']['SETTINGS']['LIST_FILTER_LABEL'] = ['ru' => 'Пользовательское свойство',
                                                                                    'en' => 'User field'];
        $propertyDataList['NOTIFY_EMAIL_VALUE']['SETTINGS']['ERROR_MESSAGE']     = ['ru' => 'Ошибка при заполнении пользовательского свойства',
                                                                                    'en' => 'An error in completing the user field'];
        $propertyDataList['NOTIFY_EMAIL_VALUE']['SETTINGS']['HELP_MESSAGE']      = ['ru' => 'Пользовательское свойство',
                                                                                    'en' => 'User field'];

        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['ENTITY_ID']                     = 'HLBLOCK_' . $highblockId;
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['FIELD_NAME']                    = 'UF_NOTIFY_QNT_PHONE';
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['XML_ID']                        = 'XML_ID_NOTIFY_QNT_PHONE';
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['MULTIPLE']                      = 'N';
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['MANDATORY']                     = 'N';
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['SHOW_FILTER']                   = 'N';
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['IS_SEARCHABLE']                 = 'N';
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['USER_TYPE_ID']                  = 'integer';
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['SETTINGS']['DEFAULT_VALUE']     = 0;
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['SETTINGS']['SIZE']              = '40';
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['SETTINGS']['ROWS']              = '1';
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['SETTINGS']['SHOW_IN_LIST']      = '';
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['SETTINGS']['EDIT_FORM_LABEL']   = ['ru' => 'Пользовательское свойство',
                                                                                       'en' => 'User field',];
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['SETTINGS']['LIST_COLUMN_LABEL'] = ['ru' => 'Пользовательское свойство',
                                                                                       'en' => 'User field',];
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['SETTINGS']['LIST_FILTER_LABEL'] = ['ru' => 'Пользовательское свойство',
                                                                                       'en' => 'User field'];
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['SETTINGS']['ERROR_MESSAGE']     = ['ru' => 'Ошибка при заполнении пользовательского свойства',
                                                                                       'en' => 'An error in completing the user field'];
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['SETTINGS']['HELP_MESSAGE']      = ['ru' => 'Пользовательское свойство',
                                                                                       'en' => 'User field'];


        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['ENTITY_ID']                     = 'HLBLOCK_' . $highblockId;
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['FIELD_NAME']                    = 'UF_NOTIFY_QNT_MAIL';
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['XML_ID']                        = 'XML_ID_NOTIFY_QNT_MAIL';
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['MULTIPLE']                      = 'N';
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['MANDATORY']                     = 'N';
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['SHOW_FILTER']                   = 'N';
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['IS_SEARCHABLE']                 = 'N';
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['USER_TYPE_ID']                  = 'integer';
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['SETTINGS']['DEFAULT_VALUE']     = 0;
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['SETTINGS']['SIZE']              = '40';
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['SETTINGS']['ROWS']              = '1';
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['SETTINGS']['SHOW_IN_LIST']      = '';
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['SETTINGS']['EDIT_FORM_LABEL']   = ['ru' => 'Пользовательское свойство',
                                                                                       'en' => 'User field',];
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['SETTINGS']['LIST_COLUMN_LABEL'] = ['ru' => 'Пользовательское свойство',
                                                                                       'en' => 'User field',];
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['SETTINGS']['LIST_FILTER_LABEL'] = ['ru' => 'Пользовательское свойство',
                                                                                       'en' => 'User field'];
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['SETTINGS']['ERROR_MESSAGE']     = ['ru' => 'Ошибка при заполнении пользовательского свойства',
                                                                                       'en' => 'An error in completing the user field'];
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['SETTINGS']['HELP_MESSAGE']      = ['ru' => 'Пользовательское свойство',
                                                                                       'en' => 'User field'];

        $propertyDataList['NUMBER_OF_USES']['ENTITY_ID']                     = 'HLBLOCK_' . $highblockId;
        $propertyDataList['NUMBER_OF_USES']['FIELD_NAME']                    = 'UF_NUMBER_OF_USES';
        $propertyDataList['NUMBER_OF_USES']['XML_ID']                        = 'XML_ID_NUMBER_OF_USES';
        $propertyDataList['NUMBER_OF_USES']['MULTIPLE']                      = 'N';
        $propertyDataList['NUMBER_OF_USES']['MANDATORY']                     = 'N';
        $propertyDataList['NUMBER_OF_USES']['SHOW_FILTER']                   = 'N';
        $propertyDataList['NUMBER_OF_USES']['IS_SEARCHABLE']                 = 'N';
        $propertyDataList['NUMBER_OF_USES']['USER_TYPE_ID']                  = 'integer';
        $propertyDataList['NUMBER_OF_USES']['SETTINGS']['DEFAULT_VALUE']     = 0;
        $propertyDataList['NUMBER_OF_USES']['SETTINGS']['SIZE']              = '40';
        $propertyDataList['NUMBER_OF_USES']['SETTINGS']['ROWS']              = '1';
        $propertyDataList['NUMBER_OF_USES']['SETTINGS']['SHOW_IN_LIST']      = '';
        $propertyDataList['NUMBER_OF_USES']['SETTINGS']['SORT']              = 10;
        $propertyDataList['NUMBER_OF_USES']['SETTINGS']['SHOW_FILTER']       = 'S';
        $propertyDataList['NUMBER_OF_USES']['SETTINGS']['EDIT_FORM_LABEL']   = ['ru' => 'Пользовательское свойство',
                                                                                'en' => 'User field',];
        $propertyDataList['NUMBER_OF_USES']['SETTINGS']['LIST_COLUMN_LABEL'] = ['ru' => 'Пользовательское свойство',
                                                                                'en' => 'User field',];
        $propertyDataList['NUMBER_OF_USES']['SETTINGS']['LIST_FILTER_LABEL'] = ['ru' => 'Пользовательское свойство',
                                                                                'en' => 'User field'];
        $propertyDataList['NUMBER_OF_USES']['SETTINGS']['ERROR_MESSAGE']     = ['ru' => 'Ошибка при заполнении пользовательского свойства',
                                                                                'en' => 'An error in completing the user field'];
        $propertyDataList['NUMBER_OF_USES']['SETTINGS']['HELP_MESSAGE']      = ['ru' => 'Пользовательское свойство',
                                                                                'en' => 'User field'];

        $userTypeEntity = new \CUserTypeEntity();

        foreach ($propertyDataList as $propertyDataForTable) {
            $userTypeEntity->Add($propertyDataForTable);
        }
    }

    public static function getHighloadBlockCollection($filter, $limit = 1) {

        $params['filter']      = $filter;
        $params['select']      = ['*'];
        $params['order']       = ['ID' => 'ASC'];
        $params['limit']       = $limit;
        $params['count_total'] = true;

        return HighloadBlockTable::getList($params);
    }

    /**
     * @return int
     */
    public function getStorageId() {

        $filter['NAME']     = self::STORAGE_NAME;
        $hlBlocksCollection = self::getHighloadBlockCollection($filter);

        return (int)$hlBlocksCollection->fetch()['ID'];
    }

    /**
     * @return bool
     */
    public function isStorageExist() {
        return (bool)$this->getStorageId();
    }

    protected function basketIsExistByHash($hash) {

        $baketCode = 0;

        if (!empty($hash)) {

            $filter['NAME'] = self::STORAGE_NAME;
            $hlBlock        = self::getHighloadBlockCollection($filter)->fetch();
            $dataClass      = HighloadBlockTable::compileEntity($hlBlock)->getDataClass();

            $basketElement = $dataClass::getList(['select' => ['ID',
                                                               'UF_BASKET_CODE'],
                                                  'filter' => ['UF_BASKET_HASH' => $hash]]);

            $basket = $basketElement->fetch();

            if ($basket['ID'] > 0) {
                $baketCode = $basket['UF_BASKET_CODE'];
            }

            return $baketCode;
        }
    }

    /**
     * @param     $basketValue
     * @param     $basketHash
     * @param int $userId
     *
     * @return string
     */
    public function saveBasketToStorage($basketValue, $basketHash = '', $userId = 0) {

        $filter['NAME'] = self::STORAGE_NAME;

        $hlBlock   = self::getHighloadBlockCollection($filter)->fetch();
        $dataClass = HighloadBlockTable::compileEntity($hlBlock)->getDataClass();

        $timeCurrent = time();

        $basketCode = $this->basketIsExistByHash($basketHash);

        if (!empty($basketCode)) {
            return $basketCode;
        }

        $newStorageElement = $dataClass::add(['UF_BASKET_CODE'  => $timeCurrent,
                                              'UF_BASKET_HASH'  => $basketHash,
                                              'UF_BASKET_VALUE' => $basketValue,
                                              'UF_USER_ID'      => $userId,
                                              'UF_BASKET_DATE'  => $timeCurrent]);

        return ($newStorageElement->getData()['UF_BASKET_CODE']);

    }


    /**
     * @param $basketId
     * @param $baketCountOfUses
     *
     * @return void
     */
    protected static function increaseTheCountOfUses($basketId, $baketCountOfUses) {

        $basketId            = (int)$basketId;
        $baketCountOfUses    = (int)$baketCountOfUses;
        $newBaketCountOfUses = $baketCountOfUses + 1;

        $filter['NAME'] = self::STORAGE_NAME;
        $hlBlock        = self::getHighloadBlockCollection($filter)->fetch();
        $dataClass      = HighloadBlockTable::compileEntity($hlBlock)->getDataClass();

        $dataClass::update($basketId, ['UF_NUMBER_OF_USES' => $newBaketCountOfUses]);
    }

    public function restoreBasketItemsListFromStorage($basketId) {

        $basketId       = (int)$basketId;
        $filter['NAME'] = self::STORAGE_NAME;
        $hlBlock        = self::getHighloadBlockCollection($filter)->fetch();
        $dataClass      = HighloadBlockTable::compileEntity($hlBlock)->getDataClass();

        $basketElement = $dataClass::getList(['select' => ['ID',
                                                           'UF_BASKET_VALUE',
                                                           'UF_NUMBER_OF_USES'],
                                              'filter' => ['UF_BASKET_CODE' => $basketId]]);

        $basket = $basketElement->fetch();

        $baketCountOfUses        = $basket['UF_NUMBER_OF_USES'];
        $baketElementIdInHlBlock = $basket['ID'];

        self::increaseTheCountOfUses($baketElementIdInHlBlock, $baketCountOfUses);

        return $basket['UF_BASKET_VALUE'];

    }

}