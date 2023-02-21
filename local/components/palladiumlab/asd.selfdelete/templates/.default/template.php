<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();?><?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();?>


	<form method="post" action="<?= POST_FORM_ACTION_URI?>">
		<?= bitrix_sessid_post()?>
		<input type="hidden" name="action" value="delete" />
		<input type="submit" value="<?= GetMessage('ASD_TPL_BUTTON_DEL')?>" class="asd_selfdelete_button btn  btn-border-blue" />
		<a href="#" class="btn btn-blue modal-close-link" style="margin-left: 30px;">Нет, я не хочу удалять</a>
	</form>
