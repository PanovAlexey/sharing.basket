<?
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 25.01.2017
 * Time: 15:05
 *
 * @author    Alexey Panov <panov@codeblog.pro>
 * @copyright Copyright © 2016, Alexey Panov
 */

namespace CodeBlog\SharingBasket\Site;


class Helper
{
    /**
     * @return string
     */
    public static function getSiteDefaultCode() {
        $sitesCollection = \CSite::GetList($by = 'sort', $order = 'desc', []);
        while ($site = $sitesCollection->Fetch()) {
            if ($site['DEF']) {
                return $site['LID'];
            }
        }
    }

}

