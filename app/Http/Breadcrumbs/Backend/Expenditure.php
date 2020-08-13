<?php

Breadcrumbs::register('admin.expenditures.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.expenditures.management'), route('admin.expenditures.index'));
});

Breadcrumbs::register('admin.expenditures.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.expenditures.index');
    $breadcrumbs->push(trans('menus.backend.expenditures.create'), route('admin.expenditures.create'));
});

Breadcrumbs::register('admin.expenditures.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.expenditures.index');
    $breadcrumbs->push(trans('menus.backend.expenditures.edit'), route('admin.expenditures.edit', $id));
});
