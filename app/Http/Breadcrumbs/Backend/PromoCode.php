<?php

Breadcrumbs::register('admin.promocodes.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.promocodes.management'), route('admin.promocodes.index'));
});

Breadcrumbs::register('admin.promocodes.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.promocodes.index');
    $breadcrumbs->push(trans('menus.backend.promocodes.create'), route('admin.promocodes.create'));
});

Breadcrumbs::register('admin.promocodes.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.promocodes.index');
    $breadcrumbs->push(trans('menus.backend.promocodes.edit'), route('admin.promocodes.edit', $id));
});
