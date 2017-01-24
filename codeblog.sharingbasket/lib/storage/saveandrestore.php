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

interface SaveAndRestore
{
    public function createStorage();

    public function getStorageId();

    public static function deleteStorage($storageId);

    public function saveBasketToStorage( $basketValue, $userId);

    public function restoreBasketItemsListFromStorage($basketId);

}