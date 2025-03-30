import { useGetPostsQuery } from "../../services/posts-service.ts"

export const PaginatorView = () => {
  const { data, error, isLoading } = useGetPostsQuery()

  console.log("Is Loading: ", isLoading)
  console.log("Error: ", error)
  console.dir("Data: ", data)
}
