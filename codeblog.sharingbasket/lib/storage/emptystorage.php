<?php
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 19.01.2017
 * Time: 13:50
 *
 * @author    Alexey Panov <panov@codeblog.pro>
 * @copyright Copyright © 2016, Alexey Panov
 */

namespace CodeBlog\SharingBasket\Storage;
/**
 * Class EmptyStotage
 *
 * @package CodeBlog\SavingBasket\Storage
 *
 * Класс - заглушка.
 */
class EmptyStorage implements SaveAndRestore
{
    public static function deleteStorage($storageId) {
        return false;
    }

    public function createStorage() {
        return false;
    }

    public function getStorageId() {
        return false;
    }

    public function isStorageExist() {
        return false;
    }

    public function saveBasketToStorage($basketValue = '', $basketHash = '', $userId = '') {
        return false;
    }

    public function restoreBasketItemsListFromStorage($basketId) {
        return false;
    }

}
