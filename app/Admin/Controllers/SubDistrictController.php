<?php

namespace App\Admin\Controllers;

use App\Models\District;
use App\Models\SubDistrict;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SubDistrictController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Kelurahan';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SubDistrict());

        $grid->column('name', __('Name'));
        $grid->column('district.name', __('Kecamatan'));
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
        $show = new Show(SubDistrict::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('district_id', __('District id'));
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
        $form = new Form(new SubDistrict());

        $form->text('name', __('Name'));
        $form->select('district_id', __('Kecamatan'))->options(District::get()->pluck('name', 'id'));
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
