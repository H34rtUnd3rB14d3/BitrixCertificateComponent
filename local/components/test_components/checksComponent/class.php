<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

class MyChecksList extends CBitrixComponent
{
	private $IBLOCK_ID = 12;

	public function executeComponent() {
		try {
			$this->checkModules();
			$this->getResult();
			$this->includeComponentTemplate();
		} catch (SystemException $e) {
			ShowError($e->getMessage());
		}
	}

	protected function checkModules() {
		if (!Loader::includeModule('iblock'))
			throw new SystemException(Loc::getMessage('CPS_MODULE_NOT_INSTALLED', array('#NAME#' => 'iblock')));
	}

	protected function getResult() {
		if ($this->errors) {
			throw new SystemException(current($this->errors));
		}

		$arResult = [
			"CHECK_AMOUNT" => 0,
		];
		$checksSort = [
			"ID" => "ASC",
		];

		$checksFilter = [
			"IBLOCK_ID" => $this->IBLOCK_ID,
			"ACTIVE" => "Y",
		];
		$checksSelect = [
			"ID", "IBLOCK_ID", "NAME", "PROPERTY_*"
		];

		$usersFilter = [
			"ID" => [],
			"ACTIVE" => "Y",
		];
		$usersOrder = [
			"sort" => "asc"
		];
		$checksList = CIBlockElement::GetList($checksSort, $checksFilter, false, false, $checksSelect);
		while ($obElement = $checksList->GetNextElement()) {
			$arItem = $obElement->GetFields();
			$arProps = $obElement->GetProperties();
			$arResult["CHECKS"][$arItem["ID"]] = [
				"Название операции" => $arItem["NAME"],
			];
			foreach ($arProps as $prop_id => $prop) {
				switch ($prop["USER_TYPE"]) {
					case 'DateTime':
						$prop["VALUE"] = date("d.m.Y H:i:s", strtotime($prop["VALUE"]));
						break;
					case "UserID":
						if ($prop["VALUE"]) {
							$usersFilter["ID"][] = $prop["VALUE"];
						}
						break;
				}
				$arResult["CHECKS"][$arItem["ID"]][$prop["NAME"]] = $prop["VALUE"];
			}
			$arResult["CHECK_AMOUNT"]++;
		}
		global $USER;
		$usersFilter["ID"][] = $USER->GetID();

		$usersFilter["ID"] = implode(" | ", $usersFilter["ID"]);

		if (!empty($usersFilter["ID"])) {
			$rsUsers = CUser::GetList([], $usersOrder, $usersFilter);
			while ($obUser = $rsUsers->GetNext()) {
				$fullName = $obUser["NAME"] . " " . $obUser["LAST_NAME"];
				if (empty($fullName)) $fullName = $obUser["LOGIN"];
				$arResult["USERS"][$obUser["ID"]] = $fullName;
			}
		}
		$arResult["TABLE_HEADERS"] = array_keys(array_values($arResult["CHECKS"])[0]);

		$this->arResult = $arResult;
	}
}

?>