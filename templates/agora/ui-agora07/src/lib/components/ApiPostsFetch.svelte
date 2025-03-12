<script lang="ts">
  import type Post from "../apis/api-post"
  import { LoaderPinwheel } from "lucide-svelte"
  import { postStore } from "../stores/store-posts"
  import PostView from "./PostView.svelte"

  let posts: Post[] | unknown

  async function retrieve() {
    postStore.subscribe((postSub) => {
      posts = postSub
      console.log(
        "Posts values from paginator component to posts view component: ",
        posts,
      )
    })
  }

  retrieve()
</script>

<main>
  <div class="flex z-20 justify-center items-center mt-4">
    {#if !posts}
      <div>
        <LoaderPinwheel
          class="w-20 h-20 stroke-1 stroke-orange-400 animate-[spin_1s_ease-in-out_infinite]"
        />
      </div>
    {:else}
      <PostView {posts} />
    {/if}
  </div>
</main>
