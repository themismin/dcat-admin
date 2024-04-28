<?php

namespace Dcat\Admin\Form\Field;

use Illuminate\Support\Arr;
use function intval;

class Head extends Html
{
    protected $width = [
        'label' => 0,
        'field' => 12,
    ];
    protected int $size = 4;

    public function __construct(protected string $title, array $arguments = [])
    {
        $size = intval(Arr::get($arguments, 0));
        $this->size = $size ?: $this->size;
        parent::__construct('', []);
    }

    public function width($field = 12, $label = 0): static
    {
        return parent::width($field, 0);
    }

    public function h(int $size): static
    {
        // $this->size = $size ?: $this->size;
        $this->size = $size > 0 ? $size : 0;
        return $this;

    }


    public function render()
    {
//         $this->html = <<<HTML
// <h{$this->size} class="mt-2 text-center mb-2 form-divider">{$this->title}</h{$this->size}>
// HTML;

        if ($this->size > 0) {
            $this->html = <<<HTML
<h{$this->size} class="mt-2 text-center mb-2 form-divider">{$this->title}</h{$this->size}>
HTML;
        } else {
            $this->html = <<<HTML
<div class="text-center">{$this->title}</div>
HTML;
        }

        return parent::render();
    }


}
