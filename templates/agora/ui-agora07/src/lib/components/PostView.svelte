<script lang="ts">
  import type Post from "../apis/api-post"
  import { isDetails } from "../stores/store-posts"
  import ENV from "../../env"

  let { posts } = $props()
  // let isDetails: boolean = $state(false)
  let details: Post = $state({
    id: 0,
    title: "",
    content: "",
    created_at: new Date(),
    updated_at: new Date(),
  })

  /**
   * This is a feature to use if you are in an environment where posts may be edited over and over again in rapid succession.
   *
   * @param id
   */
  const getPost = async (id: number): Promise<Post> => {
    const uri: string = ENV.cardUriBase + id
    try {
      const res = await fetch(uri)
      if (!res.ok) {
        throw new Error(`HTTP errors status: ${res.status}`)
      }
      const postJson = await res.json()
      return postJson.post
    } catch (error) {
      console.error(
        "I'm sorry, an error occurred while querying the post id API: ",
        error,
      )
      throw error
    }
  }
</script>

<main>
  {#snippet postCard(post: Post, index?: number)}
    <div class="py-2 my-2 rounded-lg bg-stone-800">
      <h5
        class="m-1 font-serif text-xs text-cyan-600 sm:text-sm md:text-base lg:text-lg"
      >
        <span
          class="block m-1 font-sans text-xs font-light text-cyan-200 rounded-full sm:text-sm md:text-base lg:text-lg bg-stone-700/50"
          >{index}</span
        >
        <button
          onclick={async () => {
            // Start of a demo example if I need to use the version of the post stored in the system instead of the version downloaded during pagination.
            let resPost = getPost(post.id)
            let retrievedPost: Post = await resPost.then((res) => res)
            console.log("Title: ", retrievedPost.title)
            console.log("Content: ", retrievedPost.content)
            console.log("Username: ", retrievedPost.user?.name)
            // End of demo.
            isDetails.set(true)
            details = post
          }}
          class="transition duration-300 ease-in-out delay-300 cursor-pointer hover:text-cyan-100 hover:shadow-2xl hover:shadow-stone-600"
          >{post.title}</button
        >
      </h5>
      <p
        class="m-1 font-serif text-xs text-justify sm:text-sm md:text-base lg:text-lg line-clamp-2 text-stone-400"
      >
        {post.content}
      </p>
      <h6 class="m-1 font-mono text-xs text-cyan-400">
        {#if post.user}
          {post.user.name}
        {/if}
      </h6>
    </div>
  {/snippet}

  {#snippet detailCard(details: Post)}
    <div>
      <button
        onclick={() => {
          console.log("Go back!")
          isDetails.set(false)
        }}
        class="transition duration-300 ease-in-out delay-300 cursor-pointer hover:text-cyan-100 hover:shadow-2xl hover:shadow-stone-600"
        >go back</button
      >
      <h5
        class="m-1 font-serif text-xs text-cyan-600 sm:text-base md:text-lg lg:text-2xl"
      >
        {details.title}
      </h5>
      <p
        class="m-1 font-serif text-xs text-justify sm:text-base md:text-lg lg:text-2xl text-stone-400"
      >
        {details.content}
      </p>
      <h6
        class="m-1 font-mono text-cyan-400 sm:text-base md:text-lg lg:text-2xl"
      >
        {#if details.user}
          {details.user.name}
        {/if}
      </h6>
    </div>
  {/snippet}

  <div class="gap-8 items-center">
    {#if $isDetails}
      {@render detailCard(details)}
    {:else}
      {#each posts as post, index}
        {@render postCard(post, index + 1)}
      {/each}
    {/if}
  </div>
</main>
