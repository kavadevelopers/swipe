<?php

Breadcrumbs::register('admin.revenues.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.revenues.management'), route('admin.revenues.index'));
});

Breadcrumbs::register('admin.revenues.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.revenues.index');
    $breadcrumbs->push(trans('menus.backend.revenues.create'), route('admin.revenues.create'));
});

Breadcrumbs::register('admin.revenues.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.revenues.index');
    $breadcrumbs->push(trans('menus.backend.revenues.edit'), route('admin.revenues.edit', $id));
});
