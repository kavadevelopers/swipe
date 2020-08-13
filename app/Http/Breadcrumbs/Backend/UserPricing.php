<?php

Breadcrumbs::register('admin.userpricings.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.userpricings.management'), route('admin.userpricings.index'));
});

Breadcrumbs::register('admin.userpricings.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.userpricings.index');
    $breadcrumbs->push(trans('menus.backend.userpricings.create'), route('admin.userpricings.create'));
});

Breadcrumbs::register('admin.userpricings.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.userpricings.index');
    $breadcrumbs->push(trans('menus.backend.userpricings.edit'), route('admin.userpricings.edit', $id));
});
