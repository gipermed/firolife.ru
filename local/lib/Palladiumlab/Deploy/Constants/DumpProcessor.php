<?php


namespace Palladiumlab\Deploy\Constants;


use Palladiumlab\Deploy\Constants\Dumper\Dumper;

class DumpProcessor
{
    protected string $content = '';
    /**
     * @var Dumper[]
     */
    protected array $dumpers;

    /**
     * DumpProcessor constructor.
     * @param Dumper[] $dumpers
     */
    public function __construct(array $dumpers)
    {
        $this->dumpers = array_filter($dumpers, static function ($dumper) {
            return $dumper instanceof Dumper;
        });
    }

    public function process(): DumpProcessor
    {
        $this->start();
        /** @var Dumper $dumper */
        foreach ($this->dumpers as $dumper) {
            $constants = $dumper->dump();

            if (count($constants) > 0) {
                $this->blockDescription($dumper->blockTitle());
            }

            foreach ($constants as $constant) {
                $this->itemDescription($dumper->itemTitle($constant));
                $this->define($constant);
            }
        }
        $this->end();

        return $this;
    }

    protected function start(): void
    {
        $this->content .= '<?php' . PHP_EOL . PHP_EOL;

        $this->content .= '/** @noinspection UnknownInspectionInspection */' . PHP_EOL;
        $this->content .= '/** @noinspection SpellCheckingInspection */' . PHP_EOL;
        $this->content .= '/** @noinspection PhpUnused */' . PHP_EOL;


        $this->content .= PHP_EOL
            . PHP_EOL . '/** '
            . PHP_EOL . " * Сгенерировано console deploy:constants"
            . PHP_EOL . ' * ВНИМАНИЕ!!! Данный файл генерируется. Все внесенные в этот файл изменения'
            . PHP_EOL . ' * могут быть удалены.'
            . PHP_EOL . ' */';
    }

    protected function blockDescription(string $blockTitle): void
    {
        $this->content .= PHP_EOL . PHP_EOL .
            PHP_EOL . '/** '
            . PHP_EOL . ' * ----------------------------------------'
            . PHP_EOL . " * {$blockTitle}"
            . PHP_EOL . ' * ----------------------------------------'
            . PHP_EOL . ' */';
    }

    protected function itemDescription(string $itemTitle): void
    {
        $this->content .= PHP_EOL . "   // {$itemTitle} ";
    }

    protected function define($constant): void
    {
        $this->content .= PHP_EOL . "   const {$constant['code']} = {$constant['id']};";
    }

    protected function end(): void
    {
        $this->content .= PHP_EOL;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function putContent(string $path): void
    {
        file_put_contents($path, $this->content);
    }
}