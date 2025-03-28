import type User from "./user"

/**
 * Post interface
 */
export default interface Article {
  id: number
  user_id?: number
  title: string
  content: string
  created_at: Date
  updated_at: Date
  user?: User
}
