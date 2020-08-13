<?php

Breadcrumbs::register('admin.plants.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.plants.management'), route('admin.plants.index'));
});

Breadcrumbs::register('admin.plants.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.plants.index');
    $breadcrumbs->push(trans('menus.backend.plants.create'), route('admin.plants.create'));
});

Breadcrumbs::register('admin.plants.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.plants.index');
    $breadcrumbs->push(trans('menus.backend.plants.edit'), route('admin.plants.edit', $id));
});
