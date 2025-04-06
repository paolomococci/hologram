import { CircleX, Loader } from "lucide-react"
import Article from "../../interfaces/post"
import { FC, useState } from "react"

export const PostsPaginatorView: FC<{
  posts?: Article[]
  isFilteringFor?: boolean
}> = ({ posts, isFilteringFor = false }) => {
  const temporaryArticle: Article = {
    id: 0,
    title: "",
    content: "",
    created_at: new Date(),
    updated_at: new Date()
  }

  const [isPostSelected, setIsPostSelected] = useState<boolean>(true)
  const [focusedPost, setFocusedPost] = useState<Article>(temporaryArticle)

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

  if (posts === undefined || isFilteringFor) {
    return (
      <>
        <div>
          <Loader
            color="#fc08"
            size={64}
            className="size-20 md:size-24 lg:size-28 animate-[spin_1s_ease-in-out_infinite]"
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
          className="mt-48 mb-14 bg-stone-800/95 z-30 fixed top-1 left-0.5 right-0.5 min-h-full min-w-full"
        >
          <article className="bg-stone-800/50">
            <CircleX
              onClick={() => {
                setIsPostSelected(!isPostSelected)
              }}
              size={32}
              className="fixed size-8 md:size-12 lg:size-14 mt-2 pt-2 right-2"
            />
            <div className="pt-4 mx-8">
              <h3 className="m-1 font-serif text-xs text-cyan-600 sm:text-sm md:text-base lg:text-lg">
                {focusedPost.title}
              </h3>
              <p className="prose-sm md:prose-base lg:prose-lg m-1 text-justify font-serif text-stone-400 mx-5">
                {focusedPost.content}
              </p>
              <h6 className="prose-sm md:prose-base lg:prose-lg m-1 font-mono text-xs text-cyan-400 sm:text-sm md:text-base lg:text-lg">
                {focusedPost.user?.name}
              </h6>
            </div>
          </article>
        </section>
        <section
          id="posts-view"
          hidden={!isPostSelected}
          className="mt-36 mb-14 z-10"
        >
          {posts?.map((post) => (
            <article
              key={post.id}
              className="my-2 rounded-lg bg-stone-800 py-2"
            >
              <h5 className="m-1 font-serif text-xs text-cyan-600 sm:text-sm md:text-base lg:text-lg">
                <button
                  onClick={() => handleClick(post)}
                  className="rounded-sm md:rounded-md lg:rounded-lg p-1 md:p-1.5 lg:p-3 m-1 md:m-1.5 lg:m-3 prose-base md:prose-lg lg:prose-xl transition delay-300 duration-300 ease-in-out hover:text-cyan-100 hover:shadow-2xl hover:shadow-stone-600"
                >
                  {post.title}
                </button>
              </h5>
              <p className="prose-sm md:prose-base lg:prose-lg m-1 line-clamp-2 text-justify font-serif text-stone-400">
                {post.content}
              </p>
              <h6 className="prose-sm md:prose-base lg:prose-lg m-1 font-mono text-xs text-cyan-400 sm:text-sm md:text-base lg:text-lg">
                {post.user?.name}
              </h6>
            </article>
          ))}
        </section>
      </>
    )
  }
}
