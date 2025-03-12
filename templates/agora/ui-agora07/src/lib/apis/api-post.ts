import type User from "./api-user"

export default interface Post {
  id: number
  user_id: number
  title: string
  content: string
  created_at: Date
  updated_at: Date
  user: User
}
