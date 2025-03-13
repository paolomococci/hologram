<script lang="ts">
  import axios from "axios"
  import ENV from "../../env"
  import { LoaderPinwheel } from "lucide-svelte"
  import type Post from "../apis/api-post"

  let response: any = false
  let posts: Post[]

  /**
   * Retrieve posts from the dedicated API.
   */
  async function retrievePosts() {
    try {
      response = await axios.get<Post[]>(`${ENV.baseUrl}api/posts`)
      posts = response.data
      console.log("Response: ", response)
      console.log("Posts: ", posts)
    } catch (error) {
      console.error(error)
    }
  }

  retrievePosts()
</script>

<main>
  <div class="flex z-20 justify-center items-center mt-4">
    {#if !response}
      <div>
        <LoaderPinwheel
          class="w-20 h-20 stroke-1 stroke-orange-400 animate-[spin_1s_ease-in-out_infinite]"
        />
      </div>
    {:else if response.status === 200}
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
              {post.user?.name}
            </h6>
          </div>
        {/each}
      </div>
    {/if}
  </div>
</main>
