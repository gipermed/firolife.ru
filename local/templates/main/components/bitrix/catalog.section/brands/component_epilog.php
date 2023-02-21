<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
if($arResult['IDS']):?>
    <?foreach($arResult['IDS'] as $id):?>
        <script>
            $(document).ready(function(){
                isFavoriteShow("<?=$id?>");
            })
        </script>
    <?endforeach;?>
<?endif;?>
