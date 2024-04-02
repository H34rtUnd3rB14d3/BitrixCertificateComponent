<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
\Bitrix\Main\UI\Extension::load("ui.alerts");
?>
<div class="test-css">
	<?if ($arResult["USER_AMOUNT"]):?>
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Пользователь</th>
				<th scope="col">Количество новостей</th>
			</tr>
		</thead>
		<tbody>
		<?foreach($arResult["NEWS_BY_USER"] as $key => $item):?>
		<tr>
			<td><?=$item["NAME"]?></td>
			<td><?=$item["NEWS_AMOUNT"]?></td>
		</tr>
		<?endforeach;?>
		</tbody>
	</table>
	<?else:?>
	<div class="ui-alert ui-alert-text-center">
		<span class="ui-alert-message">Пользователи в этом месяце еще не создавали новостей. test</span>
	</div>
	<?endif;?>
</div>