<div class="leave-balance-page">

    {{-- Page Header --}}
    <div class="leave-page-header">

        <div>
            <span class="leave-mini-title">
                Human Resource Management
            </span>

            <h1 class="leave-main-title">
                Leave Balances
            </h1>

            <p class="leave-subtitle">
                Manage employee leave allocations, balances and yearly entitlements for {{ $filterYear }}.
            </p>
        </div>

        <div class="leave-header-actions">

            <button wire:click="toggleAllocForm"
                class="modern-btn {{ $showAllocForm ? 'btn-light-danger' : 'btn-gradient-primary' }}">

                <i class="fas fa-{{ $showAllocForm ? 'times' : 'plus-circle' }} me-2"></i>

                {{ $showAllocForm ? 'Close Form' : 'Allocate Balance' }}
            </button>

            <button wire:click="bulkAllocate"
                class="modern-btn btn-gradient-success"
                onclick="return confirm('Allocate default balances for ALL active users for {{ $filterYear }}?')">

                <i class="fas fa-users me-2"></i>
                Bulk Allocate
            </button>

        </div>

    </div>

    {{-- Alerts --}}
    <div class="row">

        <div class="col-12">

            @if (session()->has('success'))
                <div class="modern-alert success-alert">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session()->get('success') }}</span>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="modern-alert danger-alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session()->get('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="modern-alert danger-alert align-items-start">

                    <i class="fas fa-exclamation-triangle mt-1"></i>

                    <div>
                        <strong>Please resolve the following:</strong>

                        <ul class="mb-0 mt-2 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            @endif

        </div>

    </div>

    {{-- Filters --}}
    <div class="modern-card filter-card">

        <div class="modern-card-header">
            <div>
                <h5>Filter Leave Balances</h5>
                <span>Quickly find employee leave records.</span>
            </div>
        </div>

        <div class="modern-card-body">

            <div class="row g-4 align-items-end">

                <div class="col-lg-3 col-md-6">

                    <label class="modern-label">
                        Leave Year
                    </label>

                    <div class="modern-input-wrapper">
                        <i class="fas fa-calendar-alt"></i>

                        <select class="modern-select"
                            wire:model="filterYear">

                            @for ($y = date('Y') + 1; $y >= date('Y') - 3; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor

                        </select>

                    </div>

                </div>

                <div class="col-lg-4 col-md-6">

                    <label class="modern-label">
                        Employee
                    </label>

                    <div class="modern-input-wrapper">
                        <i class="fas fa-user"></i>

                        <select class="modern-select"
                            wire:model="filterUser">

                            <option value="">All Employees</option>

                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Allocation Form --}}
    @if ($showAllocForm)

        <div class="modern-card allocation-card">

            <div class="modern-card-header allocation-header">

                <div>
                    <h5>
                        Allocate Leave Balance
                    </h5>

                    <span>
                        Create or update leave balance allocations for {{ $filterYear }}.
                    </span>
                </div>

            </div>

            <div class="modern-card-body">

                <form wire:submit.prevent="allocateBalance">

                    <div class="row g-4">

                        <div class="col-lg-3 col-md-6">

                            <label class="modern-label">
                                Employee
                            </label>

                            <div class="modern-input-wrapper">
                                <i class="fas fa-user-tie"></i>

                                <select class="modern-select"
                                    wire:model.defer="alloc_user_id">

                                    <option value="">-- Select Employee --</option>

                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->name }}
                                        </option>
                                    @endforeach

                                </select>

                            </div>

                            @error('alloc_user_id')
                                <span class="validation-error">{{ $message }}</span>
                            @enderror

                        </div>

                        <div class="col-lg-3 col-md-6">

                            <label class="modern-label">
                                Leave Type
                            </label>

                            <div class="modern-input-wrapper">
                                <i class="fas fa-layer-group"></i>

                                <select class="modern-select"
                                    wire:model="alloc_leave_type_id">

                                    <option value="">-- Select Type --</option>

                                    @foreach ($leaveTypes as $type)
                                        <option value="{{ $type->id }}">
                                            {{ $type->name }} ({{ $type->default_days }} days)
                                        </option>
                                    @endforeach

                                </select>

                            </div>

                            @error('alloc_leave_type_id')
                                <span class="validation-error">{{ $message }}</span>
                            @enderror

                        </div>

                        <div class="col-lg-3 col-md-6">

                            <label class="modern-label">
                                Total Days
                            </label>

                            <div class="modern-input-wrapper">
                                <i class="fas fa-calendar-check"></i>

                                <input type="number"
                                    class="modern-input"
                                    wire:model.defer="alloc_total_days"
                                    min="0"
                                    step="0.5">
                            </div>

                            @error('alloc_total_days')
                                <span class="validation-error">{{ $message }}</span>
                            @enderror

                        </div>

                        <div class="col-lg-3 col-md-6">

                            <label class="modern-label">
                                Carried Over
                            </label>

                            <div class="modern-input-wrapper">
                                <i class="fas fa-history"></i>

                                <input type="number"
                                    class="modern-input"
                                    wire:model.defer="alloc_carried_over"
                                    min="0"
                                    step="0.5">
                            </div>

                        </div>

                    </div>

                    <div class="allocation-actions">

                        <button type="submit"
                            class="modern-btn btn-gradient-primary">

                            <i class="fas fa-save me-2"></i>
                            Save Balance
                        </button>

                        <button wire:click.prevent="toggleAllocForm"
                            type="button"
                            class="modern-btn btn-light-danger">

                            <i class="fas fa-times me-2"></i>
                            Cancel
                        </button>

                    </div>

                </form>

            </div>

        </div>

    @endif

    {{-- Table --}}
    <div class="modern-card table-card">

        <div class="modern-card-header">

            <div>
                <h5>Employee Leave Balances</h5>
                <span>
                    View and manage employee leave balance records.
                </span>
            </div>

        </div>

        <div class="modern-card-body p-0">

            <div class="table-responsive">

                <table class="modern-table">

                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Leave Type</th>
                            <th>Total</th>
                            <th>Used</th>
                            <th>Carry Over</th>
                            <th>Remaining</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($balances as $bal)

                            @php
                                $remaining =
                                    ($bal->total_days + $bal->carried_over) -
                                    $bal->used_days;
                            @endphp

                            <tr>

                                <td>
                                    <div class="employee-cell">

                                        <div class="employee-avatar">
                                            {{ strtoupper(substr($bal->user->name ?? 'U', 0, 1)) }}
                                        </div>

                                        <div>
                                            <strong>{{ $bal->user->name ?? '-' }}</strong>
                                        </div>

                                    </div>
                                </td>

                                <td>
                                    <span class="leave-type-pill">
                                        {{ $bal->leaveType->name ?? '-' }}
                                    </span>
                                </td>

                                <td>{{ $bal->total_days }}</td>

                                <td>{{ $bal->used_days }}</td>

                                <td>{{ $bal->carried_over }}</td>

                                <td>

                                    <span class="balance-pill {{ $remaining > 0 ? 'positive-balance' : 'negative-balance' }}">
                                        {{ $remaining }}
                                    </span>

                                </td>

                                <td class="text-center">

                                    <button onclick="deleteBalance({{ $bal->id }})"
                                        class="delete-btn">

                                        <i class="fas fa-trash-alt"></i>
                                    </button>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7">

                                    <div class="empty-state">

                                        <div class="empty-icon">
                                            <i class="fas fa-folder-open"></i>
                                        </div>

                                        <h5>No Leave Balances Found</h5>

                                        <p>
                                            No balance records found for {{ $filterYear }}.
                                        </p>

                                    </div>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="pagination-wrapper">
                {{ $balances->links('pagination::bootstrap-4') }}
            </div>

        </div>

    </div>

    <script>
        function deleteBalance(id) {
            if (confirm("Are you sure you want to delete this balance record?")) {
                window.livewire.emit('deleteBalance', id);
            }
        }
    </script>

