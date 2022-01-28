<?php

use RuliLG\TableOfContents\TableOfContents;

$html1 = '<h1>Hello World</h1>
    <p>This is a paragraph</p>
    <h2>This is a subheading 2</h2>
    <p>This is another paragraph</p>
    <h3>This is a subheading 3</h3>
    <p>This is another paragraph</p>
    <h4>This is a subheading 4</h4>
    <h2>This is yet another a subheading 2</h2>
    <p>This is yet another another paragraph</p>
    <h3>This is a subheading 3</h3>
    <p>This is yet another another paragraph</p>
    <h4>This is yet another a subheading 4</h4>
    <h5>This is yet another a subheading 5</h5>
    <h6>This is yet another a subheading 6</h6>';

it('returns empty toc', function () {
    $html = '<p>Hello World</p>';
    $toc = TableOfContents::make($html)->process();
    expect($toc->html())->toBe($html);
    expect($toc->items())->toBeArray();
    expect($toc->items())->toBeEmpty();
});

it('returns right number of elements', function () use ($html1) {
    $toc = TableOfContents::make($html1)->process();
    expect($toc->items())->toBeArray();
    expect($toc->items())->toHaveCount(9);
});

it('returns right number of elements ignoring tags', function () use ($html1) {
    $toc = TableOfContents::make($html1)
        ->only(['h2', 'h3'])
        ->process();
    expect($toc->items())->toBeArray();
    expect($toc->items())->toHaveCount(4);
});

it('returns empty items if ignoring all tags', function () use ($html1) {
    $toc = TableOfContents::make($html1)
        ->only([])
        ->process();
    expect($toc->items())->toBeArray();
    expect($toc->items())->toHaveCount(0);
});

it('successfully ignores non-heading tags', function () use ($html1) {
    $toc = TableOfContents::make($html1)
        ->only(['p'])
        ->process();
    expect($toc->items())->toBeArray();
    expect($toc->items())->toHaveCount(0);
});

it('works with mixed case', function () use ($html1) {
    $toc = TableOfContents::make($html1)
        ->only(['H1', 'h2', 'H3', 'h4', 'H5', 'H6', 'p'])
        ->process();
    expect($toc->items())->toBeArray();
    expect($toc->items())->toHaveCount(9);
});

it('returns the right original html', function () use ($html1) {
    $toc = TableOfContents::make($html1)
        ->process();
    expect($toc->originalHtml())->toBe($html1);
});

it('adds the right ids to the HTML', function () use ($html1) {
    $toc = TableOfContents::make($html1)
        ->process();
    $processedHtml = $toc->html();
    foreach ($toc->items() as $item) {
        expect($processedHtml)->toContain('id="' . $item->id() . '"');
    }
});

it('keeps attributes on the processed HTML', function () {
    $html = '<h1 id="hello-world" class="hello-world" style="color: red;">Hello World</h1>
    <h2 id="hello-world-2" class="hello-world" style="color: red;">Hello World 2</h2>';
    $toc = TableOfContents::make($html)->process();
    expect($toc->html())->toContain($html);
    expect($toc->items())->toHaveCount(2);
});

it('returns the right anchor', function () {
    $html = '<h1>Hello World</h1>
    <h2>Hello World 2</h2>';
    $toc = TableOfContents::make($html)->process();
    $items = $toc->items();
    expect($items)->toHaveCount(2);
    expect($items[0]->anchor())->toBe('Hello World');
    expect($items[1]->anchor())->toBe('Hello World 2');
});

it('returns the right depth', function () {
    $html = '<h1>Hello World</h1>
    <h2>Hello World 2</h2>';
    $toc = TableOfContents::make($html)->process();
    $items = $toc->items();
    expect($items)->toHaveCount(2);
    expect($items[0]->depth())->toBe(1);
    expect($items[1]->depth())->toBe(2);
});
