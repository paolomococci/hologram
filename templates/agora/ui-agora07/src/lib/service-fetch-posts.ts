import type Post from "./api-post"
import type { FetchedResponse } from "./interface-fetch-response"
import ENV from "../env"

export class FetchPostsService {
  // API filtered
  // private urlApi = ENV.baseUrl + "api/filtered"
  // API paginator
  private urlApi = ENV.baseUrl + "api/paginator"
  private numOfPostsUrlApi = ENV.baseUrl + "api/num-of-posts"

  async fetchPosts(
    filter: string = '', 
    current: number = 1
  ): Promise<FetchedResponse> {
    try {
      // const resNumberOfPosts = await fetch(this.numOfPostsUrlApi)
      const resListOfPosts = await fetch(
        // API paginator
        `${this.urlApi}/${current}?filter=${filter}`
        // API filtered
        // `${this.urlApi}/${filter}/${current}`
      )
      if (!resListOfPosts.ok) {
        throw new Error(
          `HTTP errors status: ${resListOfPosts.status}`
        )
      }
      // const num = await resNumberOfPosts.json()
      const posts = await resListOfPosts.json()

      return {
        num: posts.num,
        posts: posts.posts,
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
