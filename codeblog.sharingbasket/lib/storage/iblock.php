<?
/**
 * Created by PhpStorm.
 * Date: 25.01.2017
 * Time: 12:00
 *
 * @author    Alexey Panov <panov@codeblog.pro>
 * @copyright Copyright � 2016, Alexey Panov
 */

namespace CodeBlog\SharingBasket\Storage;

use \Bitrix\Main\Loader;
use \CodeBlog\SharingBasket\Site;
use \CodeBlog\SharingBasket\Basket\Basket;

Loader::includeModule('iblock');

class Iblock implements SaveAndRestore
{

    const STORAGE_NAME                 = '����������� ������� �������������';
    const STORAGE_CODE                 = 'codeblog_sharing_basket';
    const STORAGE_TYPE_NAME            = 'codeblog_technical_info';
    const STORAGE_SORT_WEIGHT_VALUE    = 500;
    const STORAGE_IBLOCK_VERSION_VALUE = 2;
    const STORAGE_IBLOCK_ACTIVE_VALUE  = 'Y';

    /**
     * @param $storageId
     *
     * @return  void
     */
    public static function deleteStorage($storageId) {

        global $DB;

        $DB->StartTransaction();
        if (!\CIBlock::Delete($storageId)) {
            $DB->Rollback();
        } else {
            $DB->Commit();
        }

        $DB->StartTransaction();

        if (!\CIBlockType::Delete(self::STORAGE_TYPE_NAME)) {
            $DB->Rollback();
        }

        $DB->Commit();
    }

    /**
     * @return int
     */
    protected function createTypeIBlock() {

        global $DB;

        $typeIBlockParams = ['ID'       => self::STORAGE_TYPE_NAME,
                             'SECTIONS' => 'Y',
                             'LANG'     => ['ru' => ['NAME' => '����������� ����������'],
                                            'en' => ['NAME' => 'Technical information']]];

        $iBlockType = new \CIBlockType;
        $DB->StartTransaction();
        $iBlockTypeEntity = $iBlockType->Add($typeIBlockParams);
        if (!$iBlockTypeEntity) {
            $DB->Rollback();

            /**
             * @TODO: �������� ��������� ������ �������� ���� ���������
             */
            //$errors = $iBlockTypeEntity->LAST_ERROR;
        } else {
            $DB->Commit();
        }


        $typeIBlockId = $iBlockTypeEntity;

        return $typeIBlockId;

    }

    /**
     * @return int
     */
    public function createStorage() {

        $this->createTypeIblock();

        $iBlockParams = ['NAME'             => self::STORAGE_NAME,
                         'CODE'             => self::STORAGE_CODE,
                         'IBLOCK_TYPE_ID'   => self::STORAGE_TYPE_NAME,
                         'ACTIVE'           => self::STORAGE_IBLOCK_ACTIVE_VALUE,
                         'SORT'             => self::STORAGE_SORT_WEIGHT_VALUE,
                         'LIST_PAGE_URL'    => '',
                         'DETAIL_PAGE_URL'  => '',
                         'SECTION_PAGE_URL' => '',
                         'DESCRIPTION'      => '',
                         'VERSION'          => self::STORAGE_IBLOCK_VERSION_VALUE,
                         'SITE_ID'          => [Site\Helper::getSiteDefaultCode()]

        ];

        $iBlock = new \CIBlock;

        $iBlockId = $iBlock->Add($iBlockParams);

        $this->createPropertiesStorage($iBlockId);

        return (int)$iBlockId;

    }

