<template>
    <!-- the pairing `min-h-screen` and `items-stretch` solves the `h-screen` problem on mobile devices -->
    <div class="grid grid-cols-1 gap-2 items-stretch p-4 min-h-screen md:grid-cols-2 dark:bg-slate-700 bg-slate-300">
        <div class="light-card dark:dark-card">
            <h3 class="text-lg font-semibold dark:text-slate-300 text-slate-700">
                Response tool
            </h3>
        </div>
        <div class="col-span-2 sm:col-span-1 light-card dark:dark-card">
            <h3 class="absolute bottom-4 text-lg font-semibold dark:text-slate-300 text-slate-700">
                Response view!
            </h3>
        </div>
        <!-- TODO -->
    </div>
</template>
