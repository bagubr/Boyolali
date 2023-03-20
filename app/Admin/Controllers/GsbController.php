<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use \App\Models\Gsb;

class GsbController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Gsb';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Gsb());

        $grid->column('id', __('Id'));
        $grid->column('jap', __('Jap'));
        $grid->column('jkp', __('Jkp'));
        $grid->column('jks', __('Jks'));
        $grid->column('jlp', __('Jlp'));
        $grid->column('jls', __('Jls'));
        $grid->column('jling', __('Jling'));
        $grid->column('krk_id', __('Krk id'));
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
        $show = new Show(Gsb::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('jap', __('Jap'));
        $show->field('jkp', __('Jkp'));
        $show->field('jks', __('Jks'));
        $show->field('jlp', __('Jlp'));
        $show->field('jls', __('Jls'));
        $show->field('jling', __('Jling'));
        $show->field('krk_id', __('Krk id'));
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
        $form = new Form(new Gsb());

        $form->text('jap', __('Jap'));
        $form->text('jkp', __('Jkp'));
        $form->text('jks', __('Jks'));
        $form->text('jlp', __('Jlp'));
        $form->text('jls', __('Jls'));
        $form->text('jling', __('Jling'));
        $form->number('krk_id', __('Krk id'));

        return $form;
    }
}
