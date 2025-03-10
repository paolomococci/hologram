<script lang="ts">
  import { FetchPostsService } from "./service-fetch-posts"
  import type Post from "./api-post"
  import type { FetchedResponse } from "./interface-fetch-response"
  import { postStore } from "./store-posts"

  const fetchPostsService = new FetchPostsService()
  let fetchResponse: FetchedResponse
  let posts: Post[] = []

  async function retrievePosts(): Promise<Post[]> {
    try {
      fetchResponse = await fetchPostsService.fetchPosts()
      console.log(`FetchedResponse: `, fetchResponse)
      postStore.set(fetchResponse.posts)
      return posts
    } catch (error) {
      console.error(error)
      throw error
    }
  }

  retrievePosts()
</script>

<main>
  <div>
    <button
      class="p-1.5 my-1.5 mr-0 ml-1.5 bg-cyan-900 rounded-l-lg cursor-pointer md:p-2 md:my-2 md:ml-2 lg:p-3.5 lg:my-3.5 lg:ml-3.5 text-slate-400"
      >Prev</button
    >
    <input
      class="p-1.5 bg-cyan-900 md:p-2 lg:p-3.5 text-slate-400"
      type="search"
      name="filter-posts"
      id="filter-posts"
    />
    <button
      class="p-1.5 my-1.5 mr-1.5 ml-0 bg-cyan-900 rounded-r-lg cursor-pointer md:my-2 md:p-2 md:mr-2 lg:my-3.5 lg:p-3.5 lg:mr-3.5 text-slate-400"
      >Next</button
    >
  </div>
</main>
