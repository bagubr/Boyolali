<?php

namespace App\Admin\Controllers;

use App\Models\AdminSurvei;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Hash;

class AdminSurveiController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'AdminSurvei';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AdminSurvei());

        $grid->column('id', __('Id'));
        $grid->column('username', __('Username'));
        $grid->column('name', __('Name'));
        $grid->column('phone', __('Phone'));
        $grid->column('password', __('Password'));
        $grid->column('is_active', __('Is active'));
        $grid->column('avatar', __('Avatar'));
        $grid->column('remember_token', __('Remember token'));
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
        $show = new Show(AdminSurvei::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('username', __('Username'));
        $show->field('name', __('Name'));
        $show->field('phone', __('Phone'));
        $show->field('password', __('Password'));
        $show->field('is_active', __('Is active'));
        $show->field('avatar', __('Avatar'));
        $show->field('remember_token', __('Remember token'));
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
        $form = new Form(new AdminSurvei());

        $form->text('username', __('Username'));
        $form->text('name', __('Name'));
        $form->mobile('phone', __('Phone'));
        $form->password('password', __('Password'));
        $form->saving(function (Form $form) {
            $form->password = Hash::make($form->password);
        });
        $form->switch('is_active', __('Is active'))->default(1);
        $form->image('avatar', __('Avatar'));
        $form->text('remember_token', __('Remember token'));

        return $form;
    }
}
