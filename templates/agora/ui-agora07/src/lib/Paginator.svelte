<script lang="ts">
  import { FetchPostsService } from "./service-fetch-posts"
  import type Post from "./api-post"
  import type { FetchedResponse } from "./interface-fetch-response"
  import { postStore } from "./store-posts"
  import { writable } from "svelte/store"

  const fetchPostsService = new FetchPostsService()
  const postsPerPage = 10
  const currentPage = writable(1)
  let textOfFilter = $state("none")
  let fetchResponse: FetchedResponse
  let posts: Post[] = []
  let totalNumberOfPosts: number = 0
  let totalNumberOfPages = $state(0)

  const retrievePosts = async (
    filter?: string,
    current?: number
  ) => {
    try {
      fetchResponse = await fetchPostsService.fetchPosts(
        filter,
        current
      )
      console.log(`FetchedResponse: `, fetchResponse)
      posts = fetchResponse.posts
      postStore.set(posts)
      totalNumberOfPosts = fetchResponse.num
      totalNumberOfPages = Math.ceil(totalNumberOfPosts / postsPerPage)
    } catch (error) {
      console.error(error)
      throw error
    }
  }

  function moveToPageNumber(pageNumber: number) {
    if (pageNumber >= 1 && pageNumber <= totalNumberOfPages) {
      currentPage.set(pageNumber)
    }
  }

  retrievePosts("none", 1)
</script>

<main>
  <div>
    <button
      id="prev"
      name="prev"
      disabled={$currentPage === 1}
      onclick={() => {
        moveToPageNumber($currentPage - 1)
        retrievePosts(textOfFilter, $currentPage)
        console.log("Posts: ", posts)
        console.log("Current page: ", $currentPage)
      }}
      class="p-1.5 my-1.5 mr-0 ml-1.5 bg-cyan-900 rounded-l-lg cursor-pointer disabled:cursor-not-allowed md:p-2 md:my-2 md:ml-2 lg:p-3.5 lg:my-3.5 lg:ml-3.5 text-slate-400"
      >Prev</button
    >
    <input
      type="search"
      id="filter-posts"
      name="filter-posts"
      bind:value={textOfFilter}
      onblur={() => retrievePosts(textOfFilter, 1)}
      class="p-1.5 bg-cyan-900 disabled:cursor-not-allowed md:p-2 lg:p-3.5 text-slate-400"
    />
    <button
      id="next"
      name="next"
      disabled={$currentPage === totalNumberOfPages}
      onclick={() => {
        moveToPageNumber($currentPage + 1)
        retrievePosts(textOfFilter, $currentPage)
        console.log("Posts: ", posts)
        console.log("Current page: ", $currentPage)
      }}
      class="p-1.5 my-1.5 mr-1.5 ml-0 bg-cyan-900 rounded-r-lg cursor-pointer disabled:cursor-not-allowed md:my-2 md:p-2 md:mr-2 lg:my-3.5 lg:p-3.5 lg:mr-3.5 text-slate-400"
      >Next</button
    >
  </div>
  <div>
    {#if totalNumberOfPages > 0}
      <output class="text-slate-400"
        >{$currentPage} / {totalNumberOfPages}</output
      >
    {/if}
  </div>
</main>
