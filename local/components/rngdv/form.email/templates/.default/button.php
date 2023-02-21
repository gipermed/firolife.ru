<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<? /*?>
<button ">
	Оформить без регистрации
</button>
<?/**/ ?>

<div class="mb-10">
    <div class="ns">
        <div class="feedback-block">
            <div class="feedback-block__header">
                Что улучшить?
                <svg class="icon-svg -dialog">
                    <svg id="icon-dialog" viewBox="0 0 32 26.7">
                        <path d="M32,1.6V13.4A1.58,1.58,0,0,1,30.4,15H29.3v3a.55.55,0,0,1-.4.6h-.2a.76.76,0,0,1-.5-.2L25.3,15V6.8A3,3,0,0,0,22.2,4H10.7V1.6A1.58,1.58,0,0,1,12.3,0H30.4A1.58,1.58,0,0,1,32,1.6ZM24,7.1V21a1.75,1.75,0,0,1-1.7,1.7H7.3L3.9,26.5a.76.76,0,0,1-.5.2H3.2a.63.63,0,0,1-.5-.6V22.7h-1A1.75,1.75,0,0,1,0,21V7.1A1.75,1.75,0,0,1,1.7,5.4H22.3A1.75,1.75,0,0,1,24,7.1ZM8,14a2.1,2.1,0,1,0-4.2,0A2.06,2.06,0,0,0,6,16,2,2,0,0,0,8,14Zm6.1,0A2.11,2.11,0,0,0,12,11.9,2.05,2.05,0,0,0,9.9,14,2,2,0,0,0,12,16,2.09,2.09,0,0,0,14.1,14Zm6,0A2.11,2.11,0,0,0,18,11.9,2,2,0,0,0,16,14a1.94,1.94,0,0,0,2,2A2.09,2.09,0,0,0,20.1,14Z"></path>
                    </svg>
                </svg>
            </div>

            <div class="feedback-block__body">
                <p>Поделитесь своими идеями по улучшению нашей работы.</p>

                <button class="v-btn v-btn--red v-btn--sm v-btn--w100"
                        data-modal="<?= $templateFolder ?>/ajax.php?component=<?= $arResult["COMPONENT"] ?>">
                    Напишите нам
                    <span class="v-btn__v-icon v-icon v-icon--rarr-white"></span>
                </button>
            </div>
        </div>
    </div>
</div>
