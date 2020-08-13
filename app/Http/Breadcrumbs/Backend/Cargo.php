<?php

Breadcrumbs::register('admin.cargos.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.cargos.management'), route('admin.cargos.index'));
});

Breadcrumbs::register('admin.cargos.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.cargos.index');
    $breadcrumbs->push(trans('menus.backend.cargos.create'), route('admin.cargos.create'));
});

Breadcrumbs::register('admin.cargos.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.cargos.index');
    $breadcrumbs->push(trans('menus.backend.cargos.edit'), route('admin.cargos.edit', $id));
});
