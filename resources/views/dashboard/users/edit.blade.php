<x-dashboard.layout>

    <x-breadcrumbs title="Edit {{$user->username}}" parent="users" child="edit" />
    <x-form :route="route('users.update', $user->id)" method="patch" file="">

        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
               <x-form-input label="Add/Remove AE Credits   {{$user->username}} Current Credits - {{$user->ae_credits}}"
                             name="ae_credits"
                             placeholder=""
                             value=""
                             info-text="use - to remove credits"
                             info-text-color="text-info"
                             required=""
               />

                <x-form-input label="Reason for adding AE Credits"
                              name="reason"
                              placeholder=""
                              value=""
                              info-text=""
                              info-text-color=""
                              required=""
                />



            </div>

            <!--end::Col-->
        </div>
    </x-form>
</x-dashboard.layout>
