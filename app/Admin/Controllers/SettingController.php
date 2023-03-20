<?php

namespace App\Admin\Controllers;

use App\Models\Setting;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SettingController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Setting';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Setting());

        $grid->column('name', __('Name'));
        $grid->column('group', __('Group'));
        $grid->column('type', __('Type'));
        $grid->column('value', __('value'));
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
        $show = new Show(Setting::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('value', __('Value'));
        $show->field('group', __('Group'));
        $show->field('type', __('Type'));
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
        $form = new Form(new Setting());

        $form->text('name', __('Name'));
        $form->text('group', __('Group'));
        $form->select('type', __('Type'))->options(['FILE' => 'Tipe Value File', 'STRING' => 'Tipe value string'])
        ->when('FILE', function (Form $form) {
            $form->file('value', __('File'));
        })
        ->when('STRING', function (Form $form) {
            $form->text('value', __('Value'));
        });

        return $form;
    }
}
