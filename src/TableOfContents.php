<?php

namespace RuliLG\TableOfContents;

use Illuminate\Support\Str;

class TableOfContents
{
    private ?string $processedHtml;
    private ?array $items;

    public static function make(string $html): self
    {
        return new self($html);
    }

    public function __construct(
        private string $html,
        private array $headings = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
    )
    {
        // ...
    }

    public function render(string $view): \Illuminate\Contracts\View\View
    {
        return view($view, [
            'items' => $this->items(),
        ]);
    }

    /**
     * Returns the processed HTML
     * @return string
     */
    public function html(): string
    {
        return $this->processedHtml ?? '';
    }

    /**
     * Returns the original HTML
     * @return string
     */
    public function originalHtml(): string
    {
        return $this->html;
    }

    /**
     * Returns a list of each heading and its level
     * @return array
     */
    public function items(): array
    {
        return $this->items ?? [];
    }

    /**
     * Allows to change which headings are processed
     * @return self
     */
    public function only(array $hs): self
    {
        $this->headings = array_filter(
            array_map('strtolower', $hs),
            fn ($item) => Str::startsWith($item, 'h'),
        );
        sort($this->headings);

        return $this;
    }

    /**
     * Processes the HTML
     * @return self
     */
    public function process(): self
    {
        $processedHtml = $this->html;
        $toc = [];
        $processedHtml = preg_replace_callback("/<h([\d])([\w.:=\"\'_\-,;\?\s#\(\)\/]*)>([^<]+)<\/h/", function($matches) use(&$toc) {
            $depth = $this->depthFor('h' . $matches[1]);
            if ($depth === 0) {
                return $matches[0];
            }

            list($id, $isNewId) = $this->idFor($matches[2]);
            $toc[] = new TableOfContentsItem($id, $matches[3], (int) $matches[1]);
            if ($isNewId) {
                return '<h' . $matches[1] . $matches[2] . ' id="' . $id . '">' . $matches[3] . '</h';
            }

            return '<h' . $matches[1] . $matches[2] . '>' . $matches[3] . '</h';
        }, $processedHtml);

        $this->processedHtml = $processedHtml;
        $this->items = $toc;

        return $this;
    }

    private function depthFor(string $hTag): int
    {
        $depth = array_search($hTag, $this->headings);
        if ($depth === false) {
            return 0;
        }

        return $depth + 1;
    }

    private function idFor(string $attributes): array
    {
        // We need to check if $attributes contains an HTML id. If so, we return it
        // as is. If not, we generate a new one.
        $matches = [];
        if (preg_match('/id="([\w-]+)"/', $attributes, $matches)) {
            return [$matches[1], false];
        }

        return [Str::uuid()->toString(), true];
    }
}
