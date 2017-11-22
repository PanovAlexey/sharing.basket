<?
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

if ($APPLICATION->GetGroupRight('codeblog.sharingbasket') > 'D') {
    $menu = [
        'parent_menu' => 'global_menu_store',
        'sort'        => 100,
        'url'         => 'codeblog_sharingbasket_edit_options.php?lang='
            .LANGUAGE_ID,
        'text'        => 'Настройки модуля сохранения/восстановления корзин',
        'title'       => 'Текст подсказки',
        'icon'        => 'form_menu_icon',
        'page_icon'   => 'form_page_icon',
        'items_id'    => 'menu_codeblog_sharingbasket',
        'items'       => [],
    ];

    return $menu;
}

return false;