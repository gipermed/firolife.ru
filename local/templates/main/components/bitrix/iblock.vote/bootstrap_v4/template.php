<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

CJSCore::Init(array("ajax"));

//Let's determine what value to display: rating or average ?
if ($arParams['DISPLAY_AS_RATING'] === 'vote_avg')
{
	if (
		!empty($arResult['PROPERTIES']['vote_count']['VALUE'])
		&& is_numeric($arResult['PROPERTIES']['vote_sum']['VALUE'])
		&& is_numeric($arResult['PROPERTIES']['vote_count']['VALUE'])
	)
	{
		$DISPLAY_VALUE = round($arResult['PROPERTIES']['vote_sum']['VALUE'] / $arResult['PROPERTIES']['vote_count']['VALUE'], 2);
	}
	else
	{
		$DISPLAY_VALUE = 0;
	}
}
else
{
	$DISPLAY_VALUE = $arResult["PROPERTIES"]["rating"]["VALUE"];
}
$voteContainerId = 'vote_'.$arResult["ID"];
?>
<div class="hidden-mobile">
    <div class="bx-rating text-primary" id="<?echo $voteContainerId?>">
        <?
        $onclick = "JCFlatVote.do_vote(this, '".$voteContainerId."', ".$arResult["AJAX_PARAMS"].")";
        foreach ($arResult["VOTE_NAMES"] as $i => $name)
        {
            if ($DISPLAY_VALUE && round($DISPLAY_VALUE) > $i)
                $ratingIcon='<svg
       width="20"
       height="20"
       fill="none"
       version="1.1"
       id="svg375"
       xmlns="http://www.w3.org/2000/svg"
       xmlns:svg="http://www.w3.org/2000/svg">
      <g
         id="g348"
         transform="translate(-4)">
        <path
           d="M 8.515,19.304 C 8.033,19.551 7.485,19.118 7.583,18.564 L 8.62,12.65 4.216,8.456 C 3.805,8.064 4.019,7.346 4.57,7.269 l 6.123,-0.87 2.73,-5.409 a 0.642,0.642 0 0 1 1.158,0 l 2.73,5.409 6.123,0.87 c 0.551,0.077 0.765,0.795 0.354,1.187 l -4.404,4.195 1.037,5.913 c 0.098,0.554 -0.45,0.987 -0.932,0.74 L 14,16.484 8.514,19.304 Z"
           fill="#ffb21e"
           id="path346" />
      </g>
    </svg>';
            else
                $ratingIcon='<svg width="20" height="20" fill="none" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg">
                              <path
                                 fill-rule="evenodd" clip-rule="evenodd" d="m 3.7200124,18.563 c -0.098,0.555 0.45,0.988 0.932,0.74 l 5.4869996,-2.82 5.487,2.82 c 0.482,0.248 1.03,-0.186 0.932,-0.74 l -1.037,-5.912 4.404,-4.195 c 0.41,-0.392 0.197,-1.11 -0.354,-1.187 l -6.123,-0.87 -2.73,-5.409 C 10.485528,0.50240498 9.7914964,0.50240498 9.5590124,0.99 l -2.73,5.41 -6.12200003,0.87 c -0.551,0.077 -0.765,0.795 -0.354,1.187 l 4.40400003,4.195 -1.037,5.913 v -0.003 z m 6.13,-3.46 -4.607,2.368 0.868,-4.946 c 0.04098,-0.231158 -0.035454,-0.467581 -0.204,-0.631 l -3.632,-3.464 5.065,-0.72 c 0.212442,-0.032491 0.395497,-0.1669801 0.49,-0.36 l 2.3099996,-4.572 2.307,4.572 c 0.0947,0.1932824 0.278186,0.3278152 0.491,0.36 l 5.065,0.719 -3.632,3.463 c -0.169335,0.163343 -0.245879,0.40048 -0.204,0.632 l 0.867,4.946 -4.607,-2.367 c -0.18076,-0.09291 -0.39524,-0.09291 -0.5759996,0 z"
                                 fill="#ffb21e"
                                 id="path17"
                                 sodipodi:nodetypes="ccccccccccccccccccccccccccccccccccc" />
                            </svg>';
            $itemContainerId = $voteContainerId.'_'.$i;
            ?><span
                class="bx-rating-icon-container"
                id="<?echo $itemContainerId?>"
                title="<?echo $name?>"
                <?if (!$arResult["VOTED"] && $arParams["READ_ONLY"]!=="Y"):?>
                    onmouseover="JCFlatVote.trace_vote(this, true);"
                    onmouseout="JCFlatVote.trace_vote(this, false)"
                    onclick="<?echo htmlspecialcharsbx($onclick);?>"
                <?endif;?>
            ><?echo $ratingIcon?></span><?
        }

    ?>
    </div>
</div>
    <?if ($arParams["SHOW_RATING"] == "Y"):?>
    <div class="product-reviews-value"><?=$DISPLAY_VALUE?></div>
<?endif;