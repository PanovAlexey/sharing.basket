<?
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 01.06.2017
 * Time: 18:39
 *
 * @author    Alexey Panov <panov@codeblog.pro>
 * @copyright Copyright © 2016, Alexey Panov
 */

namespace CodeBlog\SharingBasket\Sending;


/**
 * Interface Sending
 *
 * @package CodeBlog\SharingBasket\Sending
 */
interface Sending
{
    public static function send($recipient, $basket);
}