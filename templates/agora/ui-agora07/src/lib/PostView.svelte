<script lang="ts">
  let { posts } = $props()
</script>

<main>
  <div class="gap-8 items-center">
    {#each posts as post}
      <div class="py-2 my-2 rounded-lg bg-stone-800">
        <h5
          class="m-1 font-serif text-xs text-cyan-600 sm:text-sm md:text-base lg:text-lg"
        >
          {post.title}
        </h5>
        <p
          class="m-1 font-serif text-xs text-justify sm:text-sm md:text-base lg:text-lg line-clamp-2 text-stone-400"
        >
          {post.content}
        </p>
        <h6 class="m-1 font-mono text-xs text-cyan-400">
          {post.user.name}
        </h6>
      </div>
    {/each}
  </div>
</main>
