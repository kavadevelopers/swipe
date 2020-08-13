<?php

Breadcrumbs::register('admin.expresssavers.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.expresssavers.management'), route('admin.expresssavers.index'));
});

Breadcrumbs::register('admin.expresssavers.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.expresssavers.index');
    $breadcrumbs->push(trans('menus.backend.expresssavers.create'), route('admin.expresssavers.create'));
});

Breadcrumbs::register('admin.expresssavers.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.expresssavers.index');
    $breadcrumbs->push(trans('menus.backend.expresssavers.edit'), route('admin.expresssavers.edit', $id));
});
