<?
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

if ($APPLICATION->GetGroupRight('codeblog.sharingbasket') > 'D') // проверка уровня доступа к модулю веб-форм
{
    // сформируем верхний пункт меню
    $menu = ['parent_menu' => 'global_menu_store',
             'sort'        => 100,
             'url'         => 'codeblog_sharingbasket_edit_options.php?lang=' . LANGUAGE_ID,
             'text'        => 'Настройки модуля сохранения/восстановления корзин',
             'title'       => 'Текст подсказки',
             // текст всплывающей подсказки
             'icon'        => 'form_menu_icon',
             // малая иконка
             'page_icon'   => 'form_page_icon',
             // большая иконка
             'items_id'    => 'menu_codeblog_sharingbasket',
             // идентификатор ветви
             'items'       => []];

    return $menu;
}

return false;
