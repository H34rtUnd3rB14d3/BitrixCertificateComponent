<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;

class MyTopList extends CBitrixComponent
{

	private const ENTITIES_DEFAULT_AMOUNT = 10;

	public function onPrepareComponentParams($arParams)
	{
		$arParams["USER_AMOUNT"] = is_numeric($arParams["USER_AMOUNT"]) ? $arParams["USER_AMOUNT"] : self::ENTITIES_DEFAULT_AMOUNT;
		return $arParams;
	}
	public function executeComponent()
    {
        try
        {
            $this->checkModules();
            $this->getResult();
            $this->includeComponentTemplate();
        }
        catch (SystemException $e)
        {
            ShowError($e->getMessage());
        }
    }

	protected function checkModules()
    {
        if (!Loader::includeModule('iblock'))
            throw new SystemException(Loc::getMessage('CPS_MODULE_NOT_INSTALLED', array('#NAME#' => 'iblock')));
    }

	protected function getResult()
    {
        if ($this->errors) {
            throw new SystemException(current($this->errors));
		}

        $arParams = $this->arParams;
		$arResult = [
			"USER_AMOUNT" => 0,
		];
		$newsSort = [
			"DATE_CREATE" => "DESC",
		];

		$date_from = date("01.m.Y");
		$newsFilter = [
			"IBLOCK_ID" => 3,
			"ACTIVE" => "Y",
			">=DATE_CREATE" => $date_from,
		];
		$newsSelect = [
			"ID", "CREATED_BY", "DATE_CREATE",
		];

		$usersFilter = [
			"ID" => [],
			"ACTIVE" => "Y",
		];
		$usersOrder = [
			"sort" => "asc"
		];

		$newsList = CIBlockElement::GetList($newsSort, $newsFilter, false, false, $newsSelect);
		while ($obElement = $newsList->GetNextElement()) {
			$arItem = $obElement->GetFields();
			if (!isset($arResult["NEWS_BY_USER"][$arItem["CREATED_BY"]])) {
				$arResult["NEWS_BY_USER"][$arItem["CREATED_BY"]] = [
					"NAME" => "",
					"NEWS_AMOUNT" => 0,
				];
				$usersFilter["ID"][] = $arItem["CREATED_BY"];
			}
			$arResult["NEWS_BY_USER"][$arItem["CREATED_BY"]]["NEWS_AMOUNT"]++;
		}

		if (!empty($usersFilter["ID"])) {
			$rsUsers = CUser::GetList($usersOrder, $usersFilter);
			$arResult["USER_AMOUNT"] = $rsUsers->SelectedRowsCount();
			while ($obUser = $rsUsers->GetNext()) {
				$fullName = $obUser["NAME"] . " " . $obUser["LAST_NAME"];
				if (empty($fullName)) $fullName = $obUser["LOGIN"];
				$arResult["NEWS_BY_USER"][$obUser["ID"]]["NAME"] = $fullName;
			}
			uasort($arResult["NEWS_BY_USER"], function($a, $b) {
				if ($a["NEWS_AMOUNT"] == $b["NEWS_AMOUNT"]) return $a["NAME"] > $b["NAME"] ? 1 : 0;
				return ($a["NEWS_AMOUNT"] < $b["NEWS_AMOUNT"]) ? 1 : -1;
			});
			$arResult["NEWS_BY_USER"] = array_slice($arResult["NEWS_BY_USER"], 0, $arParams["USER_AMOUNT"], true);
		}
		$this->arResult = $arResult;
    }
}
?>