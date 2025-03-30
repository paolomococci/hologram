import Header from "../Header"
import { postsStore } from "../../stores/posts-store.ts"
import { Provider } from "react-redux"
import { AllPostsView } from "../views/AllPostsView.tsx"

export const PostsView = () => {
  return (
    <>
      <header className="mb-2">
        <Header title="posts" />
      </header>

      <Provider store={postsStore}>
        <AllPostsView />
      </Provider>
    </>
  )
}
