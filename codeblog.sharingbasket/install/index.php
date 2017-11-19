<?
/**
 * Created by PhpStorm.
 * Date: 10.01.2017
 * Time: 11:00
 *
 * @package   CodeBlog
 * @category  Bitrix, basket module
 * @author    Alexey Panov <panov@codeblog.pro>
 * @copyright Copyright ? 2016, Alexey Panov
 */

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;
use Bitrix\Main\IO\Directory;
use Bitrix\Main\IO\File;
use CodeBlog\SharingBasket\Storage;
use CodeBlog\SharingBasket\Sending;

Loc::loadMessages(__FILE__);


class codeblog_sharingbasket extends \CModule
{

    public $MODULE_ID = 'codeblog.sharingbasket';
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_CSS;

    public $PARTNER_NAME;
    public $PARTNER_URI;

    public function __construct()
    {

        $arModuleVersion = array();

        include(__DIR__ . '/version.php');

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION      = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->PARTNER_NAME       = Loc::getMessage('CODEBLOG_PARTNER');
        $this->PARTNER_URI        = Loc::getMessage('CODEBLOG_PARTNER_URI');
        $this->MODULE_NAME        = Loc::getMessage('CODEBLOG_SHARING_BASKET_INSTALL_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('CODEBLOG_SHARING_BASKET_INSTALL_DESCRIPTION');

    }


    public function InstallFiles($arParams = array())
    {

        CopyDirFiles(__DIR__ . '/components', Application::getDocumentRoot() . BX_ROOT . '/components', true, true);
        CopyDirFiles(Application::getDocumentRoot() . '/local/modules/' . $this->MODULE_ID . '/admin',
            Application::getDocumentRoot() . BX_ROOT . '/admin', true, true);

        return true;
    }

    public function UnInstallFiles()
    {
        Directory::deleteDirectory(Application::getDocumentRoot() . BX_ROOT . '/components/codeblogpro/basket.sharing');

        return true;
    }

    public function DoInstallStorage()
    {

        $storage   = Storage\StorageHelper::getStorage();
        $storageId = $storage->getStorageId();

        if ($storageId == 0) {
            $storage->createStorage();
        }

    }

    public function UnInstallStorage()
    {

        $storage = Storage\StorageHelper::getStorage();

        $storageId = $storage->getStorageId();

        if ($storageId != 0) {
            $storage->deleteStorage($storageId);
        }

    }

    /**
     * @return void
     */
    public function addEmailTypeAndEmailTemplate()
    {
        
        $EventType = new CEventType;

        $EventType->Add([
            'EVENT_NAME'  => Sending\Email::C_EVENT_TYPE_NAME,
            'NAME'        => Sending\Email::C_EVENT_TYPE_NAME_RU,
            'LID'         => 'ru',
            'DESCRIPTION' => Sending\Email::C_EVENT_TYPE_DESCRIPTION_RU
        ]);

        $EventType->Add([
            'EVENT_NAME'  => Sending\Email::C_EVENT_TYPE_NAME,
            'NAME'        => 'Sending basket code',
            'LID'         => 'en',
            'DESCRIPTION' => "
#EMAIL# - E-Mail
#BASKET_CODE# - basket code"
        ]);

        $emailTemplateFields['ACTIVE']      = 'Y';
        $emailTemplateFields['EVENT_NAME']  = Sending\Email::C_EVENT_TYPE_NAME;
        $emailTemplateFields['LID']         = ['s1'];
        $emailTemplateFields['EMAIL_FROM']  = '#DEFAULT_EMAIL_FROM#';
        $emailTemplateFields['EMAIL_TO']    = '#EMAIL#';
        $emailTemplateFields['BCC']         = '';
        $emailTemplateFields['SUBJECT']     = '#EMAIL#';
        $emailTemplateFields['BODY_TYPE']   = 'text';
        $emailTemplateFields['MESSAGE']     = Sending\Email::C_EVENT_MESSAGE_RU;

        $eventMessage = new CEventMessage;
        $eventMessage->Add($emailTemplateFields);

        if (!empty($eventMessage->LAST_ERROR)) {
            /**
             * @Todo добавить вывод и логирование ошибки
             */
        }
    }

    /**
     * @global $DB
     *
     * @return void
     */
    public function deleteEmailTypeAndEmailTemplate() {

        global $DB;

        CEventType::Delete(
            [
                'EVENT_NAME' => Sending\Email::C_EVENT_TYPE_NAME
            ]
        );

        $eventMessage = new CEventMessage;
        $DB->StartTransaction();
        if(!$eventMessage->Delete($this->getMessageTemplateIdByName(Sending\Email::C_EVENT_TYPE_NAME))) {
            $DB->Rollback();
            /**
             * @ToDo добавить вывод ошибки
             */
            //$strError .= GetMessage("DELETE_ERROR");
        }
        else $DB->Commit();
    }

    /**
     * @param string $templateName
     *
     * @return array
     */
    public function getMessageTemplateIdByName($templateName) {

        $filter = [
            'TYPE_ID'       => [$templateName],
        ];

        $eventMessageCollection = CEventMessage::GetList($by = 'site_id', $order = 'desc', $filter);

        $templatesIdList = [];

        while($eventMessageItem = $eventMessageCollection->Fetch()) {
            $templatesIdList = $eventMessageItem['ID'];
        }

        return $templatesIdList;
    }

    public function DoInstall()
    {

        global $APPLICATION;
        global $step;

        $step = (int)$step;

        if ($step < 1) {
            $APPLICATION->IncludeAdminFile(Loc::getMessage('CODEBLOG_SHARING_BASKET_INSTALL_TITLE', array(
                '#MODULE#',
                $this->MODULE_NAME
            )), __DIR__ . '/step.php');
        } elseif ($step >= 1) {

            $request = Application::getInstance()->getContext()->getRequest();

            $typeStorage = $request->getPost('typestorage');

            if (!empty($typeStorage)) {
                Option::set('codeblog.sharingbasket', 'typeStorage', $typeStorage);
            }

            RegisterModule($this->MODULE_ID);

            \Bitrix\Main\Loader::includeModule('codeblog.sharingbasket');

            $this->InstallFiles();
            $this->DoInstallStorage();
            $this->addEmailTypeAndEmailTemplate();

            $APPLICATION->IncludeAdminFile(Loc::getMessage('CODEBLOG_SHARING_BASKET_INSTALL_TITLE', array(
                '#MODULE#',
                $this->MODULE_NAME
            )), __DIR__ . '/step2.php');


        }
    }

    public function DoUninstall()
    {

        global $APPLICATION;

        \Bitrix\Main\Loader::includeModule('codeblog.sharingbasket');

        $this->UnInstallStorage();
        $this->UnInstallFiles();
        $this->deleteEmailTypeAndEmailTemplate();

        Option::delete($this->MODULE_ID);

        UnRegisterModule($this->MODULE_ID);

        $APPLICATION->IncludeAdminFile(Loc::getMessage('CODEBLOG_SHARING_BASKET_UNINSTALL_TITLE', array(
            '#MODULE#',
            $this->MODULE_NAME
        )), __DIR__ . '/unstep.php');
    }


}