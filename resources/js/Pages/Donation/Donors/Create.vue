<template>
  <Head title="Create Receivable" />
  <AppLayout>
    <div class="w-full pt-6">
      <div class="mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-lg">
          <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
            <h1 class="font-semibold text-3xl text-primary">
              {{ form?.id ? "Update" : "Create" }} Receivable
            </h1>
            <!-- <form
              @submit.prevent="
                form?.id
                  ? form.put(route('donors.update', { id: form.id }))
                  : form.post(route('donors.store'), form)
              "
            > -->
            <form  @submit.prevent="
            form.processing = true;
            form?.id
                ? form.put(route('donors.update', { id: form.id }))
                : form.post(route('donors.store'), form).finally(() => {
                    form.processing = false;
                })
            ">
                <div class="grid grid-cols-1 gap-x-4 gap-y-4 md:grid-cols-3 py-6">
                  <div>
                    <label
                      for="name"
                      class="block text-sm md:text-base font-medium text-gray-900"
                      >Name
                      <span class="text-red-500">*</span>
                    </label>
                      <input
                        id="name"
                        name="name"
                        type="text"
                        autocomplete="name"
                        class="mt-1 block w-full rounded border-0 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary text-sm sm:text-base h-11"
                        step="0.01"
                        v-model="form.name"
                      />
                    <InputError
                      v-if="form.errors?.name"
                      :message="form.errors?.name"
                    />
                  </div>
                  <div>
                    <label
                      for="type"
                      class="block text-sm md:text-base font-medium text-gray-900"
                      >Receivable Type
                      <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                      <multiselect
                        v-model="selectedType"
                        :options="typeOptions"
                        :custom-label="typeCustomLabel"
                        @select="onTypeSelect"
                        label="type"
                        track-by="value"
                        placeholder="Select Donor Type"
                      ></multiselect>
                    </div>
                    <InputError
                      v-if="form.errors?.type"
                      :message="form.errors?.type"
                    />
                  </div>

                  <div v-if="hospital_accounts">
                    <label
                      for="coa_id"
                      class="block text-sm md:text-base font-medium text-gray-900"
                      >Account Head
                      <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                      <multiselect
                        v-model="selectedCoa"
                        :options="coa"
                        @update:modelValue="onCoaSelect"
                        label="acc_desc"
                        track-by="id"
                        placeholder="Select a Account Head"
                      ></multiselect>
                    </div>
                    <InputError
                      v-if="form.errors?.coa_id"
                      :message="form.errors?.coa_id"
                    />
                  </div>

                  <div class="sm:col-span-3">
                    <label
                      for="description"
                      class="block text-sm md:text-base font-medium text-gray-900"
                      >Description</label
                    >
                    <div class="mt-1">
                      <textarea
                        id="description"
                        name="description"
                        row="3"
                        autocomplete="description"
                        class="mt-1 block w-full rounded border-0 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary text-sm sm:text-base"
                        v-model="form.description"
                      ></textarea>
                    </div>
                    <InputError
                      v-if="form.errors?.description"
                      :message="form.errors?.description"
                    />
                  </div>
                  <div class="sm:col-span-3">
                    <label
                      for="address"
                      class="block text-sm md:text-base font-medium text-gray-900"
                      >Address</label
                    >
                    <div class="mt-1">
                      <textarea
                        id="address"
                        name="address"
                        row="3"
                        autocomplete="address"
                        class="mt-1 block w-full rounded border-0 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary text-sm sm:text-base"
                        v-model="form.address"
                      ></textarea>
                    </div>
                    <InputError
                      v-if="form.errors?.address"
                      :message="form.errors?.address"
                    />
                  </div>
                </div>
              <div
                class="flex items-center justify-center md:justify-end gap-4 py-4"
              >
                <InertiaLink
                  class="inline-flex justify-center rounded bg-white px-5 py-2 w-24 text-sm md:text-base font-medium text-primary shadow-sm border border-primary hover:bg-primary hover:text-white"
                  :href="route('donors.index')"
                >
                  Cancel
                </InertiaLink>
                <button
                  type="submit" :disabled="form.processing"
                  class="rounded bg-primary px-5 py-2 w-24 text-sm md:text-base font-medium text-white shadow-sm border border-primary hover:bg-accent focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary"
                >
                  Save
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
  <script setup>
import { Inertia } from "@inertiajs/inertia";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, useForm, Link as InertiaLink } from "@inertiajs/vue3";
import Multiselect from "vue-multiselect";
import { ref, computed, defineComponent, watch } from "vue";
import InputError from "../../Components/InputError.vue";

const props = defineProps({
  donor: Object,
  coa: Array,
  hospital_accounts: String,
});

const form = useForm({
  id: props?.donor?.id || null,
  name: props?.donor?.name || null,
  type: props?.donor?.type || null,
  address: props?.donor?.address || null,
  description: props?.donor?.description || null,
  coa_id: props?.donor?.coa_id || null,
});

// Service Type
const selectedType = ref();
const typeOptions = computed(() => {
  const deductionType = [
    { value: "care_off", label: "Care Off" },
    { value: "zf", label: "Zf" },
    { value: "donation", label: "Donation" },
  ];
  return deductionType;
});

const typeCustomLabel = (option) => option.label;
const onTypeSelect = async (selectedType) => {
  form.type = selectedType.value;
};
if (props?.donor?.type) {
  selectedType.value = typeOptions.value.find(
    (option) => option.value === props.donor.type
  );
}



const selectedCoa = ref(null);
if (props?.donor) {
  const coas = props.coa.find(
    (c) => c.id === props.donor.coa_id
  );
  if (coas) {
    selectedCoa.value = coas;
  }
}

const onCoaSelect = async (selectedCoa) => {
  form.coa_id = selectedCoa?.id ?? null;
};

const cancel = () => {
  Inertia.visit(route("donors.index"));
};

defineComponent({
  components: {
    Multiselect,
  },
});
</script>
  <style src="vue-multiselect/dist/vue-multiselect.css"></style>
