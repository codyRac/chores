<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'

import AppLogo from '../components/AppLogoIcon.vue'

</script>

<template>
  <Head title="Welcome">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
  </Head>

  <div class="min-h-screen bg-sky-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100">
    <!-- Top nav (auth kept) -->
    <!-- <header class="mx-auto flex w-full max-w-6xl items-center justify-end gap-3 px-6 py-4">
      <Link
        v-if="$page.props.auth?.user"
        :href="route('dashboard')"
        class="inline-flex items-center rounded-md border border-sky-200 bg-white/60 px-4 py-2 text-sm font-medium shadow-sm backdrop-blur hover:bg-white dark:border-slate-700 dark:bg-slate-900/70 dark:hover:bg-slate-900"
      >
        Dashboard
      </Link>
      <template v-else>
        <Link
          :href="route('login')"
          class="inline-flex items-center rounded-md px-4 py-2 text-sm font-medium hover:underline"
        >
          Log in
        </Link>
        <Link
          :href="route('register')"
          class="inline-flex items-center rounded-md border border-sky-200 bg-white/70 px-4 py-2 text-sm font-medium shadow-sm backdrop-blur hover:bg-white dark:border-slate-700 dark:bg-slate-900/70 dark:hover:bg-slate-900"
        >
          Register
        </Link>
      </template>
    </header> -->

    <!-- Hero -->
    <main class="mx-auto w-full  px-6 pt-16">
      <section
        class="relative overflow-hidden rounded-2xl border border-sky-200/60 bg-gradient-to-br from-sky-100 to-sky-50 p-8 shadow-sm md:p-12 dark:border-slate-800 dark:from-slate-900 dark:to-slate-950"
      >
        <!-- subtle dots -->
        <div
          class="pointer-events-none absolute inset-0 bg-[radial-gradient(theme(colors.sky.200/30)_1px,transparent_1px)] [background-size:16px_16px]"
          aria-hidden="true"
        />

        <div class="relative flex flex-col items-start gap-6 md:flex-row md:items-center md:justify-between">
          <!-- Placeholder logo & heading -->
          <div class="flex items-center gap-4">
            <!-- Placeholder logo -->
            <div
              class="grid size-16 place-items-center rounded-xl bg-sky-500 text-white shadow-md ring-1 ring-sky-600/30 dark:bg-sky-600 dark:ring-sky-400/30"
              aria-hidden="true"
            >
              <!-- simple placeholder mark -->

              <AppLogo class="size-8"></AppLogo>
            </div>

            <div>
              <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">
                Choreli
              </h1>
              <p class="mt-1 max-w-xl text-sm text-slate-600 dark:text-slate-300">
                Track chores, earn points, and redeem fun rewards—solo or with your group.
              </p>
            </div>
          </div>

           <Link
                v-if="$page.props.auth?.user"
                :href="route('dashboard')"
                class="inline-flex items-center rounded-md border border-sky-200 bg-white/60 px-4 py-2 text-sm font-medium shadow-sm backdrop-blur hover:bg-white dark:border-slate-700 dark:bg-slate-900/70 dark:hover:bg-slate-900"
            >
                Dashboard
            </Link>

          <!-- CTA -->
          <div v-else class="flex items-center gap-3">


            <Link
              :href="$page.props.auth?.user ? route('dashboard') : route('register')"
              class="inline-flex items-center rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-400 dark:bg-sky-500 dark:hover:bg-sky-400"
            >
              Get started
            </Link>
            <Link
              :href="route('login')"
              class="inline-flex items-center rounded-lg border border-sky-300 bg-white/70 px-5 py-2.5 text-sm font-semibold shadow-sm hover:bg-white dark:border-slate-700 dark:bg-slate-900/70 dark:hover:bg-slate-900"
            >
              I already have an account
            </Link>
          </div>
        </div>

        <!-- Three info cards -->
        <div class="relative mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
          <article
            class="rounded-xl border border-sky-200/70 bg-white/70 p-5 shadow-sm backdrop-blur hover:bg-white dark:border-slate-800 dark:bg-slate-900/60 dark:hover:bg-slate-900"
          >
            <div class="mb-3 inline-flex size-9 items-center justify-center rounded-lg bg-sky-100 text-sky-700 dark:bg-slate-800 dark:text-sky-300">
              🧹
            </div>
            <h3 class="text-base font-semibold">Track Chores</h3>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">
              Create chores everyone can see. Mark them done and keep the household humming.
            </p>
          </article>

          <article
            class="rounded-xl border border-sky-200/70 bg-white/70 p-5 shadow-sm backdrop-blur hover:bg-white dark:border-slate-800 dark:bg-slate-900/60 dark:hover:bg-slate-900"
          >
            <div class="mb-3 inline-flex size-9 items-center justify-center rounded-lg bg-sky-100 text-sky-700 dark:bg-slate-800 dark:text-sky-300">
              ⭐
            </div>
            <h3 class="text-base font-semibold">Earn Points</h3>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">
              Every completed chore adds to your points. Compete or collaborate—your call.
            </p>
          </article>

          <article
            class="rounded-xl border border-sky-200/70 bg-white/70 p-5 shadow-sm backdrop-blur hover:bg-white dark:border-slate-800 dark:bg-slate-900/60 dark:hover:bg-slate-900"
          >
            <div class="mb-3 inline-flex size-9 items-center justify-center rounded-lg bg-sky-100 text-sky-700 dark:bg-slate-800 dark:text-sky-300">
              🎁
            </div>
            <h3 class="text-base font-semibold">Redeem Rewards</h3>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">
              Trade points for rewards—movie night, gift cards, you name it.
            </p>
          </article>
        </div>
      </section>

      <!-- Footer-ish blurb -->
      <p class="mx-auto mt-8 max-w-3xl text-center text-sm text-slate-600 dark:text-slate-300">
        Built with Laravel, Inertia, and Vue. Seamless auth, fast navigation, and a clean UI to make chores a little more fun.
      </p>
    </main>

    <div class="h-10" />
  </div>
</template>
