<?php

namespace App\Admin\Controllers;

use App\Models\Revision;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class RevisionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Revision';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Revision());

        $grid->column('id', __('Id'));
        $grid->column('user_information_id', __('User information id'));
        $grid->column('from', __('From'));
        $grid->column('to', __('To'));
        $grid->column('from_name', __('From name'));
        $grid->column('to_name', __('To name'));
        $grid->column('note', __('Note'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Revision::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_information_id', __('User information id'));
        $show->field('from', __('From'));
        $show->field('to', __('To'));
        $show->field('from_name', __('From name'));
        $show->field('to_name', __('To name'));
        $show->field('note', __('Note'));
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
        $form = new Form(new Revision());

        $form->number('user_information_id', __('User information id'));
        $form->text('from', __('From'));
        $form->text('to', __('To'));
        $form->text('from_name', __('From name'));
        $form->text('to_name', __('To name'));
        $form->textarea('note', __('Note'));

        return $form;
    }
}
