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

class IBlock implements SaveAndRestore
{
    public function saveBasketToStorage( $basketDate, $basketDate, $userId) {
    }

    public function restoreBasketItemsListFromStorage($basketId) {
    }

}