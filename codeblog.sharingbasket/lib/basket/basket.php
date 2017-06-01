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

/**
 * Class Basket
 *
 * @package CodeBlog\SharingBasket\Basket
 */
class Basket
{
    private $id;
    private $code;
    private $value;
    private $hash;
    private $date;
    private $userId;
    private $notifyEmailValue;
    private $notifyQuantityToEmailValue;
    private $numberOfUses;

    /**
     * Basket constructor.
     *
     * @param int $id
     * @param     $code
     * @param     $value
     * @param     $hash
     * @param     $date
     * @param     $userId
     * @param     $notifyEmailValue
     * @param     $notifyQuantityToEmailValue
     * @param     $numberOfUses
     */
    public function __construct(
        $id,
        $code,
        $value,
        $hash,
        $date,
        $userId,
        $notifyEmailValue,
        $notifyQuantityToEmailValue,
        $numberOfUses
    ) {
        $this->id = (int)$id;
        $this->code = (int)$code;
        $this->value = trim($value);
        $this->hash = trim($hash);
        $this->date = trim($date);
        $this->userId = (int)trim($userId);
        $this->notifyEmailValue = trim($notifyEmailValue);
        $this->notifyQuantityToEmailValue = (int)$notifyQuantityToEmailValue;
        $this->numberOfUses = (int)$numberOfUses;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getNotifyEmailValue()
    {
        return $this->notifyEmailValue;
    }

    /**
     * @return int
     */
    public function getNotifyQuantityToEmail()
    {
        return $this->notifyQuantityToEmailValue;
    }

    /**
     * @return int
     */
    public function getNumberOfUses()
    {
        return $this->numberOfUses;
    }

}