</div>

<style>
    .leave-balance-page {
        padding-bottom: 40px;
    }

    /* Header */

    .leave-page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 28px;
    }

    .leave-mini-title {
        display: inline-block;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #c33205;
        margin-bottom: 8px;
    }

    .leave-main-title {
        font-size: 2.2rem;
        font-weight: 800;
        color: #2f1d10;
        margin-bottom: 10px;
    }

    .leave-subtitle {
        color: #76695e;
        line-height: 1.8;
        margin: 0;
    }

    .leave-header-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    /* Buttons */

    .modern-btn {
        border: none;
        border-radius: 16px;
        padding: 13px 22px;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .btn-gradient-primary {
        background: linear-gradient(135deg, #c33205, #9a2804);
        color: #fff;
        box-shadow: 0 10px 24px rgba(195, 50, 5, 0.24);
    }

    .btn-gradient-success {
        background: linear-gradient(135deg, #2eaf74, #1c8f5a);
        color: #fff;
        box-shadow: 0 10px 24px rgba(46, 175, 116, 0.22);
    }

    .btn-light-danger {
        background: #fff1f1;
        color: #cf4949;
        border: 1px solid #ffd1d1;
    }

    .modern-btn:hover {
        transform: translateY(-2px);
    }

    /* Cards */

    .modern-card {
        background: #fff;
        border-radius: 28px;
        border: 1px solid #f0e2d3;
        overflow: hidden;
        margin-bottom: 28px;
        box-shadow: 0 14px 34px rgba(44, 22, 8, 0.05);
    }

    .modern-card-header {
        padding: 24px 28px;
        border-bottom: 1px solid #f3e8db;
    }

    .modern-card-header h5 {
        font-size: 1.1rem;
        font-weight: 800;
        color: #2f1d10;
        margin-bottom: 4px;
    }

    .modern-card-header span {
        color: #7d6e63;
        font-size: 0.92rem;
    }

    .modern-card-body {
        padding: 28px;
    }

    .allocation-header {
        background: linear-gradient(135deg, #c33205, #9a2804);
    }

    .allocation-header h5,
    .allocation-header span {
        color: #fff;
    }

    /* Inputs */

    .modern-label {
        display: block;
        font-size: 0.84rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: #715f52;
    }

    .modern-input-wrapper {
        position: relative;
    }

    .modern-input-wrapper i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #b37c3f;
    }

    .modern-input,
    .modern-select {
        width: 100%;
        height: 56px;
        border-radius: 18px;
        border: 1px solid #ead9c4;
        background: #fcfaf8;
        padding: 0 18px 0 50px;
        transition: all 0.3s ease;
    }

    .modern-input:focus,
    .modern-select:focus {
        outline: none;
        border-color: #c33205;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(195, 50, 5, 0.08);
    }

    .validation-error {
        display: block;
        margin-top: 8px;
        color: #dc3545;
        font-size: 0.82rem;
    }

    .allocation-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 26px;
    }

    /* Alerts */

    .modern-alert {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px 22px;
        border-radius: 18px;
        margin-bottom: 24px;
        font-weight: 500;
    }

    .success-alert {
        background: #ecfdf3;
        border: 1px solid #b9efcf;
        color: #1f7a4f;
    }

    .danger-alert {
        background: #fff1f1;
        border: 1px solid #ffd1d1;
        color: #b63b3b;
    }

    /* Table */

    .modern-table {
        width: 100%;
        border-collapse: collapse;
    }

    .modern-table thead th {
        background: #faf4ee;
        color: #715f52;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 18px 22px;
        border-bottom: 1px solid #f0e2d3;
    }

    .modern-table tbody td {
        padding: 20px 22px;
        border-bottom: 1px solid #f7ede2;
        vertical-align: middle;
    }

    .modern-table tbody tr:hover {
        background: #fffaf6;
    }

    .employee-cell {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .employee-avatar {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: linear-gradient(135deg, #c33205, #9a2804);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
    }

    .leave-type-pill {
        display: inline-flex;
        padding: 8px 14px;
        border-radius: 50px;
        background: #f8ead9;
        color: #a56628;
        font-size: 0.82rem;
        font-weight: 700;
    }

    .balance-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 64px;
        padding: 8px 14px;
        border-radius: 50px;
        font-weight: 700;
    }

    .positive-balance {
        background: #ecfdf3;
        color: #1f7a4f;
    }

    .negative-balance {
        background: #fff1f1;
        color: #cf4a4a;
    }

    .delete-btn {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        border: none;
        background: #fff1f1;
        color: #cf4a4a;
        transition: all 0.3s ease;
    }

    .delete-btn:hover {
        background: #cf4a4a;
        color: #fff;
    }

    .pagination-wrapper {
        padding: 24px 28px;
    }

    /* Empty */

    .empty-state {
        padding: 60px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 88px;
        height: 88px;
        border-radius: 50%;
        margin: 0 auto 24px;
        background: linear-gradient(135deg, #f8ead9, #f4dec5);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #b47432;
        font-size: 2rem;
    }

    .empty-state h5 {
        font-weight: 800;
        color: #301e11;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #7c6d61;
        margin: 0;
    }

    /* Responsive */

    @media (max-width: 768px) {
        .leave-main-title {
            font-size: 1.8rem;
        }

        .modern-card-header,
        .modern-card-body {
            padding: 20px;
        }

        .modern-table thead {
            display: none;
        }

        .modern-table,
        .modern-table tbody,
        .modern-table tr,
        .modern-table td {
            display: block;
            width: 100%;
        }

        .modern-table tr {
            padding: 16px;
            border-bottom: 1px solid #f0e2d3;
        }

        .modern-table td {
            padding: 10px 0;
            border: none;
        }
    }
</style>