<x-dashboard.layout>

    <x-breadcrumbs title="Create Rule" parent="rules" child="edit" />
    <x-form :route="route('rules.update', $rule->id)" method="patch" file="">
        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
                <x-form-input label="Rule" name="rule" placeholder="{{$rule->rule}}"
                              required="required" />

                <x-form-select label="Priority" name="priority" required="required" >
                    <option value={{$rule->priority}}>{{$rule->priority}}</option>
                    <option value=1>1</option>
                    <option value=2>2</option>
                </x-form-select>

            </div>

            <!--end::Col-->
        </div>
    </x-form>
</x-dashboard.layout>
