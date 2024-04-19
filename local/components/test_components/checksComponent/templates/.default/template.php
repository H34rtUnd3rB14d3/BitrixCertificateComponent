<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
\Bitrix\Main\UI\Extension::load("ui.alerts");
CJSCore::Init(['popup', 'ajax', 'jquery']);
?>
<div class="test-css">
	<? if ($arResult["CHECK_AMOUNT"] || true): ?>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">ID</th>
				<? foreach ($arResult["TABLE_HEADERS"] as $unsed => $value): ?>
                    <th scope="col"><?= $value ?></th>
				<? endforeach; ?>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
			<? foreach ($arResult["CHECKS"] as $id => $check): ?>
                <tr>
                    <td><?= $id ?></td>
					<? foreach ($check as $prop_name => $value): ?>
                        <td>
							<?
							if ($prop_name == "Кто запускал") {
								$value = $arResult["USERS"][$value];
							}
							?>
							<?= $value ?>
                        </td>
					<? endforeach; ?>
                    <td>
                        <button onclick="start_check(<?= $id ?>)" data-check-id="<?= $id ?>">Запустить проверку</button>
                    </td>
                    <td>
                        <button>Показать результат</button>
                    </td>
                </tr>
			<? endforeach; ?>
            </tbody>
        </table>
	<? else: ?>
        <div class="ui-alert ui-alert-text-center">
            <span class="ui-alert-message">Инфоблок с проверками пуст.</span>
        </div>
	<? endif; ?>
</div>
<script>
    function start_check(check_id) {
        BX.ajax.runComponentAction('<?= $this->getComponent()->getName() ?>', 'getCheckResult', {
            mode: 'ajax',
            data: {
                person: {
                    test: check_id
                }
            }
        }).then(function (response) {
            console.log(response);
            $(`button[data-check-id='${check_id}']`).text(response.data.button_text);
            console.log($(`button[data-check-id='${check_id}']`).parent().next().children());
            $(`button[data-check-id='${check_id}']`).parent().next().children().attr("data-result-mess", response.data.check_result);
        }, function (response) {
            console.log(response);
        });
    }
</script>