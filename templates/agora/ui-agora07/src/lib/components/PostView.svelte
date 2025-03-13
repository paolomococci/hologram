<script lang="ts">
  import type Post from "../apis/api-post"
  import ENV from "../../env"

  let { posts } = $props()
</script>

{#snippet postCard(post: Post, index?: number)}
  <div class="py-2 my-2 rounded-lg bg-stone-800">
    <h5
      class="m-1 font-serif text-xs text-cyan-600 sm:text-sm md:text-base lg:text-lg"
    >
      <span class="block mr-1 font-sans text-xl font-light text-cyan-200"
        >{index}</span
      >
      <a href="{ENV.cardUriBase}{post.id.toString()}">{post.title}</a>
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
{/snippet}

<main>
  <div class="gap-8 items-center">
    {#each posts as post, index}
      {@render postCard(post, index + 1)}
    {/each}
  </div>
</main>
