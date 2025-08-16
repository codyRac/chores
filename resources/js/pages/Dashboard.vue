<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import Widget from '../components/Widget.vue';
import Skeleton from '../components/Ui/skeleton/Skeleton.vue';
import { ref, watch, computed} from 'vue'
import TableWidget from '../components/TableWidget.vue'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },

];

// Inertia props are typed as usual
const props = defineProps<{
  stats: { chores: number; redeemed: number; groups: number }
  groups: { id: number; name: string }[]
  selectedGroupId: number | null
  members: Array<{
    id: number
    name: string
    email: string
    role: string | null
    points: number
    earned: number
    redeemed: number
    joined_at: string | null
  }>
  chores: Array<{
    id: number
    title: string
    description?: string
    points: number
    completed_at: string | null
    assigned_to?: number
  }>

  rewards: Array<{
    id: number
    title: string
    description?: string
    cost: number
    redeemed_at: string | null
    redeemed_by?: number
  }>
  // add to defineProps
completedChores: Array<{
  id: number
  chore_id: number
  title: string
  category: string | null
  points: number
  completed_at: string
}>

}>()

const currentGroupId = ref<number | null>(props.selectedGroupId)

// when changed, fetch new data from the server
watch(currentGroupId, (val) => {
  router.get(
    '/dashboard',
    { group_id: val ?? '' },
    { preserveState: true, replace: true, preserveScroll: true }
  )
})

// filters
const search = ref('')
const categoryFilter = ref<'all' | string>('all')

// unique categories from chores
const categories = computed(() =>
  Array.from(
    new Set(
      (props.chores ?? [])
        .map((c: any) => c.category ?? c.catergory) // if your field is spelled "catergory", this still works
        .filter(Boolean)
    )
  )
)

// filtered rows
const filteredChores = computed(() => {
  const q = search.value.trim().toLowerCase()
  return (props.chores ?? []).filter((c: any) => {
    const title = String(c.title ?? '').toLowerCase()
    const cat   = String(c.category ?? c.catergory ?? '')
    const matchesTitle = !q || title.includes(q)
    const matchesCat   = categoryFilter.value === 'all' || cat === categoryFilter.value
    return matchesTitle && matchesCat
  })
})

const completingId = ref<number | null>(null)

const completed = (choreId: number) => {
  if (!window.confirm('Mark this chore as completed? Points will be added to your group balance.')) return

  completingId.value = choreId
  router.post(
    `/dashboard/chores/${choreId}/complete`,
    { group_id: currentGroupId.value ?? '' },
    {
      preserveScroll: true,
      preserveState: true,
      only: ['stats', 'chores', 'members'],
      onFinish: () => (completingId.value = null),
    }
  )
}



// derive a Set of completed IDs to disable buttons
const completedIds = computed(() => new Set((props.completedChores ?? []).map(c => c.chore_id)))

const completedCols = [
  { key: 'title',         label: 'Title' },
  { key: 'points',        label: 'Points', align: 'right' as const },
  { key: 'completed_at',  label: 'Completed At' },
]
const choreCols = [
  { key: 'title',         label: 'Title' },
  { key: 'points',        label: 'Points', align: 'right' as const },
  { key: 'category',  label: 'Category' },
  { key: 'action',  label: '', width: '1%' }, // action button column

]
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">

              <div class="mb-4 flex items-center gap-3 px-4">
                    <label for="group" class="text-sm font-medium">Group</label>
                    <select
                        id="group"
                        v-model="currentGroupId"
                        class="rounded-md border px-3 py-2 text-sm dark:bg-neutral-900 dark:border-neutral-700"
                    >
                        <option v-for="g in groups" :key="g.id" :value="g.id">{{ g.title }}</option>
                    </select>
                </div>
            <div class="grid  gap-4 md:grid-cols-3">
                <div class="">
                    <Widget

                        title="Points"
                        slug="crm-overview"
                        className="mb-6 bg-blue-300 h-full"
                        class="ring-1 ring-neutral-200/50"
                        >


                        <!-- your content -->
                        <p class="text-4xl">{{ stats.points }} </p>
                    </Widget>
                </div>
                <div class="relative  overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <Widget
                        title="Redeem"
                        slug="crm-overview"
                        className="mb-6 bg-green-300 h-full"
                        class="ring-1 ring-neutral-200/50"
                        >


                        <!-- your content -->
                        <p>{{ stats.redeemed }} points redeemed</p>
                    </Widget>
                </div>
                <div class="relative  overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <Widget
                        title="Members"
                        slug="crm-overview"
                        className="mb-6 bg-yellow-300 h-full"
                        class="ring-1 ring-neutral-200/50"
                        >


                        <!-- your content -->
                        <p class="uppercase" :key="member.id" v-for="member in members">{{ member.name }}</p>
                    </Widget>
                </div>
            </div>


            <TableWidget
  title="Chores"
  slug="chores"
  :columns="choreCols"
  :rows="filteredChores"
  className="mb-6 bg-red-300 h-full"
  class="ring-1 ring-neutral-200/50"
>
  <!-- Filters toolbar -->
  <template #actions>
    <div class="md:flex grid items-center gap-2">
      <input
        v-model="search"
        type="search"
        placeholder="Search title…"
        class="w-44 rounded-md border px-3 py-1.5 text-sm dark:border-neutral-700 dark:bg-neutral-900"
      />
      <select
        v-model="categoryFilter"
        class="rounded-md border px-3 py-1.5 text-sm dark:border-neutral-700 dark:bg-neutral-900"
      >
        <option value="all">All Categories</option>
        <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
      </select>
    </div>
  </template>

  <!-- Cell tweaks -->
  <template #cell-points="{ value }">
    <div class="text-right">{{ value }}</div>
  </template>

  <template #cell-category="{ value }">
    <span class="uppercase">{{ value }}</span>
  </template>

  <!-- Action button -->
  <template #cell-action="{ row }">
    <button
      @click="completed(row.id)"
      :disabled="completingId === row.id"
      class="rounded-lg border px-3 py-1.5 text-sm dark:border-neutral-700"
    >
      <span v-if="completedIds.has(row.id)">Completed</span>
      <span class="animate-pulse" v-else-if="completingId === row.id">Saving…</span>
      <span v-else>Complete</span>
    </button>
  </template>
</TableWidget>



            <div class="relative flex-1 rounded-xl border border-sidebar-border/70  dark:border-sidebar-border">
            <TableWidget
            title="Completed Chores"
            slug="completed-chores"
            className="mb-6 bg-pink-300 h-full"
            class="ring-1 ring-neutral-200/50"
            :columns="completedCols"
            :rows="completedChores"
            >
            <template #cell-completed_at="{ value }">
                {{ new Date(value).toLocaleString() }}
            </template>
            <template #cell-category="{ value }">
                <span class="uppercase">{{ value }}</span>
            </template>
            </TableWidget>


            </div>

        </div>
    </AppLayout>
</template>
