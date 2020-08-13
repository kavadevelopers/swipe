<?php

Breadcrumbs::register('admin.liabilities.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.liabilities.management'), route('admin.liabilities.index'));
});

Breadcrumbs::register('admin.liabilities.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.liabilities.index');
    $breadcrumbs->push(trans('menus.backend.liabilities.create'), route('admin.liabilities.create'));
});

Breadcrumbs::register('admin.liabilities.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.liabilities.index');
    $breadcrumbs->push(trans('menus.backend.liabilities.edit'), route('admin.liabilities.edit', $id));
});
