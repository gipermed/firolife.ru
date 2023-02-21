<?php check_prolog();

?>

<div id="modal-password-change" class="modal modal-password-change">
    <div class="modal-body">
        <a href="#" class="modal-close-btn" aria-label="Закрыть">
            <svg width="24" height="24"><use xlink:href="#icon-close"/></svg>
        </a>
        <div class="modal-head">
            <div class="modal-title">Восстановление пароля</div>
        </div>
        <div class="modal-content">
            <div class="modal-desc">Введите новый пароль для доступа в личный кабинет</div>
            <form action="?" class="password-change-form form form-ajax" data-modal-sent="#modal-password-change-sent">
                <label class="form-block form-block-password">
                    <span class="form-block-title">Новый пароль</span>
                    <span class="input-wrapp">
							<input type="password" class="input" pattern=".{8,}" required>
							<a href="#" class="password-input-type-toggle">
								<svg width="18" height="18"><use xlink:href="#icon-eye-open"/></svg>
								<svg width="18" height="18"><use xlink:href="#icon-eye-close"/></svg>
							</a>
						</span>
                    <span class="form-block-desc">Пароль должен быть не меньше 8 символов</span>
                </label>
                <label class="form-block form-block-password">
                    <span class="form-block-title">Новый пароль ещё раз</span>
                    <span class="input-wrapp">
							<input type="password" class="input" pattern=".{8,}" required>
							<a href="#" class="password-input-type-toggle">
								<svg width="18" height="18"><use xlink:href="#icon-eye-open"/></svg>
								<svg width="18" height="18"><use xlink:href="#icon-eye-close"/></svg>
							</a>
						</span>
                </label>
                <button type="submit" class="btn submit btn-full">Сохранить изменения</button>
            </form>
        </div>
    </div>
</div>
