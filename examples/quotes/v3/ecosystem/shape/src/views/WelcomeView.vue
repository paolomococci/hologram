<script setup></script>

<template>
  <!-- the pairing `min-h-screen` and `items-stretch` solves the `h-screen` problem on mobile devices -->
  <div class="grid grid-cols-1 gap-2 items-stretch p-4 min-h-screen md:grid-cols-2 dark:bg-slate-700 bg-slate-300">
    <div class="light-card dark:dark-card">
      <h3 class="text-lg font-semibold dark:text-slate-300 text-slate-700">
        This is an welcome view
      </h3>
      <article class="prose lg:prose-2xl dark:text-slate-300 text-slate-700">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis, impedit. In minus autem natus, inventore
        exercitationem minima fugiat, soluta, explicabo iusto repellat vitae. Quis, nemo numquam? Unde magni labore
        eveniet.
      </article>
      <!-- TODO -->
    </div>
  </div>
</template>
