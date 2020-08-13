<?php

Breadcrumbs::register('admin.partnerpricings.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.partnerpricings.management'), route('admin.partnerpricings.index'));
});

Breadcrumbs::register('admin.partnerpricings.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.partnerpricings.index');
    $breadcrumbs->push(trans('menus.backend.partnerpricings.create'), route('admin.partnerpricings.create'));
});

Breadcrumbs::register('admin.partnerpricings.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.partnerpricings.index');
    $breadcrumbs->push(trans('menus.backend.partnerpricings.edit'), route('admin.partnerpricings.edit', $id));
});
