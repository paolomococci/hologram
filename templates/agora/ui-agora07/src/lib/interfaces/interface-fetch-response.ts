import type Post from "../apis/api-post"

export interface FetchedResponse {
  num: number
  posts: Post[]
}
