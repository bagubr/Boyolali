<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use \App\Models\Krk;

class KrkController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Krk';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Krk());

        $grid->column('id', __('Id'));
        $grid->column('uuid', __('Uuid'));
        $grid->column('kbg', __('Kbg'));
        $grid->column('kdb', __('Kdb'));
        $grid->column('klb', __('Klb'));
        $grid->column('kdh', __('Kdh'));
        $grid->column('psu', __('Psu'));
        $grid->column('jaringan_utilitas', __('Jaringan utilitas'));
        $grid->column('prasarana_jalan', __('Prasarana jalan'));
        $grid->column('sungai_bertanggul', __('Sungai bertanggul'));
        $grid->column('sungai_tidak_bertanggul', __('Sungai tidak bertanggul'));
        $grid->column('mata_air', __('Mata air'));
        $grid->column('waduk', __('Waduk'));
        $grid->column('tol', __('Tol'));
        $grid->column('ktb', __('Ktb'));
        $grid->column('building_function_id', __('Building function id'));
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
        $show = new Show(Krk::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('uuid', __('Uuid'));
        $show->field('kbg', __('Kbg'));
        $show->field('kdb', __('Kdb'));
        $show->field('klb', __('Klb'));
        $show->field('kdh', __('Kdh'));
        $show->field('psu', __('Psu'));
        $show->field('jaringan_utilitas', __('Jaringan utilitas'));
        $show->field('prasarana_jalan', __('Prasarana jalan'));
        $show->field('sungai_bertanggul', __('Sungai bertanggul'));
        $show->field('sungai_tidak_bertanggul', __('Sungai tidak bertanggul'));
        $show->field('mata_air', __('Mata air'));
        $show->field('waduk', __('Waduk'));
        $show->field('tol', __('Tol'));
        $show->field('ktb', __('Ktb'));
        $show->field('building_function_id', __('Building function id'));
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
        $form = new Form(new Krk());

        $form->text('uuid', __('Uuid'));
        $form->text('kbg', __('Kbg'));
        $form->text('kdb', __('Kdb'));
        $form->text('klb', __('Klb'));
        $form->text('kdh', __('Kdh'));
        $form->text('psu', __('Psu'));
        $form->text('jaringan_utilitas', __('Jaringan utilitas'));
        $form->text('prasarana_jalan', __('Prasarana jalan'));
        $form->text('sungai_bertanggul', __('Sungai bertanggul'));
        $form->text('sungai_tidak_bertanggul', __('Sungai tidak bertanggul'));
        $form->text('mata_air', __('Mata air'));
        $form->text('waduk', __('Waduk'));
        $form->text('tol', __('Tol'));
        $form->text('ktb', __('Ktb'));
        $form->number('building_function_id', __('Building function id'));

        return $form;
    }
}
