<?
namespace CodeBlog\SharingBasket\Vendor;


class CModuleOptions
{
    public $arCurOptionValues = [];

    private $moduleId = '';
    private $tabsList = [];
    private $groupsList = [];
    private $optionsList = [];

    public function __construct($moduleId, $tabsList, $groupsList, $optionsList)
    {
        $this->moduleId = $moduleId;
        $this->tabsList = $tabsList;
        $this->groupsList = $groupsList;
        $this->optionsList = $optionsList;

        if ($_REQUEST['update'] == 'Y' && check_bitrix_sessid()) {
            $this->SaveOptions();
        }

        $this->GetCurOptionValues();
    }

    private function SaveOptions()
    {
        foreach($this->optionsList as $opt => $arOptParams)
        {
            if($arOptParams['TYPE'] != 'CUSTOM')
            {
                $val = $_REQUEST[$opt];

                if($arOptParams['TYPE'] == 'CHECKBOX' && $val != 'Y')
                    $val = 'N';
                elseif(is_array($val))
                    $val = serialize($val);

                COption::SetOptionString($this->module_id, $opt, $val);
            }
        }
    }

    private function GetCurOptionValues()
    {
        foreach($this->optionsList as $opt => $arOptParams)
        {
            if($arOptParams['TYPE'] != 'CUSTOM')
            {
                $this->arCurOptionValues[$opt] = \COption::GetOptionString($this->module_id, $opt, $arOptParams['DEFAULT']);
                if(in_array($arOptParams['TYPE'], array('MSELECT')))
                    $this->arCurOptionValues[$opt] = unserialize($this->arCurOptionValues[$opt]);
            }
        }
    }

    public function ShowHTML()
    {
        global $APPLICATION;

        $arP = [];

        foreach($this->groupsList as $group_id => $group_params)
            $arP[$group_params['TAB']][$group_id] = [];

        if(is_array($this->optionsList))
        {
            foreach($this->optionsList as $option => $arOptParams)
            {
                $val = $this->arCurOptionValues[$option];

                if($arOptParams['SORT'] < 0 || !isset($arOptParams['SORT']))
                    $arOptParams['SORT'] = 0;

                $label = (isset($arOptParams['TITLE']) && $arOptParams['TITLE'] != '') ? $arOptParams['TITLE'] : '';
                $opt = htmlspecialchars($option);

                switch($arOptParams['TYPE'])
                {
                    case 'CHECKBOX':
                        $input = '<input ' . $arOptParams['OTHER_PARAMETERS'] . ' type="checkbox" name="'.$opt.'" id="'.$opt.'" value="Y"'.($val == 'Y' ? ' checked' : '').' '.($arOptParams['REFRESH'] == 'Y' ? 'onclick="document.forms[\''.$this->module_id.'\'].submit();"' : '').' />';
                        break;
                    case 'TEXT':
                        if(!isset($arOptParams['COLS']))
                            $arOptParams['COLS'] = 25;
                        if(!isset($arOptParams['ROWS']))
                            $arOptParams['ROWS'] = 5;
                        $input = '<textarea rows="'.$type[1].'" cols="'.$arOptParams['COLS'].'" rows="'.$arOptParams['ROWS'].'" name="'.$opt.'">'.htmlspecialchars($val).'</textarea>';
                        if($arOptParams['REFRESH'] == 'Y')
                            $input .= '<input type="submit" name="refresh" value="OK" />';
                        break;

                    default:
                        if(!isset($arOptParams['SIZE']))
                            $arOptParams['SIZE'] = 25;
                        if(!isset($arOptParams['MAXLENGTH']))
                            $arOptParams['MAXLENGTH'] = 255;
                        $input = '<input ' . $arOptParams['OTHER_PARAMETERS'] . ' type="'.($arOptParams['TYPE'] == 'INT' ? 'number' : 'text').'" size="'.$arOptParams['SIZE'].'" maxlength="'.$arOptParams['MAXLENGTH'].'" value="'.htmlspecialchars($val).'" name="'.htmlspecialchars($option).'" />';

                        if ($arOptParams['REFRESH'] == 'Y')
                            $input .= '<input type="submit" name="refresh" value="OK" />';
                        break;
                }

                if(isset($arOptParams['NOTES']) && $arOptParams['NOTES'] != '')
                    $input .=     '<div class="notes">
                                    <table cellspacing="0" cellpadding="0" border="0" class="notes">
                                        <tbody>
                                            <tr class="top">
                                                <td class="left"><div class="empty"></div></td>
                                                <td><div class="empty"></div></td>
                                                <td class="right"><div class="empty"></div></td>
                                            </tr>
                                            <tr>
                                                <td class="left"><div class="empty"></div></td>
                                                <td class="content">
                                                    '.$arOptParams['NOTES'].'
                                                </td>
                                                <td class="right"><div class="empty"></div></td>
                                            </tr>
                                            <tr class="bottom">
                                                <td class="left"><div class="empty"></div></td>
                                                <td><div class="empty"></div></td>
                                                <td class="right"><div class="empty"></div></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>';

                $arP[$this->groupsList[$arOptParams['GROUP']]['TAB']][$arOptParams['GROUP']]['OPTIONS'][] = $label != '' ? '<tr><td valign="top" width="40%">'.$label.'</td><td valign="top" nowrap>'.$input.'</td></tr>' : '<tr><td valign="top" colspan="2" align="center">'.$input.'</td></tr>';
                $arP[$this->groupsList[$arOptParams['GROUP']]['TAB']][$arOptParams['GROUP']]['OPTIONS_SORT'][] = $arOptParams['SORT'];
            }

            $tabControl = new \CAdminTabControl('tabControl', $this->tabsList);
            $tabControl->Begin();
            echo '<form name="'.$this->module_id.'" method="POST" action="'.$APPLICATION->GetCurPage().'?mid='.$this->module_id.'&lang='.LANGUAGE_ID.'" enctype="multipart/form-data">' . bitrix_sessid_post();

            foreach($arP as $tab => $groups)
            {
                $tabControl->BeginNextTab();

                foreach($groups as $group_id => $group)
                {
                    if(sizeof($group['OPTIONS_SORT']) > 0)
                    {
                        echo '<tr class="heading"><td colspan="2">'.$this->groupsList[$group_id]['TITLE'].'</td></tr>';

                        array_multisort($group['OPTIONS_SORT'], $group['OPTIONS']);
                        foreach($group['OPTIONS'] as $opt)
                            echo $opt;
                    }
                }
            }

            $tabControl->Buttons();

            echo     '<input type="hidden" name="update" value="Y" />
                    <input type="submit" name="save" value="Сохранить" />
                    <input type="reset" name="reset" value="Отменить" />
                    </form>';

            $tabControl->End();
        }
    }
}