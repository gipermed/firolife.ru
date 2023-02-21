<?php check_prolog();

?>

<div id="modal-delprof" class="modal modal-thanks">
    <div class="modal-body">
        <a href="#" class="modal-close-btn" aria-label="Закрыть">
            <svg width="24" height="24"><use xlink:href="#icon-close"/></svg>
        </a>
        <div class="modal-content" style="border: 0px solid rgba(0,0,0,0.2)">
			<div class="modal-title" style="font-size: 21px; font-weight: 400; color: #4365AF; text-align: center; margin-bottom: 10px">Вы действительно хотите удалить свой профиль?</div>
<div class="modal-thanks-foot-desc" style="margin-bottom: 0px; text-align: center;">
                    После удаления вы не сможете восстановить свой профиль. Ваша история заказов будет очищена, информация удалена.
                </div>
            <div class="modal-thanks-foot" style="padding-top: 25px; text-align: center;">
<?$APPLICATION->IncludeComponent(
	"palladiumlab:asd.selfdelete",
	"",
Array()
);?>
            </div>
        </div>
    </div>
</div>
