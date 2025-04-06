import { useGetPostsQuery } from "../../services/posts-service.ts"
import { Loader } from "lucide-react"
import type Article from "../../interfaces/post.ts"
import { FC, useState } from "react"
import Post from "../../interfaces/post.ts"

export const AllPostsView: FC = () => {
  const { data, error, isLoading } = useGetPostsQuery()
  const [isPostSelected, setIsPostSelected] = useState<boolean>(true)

  const tempPost: Post = {
    id: 0,
    title: "",
    content: "",
    created_at: new Date(),
    updated_at: new Date()
  }

  const [focusedPost, setFocusedPost] = useState<Post>(tempPost)

  console.log("Is Loading: ", isLoading)
  console.log("Error: ", error)
  console.dir("Data: ", data)

  /**
   * to view the single post
   * 
   * @param post 
   */
  function handleClick(post: Article) {
    console.log("Handle click over a title of post: ", post)
    setFocusedPost(post)
    setIsPostSelected(!isPostSelected)
  }

  if (!Array.isArray(data)) {
    return (
      <>
        <div>
          <Loader
            color="#fc08"
            size={128}
            className="md:size-48 lg:size-64 animate-[spin_1s_ease-in-out_infinite]"
          />
        </div>
      </>
    )
  } else {
    return (
      <>
        <section
          id="selected-post-view"
          hidden={isPostSelected}
          className="mt-48 bg-stone-800/95 z-30 fixed top-1 left-0.5 right-0.5 min-h-full min-w-full"
        >
          <article
            onClick={() => setIsPostSelected(!isPostSelected)}
            title="click anywhere in this post to make it disappear"
          >
            <h3 className="m-1 font-serif text-xs text-cyan-600 sm:text-sm md:text-base lg:text-lg">
              {focusedPost.title}
            </h3>
            <p className="prose-sm md:prose-base lg:prose-lg m-1 text-justify font-serif text-stone-400 mx-5">
              {focusedPost.content}
            </p>
            <h6 className="prose-sm md:prose-base lg:prose-lg m-1 font-mono text-xs text-cyan-400 sm:text-sm md:text-base lg:text-lg">
              {focusedPost.user?.name}
            </h6>
          </article>
        </section>
        <section id="posts-view" hidden={!isPostSelected} className="mt-36 mb-36 z-10">
          {data?.map((post) => (
            <article
              key={post.id}
              className="my-2 rounded-lg bg-stone-800 py-2"
            >
              <h5 className="m-1 font-serif text-xs text-cyan-600 sm:text-sm md:text-base lg:text-lg">
                <button
                  onClick={() => handleClick(post)}
                  className="prose-base md:prose-lg lg:prose-xl transition delay-300 duration-300 ease-in-out hover:text-cyan-100 hover:shadow-2xl hover:shadow-stone-600"
                >
                  {post.title}
                </button>
              </h5>
              <p className="prose-sm md:prose-base lg:prose-lg m-1 line-clamp-2 text-justify font-serif text-stone-400">
                {post.content}
              </p>
              <h6 className="prose-sm md:prose-base lg:prose-lg m-1 font-mono text-xs text-cyan-400 sm:text-sm md:text-base lg:text-lg">
                {post.user.name}
              </h6>
            </article>
          ))}
        </section>
      </>
    )
  }
}
