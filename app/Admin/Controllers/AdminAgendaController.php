<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use \App\Models\AdminAgenda;
use Illuminate\Support\Facades\Hash;

class AdminAgendaController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'AdminAgenda';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AdminAgenda());

        $grid->column('id', __('Id'));
        $grid->column('username', __('Username'));
        $grid->column('name', __('Name'));
        $grid->column('phone', __('Phone'));
        $grid->column('is_active', __('Is active'));
        $grid->column('avatar', __('Avatar'));

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
        $show = new Show(AdminAgenda::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('username', __('Username'));
        $show->field('name', __('Name'));
        $show->field('phone', __('Phone'));
        $show->field('password', __('Password'));
        $show->field('is_active', __('Is active'));
        $show->field('avatar', __('Avatar'));
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
        $form = new Form(new AdminAgenda());

        $form->text('username', __('Username'));
        $form->text('name', __('Name'));
        $form->mobile('phone', __('Phone'));
        $form->password('password', __('Password'));
        // callback before save
        $form->saving(function (Form $form) {
            $form->password = Hash::make($form->password);
        });
        $form->switch('is_active', __('Is active'))->default(1);
        $form->image('avatar', __('Avatar'));

        return $form;
    }
}
