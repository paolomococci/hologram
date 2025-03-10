import type Post from "./api-post"
import type { FetchedResponse } from "./interface-fetch-response"
import ENV from "../env"

export class FetchPostsService {
  private urlApi = ENV.baseUrl + "api/posts"
  private numOfPostsUrlApi = ENV.baseUrl + "api/num-of-posts"

  async fetchPosts(starting?: number, until?:number, filter?: string): Promise<FetchedResponse> {
    try {
      const resNumberOfPosts = await fetch(this.numOfPostsUrlApi)
      const resListOfPosts = await fetch(
        // `${this.urlApi}?starting=${starting}&until=${until}&filter=${filter}`
        this.urlApi
      )
      if (!resNumberOfPosts.ok && !resListOfPosts.ok) {
        throw new Error(
          `HTTP errors status: ${resNumberOfPosts.status} and ${resListOfPosts.status}`
        )
      }
      const num = await resNumberOfPosts.json()
      const posts = await resListOfPosts.json()

      return {
        num: num.num,
        posts: posts,
      }
    } catch (error) {
      console.error(
        "I'm sorry, an error occurred while querying the posts API: ",
        error
      )
      throw error
    }
  }

  async fetchPostById(id: number): Promise<Post> {
    try {
      const response = await fetch(`${this.urlApi}/${id}`)
      if (!response.ok) {
        throw new Error(`HTTP error status: ${response.status}`)
      }
      return await response.json()
    } catch (error) {
      console.error(
        `I'm sorry, there was an error with the post identified by number: ${id}, error: `,
        error
      )
      throw error
    }
  }
}
