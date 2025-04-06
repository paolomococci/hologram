import Header from "../Header"
import { postsStore } from "../../stores/posts-store.ts"
import { Provider } from "react-redux"
import { PaginatorView } from "./PaginatorView.tsx"
import { FC } from "react"

export const PostsView: FC = () => {
  return (
    <>
      <header className="mb-2">
        <Header title="posts" />
      </header>

      <Provider store={postsStore}>
        <PaginatorView />
      </Provider>
    </>
  )
}
