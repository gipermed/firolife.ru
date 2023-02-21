<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
if (!empty($arResult["ITEMS"])) { ?>
    <div class="section articles-section hidden-mobile">
        <div class="container">
            <div class="section-title">Статьи</div>
            <div class="home-main-articles-row main-articles-row flex-row">
                <?php foreach ($arResult["ITEMS"] as $article) {
                    $this->addEditAction($article['ID'], $article['EDIT_LINK'], CIBlock::getArrayById($article["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->addDeleteAction($article['ID'], $article['DELETE_LINK'], CIBlock::getArrayById($article["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                    [$name, $desc, $link, $views, $picture] = [
                        $article['NAME'],
                        $article['PREVIEW_TEXT'],

                        $article['DETAIL_PAGE_URL'],

                        $article['PROPERTIES']['VIEW_COUNTER']['VALUE'],

                        $article['PREVIEW_PICTURE']['SRC'],
                    ];
                    ?>
                    <div class="main-articles-col flex-row-item" id="<?= $this->getEditAreaId($article['ID']) ?>">
                        <div class="main-article-item">
                            <a href="<?= $link ?>" class="item-link" aria-label="Читать статью"></a>
                            <div class="main-article-item-body">
                                <div class="main-article-item-title"><?= $name ?></div>
                                <div class="main-article-item-desc"><?= $desc ?></div>
                                <div class="main-article-item-btn">Читать&nbsp;&#62;</div>
                                <div class="main-article-item-views">
                                    <svg width="20" height="20">
                                        <use xlink:href="#icon-eye"/>
                                    </svg>
                                    <span class="js-view-counter" data-item-id="<?= $article['ID'] ?>">
                                        <?= $views ?>
                                    </span>
                                </div>
                            </div>
                            <div class="main-article-item-img cover-img">
                                <img src="<?= $picture ?>" srcset="<?= $picture ?> 2x" alt="">
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="read-more-btn-wrapp">
                <a href="/articles/" class="btn read-more-btn">Все статьи</a>
            </div>
        </div>
    </div>
<?php } ?>
