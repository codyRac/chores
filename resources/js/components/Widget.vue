<script setup lang="ts">
import { computed } from 'vue'

const props = withDefaults(defineProps<{
  title: string
  slug: string
  className?: string
}>(), {
  className: '',
})

/**
 * Make a stable-ish unique id per instance so multiple widgets
 * on the page don't collide in <pattern> ids.
 */
const uid = Math.random().toString(36).slice(2, 9)
const patternId = computed(() => `pattern-${props.slug}-${uid}`)
const patternUrl = computed(() => `url(#${patternId.value})`)
const headingId = computed(() => `heading-${props.slug}-${uid}`)
</script>

<template>
  <section
    :id="slug"
    :aria-labelledby="headingId"
    class="relative  rounded-2xl border border-neutral-200/70  shadow-sm backdrop-blur-sm dark:border-neutral-800/70 "
    :class="className"
  >
    

    <!-- Subtle overlay for readability -->
    <div class="absolute inset-0 bg-gradient-to-br from-white/70 via-white/30 to-transparent dark:from-neutral-900/70 dark:via-neutral-900/30" aria-hidden="true" />

    <!-- Card content -->
    <div class="relative p-5 md:p-6">
      <div class="mb-4 flex items-center justify-between gap-3">
        <h3
          :id="headingId"
          class="text-base font-semibold tracking-tight text-neutral-900 dark:text-neutral-100 md:text-lg"
        >
          {{ title }}
        </h3>
        <div class="flex items-center gap-2">
          <!-- Optional icon/action slot -->
          <slot name="actions" />
        </div>
      </div>

      <div class="prose prose-sm max-w-none text-neutral-700 dark:prose-invert dark:text-neutral-200">
        <slot />
      </div>
    </div>
  </section>
</template>

