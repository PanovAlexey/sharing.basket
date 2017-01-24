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

    private $itemsList = [];

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
     * @return json
     */
    public function getItemsListFormat() {

        $basketCollection = BasketTable::getList(['filter' => ['=FUSER_ID' => Fuser::getId(),
                                                               '=ORDER_ID' => null]]);
        while ($item = $basketCollection->fetch()) {
            $this->push($item['PRODUCT_ID'], $item['QUANTITY'], $item['DELAY']);
        }

        return $this->itemsListToFormat($this->itemsList);
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

    /**
     * @param array $itemsList
     */
    public function setItemsList(array $itemsList) {
        $this->itemsList = $itemsList;
    }

}