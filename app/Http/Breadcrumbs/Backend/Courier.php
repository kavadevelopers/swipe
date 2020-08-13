<?php

Breadcrumbs::register('admin.couriers.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.couriers.management'), route('admin.couriers.index'));
});

Breadcrumbs::register('admin.couriers.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.couriers.index');
    $breadcrumbs->push(trans('menus.backend.couriers.create'), route('admin.couriers.create'));
});

Breadcrumbs::register('admin.couriers.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.couriers.index');
    $breadcrumbs->push(trans('menus.backend.couriers.edit'), route('admin.couriers.edit', $id));
});
