<?php

Breadcrumbs::register('admin.rewardstcs.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.rewardstcs.management'), route('admin.rewardstcs.index'));
});

Breadcrumbs::register('admin.rewardstcs.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.rewardstcs.index');
    $breadcrumbs->push(trans('menus.backend.rewardstcs.create'), route('admin.rewardstcs.create'));
});

Breadcrumbs::register('admin.rewardstcs.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.rewardstcs.index');
    $breadcrumbs->push(trans('menus.backend.rewardstcs.edit'), route('admin.rewardstcs.edit', $id));
});
