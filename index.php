<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Демонстрационная версия продукта «1С-Битрикс: Управление сайтом»");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("Статьи");
?><!-- --> <?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"articles",
	Array(
		"ACTIVE_DATE_FORMAT" => "M j, Y, H:m",
		"ADD_SECTIONS_CHAIN" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"DETAIL_URL" => "/content/articles/#ELEMENT_ID#/",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PANEL" => "N",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => "",
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "2",
		"IBLOCK_TYPE" => "articles",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"NEWS_COUNT" => "5",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_TITLE" => "Статьи",
		"PARENT_SECTION" => "",
		"PREVIEW_TRUNCATE_LEN" => "0",
		"PROPERTY_CODE" => array(0=>"FORUM_MESSAGE_CNT",1=>"rating",),
		"SET_TITLE" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC"
	),
false,
Array(
	'ACTIVE_COMPONENT' => 'Y'
)
);?> <!-- --> <!-- -->
<h1>Новости</h1>
					<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"CACHE_FILTER" => "N",
		"CACHE_TIME" => "3600",
		"DETAIL_URL" => "/content/news/#SECTION_ID#/#ELEMENT_ID#/",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PANEL" => "N",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => Array("",""),
		"FILTER_NAME" => "",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "news",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"NEWS_COUNT" => "5",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_TITLE" => "Новости",
		"PREVIEW_TRUNCATE_LEN" => "0",
		"PROPERTY_CODE" => Array("",""),
		"SET_TITLE" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC"
	)
);?>
				<!-- -->
<!-- --><!-- --><!-- --><?$APPLICATION->IncludeComponent(
	"test_components:newsByUsers", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"USER_AMOUNT" => "10"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>