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
/**
 * Interface SaveAndRestore
 *
 * @package CodeBlog\SharingBasket\Storage
 */
interface SaveAndRestore
{
    public static function deleteStorage($storageId);

    public function createStorage();

    public function getStorageId();

    public function saveBasketToStorage($basketValue, $basketHash = '', $userId);

    public function restoreBasketItemsListFromStorage($basketId);

}