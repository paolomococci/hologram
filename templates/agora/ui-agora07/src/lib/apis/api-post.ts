import type User from "./api-user"

/**
 * Post interface
 */
export default interface Post {
  id: number
  user_id?: number
  title: string
  content: string
  created_at: Date
  updated_at: Date
  user?: User
}
