@php
    $departments = $departments ?? collect();
    $designations = $designations ?? collect();
    $employee = $employee ?? null;
@endphp

<div class="row">
    {{-- Employee Code --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="employee_code" :value="__('Employee Code')" />
            <x-text-input id="employee_code" name="employee_code" class="form-control" :value="old('employee_code', $employee->employee_code ?? '')" required />
            <x-input-error :messages="$errors->get('employee_code')" />
        </div>
    </div>

    {{-- Name --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" class="form-control" :value="old('name', $employee->name ?? '')" required />
            <x-input-error :messages="$errors->get('name')" />
        </div>
    </div>

    {{-- Email --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="form-control" :value="old('email', $employee->email ?? '')" />
            <x-input-error :messages="$errors->get('email')" />
        </div>
    </div>

    {{-- Phone --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="phone" :value="__('Phone')" />
            <x-text-input id="phone" name="phone" class="form-control" :value="old('phone', $employee->phone ?? '')" />
            <x-input-error :messages="$errors->get('phone')" />
        </div>
    </div>

    {{-- Gender --}}
    <div class="col-sm-6">
        <div class="mb20">
            <div class="form-style1">
                <x-input-label class="heading-color" for="gender" :value="__('Gender')" />
                <div class="bootselect-multiselect">
                    <select class="selectpicker" data-live-search="true" id="gender" name="gender">
                        <option value="" disabled
                            {{ is_null(old('gender', $employee->gender ?? null)) ? 'selected' : '' }}>Select</option>
                        <option value="male" @selected(old('gender', $employee->gender ?? '') === 'male')>Male</option>
                        <option value="female" @selected(old('gender', $employee->gender ?? '') === 'female')>Female</option>
                        <option value="other" @selected(old('gender', $employee->gender ?? '') === 'other')>Other</option>
                    </select>
                </div>
            </div>
            <x-input-error :messages="$errors->get('gender')" />
        </div>
    </div>

    {{-- Father Name --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="father_name" :value="__('Father Name')" />
            <x-text-input id="father_name" name="father_name" class="form-control" :value="old('father_name', $employee->father_name ?? '')" />
            <x-input-error :messages="$errors->get('father_name')" />
        </div>
    </div>

    {{-- Mother Name --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="mother_name" :value="__('Mother Name')" />
            <x-text-input id="mother_name" name="mother_name" class="form-control" :value="old('mother_name', $employee->mother_name ?? '')" />
            <x-input-error :messages="$errors->get('mother_name')" />
        </div>
    </div>

    {{-- Spouse Name --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="spouse_name" :value="__('Spouse Name')" />
            <x-text-input id="spouse_name" name="spouse_name" class="form-control" :value="old('spouse_name', $employee->spouse_name ?? '')" />
            <x-input-error :messages="$errors->get('spouse_name')" />
        </div>
    </div>

    {{-- NID / Passport --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="nid" :value="__('Passport / NID')" />
            <x-text-input id="nid" name="nid" class="form-control" :value="old('nid', $employee->nid ?? '')" />
            <x-input-error :messages="$errors->get('nid')" />
        </div>
    </div>

    {{-- DOB --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="dob" :value="__('Date of Birth')" />
            <x-text-input id="dob" name="dob" type="date" class="form-control" :value="old('dob', $employee->dob ?? '')" />
            <x-input-error :messages="$errors->get('dob')" />
        </div>
    </div>

    {{-- Department --}}
    <div class="col-sm-6">
        <div class="mb20">
            <div class="form-style1">
                <x-input-label class="heading-color" for="department_id" :value="__('Department')" />
                <div class="bootselect-multiselect">
                    <select class="selectpicker" data-live-search="true" id="department_id" name="department_id">
                        <option value="" disabled
                            {{ is_null(old('department_id', $employee->department_id ?? null)) ? 'selected' : '' }}>
                            Select</option>
                        @foreach ($departments as $id => $name)
                            <option value="{{ $id }}" @selected(old('department_id', $employee->department_id ?? '') == $id)>{{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <x-input-error :messages="$errors->get('department_id')" />
        </div>
    </div>

    {{-- Designation --}}
    <div class="col-sm-6">
        <div class="mb20">
            <div class="form-style1">
                <x-input-label class="heading-color" for="designation_id" :value="__('Designation')" />
                <div class="bootselect-multiselect">
                    <select class="selectpicker" data-live-search="true" id="designation_id" name="designation_id">
                        <option value="" disabled
                            {{ is_null(old('designation_id', $employee->designation_id ?? null)) ? 'selected' : '' }}>
                            Select</option>
                        @foreach ($designations as $id => $title)
                            <option value="{{ $id }}" @selected(old('designation_id', $employee->designation_id ?? '') == $id)>{{ $title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <x-input-error :messages="$errors->get('designation_id')" />
        </div>
    </div>

    {{-- Address --}}
    <div class="col-sm-12">
        <div class="mb20">
            <x-input-label class="heading-color" for="address" :value="__('Address')" />
            <textarea id="address" name="address" class="form-control">{{ old('address', $employee->address ?? '') }}</textarea>
            <x-input-error :messages="$errors->get('address')" />
        </div>
    </div>

    {{-- Permanent Address --}}
    <div class="col-sm-12">
        <div class="mb20">
            <x-input-label class="heading-color" for="permanent_address" :value="__('Permanent Address')" />
            <textarea id="permanent_address" name="permanent_address" class="form-control">{{ old('permanent_address', $employee->permanent_address ?? '') }}</textarea>
            <x-input-error :messages="$errors->get('permanent_address')" />
        </div>
    </div>

    {{-- Joining / Exit / Employment Type --}}
    <div class="col-sm-4">
        <div class="mb20">
            <x-input-label class="heading-color" for="joining_date" :value="__('Joining Date')" />
            <x-text-input id="joining_date" name="joining_date" type="date" class="form-control"
                :value="old('joining_date', $employee->joining_date ?? '')" />
            <x-input-error :messages="$errors->get('joining_date')" />
        </div>
    </div>

    <div class="col-sm-4">
        <div class="mb20">
            <x-input-label class="heading-color" for="exit_date" :value="__('Exit Date')" />
            <x-text-input id="exit_date" name="exit_date" type="date" class="form-control" :value="old('exit_date', $employee->exit_date ?? '')" />
            <x-input-error :messages="$errors->get('exit_date')" />
        </div>
    </div>

    <div class="col-sm-4">
        <div class="mb20">
            <div class="form-style1">
                <x-input-label class="heading-color" for="employment_type" :value="__('Employment Type')" />
                <div class="bootselect-multiselect">
                    <select class="selectpicker" id="employment_type" name="employment_type">
                        <option value="" disabled
                            {{ is_null(old('employment_type', $employee->employment_type ?? null)) ? 'selected' : '' }}>
                            Select</option>
                        <option value="permanent" @selected(old('employment_type', $employee->employment_type ?? '') === 'permanent')>Permanent</option>
                        <option value="contract" @selected(old('employment_type', $employee->employment_type ?? '') === 'contract')>Contract</option>
                        <option value="intern" @selected(old('employment_type', $employee->employment_type ?? '') === 'intern')>Intern</option>
                    </select>
                </div>
            </div>
            <x-input-error :messages="$errors->get('employment_type')" />
        </div>
    </div>

    {{-- Assigned Assets --}}
    <div class="col-sm-12">
        <div class="mb20">
            <x-input-label class="heading-color" for="assigned_assets" :value="__('Assigned Assets')" />
            <textarea id="assigned_assets" name="assigned_assets" class="form-control">{{ old('assigned_assets', $employee->assigned_assets ?? '') }}</textarea>
            <x-input-error :messages="$errors->get('assigned_assets')" />
        </div>
    </div>

    {{-- Remarks --}}
    <div class="col-sm-12">
        <div class="mb20">
            <x-input-label class="heading-color" for="remarks" :value="__('Remarks')" />
            <textarea id="remarks" name="remarks" class="form-control">{{ old('remarks', $employee->remarks ?? '') }}</textarea>
            <x-input-error :messages="$errors->get('remarks')" />
        </div>
    </div>

    {{-- Status --}}
    <div class="col-sm-4">
        <div class="mb20">
            <div class="form-style1">
                <x-input-label class="heading-color" for="status" :value="__('Status')" />
                <div class="bootselect-multiselect">
                    <select class="selectpicker" id="status" name="status">
                        <option value="" disabled
                            {{ is_null(old('status', $employee->status ?? null)) ? 'selected' : '' }}>Select</option>
                        <option value="active" @selected(old('status', $employee->status ?? '') === 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $employee->status ?? '') === 'inactive')>Inactive</option>
                    </select>
                </div>
            </div>
            <x-input-error :messages="$errors->get('status')" />
        </div>
    </div>
</div>
