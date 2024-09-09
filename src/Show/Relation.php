<?php

namespace Dcat\Admin\Show;

use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Support\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Fluent;

class Relation extends Field
{
    /**
     * Relation name.
     *
     * @var string
     */
    protected $name;

    /**
     * Relation panel builder.
     *
     * @var \Closure
     */
    protected $builder;

    /**
     * Relation panel title.
     *
     * @var string
     */
    protected $title;

    /**
     * Parent model.
     *
     * @var Fluent
     */
    protected $model;

    /**
     * @var int
     */
    public $width = 12;

    // Show的Relation增加prepend和addend功能
    protected $prependHtml = '';
    // Show的Relation增加prepend和addend功能
    protected $appendHtml = '';

    /**
     * Relation constructor.
     *
     * @param  string  $name
     * @param  \Closure  $builder
     * @param  string  $title
     */
    public function __construct($name, $builder, $title = '')
    {
        $this->name = $name;
        $this->builder = $builder;
        $this->title = $this->formatLabel($title);
    }

    /**
     * Set parent model for relation.
     *
     * @param  Fluent|Model  $model
     * @return $this|Fluent
     */
    public function model($model = null)
    {
        if ($model === null) {
            return $this->model;
        }

        $this->model = $model;

        return $this;
    }

    /**
     * @param  int  $width
     * @return $this
     */
    public function width(int $width, int $_ = 2)
    {
        $this->width = $width;

        return $this;
    }

    protected function build()
    {
        $view = call_user_func($this->builder, $this->model);

        if ($view instanceof Show) {
            $view->panel()->title($this->title);

            return $view->render();
        }

        if ($view instanceof Grid) {
            return $view->setName($this->name)
                ->title($this->title)
                ->disableBatchDelete()
                ->render();
        }

        return Helper::render($view);
    }

    // Show的Relation增加prepend和addend功能
    public function prepend($html)
    {
        $this->prependHtml = $html;

        return $this;
    }

    // Show的Relation增加prepend和addend功能
    public function append($html)
    {
        $this->appendHtml = $html;

        return $this;
    }

    /**
     * Render this relation panel.
     *
     * @return string
     */
    public function render()
    {
        return <<<HTML
<div class="mt-1-5">{$this->prependHtml}{$this->build()}{$this->appendHtml}</div>
HTML;
    }
}
