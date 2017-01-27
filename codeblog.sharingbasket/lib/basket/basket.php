<?
/**
 * Created by PhpStorm.
 * Date: 10.01.2017
 * Time: 11:00
 *
 * @author    Alexey Panov <panov@codeblog.pro>
 * @copyright Copyright © 2016, Alexey Panov
 */

namespace CodeBlog\SharingBasket\Basket;

use Bitrix\Main\Context;
use Bitrix\Sale\Fuser;
use Bitrix\Sale\Internals\BasketTable;
use Bitrix\Currency\CurrencyManager;


class Basket
{

    protected $itemsList  = [];
    protected $basketHash = '';

    protected function push($productId, $quantity, $delay) {

        $productId = (int)$productId;
        $quantity  = trim($quantity);
        $delay     = trim($delay);

        $this->itemsList[$productId] = ['QUANTITY' => $quantity,
                                        'DELAY'    => $delay];
    }

    public function __construct() {

    }

    /**
     * @return void
     */
    protected function setItemsList() {

        $basketCollection = BasketTable::getList(['filter' => ['=FUSER_ID' => Fuser::getId(),
                                                               '=ORDER_ID' => null]]);

        while ($item = $basketCollection->fetch()) {
            $this->push($item['PRODUCT_ID'], $item['QUANTITY'], $item['DELAY']);
        }

        $this->basketHashCalculate();
    }

    protected function basketHashCalculate() {

        $basketHash  = '';
        $itemsIdList = [];

        foreach ($this->itemsList as $itemId => $itemFields) {
            $itemsIdList[] = $itemId;
        }

        unset($itemId);

        foreach ($itemsIdList as $itemId) {
            $basketHash .= $itemId;
            foreach ($this->itemsList[$itemId] as $fieldValue) {
                $basketHash .= $fieldValue;
            }

        }

        $this->basketHash = $basketHash;

    }

    /**
     * @return json
     */
    public function getItemsListFormat($getBasketHash = false) {

        $this->setItemsList();

        if ($getBasketHash) {
            return ['ITEMS_LIST_FORMAT' => $this->itemsListToFormat($this->itemsList),
                    'BASKET_HASH'       => $this->basketHash];
        } else {
            return $this->itemsListToFormat($this->itemsList);
        }

    }

    //@TODO: реализовать проверку на существование товара
    public function isProductExist($itemId) {
        return true;
    }

    //@TODO: реализовать проверку на наличие товара на складе
    public function isProductInStock($itemId) {
        return true;
    }

    /**
     * @param $itemsListFormat
     *
     * @return void
     */
    public function setBasketByItemsListFormat($itemsListFormat) {

        $itemsList = $this->itemsListUnFormat($itemsListFormat);

        $basket = \Bitrix\Sale\Basket::loadItemsForFUser(Fuser::getId(), Context::getCurrent()->getSite());
        $basket->clearCollection();

        foreach ($itemsList as $itemId => $itemFields) {

            if ($this->isProductExist($itemId) && $this->isProductInStock($itemId)) {
                $item = $basket->createItem('catalog', $itemId);
                $item->setFields(['QUANTITY'               => $itemFields['QUANTITY'],
                                  'DELAY'                  => $itemFields['DELAY'],
                                  'CURRENCY'               => CurrencyManager::getBaseCurrency(),
                                  'LID'                    => Context::getCurrent()->getSite(),
                                  'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider']);
            }

        }

        $basket->save();
    }

    /**
     * @param array $itemsList
     *
     * @return string
     */
    private function itemsListToFormat(array $itemsList) {
        return json_encode($itemsList);
    }

    private function itemsListUnFormat($itemsListFormated) {
        return json_decode($itemsListFormated, JSON_OBJECT_AS_ARRAY);
    }

}