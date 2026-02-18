@extends('partials.layouts.master')

@section('title')
    {{ ucfirst($role->name) }} Role's Permissions | Herozi
@endsection

@section('sub-title')
    {{ ucfirst($role->name) }} Role's Permissions
@endsection

@section('pagetitle', 'Dashboard')

@section('css')
    <style>
        .permission-accordion .accordion-item {
            border: 1px solid var(--bs-border-color);
            border-radius: 8px !important;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .permission-accordion .accordion-button {
            background: var(--bs-card-bg);
            font-weight: 600;
            font-size: 15px;
            padding: 14px 20px;
            box-shadow: none;
        }

        .permission-accordion .accordion-button:not(.collapsed) {
            background: var(--bs-light);
            color: var(--bs-heading-color);
        }

        .permission-accordion .accordion-body {
            padding: 15px 20px;
            background: var(--bs-card-bg);
            border-top: 1px solid var(--bs-border-color);
        }

        .permission-badge {
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 4px;
        }

        .module-checkbox {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .perm-check-item {
            padding: 8px 15px;
            border-radius: 6px;
            transition: background 0.2s;
        }

        .perm-check-item:hover {
            background: var(--bs-light);
        }
    </style>
@endsection

@section('content')

    <div class="row g-4">
        <div class="col-12">
            <!-- Breadcrumb navigation -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Roles</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Permissions</li>
                </ol>
            </nav>
        </div>
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <h5 class="card-title mb-0">Permissions for <strong>{{ ucfirst($role->name) }}</strong></h5>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="button" class="btn btn-sm btn-info" id="expandAllBtn">Expand All</button>
                        <button type="button" class="btn btn-sm btn-secondary" id="collapseAllBtn">Collapse
                            All</button>
                        <button type="button" class="btn btn-sm btn-success" id="selectAllBtn">Select All</button>
                        <button type="button" class="btn btn-sm btn-danger" id="unselectAllBtn">Unselect All</button>
                    </div>
                </div>
                <div class="card-body">
                    <form id="permissionsForm" action="{{ route('role.permissions.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="accordion permission-accordion" id="permissionsAccordion">
                            @foreach ($modules as $moduleName => $permissions)
                                @php
                                    $moduleSlug = Str::slug($moduleName);
                                    $permCount = count($permissions);
                                    $checkedCount = count(array_intersect($permissions, $rolePermissions));
                                    $allChecked = $checkedCount === $permCount;
                                @endphp
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading_{{ $moduleSlug }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse_{{ $moduleSlug }}" aria-expanded="false"
                                            aria-controls="collapse_{{ $moduleSlug }}">
                                            <div class="d-flex align-items-center gap-3 w-100">
                                                <input type="checkbox"
                                                    class="form-check-input module-checkbox select-all-module m-0"
                                                    data-module="{{ $moduleSlug }}" {{ $allChecked ? 'checked' : '' }}
                                                    onclick="event.stopPropagation();">
                                                <span>{{ $moduleName }}</span>
                                                <span
                                                    class="badge bg-primary-subtle text-primary permission-badge">{{ $permCount }}</span>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="collapse_{{ $moduleSlug }}" class="accordion-collapse collapse"
                                        aria-labelledby="heading_{{ $moduleSlug }}">
                                        <div class="accordion-body">
                                            <div class="row g-2">
                                                @foreach ($permissions as $permission)
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="perm-check-item d-flex align-items-center gap-2">
                                                            <input type="checkbox"
                                                                class="form-check-input permission-checkbox m-0 perm-{{ $moduleSlug }}"
                                                                name="permissions[]" value="{{ $permission }}"
                                                                id="perm_{{ Str::slug($permission) }}"
                                                                {{ in_array($permission, $rolePermissions) ? 'checked' : '' }}>
                                                            <label class="form-check-label mb-0"
                                                                for="perm_{{ Str::slug($permission) }}"
                                                                style="cursor:pointer;">
                                                                {{ ucwords(str_replace('-', ' ', $permission)) }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Update & Cancel buttons -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('role.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {

            // Expand All
            $('#expandAllBtn').on('click', function() {
                $('.permission-accordion .accordion-collapse').each(function() {
                    var bsCollapse = new bootstrap.Collapse(this, {
                        toggle: false
                    });
                    bsCollapse.show();
                });
            });

            // Collapse All
            $('#collapseAllBtn').on('click', function() {
                $('.permission-accordion .accordion-collapse').each(function() {
                    var bsCollapse = new bootstrap.Collapse(this, {
                        toggle: false
                    });
                    bsCollapse.hide();
                });
            });

            // Select All
            $('#selectAllBtn').on('click', function() {
                $('.permission-checkbox').prop('checked', true);
                $('.select-all-module').prop('checked', true);
            });

            // Unselect All
            $('#unselectAllBtn').on('click', function() {
                $('.permission-checkbox').prop('checked', false);
                $('.select-all-module').prop('checked', false);
            });

            // Module "Select All" checkbox
            $('.select-all-module').on('change', function() {
                var moduleSlug = $(this).data('module');
                $('.perm-' + moduleSlug).prop('checked', this.checked);
            });

            // Update module checkbox state when individual permission changes
            $('.permission-checkbox').on('change', function() {
                var classes = $(this).attr('class').split(' ');
                var moduleClass = classes.find(function(c) {
                    return c.startsWith('perm-') && c !== 'permission-checkbox';
                });
                if (moduleClass) {
                    var moduleSlug = moduleClass.replace('perm-', '');
                    var total = $('.perm-' + moduleSlug).length;
                    var checked = $('.perm-' + moduleSlug + ':checked').length;
                    $('[data-module="' + moduleSlug + '"]').prop('checked', total === checked);
                }
            });

            // Form submission with AJAX
            $('#permissionsForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        showToast('Permissions updated successfully!');
                    },
                    error: function(xhr) {
                        showToast('Failed to update permissions.', 'danger');
                    }
                });
            });

            @if (session('success'))
                showToast('{{ session('success') }}');
            @endif
        });
    </script>
@endsection
