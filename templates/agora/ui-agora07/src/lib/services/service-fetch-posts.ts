import type Post from "../apis/api-post"
import type { FetchedResponse } from "../interfaces/interface-fetch-response"
import ENV from "../../env"

export class FetchPostsService {
  // API filtered
  // private urlApi = ENV.baseUrl + "api/filtered"
  // API paginate
  private urlApi = ENV.baseUrl + "api/paginate"

  /**
   * This function retrieves posts.
   *
   * @param filter
   * @param current
   * @returns Promise<FetchedResponse>
   */
  async fetchPosts(
    filter: string = "",
    current: number = 1
  ): Promise<FetchedResponse> {
    try {
      const resListOfPosts = await fetch(
        // API paginate
        `${this.urlApi}/${current}?filter=${filter}`
        // API filtered
        // `${this.urlApi}/${filter}/${current}`
      )
      if (!resListOfPosts.ok) {
        throw new Error(`HTTP errors status: ${resListOfPosts.status}`)
      }
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

  /**
   * To retrieve a post by identifier.
   *
   * @param id
   * @returns Promise<Post>
   */
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
