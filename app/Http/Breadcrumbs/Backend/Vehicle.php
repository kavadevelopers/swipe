<?php

Breadcrumbs::register('admin.vehicles.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.vehicles.management'), route('admin.vehicles.index'));
});

Breadcrumbs::register('admin.vehicles.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.vehicles.index');
    $breadcrumbs->push(trans('menus.backend.vehicles.create'), route('admin.vehicles.create'));
});

Breadcrumbs::register('admin.vehicles.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.vehicles.index');
    $breadcrumbs->push(trans('menus.backend.vehicles.edit'), route('admin.vehicles.edit', $id));
});
