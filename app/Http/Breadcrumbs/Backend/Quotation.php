<?php

Breadcrumbs::register('admin.quotations.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.quotations.management'), route('admin.quotations.index'));
});

Breadcrumbs::register('admin.quotations.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.quotations.index');
    $breadcrumbs->push(trans('menus.backend.quotations.create'), route('admin.quotations.create'));
});

Breadcrumbs::register('admin.quotations.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.quotations.index');
    $breadcrumbs->push(trans('menus.backend.quotations.edit'), route('admin.quotations.edit', $id));
});
