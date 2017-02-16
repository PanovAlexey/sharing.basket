<?
/**
 * Created by PhpStorm.
 * Date: 13.02.2017
 * Time: 19:20
 *
 * @author    Alexey Panov <panov@codeblog.pro>
 * @copyright Copyright © 2016, Alexey Panov
 */
namespace CodeBlog\SharingBasket\Storage\Mysql;


class Connection
{
    const STORAGE_NAME      = 'Сохраненные корзины пользователей';
    const STORAGE_CODE      = 'codeblog_sharing_basket';
    const STORAGE_TYPE_NAME = 'codeblog_technical_info';
    const HOST              = 'localhost'; //Option::get('codeblog.sharingbasket', 'dbMysqlHost');
    const DATA_BASE_NAME    = 'test_buisness'; //Option::get('codeblog.sharingbasket', 'dbMysqlName');
    const LOGIN             = 'root'; //Option::get('codeblog.sharingbasket', 'dbMysqlLogin');
    const PASSWORD          = ''; //Option::get('codeblog.sharingbasket', 'dbMysqlPassword');
}