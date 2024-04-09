<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

class ChecksAjaxController extends \Bitrix\Main\Engine\Controller
{
	public function getCheckResultAction($person)
	{
		return [
			"check_result" => "Что-то произошло",
			"button_text" => "AJAX",
		];
	}
}