<template>
  <!-- the pairing `min-h-screen` and `items-stretch` solves the `h-screen` problem on mobile devices -->
  <div class="grid gap-2 items-stretch min-h-screen md:grid-cols-3 sm:grid-cols-1 sm:p-4 md:p-8 lg:p-12 dark:bg-slate-700 bg-slate-300">
    <div class="col-span-2">
      <h3 class="text-lg font-semibold dark:text-slate-300 text-slate-700">
        This is a lorem one
      </h3>
      <article class="prose lg:prose-2xl dark:text-slate-300 text-slate-700">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque quae voluptatibus ipsam eaque perferendis,
        accusantium praesentium dicta alias porro necessitatibus dolor, soluta repudiandae eos nam pariatur
        consequuntur
        facere omnis magnam!
      </article>
    </div>
    <div>
      <h3 class="text-lg font-semibold dark:text-slate-300 text-slate-700">
        This is a lorem two
      </h3>
      <article class="prose lg:prose-2xl dark:text-slate-300 text-slate-700">
        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ullam nulla quas magni, incidunt maxime dicta neque
        autem beatae, natus mollitia amet voluptatum vero sit ut aspernatur aperiam voluptatibus quaerat dolores!
      </article>
    </div>
    <div class="col-span-2">
      <h3 class="text-lg font-semibold dark:text-slate-300 text-slate-700">
        This is a lorem three
      </h3>
      <article class="prose lg:prose-2xl dark:text-slate-300 text-slate-700">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam culpa modi quod, doloremque nihil voluptatem
        vero repudiandae nesciunt velit recusandae minima hic, porro, magnam dignissimos. Assumenda ipsa deleniti
        recusandae exercitationem!
      </article>
    </div>
    <div>
      <h3 class="text-lg font-semibold dark:text-slate-300 text-slate-700">
        This is a lorem four
      </h3>
      <article class="prose lg:prose-2xl dark:text-slate-300 text-slate-700">
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Suscipit culpa, id, odio, eum repudiandae tempora
        eligendi minus accusamus accusantium ad reprehenderit veritatis quas ipsum obcaecati explicabo sunt nulla
        iusto libero!
      </article>
    </div>
    <!-- TODO -->
  </div>
</template>

<style scoped></style>