    private function createPropertiesStorage($iBlockId) {

        $propertyDataList['BASKET_CODE']['IBLOCK_ID']     = $iBlockId;
        $propertyDataList['BASKET_CODE']['NAME']          = '��� �������';
        $propertyDataList['BASKET_CODE']['CODE']          = 'CODEBLOG_BASKET_CODE';
        $propertyDataList['BASKET_CODE']['DEFAULT_VALUE'] = '';
        $propertyDataList['BASKET_CODE']['PROPERTY_TYPE'] = 'S';
        $propertyDataList['BASKET_CODE']['ROW_COUNT']     = 1;
        $propertyDataList['BASKET_CODE']['COL_COUNT']     = 40;
        $propertyDataList['BASKET_CODE']['XML_ID']        = 'XML_BASKET_CODE';
        $propertyDataList['BASKET_CODE']['VERSION']       = self::STORAGE_IBLOCK_VERSION_VALUE;

        $propertyDataList['BASKET_HASH']['IBLOCK_ID']     = $iBlockId;
        $propertyDataList['BASKET_HASH']['NAME']          = '���������� ���� �������';
        $propertyDataList['BASKET_HASH']['CODE']          = 'CODEBLOG_BASKET_HASH';
        $propertyDataList['BASKET_HASH']['DEFAULT_VALUE'] = '';
        $propertyDataList['BASKET_HASH']['PROPERTY_TYPE'] = 'S';
        $propertyDataList['BASKET_HASH']['ROW_COUNT']     = 1;
        $propertyDataList['BASKET_HASH']['COL_COUNT']     = 40;
        $propertyDataList['BASKET_HASH']['XML_ID']        = 'XML_BASKET_HASH';
        $propertyDataList['BASKET_HASH']['VERSION']       = self::STORAGE_IBLOCK_VERSION_VALUE;

        $propertyDataList['BASKET_VALUE']['IBLOCK_ID']     = $iBlockId;
        $propertyDataList['BASKET_VALUE']['NAME']          = '����������  �������';
        $propertyDataList['BASKET_VALUE']['CODE']          = 'CODEBLOG_BASKET_VALUE';
        $propertyDataList['BASKET_VALUE']['DEFAULT_VALUE'] = '[]';
        $propertyDataList['BASKET_VALUE']['PROPERTY_TYPE'] = 'S';
        $propertyDataList['BASKET_VALUE']['ROW_COUNT']     = 5;
        $propertyDataList['BASKET_VALUE']['COL_COUNT']     = 40;
        $propertyDataList['BASKET_VALUE']['XML_ID']        = 'XML_BASKET_VALUE';
        $propertyDataList['BASKET_VALUE']['VERSION']       = self::STORAGE_IBLOCK_VERSION_VALUE;

        $propertyDataList['USER_ID']['IBLOCK_ID']     = $iBlockId;
        $propertyDataList['USER_ID']['NAME']          = '����� �������';
        $propertyDataList['USER_ID']['CODE']          = 'CODEBLOG_USER_ID';
        $propertyDataList['USER_ID']['DEFAULT_VALUE'] = 0;
        $propertyDataList['USER_ID']['PROPERTY_TYPE'] = 'N';
        $propertyDataList['USER_ID']['ROW_COUNT']     = 1;
        $propertyDataList['USER_ID']['COL_COUNT']     = 40;
        $propertyDataList['USER_ID']['XML_ID']        = 'XML_USER_ID';
        $propertyDataList['USER_ID']['VERSION']       = self::STORAGE_IBLOCK_VERSION_VALUE;

        $propertyDataList['BASKET_DATE']['IBLOCK_ID']     = $iBlockId;
        $propertyDataList['BASKET_DATE']['NAME']          = '���� �������� �������';
        $propertyDataList['BASKET_DATE']['CODE']          = 'CODEBLOG_BASKET_DATE';
        $propertyDataList['BASKET_DATE']['DEFAULT_VALUE'] = '';
        $propertyDataList['BASKET_DATE']['PROPERTY_TYPE'] = 'S';
        $propertyDataList['BASKET_DATE']['ROW_COUNT']     = 1;
        $propertyDataList['BASKET_DATE']['COL_COUNT']     = 40;
        $propertyDataList['BASKET_DATE']['XML_ID']        = 'XML_BASKET_DATE';
        $propertyDataList['BASKET_DATE']['VERSION']       = self::STORAGE_IBLOCK_VERSION_VALUE;

        $propertyDataList['NOTIFY_PHONE_VALUE']['IBLOCK_ID']     = $iBlockId;
        $propertyDataList['NOTIFY_PHONE_VALUE']['NAME']          = '����� �������� ������������� �����������';
        $propertyDataList['NOTIFY_PHONE_VALUE']['CODE']          = 'CODEBLOG_NOTIFY_PHONE_VALUE';
        $propertyDataList['NOTIFY_PHONE_VALUE']['DEFAULT_VALUE'] = '';
        $propertyDataList['NOTIFY_PHONE_VALUE']['PROPERTY_TYPE'] = 'S';
        $propertyDataList['NOTIFY_PHONE_VALUE']['ROW_COUNT']     = 1;
        $propertyDataList['NOTIFY_PHONE_VALUE']['COL_COUNT']     = 40;
        $propertyDataList['NOTIFY_PHONE_VALUE']['XML_ID']        = 'XML_NOTIFY_PHONE_VALUE';
        $propertyDataList['NOTIFY_PHONE_VALUE']['VERSION']       = self::STORAGE_IBLOCK_VERSION_VALUE;

        $propertyDataList['NOTIFY_EMAIL_VALUE']['IBLOCK_ID']     = $iBlockId;
        $propertyDataList['NOTIFY_EMAIL_VALUE']['NAME']          = 'Email ������������� �����������';
        $propertyDataList['NOTIFY_EMAIL_VALUE']['CODE']          = 'CODEBLOG_NOTIFY_EMAIL_VALUE';
        $propertyDataList['NOTIFY_EMAIL_VALUE']['DEFAULT_VALUE'] = '';
        $propertyDataList['NOTIFY_EMAIL_VALUE']['PROPERTY_TYPE'] = 'S';
        $propertyDataList['NOTIFY_EMAIL_VALUE']['ROW_COUNT']     = 1;
        $propertyDataList['NOTIFY_EMAIL_VALUE']['COL_COUNT']     = 40;
        $propertyDataList['NOTIFY_EMAIL_VALUE']['XML_ID']        = 'XML_NOTIFY_EMAIL_VALUE';
        $propertyDataList['NOTIFY_EMAIL_VALUE']['VERSION']       = self::STORAGE_IBLOCK_VERSION_VALUE;

        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['IBLOCK_ID']     = $iBlockId;
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['NAME']          = '���������� ������������ ����������� �� ���';
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['CODE']          = 'CODEBLOG_NOTIFY_QUANT_TO_PHONE';
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['DEFAULT_VALUE'] = 0;
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['PROPERTY_TYPE'] = 'N';
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['ROW_COUNT']     = 1;
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['COL_COUNT']     = 40;
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['XML_ID']        = 'XML_NOTIFY_QUANT_TO_PHONE';
        $propertyDataList['NOTIFY_QUANT_TO_PHONE']['VERSION']       = self::STORAGE_IBLOCK_VERSION_VALUE;

        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['IBLOCK_ID']     = $iBlockId;
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['NAME']          = '���������� ������������ ����������� �� email';
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['CODE']          = 'CODEBLOG_NOTIFY_QUANT_TO_EMAIL';
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['DEFAULT_VALUE'] = 0;
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['PROPERTY_TYPE'] = 'N';
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['ROW_COUNT']     = 1;
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['COL_COUNT']     = 40;
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['XML_ID']        = 'XML_NOTIFY_QUANT_TO_EMAIL';
        $propertyDataList['NOTIFY_QUANT_TO_EMAIL']['VERSION']       = self::STORAGE_IBLOCK_VERSION_VALUE;

        $propertyDataList['NUMBER_OF_USES']['IBLOCK_ID']     = $iBlockId;
        $propertyDataList['NUMBER_OF_USES']['NAME']          = '���������� �������� �������';
        $propertyDataList['NUMBER_OF_USES']['CODE']          = 'CODEBLOG_NUMBER_OF_USES';
        $propertyDataList['NUMBER_OF_USES']['DEFAULT_VALUE'] = 0;
        $propertyDataList['NUMBER_OF_USES']['PROPERTY_TYPE'] = 'N';
        $propertyDataList['NUMBER_OF_USES']['ROW_COUNT']     = 1;
        $propertyDataList['NUMBER_OF_USES']['COL_COUNT']     = 40;
        $propertyDataList['NUMBER_OF_USES']['XML_ID']        = 'XML_NUMBER_OF_USES';
        $propertyDataList['NUMBER_OF_USES']['VERSION']       = self::STORAGE_IBLOCK_VERSION_VALUE;

        $iBlockProperty = new \CIBlockProperty;

        foreach ($propertyDataList as $propertyData) {
            $iBlockProperty->Add($propertyData);
        }

    }

