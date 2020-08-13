<?php

Breadcrumbs::register('admin.estimates.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.estimates.management'), route('admin.estimates.index'));
});

Breadcrumbs::register('admin.estimates.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.estimates.index');
    $breadcrumbs->push(trans('menus.backend.estimates.create'), route('admin.estimates.create'));
});

Breadcrumbs::register('admin.estimates.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.estimates.index');
    $breadcrumbs->push(trans('menus.backend.estimates.edit'), route('admin.estimates.edit', $id));
});
