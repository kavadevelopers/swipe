<?php

Breadcrumbs::register('admin.loudhailers.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.loudhailers.management'), route('admin.loudhailers.index'));
});

Breadcrumbs::register('admin.loudhailers.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.loudhailers.index');
    $breadcrumbs->push(trans('menus.backend.loudhailers.create'), route('admin.loudhailers.create'));
});

Breadcrumbs::register('admin.loudhailers.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.loudhailers.index');
    $breadcrumbs->push(trans('menus.backend.loudhailers.edit'), route('admin.loudhailers.edit', $id));
});
