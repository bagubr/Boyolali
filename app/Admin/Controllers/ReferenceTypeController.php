<?php

namespace App\Admin\Controllers;

use App\Models\ReferenceType;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ReferenceTypeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'ReferenceType';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ReferenceType());

        $grid->column('file_type', __('File type'));
        $grid->column('note', __('Note'));
        $grid->column('content', __('Content'));
        $grid->column('max_upload', __('Max Upload'));
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
        $show = new Show(ReferenceType::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('file_type', __('File type'));
        $show->field('note', __('Note'));
        $show->field('content', __('Content'));
        $show->field('max_upload', __('Max Upload'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ReferenceType());

        $form->text('file_type', __('File type'));
        $form->text('note', __('Note'));
        $form->textarea('content', __('Content'));
        $form->number('max_upload', __('Max Upload (mb)'));
        $form->disableCreatingCheck();
        $form->disableEditingCheck();
        $form->disableViewCheck();
        $form->disableReset();
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });
        return $form;
    }
}
