<?php

namespace App\Admin\Controllers;

use App\Models\InterrogationReport;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class InterrogationReportController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'InterrogationReport';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new InterrogationReport());

        $grid->column('id', __('Id'));
        $grid->column('user_information_id', __('User information id'));
        $grid->column('building_condition', __('Building condition'));
        $grid->column('street_name', __('Street name'));
        $grid->column('allocation', __('Allocation'));
        $grid->column('note', __('Note'));
        $grid->column('employee', __('Employee'));
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
        $show = new Show(InterrogationReport::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_information_id', __('User information id'));
        $show->field('building_condition', __('Building condition'));
        $show->field('street_name', __('Street name'));
        $show->field('allocation', __('Allocation'));
        $show->field('note', __('Note'));
        $show->field('employee', __('Employee'));
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
        $form = new Form(new InterrogationReport());

        $form->number('user_information_id', __('User information id'));
        $form->text('building_condition', __('Building condition'));
        $form->text('street_name', __('Street name'));
        $form->text('allocation', __('Allocation'));
        $form->textarea('note', __('Note'));
        $form->text('employee', __('Employee'));

        return $form;
    }
}
