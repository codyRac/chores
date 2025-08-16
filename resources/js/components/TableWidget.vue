<script setup lang="ts">
import Widget from '@/components/Widget.vue'
import { computed } from 'vue'

type Column = {
  key: string
  label: string
  class?: string
  width?: string
  align?: 'left' | 'center' | 'right'
}

const props = withDefaults(defineProps<{
  title: string
  slug: string
  columns: Column[]
  rows: Array<Record<string, any>>
  rowKey?: string
  loading?: boolean
  emptyText?: string
  className?: string
}>(), {
  rowKey: 'id',
  loading: false,
  emptyText: 'No data to display.',
  className: '',
})

const hasRows = computed(() => (props.rows?.length ?? 0) > 0)
</script>

<template>
  <Widget :title="title" :slug="slug" :class="className">
    <template #actions>
      <slot name="actions" />
    </template>

    <div class="overflow-x-auto">
      <table class="min-w-full table-auto text-left text-sm">
        <thead class="bg-neutral-50 dark:bg-neutral-900/50">
          <tr class="text-neutral-600 dark:text-neutral-300">
            <th
              v-for="col in columns"
              :key="col.key"
              class="px-4 py-2 font-semibold"
              :class="[
                col.class,
                col.align === 'center' ? 'text-center' : col.align === 'right' ? 'text-right' : 'text-left',
              ]"
              :style="{ width: col.width }"
            >
              {{ col.label }}
            </th>
          </tr>
        </thead>

        <tbody v-if="!loading && hasRows">
          <tr
            v-for="row in rows"
            :key="row[rowKey] ?? JSON.stringify(row)"
            class="border-b border-x border-neutral-200 dark:border-neutral-800"
          >
            <td
              v-for="col in columns"
              :key="col.key"
              class="px-4 py-2"
              :class="[
                col.class,
                col.align === 'center' ? 'text-center' : col.align === 'right' ? 'text-right' : 'text-left',
              ]"
            >
              <!-- Per-cell slot override: #cell-{key} -->
              <slot :name="`cell-${col.key}`" :row="row" :value="row[col.key]">
                {{ row[col.key] }}
              </slot>
            </td>
          </tr>
        </tbody>

        <tbody v-else-if="loading">
          <tr>
            <td :colspan="columns.length" class="px-4 py-6">
              <div class="h-6 w-1/3 animate-pulse rounded bg-primary/10"></div>
            </td>
          </tr>
        </tbody>

        <tbody v-else>
          <tr>
            <td :colspan="columns.length" class="px-4 py-6 text-center text-neutral-500">
              <slot name="empty">{{ emptyText }}</slot>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <slot name="footer" />
  </Widget>
</template>
