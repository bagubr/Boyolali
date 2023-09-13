<?php

namespace App\Admin\Controllers;

use App\Models\MenuApplication;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Database\Eloquent\Collection;

class MenuApplicationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'MenuApplication';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MenuApplication());
        $grid->column('title', __('Title'));
        $grid->column('url', __('Url'));
        $grid->column('slug', __('Category'));
        $grid->column('file', __('File'))->image();
        $grid->disableFilter();
        $grid->disableBatchActions();
        $grid->disablePagination();
        $grid->disableExport();
        $grid->disableColumnSelector();
        // $grid->disableActions();
        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(MenuApplication::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('file', __('File'));
        $show->field('title', __('Title'));
        $show->field('url', __('Url'));
        $show->field('slug', __('Slug'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new MenuApplication());

        $form->file('file', __('File'));
        $form->text('title', __('Title'));
        $form->url('url', __('Url'));
        $form->select('slug', __('Category'))->options(['admin' => 'admin', 'users' => 'users']);
        $form->disableCreatingCheck();
        $form->disableEditingCheck();
        $form->disableViewCheck();
        $form->disableReset();
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
            $tools->disableList();
        });
        return $form;
    }
}
