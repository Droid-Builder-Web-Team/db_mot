<template>
    <EasyDataTable
      v-model:server-options="serverOptions"
      :server-items-length="serverItemsLength"
      :loading="loading"
      :headers="headers"
      :items="items"
    />
  </template>
  
  <script lang="ts" setup>
  import type { Header, Item, ServerOptions } from "vue3-easy-data-table";
  import { mockServerItems } from "../mock";
  import { ref, computed, watch } from "vue";
  
  const headers: Header[] = [
    { text: "Name", value: "name" },
    { text: "Address", value: "address" },
    { text: "Height", value: "height", sortable: true },
    { text: "Weight", value: "weight", sortable: true },
    { text: "Age", value: "age", sortable: true },
    { text: "Favourite sport", value: "favouriteSport" },
    { text: "Favourite fruits", value: "favouriteFruits" },
  ];
  
  const items = ref<Item[]>([]);
  
  const loading = ref(false);
  const serverItemsLength = ref(0);
  const serverOptions = ref<ServerOptions>({
    page: 1,
    rowsPerPage: 5,
    sortBy: 'age',
    sortType: 'desc',
  });
  
  const loadFromServer = async () => {
    loading.value = true;
    const {
      serverCurrentPageItems,
      serverTotalItemsLength,
    } = await mockServerItems(serverOptions.value);
    items.value = serverCurrentPageItems;
    serverItemsLength.value = serverTotalItemsLength;
    loading.value = false;
  };
  
  // initial load
  loadFromServer();
  
  watch(serverOptions, (value) => { loadFromServer(); }, { deep: true });
  </script>