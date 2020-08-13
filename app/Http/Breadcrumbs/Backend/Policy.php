<?php

Breadcrumbs::register('admin.policies.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    // $breadcrumbs->push(trans('menus.backend.policies.management'), route('admin.policies.index'));
});

// Breadcrumbs::register('admin.policies.create', function ($breadcrumbs) {
//     $breadcrumbs->parent('admin.policies.index');
//     $breadcrumbs->push(trans('menus.backend.policies.create'), route('admin.policies.create'));
// });

Breadcrumbs::register('admin.policies.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.policies.index');
    $breadcrumbs->push("Edit $id->title", route('admin.policies.edit', $id));
});