    /**
     * @return int
     */
    public function getStorageId() {

        $filter['CODE'] = self::STORAGE_CODE;
        $select         = ['ID'];

        $iBlockEntity = \Bitrix\Iblock\IblockTable::getList(['filter' => $filter,
                                                             'select' => $select]);
        $iBlock       = $iBlockEntity->fetch();

        return (int)$iBlock['ID'];

    }

    /**
     * @return bool
     */
    public function isStorageExist() {
        return (bool)$this->getStorageId();
    }

    /**
     * @param $hash
     *
     * @return int
     */
    protected function basketIsExistByHash($hash) {

        $baketCode = 0;

        $select = ['ID',
                   'PROPERTY_CODEBLOG_BASKET_CODE',
                   'PROPERTY_CODEBLOG_BASKET_HASH'];
        $filter = ['IBLOCK_ID'                     => self::getStorageId(),
                   'PROPERTY_CODEBLOG_BASKET_HASH' => $hash];

        if (!empty($hash)) {

            $iBlockItemsCollection = \CIBlockElement::GetList([], $filter, false, false, $select);

            if ($item = $iBlockItemsCollection->Fetch()) {
                $baketCode = $item['PROPERTY_CODEBLOG_BASKET_CODE_VALUE'];
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

        global $USER;

        $iBlockId = $this->getStorageId();

        $iBlockElement = new \CIBlockElement;

        $timeCurrent = time();
        $basketHash  = trim($basketHash);

        $propertyList                          = [];
        $propertyList['CODEBLOG_BASKET_CODE']  = $timeCurrent;
        $propertyList['CODEBLOG_BASKET_HASH']  = $basketHash;
        $propertyList['CODEBLOG_BASKET_VALUE'] = $basketValue;
        $propertyList['CODEBLOG_USER_ID']      = $userId;
        $propertyList['CODEBLOG_BASKET_DATE']  = $timeCurrent;

        $arLoadProductArray = ['MODIFIED_BY'       => $USER->GetID(),
                               'IBLOCK_SECTION_ID' => false,
                               'IBLOCK_ID'         => $iBlockId,
                               'PROPERTY_VALUES'   => $propertyList,
                               'NAME'              => '������� ' . date('Y m d G:i:s'),
                               'ACTIVE'            => 'Y'];

        $basketCode = $this->basketIsExistByHash($basketHash);

        if (!empty($basketCode)) {
            return $basketCode;
        }

        if (!$iBlockElementId = $iBlockElement->Add($arLoadProductArray)) {
            /**
             * @TODO: �������� ����������� ������
             */
            //echo $el->LAST_ERROR;
        }

        return $propertyList['CODEBLOG_BASKET_CODE'];

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

        \CIBlockElement::SetPropertyValuesEx($basketId, false, ['CODEBLOG_NUMBER_OF_USES' => $newBaketCountOfUses]);
    }

    /**
     * @param int $basketCode
     * @param string $emailValue
     *
     * @return $isEmailUpdate bool
     */
    public static function saveEmailValue($basketCode, $emailValue) {

        $isEmailUpdate = false;

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

        \CIBlockElement::SetPropertyValuesEx(
            $basket->getId(),
            false,
            [
                'CODEBLOG_NOTIFY_EMAIL_VALUE' => $emailNewValue
            ]
        );


        return $isEmailUpdate;

    }

    /**
     * @param $basketCode
     *
     * @return void
     */
    public static function increaseTheCountOfSending($basketCode) {

        $basket = self::getBasketByCode($basketCode);

        $newBaketCountOfUses = $basket->getNotifyQuantityToEmail() + 1;

        \CIBlockElement::SetPropertyValuesEx(
            $basket->getId(),
            false,
            [
                'CODEBLOG_NOTIFY_QUANT_TO_EMAIL' => $newBaketCountOfUses
            ]
        );
    }

    /**
     * @param $basketCode
     *
     * @return string
     */
    public function restoreBasketItemsListFromStorage($basketCode) {

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

        $select   = [
            'ID',
            'PROPERTY_CODEBLOG_BASKET_CODE',
            'PROPERTY_CODEBLOG_BASKET_HASH',
            'PROPERTY_CODEBLOG_BASKET_VALUE',
            'PROPERTY_CODEBLOG_USER_ID',
            'PROPERTY_CODEBLOG_BASKET_DATE',
            'PROPERTY_CODEBLOG_NOTIFY_PHONE_VALUE',
            'PROPERTY_CODEBLOG_NOTIFY_EMAIL_VALUE',
            'PROPERTY_CODEBLOG_NOTIFY_QUANT_TO_PHONE',
            'PROPERTY_CODEBLOG_NOTIFY_QUANT_TO_EMAIL',
            'PROPERTY_CODEBLOG_NUMBER_OF_USES',
        ];
        $filter   = [
            'IBLOCK_ID'                     => self::getStorageId(),
            'PROPERTY_CODEBLOG_BASKET_CODE' => (int)$basketCode
        ];

        $iBlockItemsCollection = \CIBlockElement::GetList([], $filter, false, false, $select);

        $basketElement = $iBlockItemsCollection->Fetch();

        $basket = new Basket(
            $basketElement['ID'],
            $basketElement['PROPERTY_CODEBLOG_BASKET_CODE_VALUE'],
            $basketElement['PROPERTY_CODEBLOG_BASKET_VALUE_VALUE'],
            $basketElement['PROPERTY_CODEBLOG_BASKET_HASH_VALUE'],
            $basketElement['PROPERTY_CODEBLOG_BASKET_DATE_VALUE'],
            $basketElement['PROPERTY_CODEBLOG_USER_ID_VALUE'],
            $basketElement['PROPERTY_CODEBLOG_NOTIFY_EMAIL_VALUE_VALUE'],
            $basketElement['PROPERTY_CODEBLOG_NOTIFY_QUANT_TO_EMAIL_VALUE'],
            $basketElement['PROPERTY_CODEBLOG_NUMBER_OF_USES_VALUE']
        );

        return $basket;
    }

}