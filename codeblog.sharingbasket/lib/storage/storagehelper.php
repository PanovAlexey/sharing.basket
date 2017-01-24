<?php
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 20.01.2017
 * Time: 13:52
 *
 * @author    Alexey Panov <panov@codeblog.pro>
 * @copyright Copyright © 2016, Alexey Panov
 */

namespace CodeBlog\SharingBasket\Storage;

use Bitrix\Main\Config\Option;
use CodeBlog\SharingBasket;
use CodeBlog\SharingBasket\Storage;

class StorageHelper
{
    /**
     * Фабричный метод.
     * Возвращает объект - текущего хранилища.
     *
     * @return Storage
     */
    public static function getStorage() {

        $typeStorage             = Option::get('codeblog.sharingbasket', 'typeStorage');
        $classNameForTypeStorage = "\\CodeBlog\\SharingBasket\\Storage\\" . ucfirst($typeStorage);
        \Bitrix\Main\Loader::includeModule('sharingbasket');
        $storage = new Storage\EmptyStorage();

        if (class_exists($classNameForTypeStorage)) {

            $storage = new $classNameForTypeStorage;

        }

        return $storage;

    }

}